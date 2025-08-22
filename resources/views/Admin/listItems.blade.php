@extends('Layouts.adminNavbar')

@section('title', 'Raja Shop | See Items')

@section('content')
<div class="container mt-4">
    <h3>
        @isset($category)
            Items in Category: {{ $category->name }}
        @else
            All Items
        @endisset
    </h3>

    <table class="table table-striped table-bordered table-hover text-center align-middle" style="table-layout: fixed; width: 100%;">
        <thead class="table-dark">
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 15%;">Name</th>
                <th style="width: 15%;">Price</th>
                <th style="width: 10%;">Stock</th>
                <th style="width: 15%;">Categories</th>
                <th style="width: 20%;">Picture</th>
                <th style="width: 20%;">Edit</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>{{ $item->category->name ?? '-' }}</td>
                    <td>
                        @if($item->image)
                            <img src="{{ asset('storage/'.$item->image) }}" 
                                 alt="{{ $item->name }}" 
                                 width="80" height="80" 
                                 style="object-fit: cover; border-radius: 8px;">
                        @else
                            <span class="text-muted">No Picture</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{route('showUpdateItem', ['id' => $item->id]) }}" class="btn btn-success me-2">Update</a>
                            <form action="{{route('deleteItem', $item->id)}}" method="POST" class="m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No Items at the moment</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
