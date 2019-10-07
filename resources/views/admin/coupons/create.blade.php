@extends('layouts.admin')

@section('content')
  <div class="">
    <div class="">
      <div class="">
        <div class="">
          <div class="">
            <h2>
              Nuevo Cupón
            </h2>
            <hr>
            <div class="" >
              <div class="">
                @include('admin.coupons._form')
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection
