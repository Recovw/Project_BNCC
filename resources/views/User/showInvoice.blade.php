@extends('Layouts.userNavbar')

@section('title', 'Raja Shop | Invoice Details')

@section('content')
<h2> Invoice Details {{ $invoice->invoice_number }}</h2>

<p><strong>Alamat:</strong> {{ $invoice->shipping_address }}</p>
<p><strong>Kode Pos:</strong> {{ $invoice->postal_code }}</p>
<p><strong>Total:</strong> Rp {{ number_format($invoice->total,0,',','.') }}</p>
<p><strong>Tanggal:</strong> {{ $invoice->created_at->format('d M Y H:i') }}</p>

<hr>

<h4>List of Item</h4>
<table class="table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->product_id }}</td> 
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->subtotal,0,',','.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('invoices') }}" class="btn btn-secondary">Back</a>
@endsection
