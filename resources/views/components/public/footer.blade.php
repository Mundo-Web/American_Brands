<footer class="bg-black">
    <style>
        #modalPoliticasDev 
        #modalTerminosCondiciones 
        #modallinkPoliticasDatos
        #modallinkTiempoEnvios  
        #modallinkPlazoReembolso  
        #modallinkTratamientoDatos  
        #modallinkPoliticasCookies  
        #modallinkCampanasPublicitarias  
        #modallinkBeneficios  
        #modallinkSeguimientoPedido  
        #modallinkNuestrasTiendas  
        
        {
            height: 70vh;
            overflow-y: auto;
        }

        #modalPoliticasDev .prose,
        #modalTerminosCondiciones .prose,
        #modallinkPoliticasDatos .prose,
        #modallinkTiempoEnvios  .prose,
        #modallinkPlazoReembolso  .prose,
        #modallinkTratamientoDatos  .prose,
        #modallinkPoliticasCookies  .prose,
        #modallinkCampanasPublicitarias  .prose,
        #modallinkBeneficios  .prose,
        #modallinkSeguimientoPedido  .prose,
        #modallinkNuestrasTiendas  .prose
        {
            max-width: 100%;
            text-align: justify;

        }

        .prose * {
            margin-bottom: 0% !important;
            margin-top: 0% !important;
        }
    </style>
    
    <div class="w-full">
        <div class="grid grid-cols-3 lg:grid-cols-6 gap-5 lg:gap-10 md:justify-center w-full px-[7%] pt-16 md:pt-20 bg-black text-white font-Urbanist_Light tracking-wider">
                @foreach ($logosfooter as $logofoot)
                    <div class="flex flex-row justify-center items-center">
                        <img class="w-auto mx-auto" src="{{asset($logofoot->url_image.$logofoot->name_image)}}" />    
                    </div>
                @endforeach
        </div>
        <div class="w-11/12 h-1 border-b border-white pb-5 lg:pb-10 bg-black mx-auto"></div>
    </div>
    
    
    
    <div
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 md:justify-center w-full px-[5%] pt-10 pb-10 md:pb-20 bg-black text-white font-Urbanist_Light tracking-wider">

        <div class="flex flex-col  text-base gap-2">
            <h3 class="font-Urbanist_Semibold text-xl pb-3">LEGALES</h3>
            <a id="linkTiempoEnvios">Tiempos y costos de envío</a>
            <a id="linkPoliticas">Cambios y devoluciones</a>
            <a id="linkPlazoReembolso">Plazos de reembolso</a>
        </div>

        <div class="flex flex-col text-base gap-2">
            <h3 class="font-Urbanist_Semibold text-xl pb-3">AYUDA & APOYO</h3>
            <a id="linkTerminos">Términos y condiciones</a>
            {{-- <a id="linkTratamientoDatos">Tratamiento adicional de datos</a>
            <a id="linkPoliticasCookies">Política de Cookies</a>
            <a id="linkCampanasPublicitarias">Campañas publicitarias</a> --}}
            <a id="linkBeneficios">Beneficios 0% intereses</a>
        </div>

        <div class="flex flex-col text-base gap-2">
            <h3 class="font-Urbanist_Semibold text-xl pb-3">SERVICIO AL CLIENTE</h3>
            <a href="{{route('contacto')}}">Contáctanos</a>
            {{-- <a id="linkSeguimientoPedido">Seguimiento de Pedido</a> --}}
            <a target="_blank" href="https://www.instagram.com/s/aGlnaGxpZ2h0OjE4MDQ5OTQ5MDYyODM2OTM2?story_media_id=3433199994630037399&igsh=MXZoaDBlM2gxcW1wdg==">Nuestras Tiendas</a>
            <a id="linkPoliticasDatos">Politica de Datos</a>
            <div class="flex flex-row">
                <a href="{{route('librodereclamaciones')}}"><div class="flex flex-row justify-start items-center gap-3 mt-3 px-4 py-2 border text-xs"><img class="w-6 h-auto object-contain" src="{{asset('images/img/libro.png')}}" /> LIBRO DE
                        RECLAMACIONES</div></a>
            </div>
        </div>

        <div class=" flex flex-col text-base gap-2 justify-start items-start">
            <h3 class="font-Urbanist_Semibold text-xl pb-3">PAGO SEGURO</h3>
            <img class="h-16 bg-contain object-contain" src="{{ asset('images/img/logosvisa.png') }}" />

        </div>

    </div>

    <div class="bg-black text-white pt-5 pb-16 lg:pb-20 flex items-center justify-center">
        <div class="flex flex-col justify-center items-center gap-5 w-full px-[5%]">

            <div class="flex flex-row gap-5 text-white mb-5">
                 @if ($datosgenerales->instagram)
                    <a href="{{ $datosgenerales->instagram }}" target="_blank">
                        {{-- <i class="fa-brands fa-instagram fa-xl"></i> --}}
                        <img class="w-5" src="{{asset('images/svg/instagramwhite.svg')}}" />
                    </a>
                @endif

                @if ($datosgenerales->tiktok)
                    <a href="{{ $datosgenerales->tiktok }}" target="_blank">
                        {{-- <i class="fa-brands fa-tiktok fa-xl"></i> --}}
                        <img class="w-5" src="{{asset('images/svg/tiktok.svg')}}" />
                    </a>
                @endif

                @if ($datosgenerales->facebook)
                    <a href="{{ $datosgenerales->facebook }}" target="_blank">
                        {{-- <i class="fa-brands fa-facebook fa-xl"></i> --}}
                        <img class="w-5" src="{{asset('images/svg/facebook.svg')}}" />
                    </a>
                @endif
                
                {{-- @if ($datosgenerales->linkedin)
                    <a href="{{ $datosgenerales->linkedin }}" target="_blank">
                        <i class="fa-brands fa-linkedin fa-xl"></i>
                        <img class="w-5" src="{{asset('images/svg/FACEBOOK.svg')}}" />
                    </a>
                @endif --}}
                
                {{-- @if ($datosgenerales->twitter)
                    <a href="{{ $datosgenerales->twitter }}" target="_blank">
                        <i class="fa-brands fa-twitter fa-xl"></i>
                        <img class="w-5" src="{{asset('images/svg/FACEBOOK.svg')}}" />
                    </a>
                @endif --}}
                {{-- @if ($datosgenerales->youtube)
                    <a href="{{ $datosgenerales->youtube }}" target="_blank">
                        <i class="fa-brands fa-youtube fa-2xl"></i>
                    </a>
                @endif --}}
                 @if ($datosgenerales->whatsapp)
                    <a href="https://api.whatsapp.com/send?phone={{ $datosgenerales->whatsapp }}&text={{ $datosgenerales->mensaje_whatsapp }}" target="_blank">
                        <img class="w-5" src="{{asset('images/svg/whatsapp.svg')}}" /> 
                    </a>
                @endif
            </div>

            <div class="text-center">
                <p class="font-Urbanist_Light text-sm ">
                    Copyright &copy; 2023 {{ config('app.name') }}. Reservados todos los derechos. Powered by <a
                        href="https://www.mundoweb.pe" target="_blank" class="text-white border-b border-white"> Mundo
                        Web
                    </a>
                </p>
            </div>

            <div>
                <a href="{{route('index')}}">
                    {{-- <h2 class="text-xl font-bold text-white tracking-widest font-Urbanist_Semibold">AMERICAN BRANDS</h2> --}}
                    <img id="logo-boostperu" class="min-w-56 w-60" src="{{ asset('images/svg/logoab.svg') }}" alt="american brands" />
                </a>
            </div>

        </div>
    </div>

    <div id="modalTerminosCondiciones" class="modal" style="max-width: 900px !important;width: 100% !important;  ">
        <!-- Modal body -->
        <div class="p-4 flex flex-col gap-2">
            <h1 class="font-Urbanist_Bold text-2xl lg:text-3xl text-center">Términos y Condiciones</h1>
            <div class="font-Urbanist_Regular prose p-2">{!! $terminos->content ?? '' !!}</div>
        </div>
    </div>

    <div id="modalPoliticasDev" class="modal" style="max-width: 900px !important; width: 100% !important;  ">
        <!-- Modal body -->
        <div class="p-4 flex flex-col gap-2">
            <h1 class="font-Urbanist_Bold text-2xl lg:text-3xl text-center">Políticas de Cambio de Devolución</h1>
            <div class="font-Urbanist_Regular prose p-2">{!! $politicas->content ?? '' !!}</div>
        </div>
    </div>

    <div id="modallinkPoliticasDatos" class="modal" style="max-width: 900px !important; width: 100% !important;  ">
        <!-- Modal body -->
        <div class="p-4 flex flex-col gap-2">
            <h1 class="font-Urbanist_Bold text-2xl lg:text-3xl text-center">Políticas de Datos</h1>
            <div class="font-Urbanist_Regular prose p-2">{!! $politicaDatos->content ?? '' !!}</div>
        </div>
    </div>
        <!-- ------------------------------------------------ -->
    <div id="modallinkTiempoEnvios" class="modal" style="max-width: 900px !important; width: 100% !important;  ">
        <!-- Modal body -->
        <div class="p-4 flex flex-col gap-2">
            <h1 class="font-Urbanist_Bold text-2xl lg:text-3xl text-center">Tiempo y Costos de Envío</h1>
            <div class="font-Urbanist_Regular prose p-2">{!! $TimeAndPriceDelivery->content ?? '' !!}</div>
        </div>
    </div>

    <div id="modallinkPlazoReembolso" class="modal" style="max-width: 900px !important; width: 100% !important;  ">
        <!-- Modal body -->
        <div class="p-4 flex flex-col gap-2">
            <h1 class="font-Urbanist_Bold text-2xl lg:text-3xl text-center">Plazos de Reembolso</h1>
            <div class="font-Urbanist_Regular prose p-2">{!! $PlazosDeReembolso->content ?? '' !!}</div>
        </div>
    </div>

    <div id="modallinkTratamientoDatos" class="modal" style="max-width: 900px !important; width: 100% !important;  ">
        <!-- Modal body -->
        <div class="p-4 flex flex-col gap-2">
            <h1 class="font-Urbanist_Bold text-2xl lg:text-3xl text-center">Tratamiento de Datos Adicional</h1>
            <div class="font-Urbanist_Regular prose p-2">{!! $TratamientoAdicionalDatos->content ?? '' !!}</div>
        </div>
    </div>

    <div id="modallinkPoliticasCookies" class="modal" style="max-width: 900px !important; width: 100% !important;  ">
        <!-- Modal body -->
        <div class="p-4 flex flex-col gap-2">
            <h1 class="font-Urbanist_Bold text-2xl lg:text-3xl text-center">Políticas de Cookies</h1>
            <div class="font-Urbanist_Regular prose p-2">{!! $PoliticasCookies->content ?? '' !!}</div>
        </div>
    </div>

    <div id="modallinkCampanasPublicitarias" class="modal" style="max-width: 900px !important; width: 100% !important;  ">
        <!-- Modal body -->
        <div class="p-4 flex flex-col gap-2">
            <h1 class="font-Urbanist_Bold text-2xl lg:text-3xl text-center">Campanas Publicitarias</h1>
            <div class="font-Urbanist_Regular prose p-2">{!! $CampanasPublicitarias->content ?? '' !!}</div>
        </div>
    </div>

    <div id="modallinkBeneficios" class="modal" style="max-width: 900px !important; width: 100% !important;  ">
        <!-- Modal body -->
        <div class="p-4 flex flex-col gap-2">
            <h1 class="font-Urbanist_Bold text-2xl lg:text-3xl text-center">Beneficios 0% Intereses</h1>
            <div class="font-Urbanist_Regular prose p-2">{!! $BeneficiosSinIntereses->content ?? '' !!}</div>
        </div>
    </div>

    <div id="modallinkSeguimientoPedido" class="modal" style="max-width: 900px !important; width: 100% !important;  ">
        <!-- Modal body -->
        <div class="p-4 flex flex-col gap-2">
            <h1 class="font-Urbanist_Bold text-2xl lg:text-3xl text-center">Seguimiento de Pedido</h1>
            <div class="font-Urbanist_Regular prose p-2">{!! $SeguimientoPedido->content ?? '' !!}</div>
        </div>
    </div>

    <div id="modallinkNuestrasTiendas" class="modal" style="max-width: 900px !important; width: 100% !important;  ">
        <!-- Modal body -->
        <div class="p-4 flex flex-col gap-2">
            <h1 class="font-Urbanist_Bold text-2xl lg:text-3xl text-center">Nuestras Tiendas</h1>
            <div class="font-Urbanist_Regular prose p-2">{!! $NuestrasTiendas->content ?? '' !!}</div>
        </div>
    </div>

