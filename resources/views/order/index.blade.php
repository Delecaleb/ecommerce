<x-store-layout>
    <div class="row my-5">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <p class="fw-bold fs-5">My Orders</p>
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
                                        <th>Order ID</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($orderItems as $item)
                                        <tr>
                                            <td><img src="{{ asset('storage/' . $item->product['image_url']) }}"
                                                    alt="{{ $item->name }}" width="80">
                                            </td>
                                            <td>
                                                <p class="fs-6 fw-bold">{{ $item->product['name'] }}
                                                    ({{ $item->quantity }})
                                                    <span
                                                        id="subTotal-{{ $item->id }}">${{ number_format($item->product['price'] * $item->quantity) }}</span>
                                                </p>
                                            </td>

                                            <td>

                                                <span>#{{ $item->transaction_id }}</span>

                                            </td>

                                            <td>
                                                {{ $item->status }}
                                            </td>
                                            <td>{{ date('Y M, d', strtotime($item->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    @else
                        <div class="mt-5 text-center mb-2">
                            <img class="mx-auto" src="{{ asset('storage/assets/basket.svg') }}" alt="empty basket"
                                width="100">
                        </div>
                        <div class="text-danger text-center fs-5 fw-bold mb-5">No Orders yet</div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-store-layout>
