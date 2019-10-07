<h2>
  Nueva solicitud de afiliación,
</h2>

<p>
  Se ha recibido una nueva solicitud para el programa de afiliación.
</p>
<dl>
  <dt><b>Usuario:</b> {{ $user->first_name}} {{ $user->last_name }}</dt>
  <dt><b>Detalles:</b></dt>
  <dd>DNI: {{$request->dni}}</dd>
  <dd>{{isset( $request->facebook) ? 'Facebook: '.$request->facebook : ''}}</dd>
  <dd>{{isset( $request->instagram) ? 'Instagram: '.$request->instagram : ''}}</dd>
  <dd>{{isset( $request->twitter) ? 'Twitter: '.$request->twitter : ''}}</dd>
  <dd>{{isset( $request->youtube) ? 'Youtube: '.$request->youtube : ''}}</dd>
</dl>
<p>
  Para administrar las solicitudes de afiliación ingresa a: <a href="https://isee-glasses.com/admin/affiliates">https://isee-glasses.com/admin/affiliates</a>
</p>
