<x-admin-layout>
    <div class="card rounded-lg">
        <div class="card-body">
            <div class="card-header">
                <button type="button" data-bs-toggle="modal" data-bs-target="#createProductForm" class="btn btn-success ">
                    <i class="bi bi-plus-lg"></i> New Product
                </button>
            </div>
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @session('message')
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endsession
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="fw-bold">
                        <th><i class="bi bi-hash"></i></th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th colspan="2" class="text-center">Action</th>
                    </thead>

                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="py-3">
                                    <i class="bi bi-hash"></i>
                                </td>
                                <td class="py-3">
                                    <div>
                                        <img src="{{ asset('storage/' . $product->image_url) }}"
                                            alt="{{ $product->name }}" width="50">
                                    </div>
                                </td>
                                <td class="py-3">
                                    {{ $product->name }}
                                </td>
                                <td class="py-3">
                                    {{ number_format($product->price) }}
                                </td>
                                <td class="py-3">
                                    {{ strlen($product->description) > 150 ? substr($product->description, 0, 150) . '. . .' : $product->description }}
                                </td>
                                <td class="py-3">
                                    <a href="{{ route('product.edit', $product) }}" class="btn btn-outline-success">
                                        <i class="bi bi-pencil-square text-success"></i>
                                    </a>
                                </td>
                                <td class="py-3">
                                    <form action="{{ route('product.delete', $product) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="button" class="btn btn-outline-danger deleteProduct"
                                            data-product-name="{{ $product->name }}"><i
                                                class="bi bi-trash3 text-danger"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>


    {{-- modal form to create new products --}}
    <div class="modal fade" id="createProductForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="createProductFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="createProductFormLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- name -->
                            <div class="my-2">
                                <label for="name">Product Name</label>
                                <input required type="text" placeholder="Write product name .." name="name"
                                    id="name" class="form-control rounded" value="{{ old('name', $name ?? '') }}">
                            </div>

                            <div class="my-2">
                                <label for="price">Product Price</label>
                                <input type="number" required placeholder="Product price" name="price" id="price"
                                    class="form-control rounded" value="{{ old('price', $preice ?? '') }}">
                            </div>
                            <div class="my-2">
                                <label for="description">Product Description</label>
                                <textarea required style="resize: none;" rows="5" type="text" placeholder="Write Product description"
                                    name="description" id="description" class="form-control rounded">{{ old('description', $description ?? '') }}</textarea>
                            </div>
                            <div class="my-3">
                                <label for="description">Select Image
                                    <input type="file" type="image" name="image" required />
                                </label>
                            </div>

                            <div class="">
                                <button class="btn btn-success">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.deleteProduct');

            deleteButtons.forEach(element => {
                element.addEventListener('click', function(e) {
                    e.preventDefault()
                    const form = this.closest('form');
                    const productName = this.dataset.productName;
                    Swal.fire({
                        title: `Delete "${productName}"?`,
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
                    })
                })
            });
        })
    </script>
</x-admin-layout>
