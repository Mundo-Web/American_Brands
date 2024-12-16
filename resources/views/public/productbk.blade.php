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
    <section class="w-full px-[5%] md:px-[8%]">
      <div class="grid grid-cols-1 2md:grid-cols-2 gap-10 md:gap-16 pt-8 lg:pt-16">
        {{-- grid grid-col-1 sm:grid-cols-3  gap-6  mt-5 h-max w-6/12 --}}
        {{-- flex flex-col justify-center items-center gap-5 h-max w-6/12 --}}
        <div class="flex flex-col justify-start items-center gap-5">
          {{-- <div class="col-span-3 h-max md:h-[400px] 2xl:h-[580px]  " id="containerProductosdetail">
                    <img class="w-full h-max md:h-[400px] 2xl:h-[580px] object-cover" src="{{ asset($product->imagen) }}"
                        alt="">
                </div> --}}
          <div id="containerProductosdetail"
            class="w-full flex justify-center items-center h-[330px] 2xs:h-[400px] sm:h-[450px] xl:h-[550px] rounded-3xl overflow-hidden">
            <img src="{{ asset($product->imagen) }}" alt="computer" class="w-full h-full object-contain" data-aos="fade-up"
              data-aos-offset="150" onerror="this.onerror=null;this.src='/images/img/noimagen.jpg';">
          </div>
          <x-product-slider :product="$product" />
        </div>
        <div class="flex flex-col gap-6  mt-4">
          <div class="flex flex-col gap-3">
            <h3 class="font-Inter_Medium text-4xl text-[#333] font-normal tracking-tight"> {{ $product->producto }}</h3>
            <p class="font-Inter_Regular text-base gap-2">Disponibilidad:
              @if ($product->stock == 0)
                <span class="text-[#f6000c]">No hay Stock disponible</span>
              @else
                <span class="text-[#006BF6]">Quedan {{ round((float) $product->stock) }} en stock</span>
              @endif
            </p>
            <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
              <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $stock }}%"></div>
            </div>
          </div>

          <div class="flex flex-col gap-3 ">
            @if ($product->sku)
              <p class="font-Inter_Regular text-[15.34px] gap-2 text-[#666666] mt-2">SKU: {{ $product->sku }}</p>
            @endif


            @if ($is_reseller)
              <div class="flex flex-col gap-3 content-start items-start mt-4">

                <div class="content-center flex flex-row gap-2 items-center ">
                  <span class="font-Inter_Regular text-sm gap-2 text-[#666666] line-through">S/
                    {{ $product->descuento }}</span>
                  <span class="text-[#666666] font-Inter_Regular line-through text-sm">S/
                    {{ $product->precio }}</span>
                </div>
                <div class="content-center flex flex-row gap-2 items-center ">
                  Reseller:
                  <span class="font-Inter_SemiBold text-3xl gap-2 text-[#006BF6]">S/
                    {{ $product->precio_reseller }}</span>
                </div>
              </div>
            @else
              <div class="flex flex-row gap-3 content-center items-center mt-4">
                @if ($product->descuento == 0)
                  <div class="content-center flex flex-row gap-2 items-center">
                    <span class="font-Inter_SemiBold text-3xl gap-2 text-[#006BF6]">Precio Regular S/
                      {{ $product->precio }}</span>
                  </div>
                @else
                  <div class="content-start flex flex-col gap-2 ">
                    <div>
                      <span class="font-Inter_SemiBold text-2xl gap-2 text-[#006BF6]">Precio Promo: S/
                        {{ $product->descuento }}</span>

                    </div>
                    <div>
                      <span>Precio Regular</span>
                      <span class="text-[#15294C] opacity-80 font-Inter_Regular line-through text-sm"> S/
                        {{ $product->precio }}</span>
                    </div>

                  </div>
                  @php
                    $descuento = round((($product->precio - $product->descuento) * 100) / $product->precio);
                  @endphp
                  <span
                    class="ml-2 font-Inter_Medium text-center content-center text-xs gap-2 bg-[#006BF6] text-white h-9 w-16 rounded-3xl px-2">
                    -{{ $descuento }}% </span>
                @endif
              </div>

            @endif



            <div class="font-medium text-base font-Inter_Regular w-full mt-4 text-[#444] text-justify">
              {!! $product->description !!}
            </div>
          </div>

          @if (!$product->attributes->isEmpty())
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
                      $atributo = $valorAtributo->firstWhere('id', $item->pivot->attribute_value_id);
                    @endphp
                    @if ($atributo)
                      <!-- Muestra el valor del atributo encontrado -->
                      <span class="bg-[#006BF6] text-white rounded-md px-5 text-base">{{ $atributo->valor }}</span>
                    @endif
                  @endforeach
                </div>
              @endforeach
            </div>
          @endif

          @if (!$especificaciones->isEmpty())
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
          @endif

          <div class="flex flex-col xl:flex-row gap-6 font-Inter_Regular text-base">
            <div class="flex flex-row gap-2 items-center">
              <i class="h-5 w-5 inline-block"
                style="background-image: url('{{ asset('images/img/carrito.png') }}'); background-size: contain; background-position: center; background-repeat: no-repeat;"></i>
              <span class=""> Envio a Domicilio</span>
            </div>
            <div class="flex flex-row gap-2 items-center">
              <img src="{{ asset('images/img/WhatsApp.png') }}" alt="whatsapp" class="w-8" />
              <a href="https://api.whatsapp.com/send?phone={{ $general->whatsapp }}&text=Hola! Quería solicitar informacion para el producto  {{ $product->producto }}. 
                "
                target="_blank" class="">Preguntar sobre este producto</a>
            </div>
          </div>

          <div class="flex flex-col gap-4">
            <div class="flex flex-col xl:flex-row gap-5">
              <div class="flex mb-4">
                <div class="flex justify-center items-center bg-[#F5F5F5] cursor-pointer hover:bg-slate-300">
                  <button class="py-2.5 px-5 text-lg font-Inter_SemiBold" id=disminuir type="button">-</button>
                </div>
                <div id=cantidadSpan
                  class="py-2.5 px-5 flex justify-center items-center bg-[#F5F5F5] text-lg font-Inter_SemiBold">
                  <span>1</span>
                </div>
                <div class="flex justify-center items-center bg-[#F5F5F5] cursor-pointer hover:bg-slate-300">
                  <button class="py-2.5 px-5 text-lg font-Inter_SemiBold" id=aumentar type="button">+</button>
                </div>
              </div>
              <div class="xl:ml-8 flex flex-row gap-5 justify-start items-center">
                @if ($product->status == 1 && $product->visible == 1)
                  <button id="btnAgregarCarritoPr" data-id="{{ $product->id }}"
                    class="bg-[#0D2E5E] w-[286px] h-16  text-white text-center rounded-full font-Inter_SemiBold tracking-wide text-lg hover:bg-[#1E8E9E]">
                    Agregar
                    al Carrito
                  </button>
                @endif

                @if (Auth::user() !== null)
                  <button
                    class=" @if ($isWhishList) bg-[#0D2E5E]  @else bg-[#99b9eb] @endif w-12 h-12 rounded-full text-white flex justify-center items-center hover:bg-[#1E8E9E]"
                    type="button" id="addWishlist">
                    <img src="{{ asset('images/img/blanco.png') }}" alt="" class="w-8 h-8">
                  </button>
                @endif


              </div>
            </div>
          </div>


          <div class="flex flex-col gap-2 pb-8 lg:pb-16" data-aos="fade-up">
            <span class="text-base font-Inter_Medium">
              Pago seguro garantizado
            </span>
            <div class="flex flex-wrap gap-2 px-1 mt-2">
              <img src="{{ asset('images\svg\american.svg') }}" alt="" class="h-9 w-14">
              <img src="{{ asset('images\svg\visa.svg') }}" alt="" class="h-9 w-14">
              <img src="{{ asset('images/svg/mastercad.svg') }}" alt="mastercad" class="h-9 w-14" />
            </div>
            <div class="flex flex-row gap-4 mt-6">
              <span class="text-base font-Inter_Medium">Compartir</span>
              <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank">
                <img src="{{ asset('images/svg/gb.svg') }}" alt="Facebook" class="h-8 w-8"></a>
              <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" target="_blank">
                <img src="{{ asset('images/svg/twitter.svg') }}" alt="Twitter" class="h-8 w-8"></a>
              <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ urlencode(asset($product->imagen)) }}&description=YourDescription"
                target="_blank">
                <img src="{{ asset('images/svg/pinterest.svg') }}" alt="Pinterest" class="h-8 w-8"></a>


            </div>
          </div>
        </div>
      </div>
    </section>


    @if ($combo->id)
      <section class="bg-[#F8F8F8] py-10 lg:py-14">
        <div class="w-full px-[5%] md:px-[8%]">
          <div class="flex flex-col justify-between w-full ">
            <h1 class="text-3xl font-Inter_SemiBold tracking-tight">Por tu compra llévate</h1>
            <div class="flex flex-col mt-7">
              <div class="border rounded-md shadow-sm py-4 px-6">
                <div class="flex justify-between items-center mb-4">
                  <div>
                    <b class="block text-xl">{{ $combo->producto }}</b>
                    <span class="flex items-start gap-1">
                      <span class="text-lg font-semibold">S/. {{ $combo->descuento }}</span>
                      <span class="text-sm line-through">{{ $combo->precio }}</span>
                    </span>
                  </div>
                  <button id="btnAgregarCombo" type="button"
                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-3 py-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                    data-id={{ $combo->id }}>
                    <i class="fa fa-cart-plus"></i>
                    Agregar al carrito
                  </button>
                </div>
                <div class="grid grid-cols-3 gap-3  mb-6">
                  <div class="col-span-3">
                    <div class="swiper productos-relacionados ">
                      <div class="swiper-wrapper h-full" id="offers">
                        @foreach ($combo->products as $item)
                          <div class="swiper-slide w-full h-full col-span-1">
                            <div class="flex flex-col items-center justify-center col-span-1  shadow-lg py-2  pb-5">
                              <a href="/producto/{{ $item->slug }}" target="_blanck">
                                {{-- <img src="{{ asset('images\img\1.png') }}" alt="" class="h-40 w-40 ">
                                                                    <span> {{ $item->producto }}</span>
                                                                    <h2 class="font-Inter_Bold text-[#006BF6]">S/ 80.00</h2> --}}
                                {{--  <x-product.container-combinalo width="" height="h-[300px]" bgcolor="bg-[#FFFFFF]"
                                        textpx="text-[17px]" :item="$item" /> --}}
                                <x-product.container width="col-span-1 " bgcolor="" :item="$item" />
                              </a>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </div>

                </div>
              </div>

            </div>
          </div>
        </div>
      </section>
    @endif

    <section class="bg-[#F8F8F8] py-10 lg:py-14">
      <div class="w-full px-[5%] md:px-[8%]">
        <div class="flex flex-col md:flex-row justify-between w-full ">
          <h1 class="text-3xl font-Inter_SemiBold tracking-tight">Productos Relacionados</h1>
          @php
            $url = '#';
            if (isset($ProdComplementarios) && count($ProdComplementarios) > 0) {
                $url = "/catalogo/{$ProdComplementarios[0]->categoria_id}";
            }
          @endphp
          <a href="{{ $url }}" class="flex items-center text-base font-Inter_SemiBold text-[#006BF6] ">Ver
            todos los productos <img src="{{ asset('images/img/arrowBlue.png') }}" alt="Icono" class="ml-5 "></a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-14 w-full">
          @foreach ($ProdComplementarios->take(4) as $item)
            {{-- <x-product.container-combinalo width="" height="h-[400px]" bgcolor="bg-[#FFFFFF]"
              textpx="text-[20px]" :item="$item" /> --}}
            <x-product.container width="col-span-1 " bgcolor="bg-[#FFFFFF]" :item="$item" />
          @endforeach
        </div>
      </div>

    </section>

    @if ($testimonios->count() > 0)
      <section class="">
        <div class="w-full px-[5%] md:px-[8%]">
          <h3 class="text-[34.7px] font-Inter_Medium "> ¿Qué dicen los clientes sobre nosotros?</h3>
          <div class="grid grid-cols-3 w-full gap-8 pt-16">
            @foreach ($testimonios->take(3) as $item)
              <div class="flex flex-col bg-[#F7F7F7] col-span-1 p-12 gap-4">
                <div class="flex items-center gap-4 pt-3">
                  <!-- Contenedor Flex para la imagen y el texto -->
                  <p class="font-Inter_Medium text-[24px] flex-1">{{ $item->name }}</p>
                  <!-- flex-1 hace que el texto ocupe el espacio disponible -->
                  <img src="{{ asset('images\svg\icons8-comillas-48.png') }}" alt=""
                    class="w-10 h-10 rounded-full">
                </div>
                <div class="min-h-[130px]">
                  <p class="font-Inter_Medium text-[19px] pt-1 leading-8 ">
                    {{ $item->testimonie }}
                  </p>
                </div>

                <div class="font-Inter_Bold text-[24px] w-5">
                  {{ $item->ocupation }}
                </div>
                <p class="text-[16px] font-Inter_Regular">Lima, Peru</p>
              </div>
            @endforeach
          </div>
        </div>
      </section>
    @endif

  </main>

