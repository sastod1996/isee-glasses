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
            Nuevo producto
          </div>
          <div class="">
            @include('admin.products._form')
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
