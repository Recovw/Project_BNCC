@extends('Layouts.adminNavbar')
<title>Raja Shop | Admin Only</title>

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="col-md-6">
        <h3 class="text-center">Hello, this is admin only!</h3>

        <h4 class="text-center">Add New Item</h4>
        <form action="{{ route('create') }}" method='POST' enctype="multipart/form-data" class="card p-4 shadow">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>                
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label for="name_item">Item Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Input a Name">
            </div>

            <div class="mb-3">
                <label for="category_item">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value=""><- Select Category -></option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="price_item">Price</label>
                <input type="text" class="form-control" name="price" value="{{ old('price') }}" placeholder="Input a price">
            </div>

            <div class="mb-3">
                <label for="stock_item">Stock</label>
                <input type="text" class="form-control" name="stock" value="{{ old('stock') }}" placeholder="Input a stock">
            </div>

            <div class="mb-3">
                <label for="image_item">Image</label>
                <input type="file" class="form-control" name="image" accept="image/*" placeholder="Input a image">
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit Item</button>
        </form>

        <hr>

        <h4 class="text-center">Add New Category</h4>
        <form action="{{ route('createCategory') }}" method="POST" class="card p-4 shadow">
            @csrf
            <div class="mb-3">
                <label for="category_name">Category Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Create a new category">
            </div>
            <button type="submit" class="btn btn-secondary w-100">Add Category</button>
        </form>

        <h5 class="mt-4 text-center">Existing Categories</h5>
        <ul class="list-group">
            @foreach ($categories as $c)
                <li class="list-group-item text-center">{{ $c->name }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

