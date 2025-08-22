@extends('Layouts.userNavbar')

@section('title', 'Raja Shop | Shop')

@section('content')
<div class="container py-4">

  @if($items->count() === 0)
    <div class="alert alert-info text-center">Belum ada item yang tersedia</div>
  @endif

  <div class="row g-4">
    @foreach ($items as $i)
      <div class="col-6 col-md-4 col-lg-3">
        <div class="card h-100 shadow rounded-3" style="background-color: #fff9ef;">
          
          <img 
            src="{{ $i->image ? asset('storage/'.$i->image) : asset('images/placeholder.png') }}"
            class="card-img-top"
            alt="{{ $i->name }}"
            style="object-fit: cover; height: 180px;">

          <div class="card-body d-flex flex-column">


            <h5 class="card-title mb-1 text-truncate fw-semibold">{{ $i->name }}</h5>


            <p class="mb-1 fw-semibold text-primary">
              Rp {{ number_format($i->price, 0, ',', '.') }}
            </p>

 
            @if($i->stock > 0)
                <span class="text-success mb-2">Stock: {{ $i->stock }}</span>
            @else
                <span class="text-danger mb-2">Stock: {{ $i->stock }}</span>
                <span class="text-danger mb-2">Barang sudah habis, silahkan tunggu hingga barang di-restock ulang</span>
            @endif


            {{-- <form action="{{ route('cart.add', $i->id) }}" method="POST" class="mt-auto"> --}}
            <form action="#" method="POST" class="mt-auto">
              @csrf
              <input type="hidden" name="qty" value="1">
              <button type="submit" class="btn btn-sm btn-primary w-100">
                <i class="bi bi-cart"></i> Add to Cart
              </button>
            </form>

          </div>
        </div>
      </div>
    @endforeach
  </div>


  <div class="d-flex justify-content-center mt-4">
    {{ $items->links('pagination::bootstrap-4') }}
  </div>
</div>
@endsection
