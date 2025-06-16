<x-store-layout>
    <div class="row my-5">

        <div class="col-md-6 ">
            <div class="card rounded-md">
                <div class="card-body">
                    <div class="">
                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" width="100%">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 ">
            <div class="card rounded-md">
                <div class="card-body">
                    <div class="mb-3">
                        <h1 class="fs-3">{{ $product->name }}</h1>
                    </div>
                    <div class="fs-3 price">
                        ${{ number_format($product->price) }}
                    </div>
                    <div>
                        {{ $product->description }}
                    </div>
                    @session('message')
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endsession
                    <form action="{{ route('cart.store', $product) }}" method="post">
                        @csrf
                        <div class="flex justify-between">
                            <input type="number" class="rounded-md cartQuantity" value="1" name="cart_quantity">

                            <div>
                                <button class="btn btn-success mt-2 text-sm">
                                    <i class="bi bi-cart3"></i>
                                    Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</x-store-layout>
