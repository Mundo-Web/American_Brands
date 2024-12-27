@extends('components.public.matrix', ['pagina' => 'index'])

@section('css_importados')

@stop

@php
    $bannersBottom = array_filter($banners, function ($banner) {
        return $banner['potition'] === 'inferior';
    });
    $bannerMid = array_filter($banners, function ($banner) {
        return $banner['potition'] === 'medio';
    });
@endphp

<style>
    @media (max-width: 600px) {
        .fixedWhastapp {
            right: 13px !important;
        }
    }

    .claseocultar {
        display: none;
    }

    .swiper-pagination-slider .swiper-pagination-bullet {
        width: 15px;
        height: 15px;
        background-color: #4598d3 !important;
        border: 2px solid #4598d3;
    }

    .swiper-pagination-slider .swiper-pagination-bullet:not(.swiper-pagination-bullet-active) {
        background-color: white !important;
        border: 2px solid black;
        opacity: 1;
    }

    .swiper-pagination-cat .swiper-pagination-bullet {
        width: 15px;
        height: 15px;
        background-color: #4598d3 !important;
        border: 2px solid #4598d3;
    }

    .swiper-pagination-cat .swiper-pagination-bullet:not(.swiper-pagination-bullet-active) {
        background-color: white !important;
        border: 2px solid black;
        opacity: 1;
    }

    .swiper-pagination-promo .swiper-pagination-bullet {
        width: 15px;
        height: 15px;
        background-color: #4598d3 !important;
        border: 2px solid #4598d3;
    }

    .swiper-pagination-promo .swiper-pagination-bullet:not(.swiper-pagination-bullet-active) {
        background-color: white !important;
        border: 2px solid black;
        opacity: 1;
    }

    .swiper-pagination-otrasmarcas .swiper-pagination-bullet {
        width: 15px;
        height: 15px;
        background-color: #4598d3 !important;
        border: 2px solid #4598d3;
    }

    .swiper-pagination-otrasmarcas .swiper-pagination-bullet:not(.swiper-pagination-bullet-active) {
        background-color: white !important;
        border: 2px solid black;
        opacity: 1;
    }

    .swiper-pagination-complementos .swiper-pagination-bullet {
        width: 15px;
        height: 15px;
        background-color: #4598d3 !important;
        border: 2px solid #4598d3;
    }

    .swiper-pagination-complementos .swiper-pagination-bullet:not(.swiper-pagination-bullet-active) {
        background-color: white !important;
        border: 2px solid black;
        opacity: 1;
    }
</style>



