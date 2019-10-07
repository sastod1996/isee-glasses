<button class="uk-button uk-button-default" id="refresh-random">
  Refrescar orden aleatorio en el catálogo
</button>

@push('js')
  <script>
  $('#refresh-random').click(function (e) {
    var btn = $(this)
    e.preventDefault()
    btn.prop('disabled', true)
    $.post('{{ route('products.refresh-random') }}').done(data => {
      UIkit.notification({
        message: '<span uk-icon="icon: check"></span> Refrescado',
        status: 'success',
        pos: 'bottom-center',
        timeout: 3000
      })
    }).fail(err => {
      console.log(err)
      UIkit.notification({
        message: '<span uk-icon="icon: warning"></span> Error',
        status: 'danger',
        pos: 'bottom-center',
        timeout: 3000
      })
    }).always(() => {
      btn.prop('disabled', false)
    })
  })

  </script>
@endpush
