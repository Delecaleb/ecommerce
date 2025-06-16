<x-admin-layout>

    <div class="">
        <div class="card">
            <div class="card-header">
                <p class="fw-bold fs-5">My Cart</p>
            </div>
            <div class="card-body">
                @session('message')
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endsession
                {{-- check if there is item in cart yet --}}
                @if (count($orderItems) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th colspan="2">Item</th>
                                    <th>User</th>
                                    <th>Sub Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($orderItems as $item)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $item->product['image_url']) }}"
                                                alt="{{ $item->name }}" width="80">
                                        </td>
                                        <td>
                                            <p class="fs-6 fw-bold">{{ $item->product['name'] }} ({{ $item->quantity }})
                                            </p>
                                        </td>
                                        <td>
                                            <p class="fs-6 fw-bold">{{ $item->user['email'] }}</p>
                                        </td>

                                        <td>
                                            <p class="fs-6 fw-bold">
                                                ${{ number_format($item->product['price'] * $item->quantity) }}
                                            </p>

                                        </td>
                                        <td>
                                            {{ $item->transaction_id }}
                                        </td>
                                        <td>
                                            {{ $item->status }}
                                        </td>
                                        <td>
                                            <form action="{{ route('order.update', $item) }}" method="post">
                                                @csrf
                                                @method('patch')
                                                <select name="status" class="statusToggler form-control">
                                                    <option value="pending">Pending</option>
                                                    <option value="delivered">Delivered</option>
                                                    <option value="returned">Returned</option>
                                                </select>

                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5">
                                        <div class="fs-4 fw-bold">
                                            Total
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $total = 0;
                                            foreach ($orderItems as $item) {
                                                $total += $item->product['price'] * $item->quantity;
                                            }
                                        @endphp
                                        <span class="fw-bolder fs-5" id='cartTotal'>${{ number_format($total) }}</span>
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
                    <div class="text-danger text-center fs-5 fw-bold mb-5">No Orders Yet</div>
                @endif
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const changeBtn = document.querySelectorAll('.statusToggler');
            changeBtn.forEach(btn => {
                btn.addEventListener('change', function() {
                    const form = this.closest('form');

                    // call sweet alert
                    Swal.fire({
                        title: `Confirm to Proceed`,
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Continue!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        })
    </script>
</x-admin-layout>