</footer>


<script>
    $(document).ready(function() {


        $(document).on('click', '#linkTerminos', function() {
            $('#modalTerminosCondiciones').modal({
                show: true,
                fadeDuration: 400,
            })
        })

        $(document).on('click', '#terminoslibro', function() {
            $('#modalTerminosCondiciones').modal({
                show: true,
                fadeDuration: 400,
            })
        })

        $(document).on('click', '#linkPoliticas', function() {
            $('#modalPoliticasDev').modal({
                show: true,
                fadeDuration: 400,
            })
        })

        $(document).on('click', '#linkPoliticasDatos', function() {
            $('#modallinkPoliticasDatos').modal({
                show: true,
                fadeDuration: 400,
            })
        })

        $(document).on('click', '#linkTiempoEnvios', function() {
            $('#modallinkTiempoEnvios').modal({
                show: true,
                fadeDuration: 400,
            })
        })

        $(document).on('click', '#linkPlazoReembolso', function() {
            $('#modallinkPlazoReembolso').modal({
                show: true,
                fadeDuration: 400,
            })
        })

        $(document).on('click', '#linkTratamientoDatos', function() {
            $('#modallinkTratamientoDatos').modal({
                show: true,
                fadeDuration: 400,
            })
        })

        $(document).on('click', '#linkPoliticasCookies', function() {
            $('#modallinkPoliticasCookies').modal({
                show: true,
                fadeDuration: 400,
            })
        })

        $(document).on('click', '#linkCampanasPublicitarias', function() {
            $('#modallinkCampanasPublicitarias').modal({
                show: true,
                fadeDuration: 400,
            })
        })

        $(document).on('click', '#linkBeneficios ', function() {
            $('#modallinkBeneficios ').modal({
                show: true,
                fadeDuration: 400,
            })
        })

        $(document).on('click', '#linkSeguimientoPedido', function() {
            $('#modallinkSeguimientoPedido').modal({
                show: true,
                fadeDuration: 400,
            })
        })

        $(document).on('click', '#linkNuestrasTiendas', function() {
            $('#modallinkNuestrasTiendas').modal({
                show: true,
                fadeDuration: 400,
            })
        })

      

        function alerta(message) {
            Swal.fire({
                title: message,
                icon: "error",
            });
        }

        function validarEmail(value) {
            const regex =
                /^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/

            if (!regex.test(value)) {
                alerta("Por favor, asegúrate de ingresar una dirección de correo electrónico válida");
                return false;
            }
            return true;
        }


        $("#subsEmail").submit(function(e) {

            console.log('enviando subscripcion');

            e.preventDefault();

            Swal.fire({

                title: 'Realizando suscripción',
                html: `Registrando... 
          <div class="max-w-2xl mx-auto overflow-hidden flex justify-center items-center mt-4">
              <div role="status">
              <svg aria-hidden="true" class="w-8 h-8 text-blue-600 animate-spin dark:text-gray-600 " viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
              </svg>

              </div>
          </div>
          `,
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });


            if (!validarEmail($('#emailFooter').val())) {
                return;
            };
            $.ajax({
                url: '{{ route('guardarUserNewsLetter') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    Swal.close();
                    Swal.fire({
                        title: response.message,
                        icon: "success",
                    });
                    $('#subsEmail')[0].reset();
                },
                error: function(response) {
                    let message = ''

                    let isDuplicado = response.responseJSON.message.includes(
                        'Duplicate entry')
                    console.log(isDuplicado)

                    if (isDuplicado) {
                        message =
                            'El correo que ha ingresado ya existe. Utilice  otra direccion de correo'
                    } else {
                        message = response.responseJSON.message
                    }
                    Swal.close();
                    Swal.fire({
                        title: message,
                        icon: "error",
                    });
                }
            });

        })






    })
</script>
