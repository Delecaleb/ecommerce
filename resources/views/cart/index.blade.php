<x-store-layout>
    <div class="row my-5">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <p class="fw-bold fs-5">My Cart</p>
                </div>
                <div class="card-body">
                    @session('message')
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endsession
                    {{-- check if there is item in cart yet --}}
                    @if (count($cartItems) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="2">Item</th>
                                        <th>Unit Price</th>
                                        <th>QTY</th>
                                        <th>Sub Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td><img src="{{ asset('storage/' . $item->product['image_url']) }}"
                                                    alt="{{ $item->name }}" width="80">
                                            </td>
                                            <td>
                                                <p class="fs-6 fw-bold">{{ $item->product['name'] }}</p>
                                            </td>
                                            <td>
                                                <p class="fs-6 fw-bold">${{ number_format($item->product['price']) }}
                                                </p>
                                            </td>

                                            <td>
                                                <form class="d-flex" action="{{ route('cart.updateqty', $item) }}"
                                                    method="post" class="decreaseQuantityForm">
                                                    @method('patch')
                                                    @csrf
                                                    <button type="button" class="btn updateBtn" data-action='decrease'>
                                                        <i class="bi bi-dash-square"></i>
                                                    </button>
                                                    <span class="mr-3 fs-5"
                                                        id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                                                    <button type="button" class="btn updateBtn" data-action='increase'>
                                                        <i class="bi bi-plus-square"></i>
                                                    </button>
                                                </form>
                                            </td>

                                            <td>
                                                <p class="fs-6 fw-bold">
                                                    <span
                                                        id="subTotal-{{ $item->id }}">${{ number_format($item->product['price'] * $item->quantity) }}</span>
                                                </p>
                                            </td>

                                            <td>
                                                <form action="{{ route('cart.delete', $item) }}" method="post"
                                                    class="deleteItem">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-outline-danger"
                                                        data-item-name="{{ $item->product['name'] }}"><i
                                                            class="bi bi-trash3 text-danger"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4">
                                            <div class="fs-4 fw-bold">
                                                Total
                                            </div>
                                        </td>
                                        <td colspan="2">
                                            @php
                                                $total = 0;
                                                foreach ($cartItems as $item) {
                                                    $total += $item->product['price'] * $item->quantity;
                                                }
                                            @endphp
                                            <span class="fw-bold fs-5"
                                                id='cartTotal'>${{ number_format($total) }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="mt-5 text-center mb-2">
                            <img class="mx-auto" src="{{ asset('storage/assets/basket.svg') }}" alt="empty basket"
                                width="100">
                        </div>
                        <div class="text-danger text-center fs-5 fw-bold mb-5">Your cart is empty</div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script>
        // delete confirmation pop up using sweet alert
        document.addEventListener('DOMContentLoaded', function() {
            const deleteItem = document.querySelectorAll('.deleteItem');
            deleteItem.forEach(btn => {
                btn.addEventListener('click', function() {
                    const form = this.closest('form');
                    const itemName = this.dataset.itemName;
                    // call sweet alert
                    Swal.fire({
                        title: `Delete "${itemName}"?`,
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        })

        //cart item quantity increase
        document.addEventListener('DOMContentLoaded', function() {
            const updateBtn = document.querySelectorAll('.updateBtn');

            updateBtn.forEach(element => {
                element.addEventListener('click', function() {
                    const form = this.closest('form');
                    const formData = new FormData(form);
                    const action = this.dataset.action;
                    formData.append('action', action);

                    fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]')
                                    .value,
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById(`subTotal-${data.itemId}`).textContent =
                                data
                                .subTotal;
                            document.getElementById(`qty-${data.itemId}`).textContent = data
                                .newQty;
                            document.getElementById('cartTotal').textContent =
                                `$${data.cartTotal}`;
                        })
                        .catch(error => {
                            alert('Something went wrong.');
                        });
                })
            });
        })
    </script>
</x-store-layout>
