@extends('layouts.admin')

@push('js')
<script>window.PromoContainer =  {!! json_encode($container) !!};</script>
<script src="{{ mix('js/admin/promo-container.js') }}"></script>
@endpush

@section('content')
    <promo-container></promo-container>
@endsection
