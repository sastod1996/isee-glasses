@extends('layouts.admin')

@section('content')
  <div class="">
    <div class="">
      <div class="">
        <div class="uk-flex uk-flex-between">
          <div class="uk-h2">
            Descuentos por Convenio
          </div>
          {{-- <div class="">
            <a class="uk-button uk-button-default" href="{{ route('') }}">Crear Descuento</a>
          </div> --}}
        </div>
        <div class="">
          <table class="uk-table uk-table-responsive uk-table-middle uk-table-divider">
            <thead>
              <tr>
                <th class="uk-width-small">Descripción</th>
                <th class="uk-width-small">Porcentaje</th>
                <th class="uk-width-small">Monto Máx.</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td> Dcto. Monofocales </td>
                <td> 30% </td>
                <td> S/ 60 </td>
              </tr>
              <tr>
                <td> Dcto. Multifocales </td>
                <td> 20% </td>
                <td> S/ 100 </td>
              </tr>
              <tr>
                <td> Dcto. Bifocales </td>
                <td> 25% </td>
                <td> S/ 80 </td>
              </tr>
              <tr>
                <td> Dcto. Lentes de contacto </td>
                <td> 30% </td>
                <td> - </td>
              </tr>
              <tr>
                <td> Dcto. Monturas marca Premium </td>
                <td> 30% </td>
                <td> - </td>
              </tr>
              <tr>
                <td> Dcto. Monturas marca Regular </td>
                <td> 50% </td>
                <td> - </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
