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
                @if (count($cartItems) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th colspan="2">Item</th>
                                    <th>User</th>
                                    <th>Unit Price</th>
                                    <th>QTY</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $item->product['image_url']) }}"
                                                alt="{{ $item->name }}" width="80">
                                        </td>
                                        <td>
                                            <p class="fs-6 fw-bold">{{ $item->product['name'] }}</p>
                                        </td>
                                        <td>
                                            <p class="fs-6 fw-bold">{{ $item->user['email'] }}</p>
                                        </td>
                                        <td>
                                            <p class="fs-6 fw-bold">${{ number_format($item->product['price']) }}
                                            </p>
                                        </td>

                                        <td>
                                            <span class="mr-3 fs-5"
                                                id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                                        </td>

                                        <td>
                                            <p class="fs-6 fw-bold">
                                                ${{ number_format($item->product['price'] * $item->quantity) }}
                                            </p>
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
                                            foreach ($cartItems as $item) {
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
                    <div class="mt-5 mb-2">
                        <img class="mx-auto" src="{{ asset('storage/assets/basket.svg') }}" alt="empty basket"
                            width="100">
                    </div>
                    <div class="text-danger text-center fs-5 fw-bold mb-5">Your cart is empty</div>
                @endif

            </div>
        </div>
    </div>
</x-admin-layout>
