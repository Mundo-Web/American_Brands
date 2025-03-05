@extends('components.public.matrix', ['pagina' => 'catalogo'])

@section('title', 'Producto Detalle | ' . config('app.name', 'Laravel'))

@section('css_importados')

@stop

@section('content')
  <?php
  // Definición de la función capitalizeFirstLetter()
  // function capitalizeFirstLetter($string)
  // {
  //     return ucfirst($string);
  // }
  ?>
  <style>
    /* imagen de fondo transparente para calcar el dise;o */
    .clase_table {
      border-collapse: separate;
      border-spacing: 10;
    }

    .fixedWhastapp {
      right: 2vw !important;
    }

    .clase_table td {
      /* border: 1px solid black; */
      border-radius: 10px;
      -moz-border-radius: 10px;
      padding: 10px;
    }

    .swiper-pagination-bullet-active {
      background-color: #272727;
    }

    .swiper-pagination-bullet:not(.swiper-pagination-bullet-active) {
      background-color: #979693 !important;
    }

    .blocker {
      z-index: 20;
    }


    @media (min-width: 600px) {
      #offers .swiper-slide {
        margin-right: 100px !important;
      }

      #offers .swiper-slide::before {
        content: '+';
        display: block;
        position: absolute;
        top: 50%;
        right: -70px;
        transform: translateY(-50%);
        font-size: 32px;
        font-weight: bolder;
        color: #ffffff;
        padding: 0px 12px;
        background-color: #0d2e5e;
        border-radius: 50%;
        box-shadow: 0 0 5px rgba(0, 0, 0, .125);
      }

      #offers .swiper-slide:last-child::before {
        content: none;
      }

    }
  </style>

  @php
    $images = ['', '_ambiente'];
    $x = $product->toArray();
    $i = 1;
  @endphp
  @php
    $breadcrumbs = [['title' => 'Inicio', 'url' => route('index')], ['title' => 'Producto', 'url' => '']];
  @endphp
  @php
    $StockActual = $product->stock;
    $maxStock = 100; // maximo stock

    if (!is_null($product->max_stock) > 0) {
        $maxStock = $product->max_stock;
    }
    # calculamos en % cuanto queda en base a 100
    $stock = 0;
    if ($maxStock !== 0) {
        $stock = ($StockActual * 100) / $maxStock;
    }

  @endphp

  @component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
  @endcomponent

  <main class="font-Inter_Regular" id="mainSection">
    @csrf
    <section class="w-full px-[5%] pb-10 lg:pb-20">
      <div class="grid grid-cols-1 lg:grid-cols-5 gap-10  pt-8 lg:pt-16">

        <div class="flex flex-row lg:col-span-3  justify-start items-center lg:items-start gap-2">

          <div class="w-1/5">
            <x-product-slider :product="$product" />
          </div>

          <div id="containerProductosdetail"
            class="w-4/5 flex justify-center items-center  aspect-square  overflow-hidden relative">
            <div id="descuento-container">
              <div
                class="absolute top-[20px] left-0 z-10 text-[14px] sm:text-base font-Urbanist_Regular text-center content-center gap-2 bg-[#c1272d] text-white px-3 lg:px-4 py-[2px] lg:py-1">
                -<span id="porcentajedescuento">50</span> %
              </div>
            </div>
            <div id="imagenProducto" class="w-full h-full">
              <img src="{{ asset($product->imagen) }}" alt="computer" class="w-full h-full object-contain"
                data-aos="fade-up" data-aos-offset="150" onerror="this.onerror=null;this.src='/images/img/noimagen.jpg';">
            </div>
          </div>


        </div>

        <div class="flex flex-col lg:col-span-2 gap-3">

          @if ($product->marcas)
            <img src="{{ asset($product->marcas->url_image) }}"
              onerror="this.onerror=null;this.src='/images/img/noimagen.jpg';" class="w-28 h-auto object-contain" />
          @endif
          <div class="flex flex-col">
            <h3 class="font-Urbanist_Black text-3xl text-[#cccccc]">
              {{ $product->producto }}:
              <span class="text-xl">
                {{ $product->color }} - {{ $product->peso }}
              </span>
            </h3>
          </div>

          <div class="flex flex-col gap-3">

            <div class="flex flex-row gap-3 content-center items-center" id="seccionprecio">
              @if ($product->descuento == 0)
                <div class="content-center flex flex-row gap-2 items-center">
                  <div class="font-Urbanist_Bold text-2xl gap-2 text-[#c1272d]">S/
                    <span class="precionormal">{{ $product->precio }}</span>
                  </div>
                </div>
              @else
                <div class="content-center flex flex-row gap-2 items-center">
                  <div class="font-Urbanist_Bold text-2xl gap-2 text-[#c1272d]">S/
                    <span class="preciodescuento">{{ $product->descuento }}</span>
                  </div>
                  <div class="text-[#acacac] font-Urbanist_Regular line-through text-lg">S/
                    <span class="precionormal">{{ $product->precio }}</span>
                  </div>
                </div>
                @php
                  $descuento = round((($product->precio - $product->descuento) * 100) / $product->precio);
                @endphp
                <div
                  class="ml-2 font-Urbanist_Regular text-center content-center text-base gap-2 font-bold bg-[#c1272d] text-white px-4 py-1">
                  -<span id="porcentajedescuento">{{ $descuento }}</span> % </div>
              @endif
            </div>

            @isset($product->discount)
              <span class="text-[#c1272d] ">👀 {{ $product->discount->name }}</span>
            @endisset

            <div class="h-1 border-b-[2px] border-b-[#cccccc] my-4"></div>

            <div class="flex flex-col gap-5">
              <div class="flex flex-row gap-3">

                @if ($otherProducts->isNotEmpty())
                  <div class="flex flex-col w-1/5 justify-center items-start uppercase font-Urbanist_Black">
                    <h2>Colores:</h2>
                  </div>
                  <div class="flex flex-wrap w-4/5 gap-2 lg:gap-4 justify-start items-center font-Urbanist_Medium">
                    <a class="ring-1 rounded-full p-[3px] ring-[#3f3f3f]" tippy data-tippy-content="Seleccionado">
                      <div class="flex justify-center items-center">
                        <div class="w-7 lg:w-9 h-7 lg:h-9 rounded-full overflow-hidden">
                          <img class="object-contain object-center" src="{{ asset($product->imagen) }}" />
                        </div>
                      </div>
                    </a>

                    @foreach ($otherProducts as $x)
                      @if (!empty($x->imagen))
                        <a class="ring-1 rounded-full p-[3px] ring-transparent hover:ring-[#3f3f3f]"
                          href="{{ route('producto', $x->slug) }}">
                          <div class="flex justify-center items-center">
                            <div class="w-7 lg:w-9 h-7 lg:h-9 rounded-full overflow-hidden">
                              <img class="object-contain object-center" src="{{ asset($x->imagen) }}" />
                            </div>
                          </div>
                        </a>
                      @endif
                    @endforeach
                  </div>
                @endif
              </div>


              <div class="flex flex-row gap-3">
                <div class="flex flex-col w-1/5 justify-center items-start uppercase font-Urbanist_Black">
                  <span>Tallas:</span>
                </div>
                <div class="flex flex-wrap w-4/5 gap-2 lg:gap-4 justify-start items-center font-Urbanist_Medium">
                  <div id="talla-{{ $product->id }}" data-productid="{{ $product->id }}"
                    class="tallaSelected tallas ring-1 p-[3px] flex items-center justify-center cursor-pointer  rounded-full hover:ring-1  ring-[#3f3f3f]">
                    <div class="flex justify-center items-center w-7 lg:w-8 h-7 lg:h-8 text-base transition talla-span">
                      {{ $product->peso }}
                    </div>
                  </div>
                  @foreach ($tallasdeProductos as $t)
                    <div id="talla-{{ $t->id }}" data-productid="{{ $t->id }}"
                      class="tallas flex items-center justify-center p-[3px] cursor-pointer  rounded-full hover:ring-1  ring-[#3f3f3f]">
                      <div class="flex justify-center items-center text-base w-7 lg:w-8 h-7 lg:h-8 transition talla-span">
                        {{ $t->peso }}
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>

              {{-- @if (!$product->attributes->isEmpty())
                                <div class="flex flex-row gap-3">
                                  @php
                                    $groupedAttributes = $product->attributes->groupBy('titulo');
                                  @endphp
                      
                                  @foreach ($groupedAttributes as $titulo => $items)
                                    @php
                                      $filteredItems = $items->filter(function($item) {
                                        return in_array($item->pivot->attribute_id, [3]);
                                      });
                                    @endphp
                                    @if ($filteredItems->isNotEmpty())
                                        <div class="flex flex-col w-1/5 justify-center items-start uppercase font-Urbanist_Black">
                                          <span>{{ $titulo }}:</span>
                                        </div>
                                        <div class="flex flex-wrap w-4/5 gap-5 justify-start items-center font-Urbanist_Medium">
                                          @foreach ($items as $item)
                                            
                                              @php
                                                $atributo = $valorAtributo->firstWhere('id', $item->pivot->attribute_value_id);
                                              @endphp

                                              @if ($atributo)
                                                <span class="flex justify-center items-center">{{ $atributo->valor }}</span>
                                              @endif
                                            
                                          @endforeach
                                        </div>
                                    @endif
                                  @endforeach
                                </div>
                              @endif --}}

              {{-- <div class="flex flex-row gap-3">
                                     <div class="flex flex-col w-1/5 justify-start items-start uppercase font-Urbanist_Black">
                                          <h2>Tallas</h2>
                                    </div>

                                    <div class="flex flex-wrap w-4/5 gap-5 justify-start items-center font-Urbanist_Medium">
                                        <div class="flex justify-center items-center">28</div>
                                        <div class="flex justify-center items-center">30</div>
                                        <div class="flex justify-center items-center">32</div>
                                        <div class="flex justify-center items-center">34</div>
                                    </div>
                              </div> --}}
                @php
                  use Illuminate\Support\Facades\File;
                  $imagenAmbiente = $product->imagen_ambiente;
                  $rutaImagen = public_path($imagenAmbiente);
                  $isImage = $imagenAmbiente && File::exists($rutaImagen);
                @endphp
              
                @if ($isImage)
                  <div class="flex flex-row">
                    <div id="linkmodal" class="flex flex-row gap-2 border w-auto px-3 py-1 border-black cursor-pointer">
                      <img class="h-4 object-contain" src="{{ asset('images/img/ruler.png') }}" />
                      <p class="font-Urbanist_Bold text-sm">GUÍA DE TALLAS</p>
                    </div>
                  </div>
                @endif

            </div>


            <div class="h-1 border-b-[2px] border-b-[#cccccc] my-4"></div>

          </div>

          {{-- @if ($otherProducts->isNotEmpty())
                        <p class="mb-2 "><b>Característica</b>:
                        <span class="block bg-[#F5F5F7] p-3 mt-2" tippy> {{ $product->color }}</span>
                        
                        <p class="-mb-4 "><b>Otras opciones</b>:</p>
                                
                            <div class="flex flex-wrap gap-2">
                                @foreach ($otherProducts as $x)
                                <a class="block bg-[#F5F5F7] hover:bg-[#ebebf2] p-3" href="/producto/{{ $x->slug }}" tippy> {{ $x->color }}</a>
                                @endforeach
                            </div>

                    @endif --}}

          {{-- @if (!$product->attributes->isEmpty())
                        <div class="flex flex-col gap-8 mt-4 font-Inter_Regular text-lg">
                            @php
                                $groupedAttributes = $product->attributes->groupBy('titulo');
                            @endphp

                            @foreach ($groupedAttributes as $titulo => $items)
                                <div class="flex flex-row gap-3 text-center text-base font-Inter_Medium">
                                    <span>{{ $titulo }}:</span>
                                    @foreach ($items as $item)
                                        @php
                                            // Encuentra el objeto en $valorAtributo que tiene el id igual a $item->pivot->attribute_value_id
                                            $atributo = $valorAtributo->firstWhere(
                                                'id',
                                                $item->pivot->attribute_value_id,
                                            );
                                        @endphp
                                        @if ($atributo)
                                            <!-- Muestra el valor del atributo encontrado -->
                                            <span
                                                class="bg-[#006BF6] text-white rounded-md px-5 text-base">{{ $atributo->valor }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endif --}}

          {{-- @if (!$especificaciones->isEmpty())
                        <p class="font-Inter_Medium text-base gap-2 ">Especificaciones: </p>
                        <div class="min-w-full divide-y divide-gray-200">
                            <table class=" divide-y divide-gray-200 ">
                                <tbody>
                                    @foreach ($especificaciones as $item)
                                        <tr>
                                            <td class="px-4 py-1 border border-gray-200">
                                                {{ $item->tittle }}
                                            </td>
                                            <td class="px-4 py-1 border border-gray-200">
                                                {{ $item->specifications }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif --}}

          @if ($product->status == 1 && $product->visible == 1)
            <div class="flex flex-col gap-4">
              <div class="flex flex-col md:flex-row gap-1 md:gap-5 items-start">
                <div class="flex flex-row gap-5 justify-start items-center w-auto order-2 md:order-1">

                  <button id="btnAgregarCarritoPr" data-id="{{ $product->id }}"
                    class="bg-black w-full py-3 px-5 xl:px-8  text-white text-center uppercase font-Urbanist_Medium tracking-wide text-base">
                    Agregar
                    a la bolsa
                  </button>

                </div>
                <div class="flex order-1 md:order-2">
                  <div class="flex justify-center items-center cursor-pointer rounded-l-3xl">
                    <button class="py-2.5 px-5 text-lg font-Helvetica_Bold rounded-full bg-transparent m-1 text-black"
                      id=disminuir type="button">-</button>
                  </div>
                  <div id=cantidadSpan
                    class="py-2.5 px-5 flex justify-center items-center bg-transparent text-lg font-Urbanist_Bold">
                    <span>1</span>
                  </div>
                  <div class="flex justify-center items-center cursor-pointer rounded-r-3xl">
                    <button class="py-2.5 px-5 text-lg font-Helvetica_Bold rounded-full bg-transparent m-1 text-black"
                      id=aumentar type="button">+</button>
                  </div>
                </div>

              </div>
            </div>
          @endif


          <div class="flex flex-col justify-center items-start">
            @if ($product->sku)
              <p class="font-Urbanist_Regular text-base text-[#444]">SKU: <span id="num_sku">{{ $product->sku }}</span>
              </p>
            @endif

            @if ($product->sku)
              <p class="font-Urbanist_Regular text-base text-[#444]">Stock: <span
                  id="num_stock">{{ number_format($product->stock, 0) }}</span>
              </p>
            @endif
          </div>

          <div class="!text-lg !font-Urbanist_Regular w-full mt-2 text-[#444]">
            {!! $product->description !!}
          </div>



        </div>
      </div>
    </section>


    @if (count($ProdComplementarios) > 0)
      <div class="px-[5%]">
        <div class="h-1 border-b-[2px] border-b-[#cccccc]"></div>
      </div>

      <section class="bg-white py-10 lg:py-14">
        <div class="w-full px-[5%]">
          <div class="flex flex-col">
            <h1 class="text-3xl font-Urbanist_Bold text-center tracking-tight">PODRÍA GUSTARTE</h1>
          </div>
          <div class="mt-12">
            <div class="swiper productos-relacionados h-max">
              <div class="swiper-wrapper">
                @foreach ($ProdComplementarios->take(10) as $item)
                  <div class="swiper-slide">
                    <x-product.container width="col-span-1 " bgcolor="bg-[#FFFFFF]" :item="$item" />
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </section>
    @endif


    <div id="modaltallas" class="modal" style="max-width: 900px !important; width: 100% !important;  ">
      <!-- Modal body -->
      <div class="p-1 flex flex-col overflow-hidden">
        <img id="zoomImage" class="object-contain w-full h-full" src="{{ asset($product->imagen_ambiente) }}" />
      </div>
    </div>

  </main>

  <style>
    #zoomImage {
      transition: transform 0.3s ease;
    }
  </style>

@section('scripts_importados')
  <script>
    const zoomImage = document.getElementById('zoomImage');

    zoomImage.addEventListener('mousemove', (e) => {
      const rect = zoomImage.getBoundingClientRect();
      const x = e.clientX - rect.left; // Posición X del mouse en la imagen
      const y = e.clientY - rect.top; // Posición Y del mouse en la imagen

      // Ajustar el nivel de zoom y la posición
      zoomImage.style.transformOrigin = `${x}px ${y}px`;
      zoomImage.style.transform = 'scale(1.5)'; // Ajusta el nivel de zoom según sea necesario
    });

    zoomImage.addEventListener('mouseleave', () => {
      zoomImage.style.transform = 'scale(1)'; // Restaura el zoom al salir
    });
  </script>
  <script>
    var headerServices = new Swiper(".productos-relacionados", {
      slidesPerView: 4,
      spaceBetween: 10,
      loop: false,
      centeredSlides: false,
      initialSlide: 0, // Empieza en el cuarto slide (índice 3) */
      /* pagination: {
        el: ".swiper-pagination-estadisticas",
        clickable: true,
      }, */
      //allowSlideNext: false,  //Bloquea el deslizamiento hacia el siguiente slide
      //allowSlidePrev: false,  //Bloquea el deslizamiento hacia el slide anterior
      allowTouchMove: true, // Bloquea el movimiento táctil
      autoplay: {
        delay: 5500,
        disableOnInteraction: true,
        pauseOnMouseEnter: true
      },

      breakpoints: {
        0: {
          slidesPerView: 1,
          centeredSlides: true,
          loop: false,
        },
        420: {
          slidesPerView: 2,
          centeredSlides: false,

        },
        700: {
          slidesPerView: 3,
          centeredSlides: false,

        },
        850: {
          slidesPerView: 4,
          centeredSlides: false,

        },
      },
    });
  </script>

  <script>
    function capitalizeFirstLetter(string) {
      string = string.toLowerCase()
      return string.charAt(0).toUpperCase() + string.slice(1);
    }

    var productId = {{ $product->id }};
    var stock = {{ $product->stock }};

    const getAlreadyInCart = (id) => {
      return (Local.get('carrito') ?? []).find(x => x.id == id)?.cantidad ?? 0
    }

    // })
    $('#disminuir').on('click', function() {
      let cantidad = Number($('#cantidadSpan span').text())
      if (cantidad > 0) {
        cantidad--
        $('#cantidadSpan span').text(cantidad)
      }


    })
    // cantidadSpan
    $('#aumentar').on('click', function() {
      let cantidad = Number($('#cantidadSpan span').text())
      let already = getAlreadyInCart(productId);
      cantidad++
      if (cantidad > (stock - already)) return Swal.fire({
        title: 'No hay suficiente stock',
        text: `No se puede agregar más de ${stock} items de este producto ${already>0?`\nYa tienes ${already} items agregados en el carrito`: ''}`,
        icon: 'warning',
        confirmButtonText: 'Aceptar'
      })
      $('#cantidadSpan span').text(cantidad)

    })
  </script>

  <script>
    $(document).ready(function() {

      $(document).on('click', '#linkmodal', function() {
        $('#modaltallas').modal({
          show: true,
          fadeDuration: 400,
        })
      })

    })
  </script>

  <script>
    $(document).ready(function() {

      function buscarTallaProducto() {
        let tallaSelected = $('.tallaSelected');
        productId = tallaSelected.data('productid');

        $.ajax({
          url: '{{ route('buscarTalla') }}',
          method: 'POST',
          data: {
            idproduct: productId,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $('#num_sku').text(response.producto[0].sku);
            $('#btnAgregarCarritoPr').attr('data-id', response.producto[0].id);

            // alter the url, set the slug as /producto/{slug}
            const slug = response.producto[0].slug; // Obtener el slug del producto
            const newUrl = `/producto/${slug}`; // Establecer la nueva URL
            window.history.pushState({
              path: newUrl
            }, '', newUrl);

            //$('#num_stock').text(Math.floor(response.producto[0].stock));
            stock = Number(response.producto[0].stock);
            let precio = parseFloat(response.producto[0].precio);
            let descuento = parseFloat(response.producto[0].descuento);

            let porcentajeDescuento = 0;
            let seccionPrecioHTML = '';
            let descuentoHTML = '';

            // Validar si hay descuento
            if (descuento > 0 && descuento < precio) {
              porcentajeDescuento = Math.round((precio - descuento) * 100 / precio);
              seccionPrecioHTML += `
                      <div class="content-center flex flex-row gap-2 items-center">
                          <div class="font-Urbanist_Bold text-2xl gap-2 text-[#c1272d]">S/
                              <span class="preciodescuento">${descuento.toFixed(2)}</span>
                          </div>
                          <div class="text-[#acacac] font-Urbanist_Regular line-through text-lg">S/
                              <span class="precionormal">${precio.toFixed(2)}</span>
                          </div>
                      </div>
                      <div class="ml-2 font-Urbanist_Regular text-center content-center text-base gap-2 bg-[#c1272d] text-white px-4 py-1">
                          -<span id="porcentajedescuento-value">${porcentajeDescuento}</span> %
                      </div>
                  `;

              descuentoHTML = `
                        <div class="absolute top-[20px] left-0 z-10 text-[14px] sm:text-base font-Urbanist_Regular text-center content-center gap-2 bg-[#c1272d] text-white px-3 lg:px-4 py-[2px] lg:py-1">
                            -<span id="porcentajedescuento">${porcentajeDescuento}</span> %
                        </div>
                    `;

            } else {
              seccionPrecioHTML += `
                      <div class="content-center flex flex-row gap-2 items-center">
                          <div class="font-Urbanist_Bold text-2xl gap-2 text-[#c1272d]">S/
                              <span class="precionormal">${precio.toFixed(2)}</span>
                          </div>
                      </div>
                  `;
            }

            if (descuento > 0 && descuento < precio) {
              $('#descuento-container').html(descuentoHTML);
            } else {
              $('#descuento-container').empty();
            }

            $('#seccionprecio').html(seccionPrecioHTML);

            // INICIO: regulariza el stock
            if ($('#cantidadSpan span').text() == 0) $('#cantidadSpan span').text(1); 
            const already = getAlreadyInCart(productId);
            if ($('#cantidadSpan span').text() > (stock - already)) {
              $('#cantidadSpan span').text(stock - already)
            }
            // FIN: regulariza el stock

            if (Number(stock) > 0) {
              //console.log('numero mayora a 0 ')
              $('#num_stock').text(`${Math.floor(stock)}`)
              $('#btnAgregarCarritoPr')
                .removeClass('opacity-50 cursor-not-allowed')
                .attr('disabled', false);
            } else {
              $('#num_stock').text(`No hay Stock`)
              $('#btnAgregarCarritoPr')
                .addClass('opacity-50 cursor-not-allowed')
                .attr('disabled', true);
            }


          },
          error: function(xhr) {
            console.log(xhr.responseText);
          }
        });
      }

      $(document).on('click', '.tallas', function() {
        $('.tallas').removeClass('tallaSelected');
        $('.tallas').removeClass('ring-1');

        $(this).addClass('tallaSelected');
        $(this).addClass('ring-1');

        buscarTallaProducto();
      });

      buscarTallaProducto();
    });
  </script>

  <script>
    var appUrl = <?php echo json_encode($url_env); ?>;
    $(document).ready(function() {
      articulosCarrito = Local.get('carrito') || [];

      // PintarCarrito();
    });
  </script>



@stop

@stop
