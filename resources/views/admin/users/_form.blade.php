<form class="form-horizontal" method="POST" action="{{ isset($user) ? route('users.update', ['id' => $user->id]) : route('users.store') }}">

  {{ csrf_field() }}

  @if (isset($user))
    <input type="hidden" name="_method" value="put">
  @endif

  <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
    <label for="first_name" class="col-md-3 control-label">Nombres</label>
    <div class="col-md-9">
      <input name="first_name" type="text" class="form-control" id="first_name" value="{{ old('first_name', isset($user) ? $user->first_name : '') }}">
      @if ($errors->has('first_name'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('first_name') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
    <label for="last_name" class="col-md-3 control-label">Apellidos</label>
    <div class="col-md-9">
      <input name="last_name" type="text" class="form-control" id="last_name" value="{{ old('last_name', isset($user) ? $user->last_name : '') }}">
      @if ($errors->has('last_name'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('last_name') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    <label for="email" class="col-md-3 control-label">Email</label>
    <div class="col-md-9">
      <input name="email" type="email" class="form-control" id="email" value="{{ old('email', isset($user) ? $user->email : '') }}">
      @if ($errors->has('email'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('email') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    <label for="password" class="col-md-3 control-label">Contraseña</label>
    <div class="col-md-9">
      @if(isset($user))
        <div class="input-group">
          <input type="password" class="form-control" id="password" value=""
          placeholder="Sin cambios" disabled>
          <div class="input-group-btn">
            <button type="button" role="show" class="btn btn-default edit-pass">
              <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar
            </button>
            <button type="button" id="see_password" class="btn btn-default" style="display: none;">
              <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Ver
            </button>
            <button type="button" role="cancel" class="btn btn-default edit-pass" style="display: none;">
              <span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar
            </button>
          </div>
        </div>
      @else
        <input name="password" type="password" class="form-control" id="password" value="">
      @endif
      @if ($errors->has('password'))
        <div class="uk-text-danger">
          <strong>{{ $errors->first('password') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="form-group">
    <label for="" class="col-md-3 control-label"></label>
    <div class="col-md-9">
      <input class="btn btn-primary" type="submit" value="Guardar">
      <a class="uk-button uk-button-default" href="{{ route('users.index') }}">REGRESAR</a>
    </div>
  </div>

</form>

@push('js')
  <script src="/js/admin/partials/_form_users.js" charset="utf-8"></script>
@endpush
