<div id="asign-{{ $product->slug }}" class="uk-modal-container modal-colorsizes" uk-modal>
  <div class="uk-modal-dialog uk-modal-body">
    <div class="uk-modal-header">
      <h2 class="uk-modal-title uk-text-uppercase">Asignar tamaños a colores</h2>
    </div>
    @if ($product->color_sizes_status)
      <form class="" action="{{ route('products.editasign', $product->slug) }}" method="post">
        {{ csrf_field() }}
        <div class="uk-modal-body">
          <div class="" uk-grid>
            @foreach ($product->sizes as $size)
              @php
                $loop1 = $loop->index;
              @endphp
              <div class="uk-width-1-{{ count($product->sizes) }}">
                <div class="">
                  <div class="">
                    <div class="" uk-grid>
                      <div class="uk-width-1-2">
                        <div class="isee-h3 uk-text-bold">{{ $size->name }}</div>
                      </div>
                      <div class="uk-width-1-2">
                        <div class="isee-h4 uk-text-bold">STOCK</div>
                      </div>
                    </div>
                  </div>
                  <div class="uk-margin">
                    @foreach ($product->colors as $color)
                      @php
                      $stock = 0;
                      $ap_id = $size->attribute_product_id;
                      $id = null;
                      @endphp
                      <div class="uk-flex uk-flex-middle" uk-grid>
                        <div class="uk-width-1-2">
                          <label>
                            <input class="uk-checkbox" type="checkbox" size="{{ $size->slug }}" name="sizes[{{ $loop1 }}][{{ $loop->index }}][color_id]" value="{{ $color->attribute_product_id }}"
                            @foreach ($product->color_sizes as $color_size)
                              @if ($color_size->slug == $size->slug)
                                @foreach ($color_size->colors as $color_s)
                                  @if ($color->slug == $color_s->slug)
                                    checked
                                  @endif
                                @endforeach
                              @endif
                            @endforeach
                            > {{ $color->name }}
                          </label>
                        </div>
                        <div class="uk-width-1-2">
                          @if (isset($product->color_sizes))
                            @foreach ($product->color_sizes as $color_size)
                              @if ($color_size->slug == $size->slug)
                                @if (isset($color_size->colors))
                                  @foreach ($color_size->colors as $color_s)
                                    @if ($color->slug == $color_s->slug)
                                      @php
                                      $id = $color_s->color_size_id;
                                      $stock = $color_s->stock;
                                      $ap_id = $color_size->attribute_product_id;
                                      @endphp
                                    @endif
                                  @endforeach
                                @endif
                              @endif
                            @endforeach
                          @endif
                          <input class="uk-input" type="number" size="{{ $size->slug }}" name="sizes[{{ $loop1 }}][{{ $loop->index }}][stock]" value="{{ isset($stock) ? $stock : 0 }}">
                          <input type="hidden" name="sizes[{{ $loop1 }}][{{ $loop->index }}][size_id]" value="{{ isset($ap_id) ? $ap_id : $size->attribute_product_id }}">
                          <input type="hidden" name="sizes[{{ $loop1 }}][{{ $loop->index }}][id]" value="{{ $id }}">
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
        <div class="uk-modal-footer">
          <div class="uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
            <input type="submit" class="uk-button uk-button-primary uk-light" name="" value="Guardar">
          </div>
        </div>
      </form>
    @else
      <form class="" action="{{ route('products.asign', $product->slug) }}" method="post">
        {{ csrf_field() }}
        <div class="uk-modal-body">
          <div class="" uk-grid>
            @foreach ($product->sizes as $size)
              @php
                $loop1 = $loop->index;
              @endphp
              <div class="uk-width-1-2">
                <div class="isee-h3">{{ $size->name }}</div>
                <div class="uk-margin">
                  @foreach ($product->colors as $color)
                    <div class="uk-flex uk-flex-middle" uk-grid>
                      <div class="uk-width-1-2">
                        <label>
                          <input class="uk-checkbox" type="checkbox" size="{{ $size->slug }}" name="sizes[{{ $loop1 }}][{{ $loop->index }}][color_id]" value="{{ $color->attribute_product_id }}">
                          {{ $color->name }}
                        </label>
                      </div>
                      <div class="uk-width-1-2">
                        <input class="uk-input" type="number" size="{{ $size->slug }}" name="sizes[{{ $loop1 }}][{{ $loop->index }}][stock]" value="0">
                        <input type="hidden" name="sizes[{{ $loop1 }}][{{ $loop->index }}][size_id]" value="{{ $size->attribute_product_id }}">
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        </div>
        <div class="uk-modal-footer">
          <div class="uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Cerrar</button>
            <input type="submit" class="uk-button uk-button-primary uk-light" name="" value="Guardar">
          </div>
        </div>
      </form>
    @endif
  </div>
</div>
