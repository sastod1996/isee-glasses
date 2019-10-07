<a class="uk-button uk-button-default" href="#modal-import-stock" uk-toggle>Importar Stock</a>

<div id="modal-import-stock" uk-modal>
  <form class="uk-modal-dialog" action="{{ route('excel.import-stock') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <button class="uk-modal-close-default" type="button" uk-close></button>
    <div class="uk-modal-header">
      <h2 class="uk-modal-title">Importar stock</h2>
    </div>
    <div class="uk-modal-body">
      <p>Selecciona un archivo Excel.</p>
      <input type="file" name="excel">
    </div>
    <div class="uk-modal-footer uk-text-right">
      <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
      <button class="uk-button uk-button-primary uk-light" type="submit">Subir</button>
    </div>
  </form>
</div>

@push('js')
  <script>
    function onSubmitImport() {
      $('#modal-import-stock').find('.uk-modal-close, .uk-modal-close-default').hide()
      $('#modal-import-stock [type="submit"]').attr('disabled', '')
    }
    $('#modal-import-stock form').submit(onSubmitImport)
  </script>
@endpush
