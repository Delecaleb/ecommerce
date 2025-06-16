<x-store-layout>
    <div class="card my-5">
        <div class="card-body md-p-5">
            <div class="row">
                @session('message')
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endsession
                @foreach ($products as $item)
                    <div class="col-md-3 mb-5">
                        <div class="card rounded-md">
                            <div class="product-image bg-light">
                                <a href="{{ route('details', $item) }}">
                                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
                                </a>
                            </div>
                            <div class="card-body">

                                <div>
                                    <a href="{{ route('details', $item) }}">
                                        <h1 class="fs-5">{{ $item->name }}</h1>
                                    </a>
                                </div>
                                <div class="fs-6">
                                    {{ substr($item->description, 0, 30) }}
                                </div>
                                <div class="fs-3 price mb-2">
                                    ${{ number_format($item->price) }}
                                </div>
                                <form action="{{ route('cart.store', $item) }}" method="post">
                                    @csrf
                                    <div class="d-flex justify-content-between">
                                        <input type="number" class="rounded-lg cartQuantity text-center" value="1"
                                            name="cart_quantity">

                                        <div>
                                            <button class="btn btn-success mt-2 p-2 text-sm">
                                                <i class="bi bi-cart3"></i>
                                                Add
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-store-layout>
