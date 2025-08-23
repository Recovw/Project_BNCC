@extends('Layouts.userNavbar')
@section('content')
<h2>Cart</h2>

@if(session('cart') && count(session('cart')) > 0)
    <form action="{{ route('updateCart') }}" method="POST">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Categories</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach(session('cart') as $id => $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['category'] }}</td>
                        <td>Rp {{ number_format($item['price'],0,',','.') }}</td>
                        <td>
                            <input type="number" name="cart[{{ $id }}][quantity]" value="{{ $item['quantity'] }}" min="1" class="form-control" style="width:80px;">
                        </td>
                        <td>Rp {{ number_format($subtotal,0,',','.') }}</td>
                        <td>
                            <a href="{{ route('removeCart', $id) }}" class="btn btn-danger btn-sm">Delete Item</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4>Total: Rp {{ number_format($total,0,',','.') }}</h4>

        <button type="submit" class="btn btn-primary">Update Cart</button>
    </form>
@else
    <p>Cart kosong!</p>
@endif
@endsection
