@push('css')
  <link rel="stylesheet" href="/css/site/pages/contactanos.css">
@endpush

@extends('layouts.site')

@section('content')



  <div class="uk-section uk-background-cover uk-background-default">
    <div class="uk-section-small uk-padding-remove-bottom">
      <div class="uk-container uk-container-small isee-spacing-small uk-text-center">
        <p class="uk-h1 isee-bold">
          @lang('contactanos.contactanos')
        </p>
        <p class="uk-h3 isee-bold">
          @lang('contactanos.mensaje1')
        </p>
      </div>
    </div>
  </div>

  @php
    $user = Auth::user();
  @endphp

  <div class="uk-section uk-padding-remove-top uk-margin">
    <div class="uk-container uk-container-small">
      <form class="uk-grid-small" action="/submit" method="post" uk-grid>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="uk-width-1-2@s">
          <input class="uk-input uk-form-large" name="first_name" type="text" placeholder="@lang('forms.nombres')" required value="{{ isset($user) ? $user->first_name : '' }}">
        </div>
        <div class="uk-width-1-2@s">
          <input class="uk-input uk-form-large" name="last_name" type="text" placeholder="@lang('forms.apellidos')" required value="{{ isset($user) ? $user->last_name : '' }}">
        </div>
        <div class="uk-width-1-2@s">
          <input class="uk-input uk-form-large" name="email" type="email" placeholder="@lang('forms.correo')" required value="{{ isset($user) ? $user->email : '' }}">
        </div>
        <div class="uk-width-1-2@s">
          <input id="telephone" class="uk-input uk-form-large" name="telephone" type="tel"  placeholder="@lang('forms.tlf')" value="{{ isset($user) ? $user->telephone : '' }}" maxlength="15">
        </div>
        <div class="uk-width-1-1">
          <textarea class="uk-textarea uk-form-large" name="body" rows="5" placeholder="@lang('forms.question-contactanos')" required></textarea>
        </div>
        <div class="uk-margin-auto">
          <button class="isee-h3 uk-button uk-button-large uk-light isee-bold isee-background-green" type="submit">@lang('contactanos.enviar')</button>
        </div>
      </form>
    </div>
  </div>

@endsection

@push('js')
  @if (session('status'))
    <script type="text/javascript">
      UIkit.notification({
        message: '<i uk-icon="icon: check"></i> ¡Mensaje enviado!',
        status: 'success',
        pos: 'top-center',
        timeout: 5000
      });
    </script>
  @endif

@endpush

@push('js')
  <script>
  $(document).ready(function() {
    $("#telephone").keydown(function (e) {
      // Allow: backspace, delete, tab, escape, enter and .
      if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
      // Allow: Ctrl+A, Command+A
      (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
      // Allow: home, end, left, right, down, up
      (e.keyCode >= 35 && e.keyCode <= 40)) {
        // let it happen, don't do anything
        return;
      }
      // Ensure that it is a number and stop the keypress
      if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
      }
    });
  });
  </script>
@endpush