@section('scripts_importados')
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
    // $(document).ready(function() {


    function capitalizeFirstLetter(string) {
      string = string.toLowerCase()
      return string.charAt(0).toUpperCase() + string.slice(1);
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
      cantidad++
      $('#cantidadSpan span').text(cantidad)

    })
  </script>
  <script>
    // let articulosCarrito = [];

    /* 
        function deleteOnCarBtn(id, operacion) {
          const prodRepetido = articulosCarrito.map(item => {
            if (item.id === id && item.cantidad > 0) {
              item.cantidad -= Number(1);
              return item; // retorna el objeto actualizado 
            } else {
              return item; // retorna los objetos que no son duplicados 
            }

          });
          Local.set('carrito', articulosCarrito)
          limpiarHTML()
          PintarCarrito()


        } */

    function calcularTotal() {
      let articulos = Local.get('carrito')
      let total = articulos.map(item => {
        let monto
        if (Number(item.descuento) !== 0) {
          monto = item.cantidad * Number(item.descuento)
        } else {
          monto = item.cantidad * Number(item.precio)

        }
        return monto

      })
      const suma = total.reduce((total, elemento) => total + elemento, 0);

      $('#itemsTotal').text(`S/. ${suma.toFixed(2)} `)

    }

    /*  function addOnCarBtn(id, operacion) {

       const prodRepetido = articulosCarrito.map(item => {
         if (item.id === id) {
           item.cantidad += Number(1);
           return item; // retorna el objeto actualizado 
         } else {
           return item; // retorna los objetos que no son duplicados 
         }

       });
       Local.set('carrito', articulosCarrito)
       // localStorage.setItem('carrito', JSON.stringify(articulosCarrito));
       limpiarHTML()
       PintarCarrito()


     } */



    var appUrl = <?php echo json_encode($url_env); ?>;
    $(document).ready(function() {
      articulosCarrito = Local.get('carrito') || [];

      // PintarCarrito();
    });

    function limpiarHTML() {
      //forma lenta 
      /* contenedorCarrito.innerHTML=''; */
      $('#itemsCarrito').html('')


    }

    $('#btnAgregarCombo').on('click', async function() {
      const offerId = this.getAttribute('data-id')
      const res = await fetch(`/api/offers/${offerId}`)
      const data = await res.json()

      let nombre = `<b>${data.producto}</b><ul class="mb-1">`
      data.products.forEach(product => {
        nombre +=
          `<li class="text-xs text-nowrap overflow-hidden text-ellipsis w-[270px]">${product.producto}</li>`
      })
      nombre += '</ul>'

      let newcarrito
      articulosCarrito = Local.get('carrito') ?? []


      const index = articulosCarrito.findIndex(item => item.id == data.id && item.isCombo)

      if (index != -1) {

        articulosCarrito = articulosCarrito.map(item => {
          if (item.isCombo && item.id == data.id) {
            item.nombre = nombre
            item.cantidad++
          }
          return item
        })
      } else {

        articulosCarrito = [...articulosCarrito, {
          "id": data.id,
          "isCombo": true,
          "producto": nombre,
          "descuento": data.descuento,
          "precio": data.precio,
          "imagen": data.imagen ? `${appUrl}${data.imagen}` : `${appUrl}/images/img/noimagen.jpg`,
          "cantidad": 1,
          "color": null
        }]

      }


      Local.set('carrito', articulosCarrito)

      limpiarHTML()
      PintarCarrito()
      mostrarTotalItems()

      Swal.fire({
        icon: "success",
        title: `Combo agregado correctamente`,
        showConfirmButton: true
      });
    })



    $('#addWishlist').on('click', function() {
      $.ajax({
        url: `{{ route('wishlist.store') }}`,
        method: 'POST',
        data: {
          _token: $('input[name="_token"]').val(),
          product_id: '{{ $product->id }}'
        },
        success: function(response) {

          // Cambiar el color del botón

          if (response.message === 'Producto agregado a la lista de deseos') {
            $('#addWishlist').removeClass('bg-[#99b9eb]').addClass('bg-[#0D2E5E]');
          } else {
            $('#addWishlist').removeClass('bg-[#0D2E5E]').addClass('bg-[#99b9eb]');
          }
          Swal.fire({
            icon: 'success',
            title: response.message,
            showConfirmButton: false,
            timer: 1500
          });
        },
        error: function(error) {
          console.log(error);
        }
      });
    })
  </script>


@stop

@stop
