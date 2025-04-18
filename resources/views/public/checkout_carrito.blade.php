@extends('components.public.matrix', ['pagina' => ''])

@section('css_importados')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@stop

<style>
  .fixedWhastapp {
    right: 128px !important;
  }
</style>

@section('content')


  <main>
    <section class="font-poppins w-11/12 mx-auto my-8 flex flex-col gap-5">
      <x-breadcrumb>
        <x-breadcrumb.item>Carrito de compras</x-breadcrumb.item>
      </x-breadcrumb>
      {{-- <div>
        <a href="index.html" class="font-normal text-[14px] text-[#6C7275]">Home</a>
        <span>/</span>
        <a href="carrito.html" class="font-semibold text-[14px] text-[#141718]">Carrito</a>
      </div> --}}

      {{-- <div class="flex flex-col">
        <label for="email" class="font-medium text-[12px] text-[#6C7275]">E-mail</label>

        <input id="email" type="email" placeholder="Correo electrónico" required name="email" value=""
          class=" py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" />
      </div> --}}
      <div class="flex md:gap-20 flex-col  lg:flex-row">
        <div class="flex flex-col justify-between items-center lg:basis-8/12 w-full lg:w-auto">
          <x-ecommerce.gateway.container>
            <div class="flex flex-col 2lg:flex-row pb-5  border-[#E8ECEF] gap-5">
              <table>
                <tbody id="itemsCarritoCheck">

                </tbody>
              </table>
            </div>
          </x-ecommerce.gateway.container>
          <div class="flex flex-col gap-5 pb-10 w-full">
            <h2 class="font-semibold text-xl tracking-wide text-[#151515] font-Urbanist_Bold">
              Información de usuario
            </h2>
            <div class="w-full flex flex-col gap-2 font-Urbanist_Regular">
              <label for="email" class="font-medium text-[13px] text-[#6C7275]">E-mail <span
                  class="text-[#c1272d]">*</span></label>
              <input id="email" type="email" placeholder="Correo electrónico" 
                name="email" value="{{ auth()->check() ? auth()->user()->email : '' }}"
                
                class="w-full py-3 px-4 focus:outline-none focus:ring-[#c1272d] focus:border-[#c1272d] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]"
                required>
            </div>
            <h2 class="font-semibold text-xl tracking-wide text-[#151515] font-Urbanist_Bold">
              Dirección de envío
            </h2>
            <ul class="grid w-full gap-6 md:grid-cols-3 font-Urbanist_Regular">
              {{-- <li>
                <input type="radio" name="envio" id="recoger-option" value="recoger" class="hidden peer" required
                  @if (!$hasDefaultAddress) checked @endif>
                <label for="recoger-option"
                  class="border inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-3 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-[#c1272d] hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                  <div class="block">
                    <svg class="w-6 h-6 mb-2 text-gray-800 dark:text-white" aria-hidden="true"
                      xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z">
                      </path>
                    </svg>

                    <div class="w-full text-lg font-semibold">Recojo en tienda</div>
                    <div class="w-full text-sm">Envio gratis</div>
                  </div>
                </label>
              </li> --}}
              <li>
                <input type="radio" name="envio" id="express-option" value="express" class="hidden peer"
                  {{-- @if ($hasDefaultAddress) checked @endif --}}
                  checked
                  >
                <label for="express-option"
                  class="border inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-3 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-[#c1272d] hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                  <div class="block">
                    <svg class="w-6 h-6 mb-2 text-gray-800 dark:text-white" aria-hidden="true"
                      xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 21v-9m3-4H7.5a2.5 2.5 0 1 1 0-5c1.5 0 2.875 1.25 3.875 2.5M14 21v-9m-9 0h14v8a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-8ZM4 8h16a1 1 0 0 1 1 1v3H3V9a1 1 0 0 1 1-1Zm12.155-5c-3 0-5.5 5-5.5 5h5.5a2.5 2.5 0 0 0 0-5Z">
                      </path>
                    </svg>

                    <div class="w-full text-lg font-semibold">Delivery</div>
                    <div class="w-full text-sm">Sujeto a evaluacion</div>
                  </div>
                </label>
              </li>
            </ul>
            <div id="direccionContainer" class="flex flex-col gap-5 font-Urbanist_Regular">
              <div class="flex flex-col gap-5">
                @if (isset($addresses) && is_array($addresses) && count($addresses) > 0)
                  <div class="flex flex-col gap-5 md:flex-row">
                    <div class="basis-2/3 flex flex-col gap-2 z-[45]">
                      <label class="font-medium text-[12px] text-[#6C7275]">Tu lista de direcciones<span
                          class="text-[#c1272d]">*</span></label>
                      <div class="w-full">
                        <div class="dropdown w-full">
                          <select id="addresses"
                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#c1272d] focus:border-[#c1272d] block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 select2-hidden-accessible"
                            data-address>
                            <option value>Agregar una nueva direccion</option>
                            @foreach ($addresses as $address)
                              <option value="{{ $address->id }}" data="{{ $address }}"
                                @if ($address->isDefault) selected @endif></option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                @endif
                <div data-show="new" class="flex flex-col gap-5 md:flex-row">
                  @if ($departments->count() > 0)
                    <div class="basis-1/3 flex flex-col gap-2 z-[45]">
                      <label class="font-medium text-[13px] text-[#6C7275] ">Departamento <span
                          class="text-[#c1272d]">*</span></label>

                      <div>
                        <!-- combo -->
                        <div class="dropdown w-full">
                          <select name="departamento_id" id="departamento_id"
                            class="selectpicker mt-1 h-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#c1272d] focus:border-[#c1272d] block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 select2-hidden-accessible"
                            data-address>
                            <option value="" data-select2-id="select2-data-2-4o85">Seleccione un
                              departamento</option>
                            @foreach ($departments as $department)
                              <option value="{{ $department->id }}">{{ $department->description }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>



                    </div>

                    <div class="basis-1/3 flex flex-col gap-2 z-[40]">
                      <label class="font-medium text-[13px] text-[#6C7275]">
                        Provincia <span class="text-[#c1272d]">*</span>
                      </label>

                      <div>
                        <!-- combo -->
                        <div class="dropdown-provincia w-full">
                          <select name="provincia_id" id="provincia_id"
                            class="selectpicker mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 select2-hidden-accessible"
                            data-address>
                            <option value="" data-select2-id="select2-data-4-gokf">Seleccione una
                              provincia
                            </option>

                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="basis-1/3 flex flex-col gap-2 z-[30]">
                      <label class="font-medium text-[13px] text-[#6C7275]">
                        Distrito <span class="text-[#c1272d]">*</span>
                      </label>

                      <div>
                        <!-- combo -->
                        <div class="dropdown-distrito w-full">
                          <select name="distrito_id" id="distrito_id"
                            class="selectpicker mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-[13px] rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 select2-hidden-accessible"
                            data-address>
                            <option value="" data-select2-id="select2-data-6-ihrp">Seleccione un distrito
                            </option>
                          </select>
                        </div>
                      </div>
                    </div>
                  @else
                    <div><span> ** Configure los "Costos de Envio" para que pueda visualizar esta lista
                        **</span>
                    </div>
                  @endif

                </div>

                <div data-show="new" class="flex flex-col gap-2">
                  <label for="nombre_calle" class="font-medium text-[13px] text-[#6C7275]">Avenida / Calle /
                    Jirón <span class="text-[#c1272d]">*</span></label>

                  <input id="nombre_calle" type="text" name="dir_av_calle"
                    placeholder="Ingresa el nombre de la calle"
                    class="w-full py-3 px-4 focus:outline-none focus:ring-[#c1272d] focus:border-[#c1272d] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]"
                    data-address>
                </div>
              </div>
              <div>
                <div data-show="new" class="flex flex-col md:flex-row gap-5">
                  <div class="basis-1/2 flex flex-col gap-2">
                    <label for="numero_calle" class="font-medium text-[13px] text-[#6C7275]">Número <span
                        class="text-[#c1272d]">*</span></label>
                    <input id="numero_calle" name="dir_numero" type="text"
                      placeholder="Ingresa el número de la callle"
                      class="w-full py-3 px-4 focus:outline-none focus:ring-[#c1272d] focus:border-[#c1272d] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]"
                      data-address>
                  </div>

                  <div class="basis-1/2 flex flex-col gap-2">
                    <label for="direccion" class="font-medium text-[13px] text-[#6C7275]">Dpto./ Interior/
                      Piso/
                      Lote/ Bloque
                      (opcional)</label>
                    <input id="direccion" type="text" name="dir_bloq_lote" placeholder="Ejem. Casa 3, Dpto 101"
                      class="w-full py-3 px-4 focus:outline-none focus:ring-[#c1272d] focus:border-[#c1272d] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="lg:basis-4/12 flex flex-col justify-start gap-5">
          <h2 class="font-semibold text-2xl tracking-tight text-[#151515] font-Urbanist_Bold">
            Resumen de la compra
          </h2>
          <div>
            <div class="flex flex-col gap-3 font-Urbanist_Bold">
              @auth
                <div class="text-[#141718] flex justify-between items-center border-b-[1px] border-[#E8ECEF] pb-3">
                  <h2 class="font-bold text-[16px] text-[#151515]">
                    Código de cupon
                  </h2>
                  <div class="flex gap-0 relative">
                    <input
                      type="text"
                      id="txtCodigoPromocion"
                      name="txtCodigoPromocion"
                      class="w-full border-[#151515] rounded-0 py-[7px] px-3 focus:outline-none focus:ring-0 focus:border-[#151515]"
                      
                    />
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <button id="btnAplicarCupon"
                      class="absolute rounded-0 border right-0 p-2 px-4 text-white bg-[#151515] w-auto top-1/2 transform -translate-y-1/2"
                    >
                      Aplicar
                    </button>
                  </div>
                </div>
              @endauth

              <div class="text-[#141718] flex justify-between items-center border-b-[1px] border-[#E8ECEF] pb-3">
                <p class="font-normal text-[16px]">Envío</p>
                <p id="precioEnvio" class="font-semibold text-[16px]">Gratis</p>
              </div>

              <div id="descuentocupon">
                
              </div>

              <div class="text-[#141718] flex justify-between items-center border-b-[1px] border-[#E8ECEF] pb-3">
                <p class="font-normal text-[16px]">Subtotal</p>
                <p id="itemSubtotal" class="font-semibold text-[16px]">S/. 0.00</p>
              </div>

              <div
                class="text-[#141718] text-[20px] flex justify-between font-semibold items-center border-b-[1px] border-[#E8ECEF] pb-5">
                <p>Total</p>
                <p id="itemTotal">S/. 0.00 </p>
              </div>
              <button id="btnSiguiente"
                class="text-white bg-black w-full py-3 rounded-none font-Urbanist_Bold cursor-pointer  font-semibold text-lg inline-block text-center" type="button">Ir
                a pagar</button>
            </div>
          </div>
        </div>
      </div>

      {{-- @if ($destacados->count() > 0)
        <h1 class="text-2xl md:text-3xl font-semibold font-Urbanist_Bold text-[#323232] mb-2 mt-4">Aprovecha estas
          ofertas
          especiales
          antes de completar tu compra</h1>
        <div class="relative">

          <div class="swiper-container">
            <div class="swiper-wrapper">
              @foreach ($destacados as $item)
                <div class="swiper-slide">
                  <x-product.container width="w-1/5" bgcolor="bg-[#FFFFFF]" :item="$item" />
                </div>
              @endforeach
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Add Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
        </div>
      @endif --}}

    </section>
  </main>
  <style>
    .swiper-horizontal>.swiper-pagination-bullets,
    .swiper-pagination-bullets.swiper-pagination-horizontal,
    .swiper-pagination-custom,
    .swiper-pagination-fraction {
      position: absolute;
      bottom: -50px !important;
      /* Ajusta este valor según sea necesario */
      width: 100%;
      text-align: center;
      /* bottom: 0% !important; */

    }


    .custom-pagination-bullet {
      background: #000;
      /* Cambia el color de los bullets si es necesario */
    }
  </style>

<script>
  const isAuthenticated = @json($user);
 
  if (isAuthenticated) {
     autenticado = true;
  }else{
     autenticado = false;
  }

  const logueado = Local.get('autenticado') ?? {};
      Local.set('autenticado', {
          ...logueado,
          autenticado: autenticado
  });

  $(document).on("click", "#eliminarCupon", function () {
    // Elimina el cupón del localStorage
    Local.delete('cupon');

    // Limpia el HTML del descuento
    $("#descuentocupon").html("");

    // Vuelve a renderizar el carrito
    PintarCarrito();

    Swal.fire({
        title: 'Cupón eliminado',
        text: 'El cupón ha sido eliminado exitosamente.',
        icon: 'success'
    });
  });

  function agregarCuponADb(cuponId) {

        const carrito = Local.get('carrito') ?? []

        $.ajax({
            url: "{{ route('agregarcupon') }}", 
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: cuponId,
                cart: carrito
            },
            success: function (response) {
              
              if (response.cupon && response.cupon.cupon) {
                 
                  const { monto, porcentaje } = response.cupon.cupon;

                  // Calcula el descuento basado en porcentaje o monto fijo
                  let descuento = 0;
                  //const total = parseFloat($("#total").text().replace("S/.", "").trim()); // Obtén el total actual

                  if (porcentaje === 1) {
                      descuento = (response.total * parseFloat(monto)) / 100; // Si el cupón es porcentual
                  } else {
                      descuento = parseFloat(monto); // Si el cupón es un monto fijo
                  }
 
                  const cupon = Local.get('cupon') ?? {};
                  Local.set('cupon', {
                      ...cupon,
                      idcupon: cuponId,
                      montof: monto,
                      porcentaje: porcentaje
                  });
                    
                
                  // Maqueta el HTML del descuento dinámicamente
                  if (descuento > 0) {
                      const descuentoHtml = `
                          <div class="text-[#141718] flex justify-between items-center border-b-[1px] border-[#E8ECEF] pb-3">
                              <div>
                                <p class="font-normal text-[16px]">Descuento</p>
                              </div>
                              <div class="flex flex-row gap-2">
                                <button id="eliminarCupon" class="text-red-500 font-bold text-[16px] ml-2"><i class="fa-regular fa-circle-xmark"></i></button>
                                <p id="precioEnvio" class="font-semibold text-[16px]">- S/. ${descuento.toFixed(2)}</p>
                              </div>
                              
                          </div>
                      `;
                      console.log(descuentoHtml);  
                      // Inserta el HTML en el resumen del carrito
                      $("#descuentocupon").html(descuentoHtml); // Asegúrate de que `#resumenCarrito` sea el contenedor adecuado

                      // $("#eliminarCupon").on("click", function () {
                      //     eliminarCupon();
                      // });
                  }

                  PintarCarrito();
              }
            },
            error: function (xhr) {
                Swal.fire({
                    title: 'Error',
                    text: xhr.responseJSON?.message || 'Hubo un problema al agregar el cupón.',
                    icon: 'error'
                });
            }
        });
  }


  $(document).ready(function () {
      $('#btnAplicarCupon').on('click', function () {
          const codigo = $('#txtCodigoPromocion').val();
          const carrito = Local.get('carrito') ?? [];

          if (!codigo) {
            Swal.fire({
                title: 'Error',
                text: 'Por favor ingresa un código de cupón.',
                icon: 'warning'
            });
            return;
        }

          $.ajax({
            url: "{{ route('validarcupon') }}", 
            method: "POST", // Método HTTP
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token CSRF desde el meta
            },
            data: {
              cupon: codigo,
              cart: carrito
            },
            success: function(response) {
              console.log(response)
              Swal.fire({
                title: response.message,
                text: 'Cupón agregado correctamente',
                icon: 'success',
              });

              agregarCuponADb(response.cupon.id);
              
              
            },
            error: function(xhr, status, error) {
              Swal.fire({
                title: 'Cupón inválido',
                text: xhr.responseJSON.message || 'Hubo un problema al validar el cupón.',
                icon: 'error'
              });
            }
          });

      });

      
      
        if (isAuthenticated) {
            const cupon = Local.get('cupon') ?? {};
            const cuponid = cupon.idcupon;
           
            if (cuponid) {
                agregarCuponADb(cuponid);
                PintarCarrito();
            }
        } else {
            console.log("Usuario no autenticado. No se ejecutará la función agregarCuponADb.");
        }

  });



