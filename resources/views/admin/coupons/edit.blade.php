@extends('layouts.admin')

@section('content')
  <div class="">
    <div class="">
      <div class="">
        <div class="">
          <div class="">
            <h2>
              Cupón <strong>{{ $coupon->code }}</strong>
            </h2>
            <hr>
            <div class="">
              <div class="">
                @include('admin.coupons._form', ['coupon' => $coupon])
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection
