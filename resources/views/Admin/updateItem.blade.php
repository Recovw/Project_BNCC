@extends('Layouts.adminNavbar')

@section('title', 'Raja Shop | Admin | Update Item')

@section('content')
    <div class="container d-flex justify-content-center mt-5">
    <div class="col-md-6">
        <h4 class="text-center">Update Item</h4>
        <form action="{{ route('updateItem', $item->id) }}" method='POST' enctype="multipart/form-data" class="card p-4 shadow">
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
                <label for="name_item">Update Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Input a Name">
            </div>

            <div class="mb-3">
                <label for="category_item">Update Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value=""><- Select Category -></option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="price_item">Update Price</label>
                <input type="text" class="form-control" name="price" value="{{ old('price') }}" placeholder="Input a price">
            </div>

            <div class="mb-3">
                <label for="stock_item">Update Stock</label>
                <input type="text" class="form-control" name="stock" value="{{ old('stock') }}" placeholder="Input a stock">
            </div>

            <div class="mb-3">
                <label for="image_item">Update Image</label>
                <input type="file" class="form-control" name="image" accept="image/*" placeholder="Input a image">
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit Item</button>
            <a href="{{route('seeItems')}}" class="btn btn-danger mt-3">Cancel</a>
        </form>
   </div>
</div>
@endsection