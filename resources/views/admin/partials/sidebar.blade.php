@php
  $links = json_decode(json_encode([
    [
      'url' => '/admin/products',
      'text' => 'Productos',
      'role' => 1
    ],
    [
      'url' => '/admin/coupons',
      'text' => 'Cupones',
      'role' => 1
    ],
    [
      'url' => '#',
      'text' => 'Órdenes',
      'role' => 1,
      'childs' => [
        [
          'url' => '/admin/show-orders/1',
          'text' => 'Órdenes en proceso'
        ],
        [
          'url' => '/admin/show-orders/2',
          'text' => 'Órdenes finalizadas'
        ]
      ]
    ],
    [
      'url' => '#',
      'text' => 'Programa de Afiliación',
      'role' => 1,
      'childs' => [
        [
          'url' => '/admin/new-affiliates',
          'text' => 'Solicitudes de afiliación'
        ],
        [
          'url' => '/admin/affiliates',
          'text' => 'Afiliados'
        ]
      ]
    ],
    [
      'url' => '/admin/clients',
      'text' => 'Clientes',
      'role' => 1,
      'childs' => [
        [
          'url' => '/admin/discount-allies',
          'text' => 'Descuentos por Convenios'
        ]
      ]
    ],
    [
      'url' => '/admin/enterprises',
      'text' => 'Empresas',
      'role' => 1
    ],
    [
      'url' => '/admin/sliders',
      'text' => 'Sliders',
      'role' => 1
    ],
    [
      'url' => '/admin/promotions',
      'text' => 'Promociones',
      'role' => 1
    ],
    [
      'url' => '/admin/typepacks',
      'text' => 'Tipo/Paquetes',
      'role' => 1
    ],
    [
      'url' => '/admin/attributes',
      'text' => 'Atributos',
      'role' => 1
    ],
    [
      'url' => '/admin/popups',
      'text' => 'Pop-ups',
      'role' => 1
    ]
  ]));
@endphp

<div class="">
  <ul class="uk-list">
    @if (Auth::user()->email == 'service@isee-glasses.com')
      <li>
        <a class="uk-link-reset">Órdenes</a>
        <ul>
          <li><a class="uk-link-reset" href="{{ url('/admin/show-orders/1') }}">- Órdenes en proceso</a></li>
        </ul>
      </li>
    @elseif (Auth::user()->email == 'asistente@isee-glasses.com' || Auth::user()->email == 'diseno@isee-glasses.com')
      <li>
        <a class="uk-link-reset" href="/admin/products">Productos</a>
      </li>
    @else
      @foreach ($links as $link)
        <li>
          @if (Auth::user()->is_administrator())
            <a class="uk-link-reset" href="{{ url($link->url) }}">
              {{ $link->text }}
            </a>
            @if (isset($link->childs))
              <ul class="uk-list">
                @foreach ($link->childs as $child)
                  <li><a class="uk-link-reset" href="{{ url($child->url) }}">- {{ $child->text}}</a></li>
                @endforeach
              </ul>
            @endif

          @elseif(Auth::user()->is_client() || Auth::user()->is_affiliate())
            @if ($link->role == 2)
              <a class="uk-link-reset" href="{{ url($link->url) }}">
                {{ $link->text }}
              </a>
            @endif
          @endif
        </li>
      @endforeach
    @endif
  </ul>
</div>