@section('content')

    <main class="z-[15] ">

    {{-- @if (count($slider) > 0) 
        <section class="">
          <x-swipper-card :items="$slider" />
        </section>
      @endif --}}

    @if (count($slider) > 0) 
        <section class="w-full relative mx-auto">
            <div class="swiper sliderab h-max">
                <div class="swiper-wrapper">
                  @foreach ($slider as $slide)                      
                    <div class="swiper-slide">
                        <div class="w-full">
                          <a href="{{$slide->link2}}">  
                            <div class="hidden md:flex h-[450px] w-full md:h-auto relative z-10 md:flex-col items-end justify-end">
                                <img class="block h-full w-full object-contain object-bottom"
                                    src="{{ asset($slide->url_image . $slide->name_image) }}" 
                                    onerror="this.onerror=null;this.src='{{ asset('images/img/noimagen.jpg') }}';"
                                    alt="">
                            </div>
                            <div class="flex flex-col md:hidden h-auto w-full md:h-auto relative z-10  items-end justify-end">
                                <img class="block h-full w-full object-contain object-bottom"
                                    src="{{ asset($slide->link1) }}" 
                                    onerror="this.onerror=null;this.src='{{ asset('images/img/noimagen.jpg') }}';"
                                    alt="">
                            </div>
                          </a>      
                        </div>
                    </div>
                  @endforeach 
                </div>
                {{-- <div class="flex flex-row justify-center items-center relative">
                    <div class="swiper-pagination-slider absolute top-full bottom-0 z-10 right-full !left-1/2"></div>
                </div> --}}
            </div>
        </section>
    @endif

    @if (count($subcategorias) > 0) 
        <section class="w-full px-[5%] relative mx-auto pt-12 lg:pt-16">
          <div class="w-full">  
            <div class="swiper carruseltop h-max">
                <div class="swiper-wrapper">
                    @foreach ($subcategorias as $subcategoria)       
                        <div class="swiper-slide">
                          <div class="flex flex-col max-w-[450px] mx-auto relative">  
                            <a href="/catalogo?subcategoria={{$subcategoria->id}}">       
                                <img class="w-full h-auto object-cover aspect-square" src="{{ asset($subcategoria->url_image . $subcategoria->name_image) }}" /> 
                            </a>
                            <div class="absolute inset-x-0 bottom-0 h-[150px] bg-gradient-to-t from-black/95 to-transparent"></div>
                            <div class="flex flex-row w-full absolute bottom-5">
                                <div class="flex flex-row justify-center items-center w-full">
                                    <h2
                                        class="text-white text-2xl tracking-widest font-Urbanist_Semibold font-bold text-center uppercase">
                                        {{$subcategoria->name}}
                                    </h2>
                                </div>
                            </div>
                           </div>       
                        </div>
                    @endforeach 
                </div>
                <div class="flex flex-row justify-center items-center relative mt-10">
                    <div class="swiper-pagination-cat absolute top-full bottom-0 z-10 right-full !left-1/2 "></div>
                </div>
            </div>
          </div>  
        </section>
    @endif

    {{-- <section class="w-full px-[5%] relative mx-auto pt-12 lg:pt-16">
            <div class="swiper carruseltop h-max">
                <div class="swiper-wrapper">
                    @foreach ($subcategorias as $subcategoria)       
                        <div class="swiper-slide">
                          <a href="/catalogo?subcategoria={{$subcategoria->id}}">      
                            <div class="bg-no-repeat object-top bg-center bg-cover min-h-[350px] aspect-square flex flex-row  items-center p-5 "
                                style=" background-image: url('{{ asset($subcategoria->url_image . $subcategoria->name_image) }}')">
                                <div class="flex flex-row justify-end items-end w-full ">
                                    <div class="flex flex-row md:w-2/3">
                                        <h2
                                            class="text-white text-2xl tracking-widest font-Urbanist_Semibold font-bold text-right uppercase">
                                            {{$subcategoria->name}}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                          </a>      
                        </div>
                    @endforeach 
                </div>
                <div class="flex flex-row justify-center items-center relative mt-10">
                    <div class="swiper-pagination-cat absolute top-full bottom-0 z-10 right-full !left-1/2 "></div>
                </div>
            </div>
    </section> --}}

    @if (count($bannerMid) > 0)
      <section class="w-full">
        <x-banner-section-cover :banner="$bannerMid" />
      </section>
    @endif


    @if (count($benefit) > 0) 
        <section class="flex flex-col w-full gap-12 relative pt-12 lg:pt-16 px-[5%]">

            <div class="swiper promo h-max flex flex-row w-full">
                <div class="swiper-wrapper">
                   @foreach ($benefit as $benefi)         
                        <div class="swiper-slide">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">

                                <div class="flex flex-col gap-5 lg:gap-10 justify-center items-start w-[95%] lg:w-[85%] text-left">
                                    <h2 class="font-Urbanist_Black text-2xl lg:text-3xl text-black">
                                        {{$benefi->descripcionshort}}
                                    </h2>

                                    <h1 class="font-Urbanist_Black text-5xl lg:text-8xl text-[#cccccc]">
                                        {{$benefi->titulo}}
                                    </h1>

                                    <div class="font-Urbanist_Light text-2xl lg:text-3xl text-black">
                                        {{$benefi->descripcion}}
                                    </div>

                                    <a href="{{$benefi->link1}}" class="font-Urbanist_Light text-lg lg:text-xl text-black px-10 py-2 border border-black">
                                        COMPRA AQUÍ
                                    </a>
                                </div>

                                <div class="flex flex-col justify-center items-center">
                                    <div class="w-full h-[500px] lg:[400px] xl:h-[700px] overflow-hidden relative bg-cover bg-center">
                                        <img src="{{ asset($benefi->imagen) }}" onerror="this.onerror=null;this.src='/images/img/noimagen.jpg';" class="mx-auto w-auto lg:w-full h-full object-cover lg:object-contain" />
                                    </div>
                                </div>


                            </div>
                        </div> 
                    @endforeach 
                </div>
                <div class="flex flex-row justify-center items-center relative  mt-10">
                    <div class="swiper-pagination-promo absolute top-full bottom-0 z-10 right-full !left-1/2"></div>
                </div>
            </div>
        </section>
    @endif



    @if (count($logosdestacados) > 0) 
        <section class="w-full grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-7 md:gap-8 relative mx-auto pt-12 lg:pt-16">
           @foreach ($logosdestacados as $logosd)
             <a href="/catalogo?marcas={{$logosd->id}}">
                <div class="flex flex-col justify-end bg-white w-full bg-no-repeat object-top bg-center bg-contain min-w-[300px]">
                    <div class="flex flex-center justify-center items-center w-full">
                        <img class="w-full h-full object-contain" src="{{$logosd->url_image2}}" />
                    </div>
                </div>
              </a>
           @endforeach 
        </section>
    @endif
        

    {{-- @if (count($logosdestacados) > 0) 
        <section class="w-full grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-7 md:gap-8 relative mx-auto pt-12 lg:pt-16">
           @foreach ($logosdestacados as $logosd)
             <a href="/catalogo?marcas={{$logosd->id}}">
                <div class="flex flex-col justify-end bg-white h-[300px] lg:h-[350px] w-full bg-no-repeat object-top bg-center bg-contain" 
                 style=" background-image: url('{{ asset($logosd->url_image2) }}')"
                 >
                    <div class="flex flex-col justify-end items-center w-full pb-[7%]">
                        
                        <img src="{{ asset($logosd->url_image) }}" class="h-16 object-contain"/>
                    </div>
                </div>
              </a>
           @endforeach 
        </section>
    @endif     --}}
        

    @if (count($logos) > 0)    
        <section class="w-full px-[5%] relative mx-auto pt-12 lg:pt-16">
              <h2 class="text-center font-Urbanist_Black text-2xl lg:text-3xl text-black">TAMBIÉN PUEDES ENCONTRAR</h2>
        </section>
    
         <section class="w-full px-[5%] relative mx-auto pt-12 lg:pt-16">
            <div class="swiper otrasmarcas h-max">
                <div class="swiper-wrapper">
                  @foreach ($logos as $logosn)  
                    <div class="swiper-slide">
                      <a href="/catalogo?marcas={{$logosn->id}}">
                        <div class="bg-no-repeat object-top bg-center bg-cover h-[350px] flex flex-row  items-center p-2 ">
                            <img class="w-full h-full object-contain" src="{{ asset($logosn->url_image2) }}" />
                        </div>
                      </a>
                    </div>
                  @endforeach   
                </div>
                <div class="flex flex-row justify-center items-center relative mt-10">
                    <div class="swiper-pagination-otrasmarcas absolute top-full bottom-0 z-10 right-full !left-1/2 "></div>
                </div>
            </div>
        </section>
    @endif



    {{-- @if (count($logos) > 0)    
        <section class="w-full px-[5%] relative mx-auto pt-12 lg:pt-16">
              <h2 class="text-center font-Urbanist_Black text-2xl lg:text-3xl text-black">TAMBIÉN PUEDES ENCONTRAR</h2>
        </section>
    
         <section class="w-full px-[5%] relative mx-auto pt-12 lg:pt-16">
            <div class="swiper otrasmarcas h-max">
                <div class="swiper-wrapper">
                  @foreach ($logos as $logosn)  
                    <div class="swiper-slide">
                      <a href="/catalogo?marcas={{$logosn->id}}">
                        <div class="bg-no-repeat object-top bg-center bg-cover h-[350px] md:h-[350px] xl:h-[350px]  flex flex-row  items-center p-5 "
                            style=" background-image: url('{{ asset($logosn->url_image2) }}')">
                            <div class="flex flex-col justify-center  h-[300px] lg:h-[350px] w-full bg-no-repeat object-top bg-center bg-cover">
                                <div class="flex flex-col justify-end items-center w-full">
                                    <img src="{{ asset($logosn->url_image) }}" class="h-16 object-contain"/>
                                </div>
                            </div>
                        </div>
                      </a>
                    </div>
                  @endforeach   
                </div>
                <div class="flex flex-row justify-center items-center relative mt-10">
                    <div class="swiper-pagination-cat absolute top-full bottom-0 z-10 right-full !left-1/2 "></div>
                </div>
            </div>
        </section>
    @endif --}}


    @if (count($destacados) > 0)  
        <section class="w-full px-[5%] relative mx-auto pt-12 lg:pt-16">
              <h2 class="text-center font-Urbanist_Black text-2xl lg:text-3xl text-black">COMPLEMENTA TU ESTILO</h2>
        </section>
            
         <section class="w-full px-[5%] relative mx-auto py-12 lg:py-16">
            <div class="swiper complementos h-max">
                <div class="swiper-wrapper">
                  @foreach ($destacados as $productosd)       
                    <div class="swiper-slide">
                        <a href="{{route('producto', $productosd->slug)}}">
                            <div class="flex flex-row justify-center items-center aspect-square">
                                <div class="max-w-[350px] rounded-full  flex flex-col items-center p-5 ">
                                    <img class="w-full h-full object-contain rounded-full" src="{{ asset($productosd->imagen) }}" />
                                </div>
                            </div>
                        </a>
                        <div class="flex flex-col justify-center items-center gap-1 mt-3">
                          <p class="font-Urbanist_Semibold text-base text-black line-clamp-1">{{ optional($productosd->category)->name }}</p>
                          <a href="{{route('producto', $productosd->slug)}}">  
                            <h2 class="font-Urbanist_Semibold text-base text-[#8f8f8f] line-clamp-1">{{$productosd->producto}}</h2>
                          </a>  
                          @if($productosd->descuento > 0)
                            <p class="font-Urbanist_Semibold text-lg text-black">S/ {{$productosd->descuento}} <span class="text-sm line-through text-[#8f8f8f]"> S/ {{$productosd->precio}}</span></p>
                          @else
                            <p class="font-Urbanist_Semibold text-lg text-black">S/ {{$productosd->precio}}</p>
                          @endif
                        </div>
                    </div>
                  @endforeach    
            </div>
            <div class="flex flex-row justify-center items-center relative mt-10">
                <div class="swiper-pagination-complementos absolute top-full bottom-0 z-10 right-full !left-1/2 "></div>
            </div>
        </section>
    @endif



        {{-- <section class="w-full px-[5%] relative mx-auto pt-12 lg:pt-16">
              <h2 class="text-center font-Urbanist_Black text-2xl lg:text-3xl text-black">FOLLOW US <span class="font-Urbanist_Regular"> ON </span> 
              <span class="font-Urbanist_Regular italic"> @americanbrandspe </span></h2>
        </section> --}}

        {{-- <section class="w-full relative mx-auto pt-12 lg:pt-16">
            <div class="swiper instagram h-max">
                <div class="swiper-wrapper"> --}}
                    {{-- @php
                        $filteredMedia = array_filter($media, function ($item) {
                            return $item['media_type'] === 'IMAGE' || $item['media_type'] === 'CAROUSEL_ALBUM';
                        });
                    @endphp
                    @foreach (array_slice($filteredMedia, 0, 12) as $item)
                        <div class="swiper-slide">
                            <div class="relative group aspect-square h-full">
                                <img src="{{ $item['media_url'] }}" alt="Image" class="object-cover h-full w-full">
                                <a href="{{ $item['permalink'] }}" target="_blank"
                                    class="opacity-0 hover:cursor-pointer group-hover:opacity-60 duration-300 absolute inset-0 flex justify-center items-center bg-black bg-opacity-70">
                                </a>
                            </div>
                        </div>
                    @endforeach     --}}
                    {{-- @foreach (array_slice($media, 0, 12) as $item)
                        <div class="swiper-slide">
                            <div class="relative group aspect-square h-full">
                                @if ($item['media_type'] === 'IMAGE' || $item['media_type'] === 'CAROUSEL_ALBUM')
                                    <img src="{{ $item['media_url'] }}" alt="Image" class="object-cover h-full w-full">
                                    <a href="{{ $item['permalink'] }}" target="_blank"
                                        class="opacity-0 hover:cursor-pointer group-hover:opacity-60 duration-300 absolute inset-0 flex justify-center items-center bg-black bg-opacity-70">
                                    </a>
                                    <img
                                        class="opacity-0 group-hover:opacity-100 duration-300 absolute inset-x-0 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
                                        src="{{ asset('img_donas/instagram.svg') }}">
                                @elseif ($item['media_type'] === 'VIDEO')
                                    <div class="h-full overflow-hidden">
                                        <video class="min-h-full min-w-full">
                                            <source src="{{ $item['media_url'] }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <a href="{{ $item['permalink'] }}" target="_blank"
                                            class="opacity-0 hover:cursor-pointer group-hover:opacity-60 duration-300 absolute inset-0 flex justify-center items-center bg-black bg-opacity-70">
                                        </a>
                                        <img
                                            class="opacity-0 group-hover:opacity-100 duration-300 absolute inset-x-0 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
                                            src="{{ asset('img_donas/instagram.svg') }}">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach --}}
                {{-- </div>
            </div>
        </section> --}}


        {{-- <section class="w-full relative mx-auto pt-12 lg:pt-16">
            <div class="swiper instagram h-max">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="bg-no-repeat object-top bg-center bg-cover aspect-square flex flex-row  items-center"
                            style=" background-image: url('{{ asset('images/img/banner_AB.png') }}')">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg-no-repeat object-top bg-center bg-cover aspect-square flex flex-row  items-center"
                            style=" background-image: url('{{ asset('images/img/banner_AB.png') }}')">
                        </div>
                    </div>  
                    <div class="swiper-slide">
                        <div class="bg-no-repeat object-top bg-center bg-cover aspect-square flex flex-row  items-center"
                            style=" background-image: url('{{ asset('images/img/banner_AB.png') }}')">
                        </div>
                    </div>  
                    <div class="swiper-slide">
                        <div class="bg-no-repeat object-top bg-center bg-cover aspect-square flex flex-row  items-center"
                            style=" background-image: url('{{ asset('images/img/banner_AB.png') }}')">
                        </div>
                    </div>  
                    <div class="swiper-slide">
                        <div class="bg-no-repeat object-top bg-center bg-cover aspect-square flex flex-row  items-center"
                            style=" background-image: url('{{ asset('images/img/banner_AB.png') }}')">
                        </div>
                    </div>  
                    <div class="swiper-slide">
                        <div class="bg-no-repeat object-top bg-center bg-cover aspect-square flex flex-row  items-center"
                            style=" background-image: url('{{ asset('images/img/banner_AB.png') }}')">
                        </div>
                    </div>       
                </div>
            </div>
        </section> --}}
        

        {{-- @if (count($logos) > 0) 
      <section class="w-full px-[5%] lg:px-[8%] py-12 lg:py-20 flex flex-col gap-10">
          <div class="text-center">
              <h2 class="font-Helvetica_Bold text-[#010101] text-4xl">Autoradios IOS</h2>
          </div>

          <div class="flex flex-wrap justify-between gap-8 ">
              @foreach ($logos as $logo)
                  <img class="w-32 object-contain mx-auto" src="{{ asset($logo->url_image) }}" />
              @endforeach
          </div>
      </section>
    @endif --}}

        {{-- seccion Gran Descuento  --}}

       


        {{-- seccion Productos populares  --}}

        {{-- @if ($productosPupulares->count() > 0)
      <section>
        <div class="w-full px-[5%] py-14 lg:py-20">
          <div class="flex flex-col md:flex-row justify-between w-full gap-3">
            <div class="flex flex-col">
              <h3 class="text-[#FD1F4A] font-semibold font-Helvetica_Light text-lg">Descuentos especiales</h3>
              <h1 class="text-2xl md:text-3xl font-semibold font-Helvetica_Medium text-[#111] tracking-wide">Los más vendidos</h1>
            </div>
            <div class="flex flex-col items-center justify-center">
              <a href="/catalogo" class="bg-[#FD1F4A] text-base font-normal text-white text-center font-Helvetica_Medium px-6 py-3 rounded-3xl flex items-center justify-center w-auto">
                Vamos a comprar</a>
            </div>
          </div>
          @foreach ($productosPupulares->chunk(4) as $taken)
          
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 md:flex-row gap-4 mt-14 w-full">
             
              @foreach ($taken as $item)
                <x-product.container width="w-1/4" bgcolor="bg-[#FFFFFF]" :item="$item" />
                
              @endforeach
            </div>
          @endforeach
        </div>
      </section>
    @endif --}}


        {{-- @php
          $categories = $categoriasindex;
          $chunks = $categories->chunk(3);
          $processedCategories = collect();
    @endphp

    @foreach ($chunks as $chunk)
            @if ($chunk->count() == 3)
                <div class="grid grid-cols-1 md:grid-cols-4 px-[5%] gap-8 lg:gap-12 pt-10">
                    @foreach ($chunk as $category)
                      @if ($loop->first) 
                          <div class="w-full md:row-span-2 md:col-span-2">
                            <a href="{{ route('Catalogo.jsx', $category->id) }}">
                              <div class="h-full w-full relative flex flex-col group">
                                  <img src="{{ asset($category->url_image . $category->name_image) }}" alt=""
                                      class="h-96 md:h-full w-full flex flex-col justify-end items-start object-cover"
                                      onerror="this.src='/images/img/noimagen.jpg';">
                                  <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-60 transition-opacity duration-300"></div>
                                   <div class="absolute bottom-0 flex flex-col gap-5 w-full p-5 lg:p-10 opacity-0  group-hover:opacity-100 transition-opacity duration-300">
                                  <h2 class="text-2xl text-white font-Helvetica_Bold">{{ $category->name }}</h2>
                                  <p class="text-lg text-white font-Helvetica_Light">Donec vehicula, lectus vel pharetra semper, justo massa pharetra nunc, non venenatis ante augue quis est.</p>
                                </div>
                              </div>
                            </a>
                          </div>
                      @else
                          <div class="w-full md:col-span-2">
                            <a href="{{ route('Catalogo.jsx', $category->id) }}">
                              <div class="h-full w-full relative flex flex-col group">
                                <img src="{{ asset($category->url_image . $category->name_image) }}" alt=""
                                    class="h-60 md:h-64 lg:h-60 xl:h-80 w-full flex flex-col justify-end items-start object-cover"
                                    onerror="this.src='/images/img/noimagen.jpg';">
                                <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-60 transition-opacity duration-300"></div>
                                <div class="absolute bottom-0 flex flex-col gap-5 w-full p-5 lg:p-10 opacity-0  group-hover:opacity-100 transition-opacity duration-300">
                                  <h2 class="text-2xl text-white font-Helvetica_Bold">{{ $category->name }}</h2>
                                  <p class="text-lg text-white font-Helvetica_Light">Donec vehicula, lectus vel pharetra semper, justo massa pharetra nunc, non venenatis ante augue quis est.</p>
                                </div>
                              </div>
                            </a>
                          </div>
                       @endif
                    @endforeach
                </div>
            @endif
          
            @php
                  $processedCategories = $processedCategories->merge($chunk); // Guardamos las categorías procesadas.
            @endphp
    @endforeach 

    @php
        $remainder = $categories->count() % 3;
        $remainderCategories = $categories->diff($processedCategories);
    @endphp
      
    @php
        $remainderCategories = $categories->slice(-$remainder);
    @endphp

    @if ($remainder > 0)
          @if ($remainder == 1)
                <div class="grid grid-cols-1 md:grid-cols-4 px-[5%] gap-8 lg:gap-12 pt-10">
                  @foreach ($remainderCategories as $category)
                    <div class="col-span-4">
                              <a href="{{ route('Catalogo.jsx', $category->id) }}">
                                <div class="h-full w-full relative flex flex-col group">
                                  <img src="{{ asset($category->url_image . $category->name_image) }}" alt=""
                                      class="h-60 md:h-64 lg:h-60 xl:h-96 w-full flex flex-col justify-end items-start object-cover"
                                      onerror="this.src='/images/img/noimagen.jpg';">
                                  <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-60 transition-opacity duration-300"></div>
                                  <div class="absolute bottom-0 flex flex-col gap-5 w-full p-5 lg:p-10 opacity-0  group-hover:opacity-100 transition-opacity duration-300">
                                    <h2 class="text-2xl text-white font-Helvetica_Bold">{{ $category->name }}</h2>
                                    <p class="text-lg text-white font-Helvetica_Light">Donec vehicula, lectus vel pharetra semper, justo massa pharetra nunc, non venenatis ante augue quis est.</p>
                                  </div>
                                </div>
                              </a>
                      </div>
                    </div>
                  @endforeach
                </div>
 
          @elseif ($remainder == 2)
                <div class="grid grid-cols-1 md:grid-cols-4 px-[5%] gap-8 lg:gap-12 pt-10">
                    @foreach ($remainderCategories as $category)
                        <div class="w-full md:col-span-2">
                                  <a href="{{ route('Catalogo.jsx', $category->id) }}">
                                    <div class="h-full w-full relative flex flex-col group">
                                      <img src="{{ asset($category->url_image . $category->name_image) }}" alt=""
                                          class="h-60 md:h-64 lg:h-60 xl:h-80 w-full flex flex-col justify-end items-start object-cover"
                                          onerror="this.src='/images/img/noimagen.jpg';">
                                      <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-60 transition-opacity duration-300"></div>
                                      <div class="absolute bottom-0 flex flex-col gap-5 w-full p-5 lg:p-10 opacity-0  group-hover:opacity-100 transition-opacity duration-300">
                                        <h2 class="text-2xl text-white font-Helvetica_Bold">{{ $category->name }}</h2>
                                        <p class="text-lg text-white font-Helvetica_Light">Donec vehicula, lectus vel pharetra semper, justo massa pharetra nunc, non venenatis ante augue quis est.</p>
                                      </div>
                                    </div>
                                  </a>
                        </div>
                    @endforeach
                </div>
          @endif
    @endif --}}


        {{-- seccion Ultimos Productos  --}}
        {{-- @if ($ultimosProductos->count() > 0)
    <section>
      <div class="w-full px-[5%] py-14 lg:py-20">
        <div class="flex flex-col md:flex-row justify-between w-full gap-3">
          <div class="flex flex-col">
            <h3 class="text-[#FD1F4A] font-semibold font-Helvetica_Light text-lg">Apúrate que se acaban</h3>
            <h1 class="text-2xl md:text-3xl font-semibold font-Helvetica_Medium text-[#111] tracking-wide">Equipos nuevos</h1>
          </div>
          <div class="flex flex-col items-center justify-center">
            <a href="/catalogo" class="bg-[#FD1F4A] text-base font-normal text-white text-center font-Helvetica_Medium px-6 py-3 rounded-3xl flex items-center justify-center w-auto">
              Autoradios</a>
          </div>
        </div>
        @foreach ($ultimosProductos->chunk(4) as $taken)
          <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 md:flex-row gap-6 mt-14 w-full">
            @foreach ($taken as $item)
              <x-product.container width="w-full" bgcolor="bg-[#FFFFFF]" :item="$item" />
              
            @endforeach
          </div>
        @endforeach
      </div>
    </section>
    @endif --}}






        {{-- Seccion Blog --}}
        {{-- @if ($blogs->count() > 0)
      <section class="w-full px-[5%] py-7 lg:py-14" data-aos="fade-up">
        <div class="flex flex-col md:flex-row justify-between w-full gap-3">
          <h1 class="text-2xl md:text-3xl font-semibold font-Inter_Medium text-[#323232]">Blog & Eventos</h1>
          <a href="/blog/0" class="flex items-center text-base font-Inter_Medium font-semibold text-[#006BF6]">Ver todos
            las Publicaciones <img src="{{ asset('images/img/arrowBlue.png') }}" alt="Icono" class="ml-2 "></a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 mt-14 gap-10 sm:gap-5">
          @foreach ($blogs as $post)
            <x-blog.container-post :post="$post" />
          @endforeach
        </div>

      </section>
    @endif --}}


        {{-- gran descuento --}}
        {{-- @if (count($bannersBottom) > 0)
      <section class="w-full px-[5%] mt-7 lg:mt-10 " data-aos="zoom-out-right">
        <div class="bg-gradient-to-b from-gray-50 to-white flex flex-col md:flex-row justify-between bg-[#EEEEEE]">
          <x-banner-section :banner="$bannersBottom" />
        </div>
      </section>
    @endif --}}


        {{-- @if ($benefit->count() > 0)
      <section class="py-10 lg:py-13 bg-[#F8F8F8] w-full px[5%]" data-aos="zoom-out-right">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 ">
          @foreach ($benefit as $item)
            <div class="flex flex-col items-center w-full gap-1 justify-center text-center px-[10%] xl:px-[18%]">
              <img src="{{ asset($item->icono) }}" alt="">
              <h4 class="text-xl font-bold font-Inter_Medium"> {{ $item->titulo }} </h4>
              <div class="text-lg leading-8 text-[#444444] font-Inter_Medium">{!! $item->descripcionshort !!}</div>
            </div>
          @endforeach
        </div>
      </section>
    @endif --}}



    </main>



    <!-- Main modal -->
    <div id="modalofertas" class="modal modalbanner">
        <!-- Modal body -->
        <div class="p-1 ">
            <x-swipper-card-ofertas :items="$popups" id="modalOfertas" />
        </div>
    </div>

    @if(Session::has('welcome_message'))
    <div id="welcome-popup" class="claseocultar fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-6 rounded shadow-lg text-center">
                <h2 class="text-lg font-bold mb-4">{{ Session::get('welcome_message') }}</h2>
                <button id="close-popup" class="bg-blue-500 text-white px-4 py-2 rounded">Cerrar</button>
            </div>
        </div>
    @endif


