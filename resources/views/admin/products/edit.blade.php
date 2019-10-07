@push('css')
  <link rel="stylesheet" href="/css/admin/pages/products.css">
@endpush

@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Editar producto <strong>{{ $product->name }}</strong>
          </div>
          <div class="">
            @include('admin.products._form', ['product' => $product, 'backTo' => $backTo])
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
