@extends('layouts.admin')

@section('content')
  <div class="">
    <div class="">
      <div class="">
        <div class="">
          <div class="">
            <h2>
              Popup <strong>{{ $popup->name }}</strong>
            </h2>
            <hr>
            <div class="">
              <div class="">
                @include('admin.popups._form', ['popup' => $popup])
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection

@push('js')
  @if (Session::has('error'))
    <script>
      UIkit.notification({
        message: '<span uk-icon="icon: warning"></span> {{ Session::get('error') }}',
        status: 'danger',
        pos: 'bottom-center',
        timeout: 3000
      });
    </script>
  @endif
@endpush