</script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 5,
        autoplay: {
          delay: 2500,
          disableOnInteraction: false,
        },
        loop: true,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        breakpoints: {
          0: {
            slidesPerView: 1,
            spaceBetween: 10,
          },
          640: {
            slidesPerView: 2,
            spaceBetween: 20,
          },
          768: {
            slidesPerView: 3,
            spaceBetween: 30,
          },
          1024: {
            slidesPerView: 5,
            spaceBetween: 40,
          },
        },
      });
    });
  </script>


@section('scripts_importados')
  <script>
    // $('#direccionContainer').fadeOut(0)

    const cart = Local.get('carrito') ?? []
    if (cart.length == 0) location.href = '/'

    const hasDefaultAddress = {{ $hasDefaultAddress ? 'true' : 'false' }};
    $('[name="envio"]').on('click', () => {
      const value = $('[name="envio"]:checked').val()
      const address = Local.get('address') ?? {}
      if (value == 'express') {
        $('#direccionContainer').fadeIn(125)
        if ($('#distrito_id').val()) {
          $('#distrito_id').trigger('change')
        } else {
          $('#precioEnvio').text(`Evaluando`)
        }
        $('[data-address]').prop('required', true)
        // $('#addresses').prop('required', false)
        $('#addresses').removeAttr('required');
      } else {
        $('#direccionContainer').fadeOut(125)
        $('#precioEnvio').text('Gratis')
        $('[data-address]').prop('required', false)

      }
      Local.set('address', {
        ...address,
        envio: value
      })
      PintarCarrito()
      
    })

    const direcion = Local.get('address') ?? []
    console.log(direcion);

    const provinces = @json($provinces);
    const districts = @json($districts);

    const addressTemplate = ({
      id,
      text,
      element
    }) => {
      if (!id) return text

      const data = JSON.parse(element.getAttribute('data'))
      let price = 'Gratis'
      let className = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
      if (data.price.price > 0) {
        price = `S/. ${data.price.price.toFixed(2)}`
        className = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300'
      }
      return $(`<div class="relative">
        <b class="block">
          ${data.price.district.province.department.description},
          ${data.price.district.province.description},
          ${data.price.district.description}
        </b>
        ${data.street} #${data.number}
        <span class="absolute right-2 top-[50%] translate-y-[-50%] w-max block mx-auto text-xs font-medium px-2.5 py-0.5 mb-1 rounded-full ${className}">
          ${price}  
        </span>
      </div>`)
    }

    const addressStrg = Local.get('address') ?? {}
    $(`[name="envio"][value="${addressStrg.envio}"]`)
      .prop('checked', true)
      .trigger('click');

    $('#addresses').select2({
      templateResult: addressTemplate,
      templateSelection: addressTemplate
    })
    $('#departamento_id').select2()
    $('#provincia_id').select2()
    $('#distrito_id').select2()

    $('.selectpicker').select2()

    $('#addresses').on('change', function() {
      const address = $(this).val()
      if (!address) {
        $('[data-show="new"]').fadeIn()
        $('#departamento_id')
          .val(null)
          .trigger('change')
        $('#nombre_calle').val(null)
        $('#numero_calle').val(null)
        $('#direccion').val(null)
        const addressStrg = Local.get('address') ?? {}
        Local.set('address', {
          ...addressStrg,
          address_id: null
        })
        return
      }
      const data = JSON.parse($(this).find('option:selected').attr('data'))
      $('[data-show="new"]').fadeOut()
      $('#departamento_id')
        .val(data.price.district.province.department.id)
        .trigger('change')
      $('#provincia_id')
        .val(data.price.district.province.id)
        .trigger('change')
      $('#distrito_id')
        .val(data.price.district.id)
        .trigger('change')
      $('#nombre_calle').val(data.street)
      $('#numero_calle').val(data.number)
      $('#direccion').val(data.description)

      Local.set('address', {
        envio: 'express',
        address_id: address,
        department_id: data.price.district.province.department.id,
        department: data.price.district.province.department.description,
        province_id: data.price.district.province.id,
        province: data.price.district.province.description,
        district_id: data.price.district.id,
        district: data.price.district.description,
        price_id: data.price.id,
        price: data.price.price,
        street: data.street,
        number: data.number,
        description: data.description
      })

      PintarCarrito()
    })

    $('#addresses').val(addressStrg.address_id).trigger('change');
    
    $('#departamento_id').on('change', function() {
      $('#provincia_id').html('<option value>Seleccione una provincia</option>')
      $('#distrito_id').html('<option value>Seleccione un distrito</option>')
      $('#precioEnvio').text(`Evaluando`)
      provinces.filter(x => Number(x.department_id) == Number(this.value)).forEach((province) => {
        const option = $('<option>', {
          value: province.id,
          text: province.description
        })
        $('#provincia_id').append(option)
      })
      $('#provincia_id').select2()
      const addressStrg = Local.get('address') ?? {}
      Local.set('address', {
        ...addressStrg,
        department_id: this.value,
        department: $(this).find('option:selected').text(),
        province_id: null,
        district_id: null,
        price: 0,
        price_id: null
      })
      PintarCarrito()
    })

    $('#departamento_id').val(addressStrg.department_id).trigger('change')

    $('#provincia_id').on('change', function() {
      $('#distrito_id').html('<option value>Seleccione un distrito</option>')
      $('#precioEnvio').text(`Evaluando`)
      districts.filter(x => Number(x.province_id) == Number(this.value)).forEach((district) => {
        const option = $('<option>', {
          value: district.id,
          text: district.description,
          'data-price': district.price,
          'price-id': district.price_id
        })
        $('#distrito_id').append(option)
      })
      $('#distrito_id').select2()
      const addressStrg = Local.get('address') ?? {}
      Local.set('address', {
        ...addressStrg,
        province_id: this.value,
        province: $(this).find('option:selected').text(),
        district_id: null,
        price: 0,
        price_id: null
      })
      PintarCarrito()
    })

    $('#provincia_id').val(addressStrg.province_id).trigger('change');

    $('#distrito_id').on('change', function() {
      const option = $('#distrito_id option:selected')
      const priceStr = $('#distrito_id option:selected').attr('data-price')
      const price = Number(priceStr) || 0
      if (price == 0) {
        $('#precioEnvio').text('Gratis')
      } else {
        $('#precioEnvio').text(`S/. ${price.toFixed(2)}`)
      }
      const address = Local.get('address') ?? {}
      Local.set('address', {
        ...address,
        price,
        district_id: this.value,
        district: $(this).find('option:selected').text(),
        price_id: option.attr('price-id')
      })
      PintarCarrito()
    })

    $('#distrito_id').val(addressStrg.district_id).trigger('change');

    if (hasDefaultAddress) {
      $('#express-option').trigger('click')
      $('#addresses').trigger('change')
    }

    $('#nombre_calle').on('change', function() {
      const addressStrg = Local.get('address') ?? {}
      Local.set('address', {
        ...addressStrg,
        street: this.value
      })
    })
    $('#numero_calle').on('change', function() {
      const addressStrg = Local.get('address') ?? {}
      Local.set('address', {
        ...addressStrg,
        number: this.value
      })
    })
    $('#direccion').on('change', function() {
      const addressStrg = Local.get('address') ?? {}
      Local.set('address', {
        ...addressStrg,
        description: this.value
      })
    })

    $('#email').on('change', function() {
      const email = Local.get('datospersonales') ?? {}
      Local.set('datospersonales', {
        ...email,
        email: this.value
      })
    })

    $(document).ready(function() {
      const initialEmail = $('#email').val().trim();
      if (initialEmail) {
          const email = Local.get('datospersonales') ?? {}
          Local.set('datospersonales', {
            ...email,
            email: initialEmail
          })
      }
    })

    $('#nombre_calle').val(addressStrg.street ?? '')
    $('#numero_calle').val(addressStrg.number ?? '')
    $('#direccion').val(addressStrg.description ?? '')
  </script>
  <script>
    $(document).ready(function() {
      PintarCarrito()
    });

    // let articulosCarrito = [];
    let checkedRadio = false

    // const getCostoEnvio = () => {
    //   if ($('[name="envio"]:checked').val() == 'recoger') return 0
    //   const priceStr = $('#distrito_id option:selected').attr('data-price')
    //   const price = Number(priceStr) || 0
    //   return price
    // }

    var appUrl = <?php echo json_encode($url_env); ?>;
    $(document).ready(function() {
      articulosCarrito = Local.get('carrito') || [];

      // PintarCarrito();
    });

    function limpiarHTML() {
      $('#itemsCarrito').html('')
      $('#itemsCarritoCheck').html('')
    }

    $('#btnAgregarCarrito').on('click', function() {
      let url = window.location.href;
      let partesURl = url.split('/')
      let item = partesURl[partesURl.length - 1]
      let cantidad = Number($('#cantidadSpan span').text())
      item = item.replace('#', '')



      // id='nodescuento'


      $.ajax({

        url: `{{ route('carrito.buscarProducto') }}`,
        method: 'POST',
        data: {
          _token: $('input[name="_token"]').val(),
          id: item,
          cantidad

        },
        success: function(success) {
          let {
            producto,
            id,
            descuento,
            precio,
            imagen,
            color
          } = success.data
          let cantidad = Number(success.cantidad)
          let detalleProducto = {
            id,
            producto,
            descuento,
            precio,
            imagen,
            cantidad,
            color,
            tipo_envio: 0
          }
          let existeArticulo = articulosCarrito.some(item => item.id === detalleProducto.id)
          if (existeArticulo) {
            //sumar al articulo actual 
            const prodRepetido = articulosCarrito.map(item => {
              if (item.id === detalleProducto.id) {
                item.cantidad += Number(detalleProducto.cantidad);
                return item; // retorna el objeto actualizado 
              } else {
                return item; // retorna los objetos que no son duplicados 
              }

            });
          } else {
            articulosCarrito = [...articulosCarrito, detalleProducto]

          }

          localStorage.setItem('carrito', JSON.stringify(articulosCarrito));

          limpiarHTML()
          PintarCarrito()

        },
        error: function(error) {
          console.log(error)
        }

      })
    })

    $('input[type="radio"][name="bordered-radio"]').on('click', function() {
      // Obtener el valor del radio button seleccionado
      const valorSeleccionado = $(this).val();

      articulosCarrito = Local.get('carrito') ?? []
      let carritoCheck = articulosCarrito.map(item => {
        let obj = {
          id: item.id,
          producto: item.producto,
          descuento: item.descuento,
          precio: item.precio,
          imagen: item.imagen,
          cantidad: item.cantidad,
          color: item.color,
          tipo_envio: Number(valorSeleccionado)
        };
        return obj
      })

      Local.set("carrito", carritoCheck)
      checkedRadio = true

      // Hacer algo con el valor seleccionado, por ejemplo, imprimirlo en la consola
      limpiarHTML()
      PintarCarrito()
    });

    function validarEmail(value) {
        const regex =
            /^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/
        
            if (!regex.test(value)) {

              Swal.fire({
                title: `Ups!!`,
                text: `Por favor, asegúrate de ingresar una dirección de correo electrónico válida`,
                icon: "error"
              });
              return false;
            }
        return true;
    }

    $('#btnSiguiente').on('click', async function(e) {
      const datos = Local.get('datospersonales') ?? [];
      const cart = Local.get('carrito') ?? []
      const cupon = Local.get('cupon') ?? []
      const autenticado = Local.get('autenticado') ?? []
      const address = Local.get('address') ?? {envio: 'recoger'}
      
      console.log(datos);
      console.log(cart);
      console.log(address);
      console.log(autenticado);
      console.log(cupon);

      if (address.district_id == '') {
        Swal.fire({
          title: `Ups!!`,
          text: `Debes seleccionar un distrito`,
          icon: "warning"
        });
        return
      }

      if (address.street == '') {
        Swal.fire({
          title: `Ups!!`,
          text: `Debes ingresar una direccion`,
          icon: "warning"
        });
        return
      }

      if (address.number == '') {
        Swal.fire({
          title: `Ups!!`,
          text: `Debes ingresar un numero`,
          icon: "warning"
        });
        return
      }

      const email = $('#email').val();

      if (email == '') {
          Swal.fire({
            title: `Ups!!`,
            text: 'Por favor ingrese su correo electronico',
            icon: "warning",
          });
          return
      }
      
      if (!validarEmail(email)) {
        return;
      }
      

      const resOrder = await fetch("{{ route('sales.save') }}", {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
          'X-Xsrf-Token': decodeURIComponent(Cookies.get('XSRF-TOKEN'))
        },
        body: JSON.stringify({
          cart, address, datos, cupon, autenticado
        })
      })

     
      if (!resOrder.ok) {
        const errorData = await resOrder.json();
          return Swal.fire({
            title: `Error!!`,
            text: errorData?.message ?? `Ocurrió un error al intentar procesar tu compra`,
            icon: "error"
          });
        
      }else{
        const dataOrder = await resOrder.json()
        location.href = `/pago/${dataOrder.data.code}`
      }
      

      
    })
  </script>
@stop

@stop