@section('scripts_importados')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const popup = document.getElementById('welcome-popup');
            const closeButton = document.getElementById('close-popup');

            if (popup) {
                popup.classList.remove('hidden'); // Mostrar el popup

                closeButton.addEventListener('click', () => {
                    popup.classList.add('hidden'); // Ocultar el popup
                });
            }
        });
    </script>  

    <script>
        let pops = @json($popups);

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
        $(document).ready(function() {
            console.log(pops.length)
            if (pops.length > 0) {
                $('#modalofertas').modal({
                    show: true,
                    fadeDuration: 100
                })

            }


            $(document).ready(function() {
                articulosCarrito = Local.get('carrito') || [];

                // PintarCarrito();
            });

        })
    </script>

    <script>
        var swiper = new Swiper(".sliderab", {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            grabCursor: true,
            centeredSlides: false,
            initialSlide: 0,
             autoplay: {
                delay: 3000,
            },

            pagination: {
                el: ".swiper-pagination-slider",
                clickable: true,
            },


        });


        var swiper = new Swiper(".carruseltop", {
            slidesPerView: 4,
            spaceBetween: 25,
            loop: true,
            grabCursor: true,
            centeredSlides: false,
            initialSlide: 0,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination-cat",
                clickable: true,
                dynamicBullets: true,
            },

            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 25,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 25,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 25,
                },
                1350: {
                    slidesPerView: 4,
                    spaceBetween: 25,
                },
            },
        });

        var swiper = new Swiper(".otrasmarcas", {
            slidesPerView: 4,
            spaceBetween: 25,
            loop: true,
            grabCursor: true,
            centeredSlides: false,
            initialSlide: 0,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination-otrasmarcas",
                clickable: true,
                dynamicBullets: true,
            },

            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 25,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 25,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 25,
                },
                1350: {
                    slidesPerView: 4,
                    spaceBetween: 25,
                },
            },
        });


        var swiper = new Swiper(".complementos", {
            slidesPerView: 5,
            spaceBetween: 25,
            loop: true,
            grabCursor: true,
            centeredSlides: false,
            initialSlide: 0,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination-complementos",
                clickable: true,
                dynamicBullets: true,
            },

            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 25,
                },
                600: {
                    slidesPerView: 2,
                    spaceBetween: 25,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 25,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 25,
                },
                1350: {
                    slidesPerView: 5,
                    spaceBetween: 25,
                },
            },
        });


        var swiper = new Swiper(".instagram", {
            slidesPerView: 6,
            loop: true,
            grabCursor: true,
            centeredSlides: false,
            initialSlide: 0,
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                },
                600: {
                    slidesPerView: 2,
                    spaceBetween: 0,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 0,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 0,
                },
                1350: {
                    slidesPerView: 5,
                    spaceBetween: 0,    
                },
            },
        });


        var swiper = new Swiper(".promo", {
            slidesPerView: 1,
            spaceBetween: 50,
            loop: true,
            grabCursor: true,
            centeredSlides: false,
            initialSlide: 0,
            pagination: {
                el: ".swiper-pagination-promo",
                clickable: true,
                dynamicBullets: true,
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 50,
                },
                768: {
                    slidesPerView: 1,
                    spaceBetween: 50,
                },
                1024: {
                    slidesPerView: 1,
                    spaceBetween: 50,
                },
            },
        });
    </script>
@stop

@stop
