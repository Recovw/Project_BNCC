@extends('Layouts.userNavbar')

@section('title', 'Raja Shop | Invoice History')

@section('content')
<h2> Invoice History</h2>

@if($invoices->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Invoice Number</th>
                <th>Total</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>Rp {{ number_format($invoice->total,0,',','.') }}</td>
                    <td>{{ $invoice->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <a href="{{ route('showInvoice', $invoice->id) }}" class="btn btn-info btn-sm">Details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No Invoices</p>
@endif
@endsection
