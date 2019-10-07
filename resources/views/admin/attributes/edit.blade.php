@extends('layouts.admin')

@section('content')

  <div class="">
    <div class="">
      <div class="">

      </div>
      <div class="">
        <div class="">
          <div class="uk-h2">
            Editar atributo <strong>{{ $attribute->name }}</strong>
          </div>
          <div class="">
            @include('admin.attributes._form', ['attribute' => $attribute])
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
