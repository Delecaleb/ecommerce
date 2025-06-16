<x-admin-layout>
    <div class="card rounded-lg">
        <div class="card-body">
            <form action="{{ route('product.update', $product) }}" method="POST" enctype="multipart/form-data">
                @method('patch')
                @csrf
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="text-danger">{{ $error }}</div>
                    @endforeach
                @endif

                @session('message')
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endsession
                <img src="{{ asset('storage/' . $product->image_url) }}" alt="" width="100">
                <!-- name -->
                <div class="py-2">
                    <label for="name">Product Name</label>
                    <input required type="text" value="{{ $product->name }}" placeholder="Write product name .."
                        name="name" id="name" class="form-control">
                </div>

                <div class="py-2">
                    <label for="price">Product Price</label>
                    <input type="number" value="{{ $product->price }}" placeholder="Product price" name="price"
                        id="price" class="form-control">
                </div>
                <div class="py-2">
                    <label for="description">Product Description</label>
                    <textarea type="text" placeholder="Write Product description" name="description" id="description"
                        class="form-control">{{ $product->description }}</textarea>
                </div>

                <div class="my-3">
                    <label for="description">Replace Product Image
                        <input type="file" type="image" name="image" />
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">

                    <button class="btn btn-success">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
