<a class="uk-button uk-button-secondary" href="#modal-import-products" uk-toggle>Importar Productos</a>

<div id="modal-import-products" uk-modal>
  <form class="uk-modal-dialog" action="{{ route('excel.import-products') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <button class="uk-modal-close-default" type="button" uk-close></button>
    <div class="uk-modal-header">
      <h2 class="uk-modal-title">Importar productos</h2>
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
      $('#modal-import-products').find('.uk-modal-close, .uk-modal-close-default').hide()
      $('#modal-import-products [type="submit"]').attr('disabled', '')
    }
    $('#modal-import-products form').submit(onSubmitImport)
  </script>
@endpush
