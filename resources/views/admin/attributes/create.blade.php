@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Nuevo atributo
          </div>
          <div class="">
            @include('admin.attributes._form')
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
@push('js')
  <script>
    $('input[name=premium]').on( "click", function() {
      $('#view').val($(this).val());
    });
  </script>
@endpush
