@extends('Layouts.userNavbar')

@section('title', 'Raja Shop | Cart')

@section('content')

<h2>Checkout </h2>

@if(session('cart') && count(session('cart')) > 0)

    <form action="{{ route('storeInvoice') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Alamat Pengiriman</label>
            <input type="text" name="shipping_address" class="form-control form-control-sm" style="width: 300px;" required minlength="10" maxlength="100">
        </div>

        <div class="mb-3">
            <label>Kode Pos</label>
            <input type="text" name="postal_code" class="form-control form-control-sm" style="width: 300px;"" required pattern="[0-9]{5}">
        </div>

        <button type="submit" class="btn btn-success">Create Invoice</button>
    </form>

    <hr>

    <form action="{{ route('updateCart') }}" method="POST">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php 
                        $subtotal = $item['price'] * $item['quantity']; 
                        $total += $subtotal; 
                    @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['category'] }}</td>
                        <td>Rp {{ number_format($item['price'],0,',','.') }}</td>
                        <td>
                            <input type="number" 
                                   name="cart[{{ $id }}][quantity]" 
                                   value="{{ $item['quantity'] }}" 
                                   min="1" 
                                   class="form-control form-control-sm"
                                   style="width: 70px; text-align: center;">
                        </td>
                        <td>Rp {{ number_format($subtotal,0,',','.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4>Total: Rp {{ number_format($total,0,',','.') }}</h4>

        <button type="submit" class="btn btn-primary">Update Cart</button>
    </form>
@else
    <p>Cart is empty!</p>
@endif
@endsection
