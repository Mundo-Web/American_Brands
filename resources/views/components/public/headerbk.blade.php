@php
    $pagina = Route::currentRouteName();
    $isIndex = $pagina == 'index';
@endphp


<style>
    .limited-text {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;  
    overflow: hidden;
    text-overflow: ellipsis;
    }
    
    nav a .underline-this {
        position: relative;
        overflow: hidden;
        /*display: inline-block;*/
        text-decoration: none;
        /* padding-bottom: 4px; */
    }

    nav a .underline-this::before,
    nav a .underline-this::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        /*height: 2px;*/
        background-color: #FF5E14;
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    nav a .underline-this::after {
        transform-origin: right;
    }

    nav a:hover .underline-this::before,
    nav a:hover .underline-this::after {
        transform: scaleX(1);
    }

    nav a:hover .underline-this::before {
        transform-origin: left;
    }

    nav li {
        padding: 0 !important;
        margin: 0 !important;
    }

    .jquery-modal.blocker.current {
        z-index: 30;
    }
</style>

<style>
    .bg-image {
        background-image: url('');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 900;
    }

    .productos-link-container{
       z-index: 999;
    }
</style>

<div class="navigation shadow-xl px-5 overflow-y-auto" style="z-index: 9999; background-color: #fff !important ">
    <button aria-label="hamburguer" type="button" class="hamburger" id="position" onclick="show()">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 2L2 18M18 18L2 2" stroke="#272727" stroke-width="2.66667" stroke-linecap="round" />
        </svg>
    </button>

    <nav class="w-full h-full overflow-y-auto p-5" x-data="{ openCatalogo: true, openSubMenu: null }">
        <ul class="space-y-1">
            <li>
                <a href="/"
                    class="text-[#272727] font-medium font-Urbanist_Semibold text-sm py-2 px-3 block hover:opacity-75 transition-opacity duration-300 {{ $isIndex ? 'text-black' : '' }}">
                    <span >
                        <svg class="inline-block w-3 h-3 mb-0.5 me-2 text-gray-400 dark:text-gray-500 group-hover:text-blue-600 dark:group-hover:text-blue-500"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        HOMBRE
                    </span>
                </a>
            </li>

            <li>
                <a @click="openCatalogo = !openCatalogo" href="javascript:void(0)"
                    class="text-[#272727] flex justify-between items-center font-medium font-Urbanist_Semibold text-sm py-2 px-3 hover:opacity-75 transition-opacity duration-300 {{ $pagina == 'catalogo' ? 'text-[#FF5E14]' : '' }}">
                    <span>
                        <svg class="inline-block w-3 h-3 mb-0.5 me-2 text-gray-400 dark:text-gray-500 group-hover:text-blue-600 dark:group-hover:text-blue-500"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 18 18">
                            <path
                                d="M15.977.783A1 1 0 0 0 15 0H3a1 1 0 0 0-.977.783L.2 9h4.239a2.99 2.99 0 0 1 2.742 1.8 1.977 1.977 0 0 0 3.638 0A2.99 2.99 0 0 1 13.561 9H17.8L15.977.783ZM6 2h6a1 1 0 1 1 0 2H6a1 1 0 0 1 0-2Zm7 5H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Z" />
                            <path
                                d="M1 18h16a1 1 0 0 0 1-1v-6h-4.439a.99.99 0 0 0-.908.6 3.978 3.978 0 0 1-7.306 0 .99.99 0 0 0-.908-.6H0v6a1 1 0 0 0 1 1Z" />
                        </svg>
                        MUJER
                    </span>
                    <span :class="{ 'rotate-180': openCatalogo }"
                        class="ms-1 inline-block transform transition-transform duration-300">↓</span>
                </a>
                <ul x-show="openCatalogo" x-transition class="ml-3 mt-1 space-y-1 border-l border-gray-300">
                    <li>
                        <a href="{{ route('Catalogo.jsx') }}"
                            class="text-black flex items-center font-Urbanist_Semibold py-2 px-3 hover:opacity-75 transition-opacity duration-300">
                            <span>
                                Todas las categorías
                            </span>

                        </a>
                        @if (count($categorias) > 0)


                            <div x-data="{ openCategories: {} }">
                                @foreach ($categorias as $item)
                                    <div class="text-black flex items-center font-Urbanist_Semibold py-2 px-3 hover:opacity-75 transition-opacity duration-300"
                                        @click="openCategories[{{ $item->id }}] = !openCategories[{{ $item->id }}]">
                                        <span>{{ $item->name }}</span>
                                        <svg class="w-5 h-5 transform transition-transform"
                                            :class="{ 'rotate-180': openCategories[{{ $item->id }}] }"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>

                                    <div x-show="openCategories[{{ $item->id }}]"
                                        class="p-2  border-t-0 border-gray-200 ">
                                        @foreach ($item->subcategories as $subitem)
                                            <label for="item-category-{{ $subitem->id }}"
                                                class="text-custom-border flex flex-row gap-2 items-center cursor-pointer">
                                                <a href="/catalogo?subcategoria={{ $subitem->id }}"
                                                    id="item-category-{{ $subitem->id }}" name="category"
                                                    class="rounded-sm border-none text-black font-Urbanist_Semibold flex items-center py-1 px-3 hover:opacity-75 transition-opacity duration-300"
                                                    value="{{ $subitem->id }}">
                                                    {{ $subitem->name }}
                                                </a>
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>

                        @endif
                    </li>

                </ul>
            </li>

            <li>
                <a href="/"
                    class="text-black font-medium font-Urbanist_Semibold text-sm py-2 px-3 block hover:opacity-75 transition-opacity duration-300 {{ $pagina == 'contacto' ? 'text-[#FF5E14]' : '' }}">
                    <span>
                        <svg class="inline-block w-3 h-3 mb-0.5 me-2 text-gray-400 dark:text-gray-500 group-hover:text-blue-600 dark:group-hover:text-blue-500"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 14 20">
                            <path
                                d="M12 0H2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM7.5 17.5h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2ZM12 13H2V4h10v9Z" />
                        </svg>
                        ACCESORIOS
                    </span>
                </a>
            </li>

            <li>
                <a href="/"
                    class="text-black font-medium font-Urbanist_Semibold text-sm py-2 px-3 block hover:opacity-75 transition-opacity duration-300 {{ $pagina == 'contacto' ? 'text-[#FF5E14]' : '' }}">
                    <span>
                        <svg class="inline-block w-3 h-3 mb-0.5 me-2 text-gray-400 dark:text-gray-500 group-hover:text-blue-600 dark:group-hover:text-blue-500"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M19 4h-1a1 1 0 1 0 0 2v11a1 1 0 0 1-2 0V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V5a1 1 0 0 0-1-1ZM3 4a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4Zm9 13H4a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-3H4a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-3H4a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-3h-2a1 1 0 0 1 0-2h2a1 1 0 1 1 0 2Zm0-3h-2a1 1 0 0 1 0-2h2a1 1 0 1 1 0 2Z" />
                            <path d="M6 5H5v1h1V5Z" />
                        </svg>
                        MARCAS
                    </span></a>
            </li>

             <li>
                <a href="/"
                    class="text-black font-medium font-Urbanist_Semibold text-sm py-2 px-3 block hover:opacity-75 transition-opacity duration-300 {{ $pagina == 'contacto' ? 'text-[#FF5E14]' : '' }}">
                    <span>
                        <svg class="inline-block w-3 h-3 mb-0.5 me-2 text-gray-400 dark:text-gray-500 group-hover:text-blue-600 dark:group-hover:text-blue-500"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M19 4h-1a1 1 0 1 0 0 2v11a1 1 0 0 1-2 0V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V5a1 1 0 0 0-1-1ZM3 4a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4Zm9 13H4a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-3H4a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-3H4a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-3h-2a1 1 0 0 1 0-2h2a1 1 0 1 1 0 2Zm0-3h-2a1 1 0 0 1 0-2h2a1 1 0 1 1 0 2Z" />
                            <path d="M6 5H5v1h1V5Z" />
                        </svg>
                        OUTLET
                    </span></a>
            </li>

            @if ($tags->count() > 0)
                @foreach ($tags as $item)
                    <li>
                        <a href="/catalogo?tag={{ $item->id }}"
                            class="text-[#272727] font-medium font-poppins text-sm py-2 px-3 block hover:opacity-75 transition-opacity duration-300 {{ $pagina == 'contacto' ? 'text-[#FF5E14]' : '' }}">
                            <span class="underline-this  ">
                                {{ $item->name }} </span>
                        </a>

                    </li>
                @endforeach
            @endif
        </ul>
    </nav>
</div>


<header>
    @foreach ($datosgenerales as $item)
        <div
            class="bg-[#4598d3] h-[50px] flex justify-center w-full px-[5%] xl:px-[8%] py-3 tracking-wider items-center mb-7">
            <h3 class="text-white font-Urbanist_Semibold text-base tracking-wider text-center hidden lg:flex">
                ENVÍO GRATUITO EN LIMA METROPOLITANA POR COMPRAS SUPERIORES A S./149.90
            </h3>
        </div>
    @endforeach
    
    {{-- <div
        class="bg-[#F5F5F7] h-10 flex lg:justify-end justify-center w-full px-[5%] xl:px-[8%] py-3 text-base items-center">
        <div class="text-[#111111] font-Helvetica_Medium font-medium  text-end flex gap-5 text-sm">
            
            <a href="{{ route('help') }}">Ayuda </a> |

            @if (Auth::user() == null)
                <a href="/login">Crear Usuario </a> | <a href="/register">Iniciar Sesion</a>
            @else
                <div class=" relative md:inline-flex" x-data="{ open: false }">
                    <button class="inline-flex justify-center items-center group" aria-haspopup="true"
                        @click.prevent="open = !open" :aria-expanded="open">
                        <div class="flex items-center truncate ">
                        <span id="usernamelogin" class="truncate ml-2 text-sm font-medium dark:text-slate-300 group-hover:opacity-75 dark:group-hover:text-slate-200">

                        </span>
                        <i class="fas fa-angle-down ms-2"></i>
                        </div>
                    </button>
                    <div
                        class="origin-top-right z-10 text-red-600 bg-red-100 absolute top-full min-w-44  dark:bg-slate-800 border border-slate-200 dark:border-slate-700 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                        @click.outside="open = false" @keydown.escape.window="open = false" x-show="open">
                        <ul>
                        <li class=" hover:bg-rose-700 hover:text-white transition duration-100 ease-in">
                            <a class="font-medium text-sm  flex items-center py-1 px-3 " href="/micuenta" @click="open = false"
                            @focus="open = true" @focusout="open = false">Mi
                            Cuenta</a>
                        </li>

                        <li class=" hover:bg-rose-700 hover:text-white transition duration-100 ease-in">
                            <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <button type="submit" class="font-medium text-sm  flex items-center py-1 px-3"
                                @click.prevent="$root.submit(); open = false">
                                {{ __('Cerrar sesión') }}
                            </button>
                            </form>
                        </li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div> --}}

    <div>
        <div id="header-menu" class="flex w-full px-[5%] py-2 flex-row text-[17px] relative bg-black">
            
            {{-- Menu hamburguesa --}}
            <div id="menu-burguer" class="flex w-3/12 lg:hidden z-10 justify-start items-center">
                <img class="h-9 w-9 cursor-pointer" src="{{ asset('images/svg/menubar.svg') }}"
                    alt="menu hamburguesa" onclick="show()" />
            </div>

            {{-- Input Search --}}
            <div class="relative hidden lg:flex w-3/12 lg:py-0  items-center justify-center">
                <div class="w-full">
                    <input id="buscarproducto" type="text" placeholder="Buscar productos"
                        class="font-Urbanist_Light w-full text-sm pl-8 bg-black pr-10 py-2 border border-t-0 border-x-0 border-b-[1px] border-b-white focus:border-b-white focus:outline-none focus:ring-0 text-white placeholder:text-white lg:placeholder:text-white">

                    <span class="absolute inset-y-0 left-0 flex items-start lg:items-center px-2 pb-2 pt-[9px] lg:p-2">
                        <svg width="17" height="17" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="rotate-90">
                            <path
                                d="M14.6851 13.6011C14.3544 13.2811 13.8268 13.2898 13.5068 13.6206C13.1868 13.9514 13.1955 14.4789 13.5263 14.7989L14.6851 13.6011ZM16.4206 17.5989C16.7514 17.9189 17.2789 17.9102 17.5989 17.5794C17.9189 17.2486 17.9102 16.7211 17.5794 16.4011L16.4206 17.5989ZM15.2333 9.53333C15.2333 12.6814 12.6814 15.2333 9.53333 15.2333V16.9C13.6018 16.9 16.9 13.6018 16.9 9.53333H15.2333ZM9.53333 15.2333C6.38531 15.2333 3.83333 12.6814 3.83333 9.53333H2.16667C2.16667 13.6018 5.46484 16.9 9.53333 16.9V15.2333ZM3.83333 9.53333C3.83333 6.38531 6.38531 3.83333 9.53333 3.83333V2.16667C5.46484 2.16667 2.16667 5.46484 2.16667 9.53333H3.83333ZM9.53333 3.83333C12.6814 3.83333 15.2333 6.38531 15.2333 9.53333H16.9C16.9 5.46484 13.6018 2.16667 9.53333 2.16667V3.83333ZM13.5263 14.7989L16.4206 17.5989L17.5794 16.4011L14.6851 13.6011L13.5263 14.7989Z"
                                fill="#E6E4E5" class="fill-fillAzulPetroleo lg:fill-fillPink" />
                        </svg>
                    </span>

                    <div class="bg-white z-60 shadow-2xl top-12 w-full absolute overflow-y-auto max-h-[200px]"
                        id="resultados"></div>
                </div>
            </div>

            {{-- Logo--}}
            <div class="w-9/12 flex items-center justify-center">
                <a href="/">
                    <img id="logo-boostperu" class="min-w-56 w-60" src="{{ asset($isIndex ? 'images/svg/LOGOAB.svg' : 'images/svg/LOGOAB.svg') }}" alt="american brands" />
                    {{-- <h2 class="text-2xl font-bold text-white tracking-widest font-Urbanist_Semibold text-center">AMERICAN BRANDS</h2> --}}
                </a>
            </div>

            {{-- Iconos --}}
            <div class="flex w-3/12 justify-end md:justify-end items-center gap-2 max-w-96 my-auto">
                <div class="flex flex-row justify-between gap-2 lg:gap-4 mt-1">
                    @if (Auth::user() == null)
                        <a class="hidden md:flex" href="{{ route('login') }}">
                            {{-- <i class="fa-solid fa-user-large fa-xl text-white !leading-none"></i> --}}
                            <img src="{{asset('images/svg/USER.svg')}}" class="text-white w-7" /></a>
                        </a>
                    @else
                        <div class="relative  hidden md:inline-flex font-Urbanist_Bold" x-data="{ open: false }">
                            <button class="px-3 py-5 inline-flex justify-center items-center group" aria-haspopup="true"
                                @click.prevent="open = !open" :aria-expanded="open">
                                <div class="flex items-center truncate">
                                    <span id="username"
                                        class="truncate ml-2 text-sm font-medium dark:text-slate-300 group-hover:opacity-75 dark:group-hover:text-slate-200 text-white ">
                                        {{ explode(' ', Auth::user()->name)[0] }}</span>
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </button>
                            <div class="bg-white origin-top-right z-10 absolute top-full min-w-44 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                                @click.outside="open = false" @keydown.escape.window="open = false" x-show="open">
                                <ul>
                                    <li class="hover:bg-gray-100">
                                        <a class="font-medium text-sm text-black flex items-center py-1 px-3"
                                            href="{{ route('micuenta') }}" @click="open = false" @focus="open = true"
                                            @focusout="open = false">Mi Cuenta</a>
                                    </li>

                                    <li class="hover:bg-gray-100">
                                        <form class="mb-0" method="POST" action="{{ route('logout') }}" x-data>
                                            @csrf
                                            <button type="submit"
                                                class="font-medium text-sm text-black flex items-center py-1 px-3"
                                                @click.prevent="$root.submit(); open = false">
                                                {{ __('Cerrar sesión') }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif

                    {{-- <div class="hidden lg:flex justify-center items-center">
                        <i class="fa-solid fa-location-dot fa-xl text-white !leading-none -mt-1"></i>
                    </div> --}}

                    {{-- <div class="hidden lg:flex justify-center items-center">
                        <i class="fa-solid fa-heart  fa-xl text-white !leading-none -mt-1"></i>
                    </div> --}}

                    <div class="flex justify-center items-center min-w-[38px]">
                        <div id="open-cart" class="relative inline-block cursor-pointer pr-3">
                            <span id="itemsCount"
                                class="bg-[#c1272d] text-xs font-medium font-Urbanist_Regular text-white text-center px-[7px] py-[2px]  rounded-full absolute bottom-0 right-0 ml-3">0</span>
                            {{-- <img src="{{ asset('images/svg/bag_boost.svg') }}"
                    class="bg-white rounded-lg p-1 max-w-full h-auto cursor-pointer" /> --}}
                            {{-- <i class="fa-solid fa-suitcase-rolling fa-xl text-white !leading-none -mt-1"></i> --}}
                            <img src="{{asset('images/svg/CARRITO.svg')}}" class="text-white w-7" /></a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>


    <div>
        <div class="hidden lg:flex items-center justify-center ">
          <div>
            <nav id="menu-items"
              class=" text-[#333] text-base font-Urbanist_Semibold tracking-wider flex gap-5 xl:gap-10 items-center justify-center py-8"
              x-data="{ openCatalogo: false, openSubMenu: null }">
              
              <a id="productos-link" href="{{ route('Catalogo.jsx') }}" class="font-medium">
                <span class="underline-this">HOMBRE</span>
                <div id="productos-link-h" class="w-0"></div>
              </a>

              <a href="{{ route('Catalogo.jsx') }}" class="font-medium other-class">
                <span class="underline-this">MUJER</span>
              </a>

              <a id="#" href="{{ route('Catalogo.jsx') }}" class="font-medium other-class">
                <span class="underline-this">ACCESORIOS</span>
                <div id="#" class="w-0"></div>
              </a>

              {{-- <a id="productos-link" href="{{ route('Catalogo.jsx') }}" class="font-medium ">
                <span class="underline-this">PRODUCTOS</span>
                <div id="productos-link-h" class="w-0"></div>
              </a> --}}

              {{-- @if ($offerExists)
                <a href="{{ route('Ofertas.jsx') }}" class="font-medium hover:opacity-75 other-class">
                  <span class="underline-this">MARCAS</span>
                </a>
              @endif --}}

              <a id="productos-link2" href="/contacto" class="font-medium hover:opacity-75 other-class">
                <span class="underline-this">MARCAS</span>
                <div id="productos-link-m" class="w-0"></div>
              </a>
             
              @if ($tags->count() > 0)
                @foreach ($tags as $item)
                  <a href="/catalogo?tag={{ $item->id }}" class="font-medium text-white px-4 other-class"
                    style="background-color: {{ $item->color }}">
                    <span class="">
                      {{ $item->name }} </span>
                  </a>
                @endforeach
              @endif

            </nav>
          </div>
        </div> 
    </div>


    <div class="flex justify-end relative">
        <div class="fixed bottom-[36px] z-[10] right-[15px] md:right-[25px] animate-bounce animate-twice"  >
            <a target="_blank" href="https://api.whatsapp.com/send?phone={{ $datosgenerales[0]->whatsapp }}&text={{ $datosgenerales[0]->mensaje_whatsapp }}"
                class="">
                <img src="{{ asset('images/svg/botonwhatsapp.svg') }}" alt="whatsapp" class="w-16"  />
            </a>
        </div>
    </div>

   
</header>







<div id="cart-modal"
    class="bag !absolute top-0 right-0 md:w-[450px] cartContainer border shadow-2xl  !rounded-l-2xl !p-0 !z-30"
    style="display: none">
    <div class="p-4 flex flex-col h-[calc(100vh-2px)] justify-between gap-2">
        <div class="flex flex-col">
            <div class="flex justify-between ">
                <h2 class="font-semibold font-Urbanist_Bold text-[28px] text-[#151515] tracking-tight pb-5">Carrito de compras</h2>
                <div id="close-cart" class="cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke="#272727" stroke-linecap="round" stroke-linejoin="round"
                            d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
            <div class="overflow-y-scroll h-[calc(90vh-130px)] scroll__carrito">
                <table class="w-full">
                    <tbody id="itemsCarrito">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex flex-col gap-2 pt-2">
            <div class="text-[#111111]  text-xl flex justify-between items-center ">
                <p class="font-Urbanist_Bold font-semibold">Total</p>
                <p class="font-Urbanist_Bold font-semibold" id="itemsTotal">S/ 0.00</p>
            </div>
            <div>
                <a href="/carrito"
                    class="font-normal font-Urbanist_Bold text-lg bg-black  py-3 px-5 rounded-none text-white cursor-pointer w-full inline-block text-center">Ir al
                    carrito</a>
            </div>
        </div>
    </div>
</div>


<script>
  @auth
  $(document).ready(function() {
    let name = "{{ Auth::user()->name }}" ?? ''
    let lastname = "{{ Auth::user()->lastname }}" ?? ''
    lastname = lastname.toLowerCase()
    let [firstName, SecondName] = name.split(' ')
    let [firstLName, SecondLName] = lastname.split(' ')


    firstLName = firstLName ? firstLName.charAt(0).toUpperCase() + firstLName.slice(1) : ''
    SecondLName = SecondLName ? SecondLName.charAt(0).toUpperCase() + SecondLName.slice(1) : ''

    $('#usernamelogin').text(
      `${firstName ? firstName : ''} ${SecondName ? SecondName : ''} ${firstLName ? firstLName : ''} ${SecondLName ? SecondLName : ''}`
    )

  })
  @endauth
</script>

<script>
    let clockSearch;

    function openSearch() {
        document.getElementById("myOverlay").style.display = "block";

    }

    function closeSearch() {
        document.getElementById("myOverlay").style.display = "none";
    }

    function imagenError(image) {
        image.onerror = null; // Previene la posibilidad de un bucle infinito si la imagen de error también falla
        image.src = '/images/img/noimagen.jpg'; // Establece la imagen de error
    }

    $('#buscarproducto').keyup(function() {

        clearTimeout(clockSearch);
        var query = $(this).val().trim();

        if (query !== '') {
            clockSearch = setTimeout(() => {
                $.ajax({
                    url: '{{ route('buscar') }}',
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        var resultsHtml = '';
                        var url = '{{ asset('') }}';
                        data.forEach(function(result) {
                            const price = Number(result.precio) || 0
                            const discount = Number(result.descuento) || 0
                            resultsHtml += `<a href="/producto/${result.slug}">
              <div class="w-full flex flex-row py-3 px-3 hover:bg-slate-200">
                <div class="w-[15%]">
                  <img class="w-20 rounded-md" src="${url}${result.imagen}" onerror="imagenError(this)" />
                </div>
                <div class="flex flex-col justify-center w-[60%] px-2 line-clamp-2">
                  <h2 class="text-left text-[12px] line-clamp-2">${result.producto}</h2>
                </div>
                <div class="flex flex-col justify-center w-[15%]">
                  <p class="text-right w-max text-[14px] ">S/ ${discount > 0 ? discount.toFixed(2) : price.toFixed(2)}</p>
                  ${discount > 0 ? `<p class="text-[12px] text-right line-through text-slate-500 w-max">S/ ${price.toFixed(2)}</p>` : ''}
                </div>
              </div>
            </a>`;
                        });

                        $('#resultados').html(resultsHtml);
                    }
                });

            }, 300);

        } else {
            $('#resultados').empty();
        }
    });
</script>

<script>
    $('#open-cart').on('click', () => {
        $('#cart-modal').modal({
            showClose: false,
            fadeDuration: 100
        })
    })
    $('#close-cart').on('click', () => {
        $('.jquery-modal.blocker.current').trigger('click')
    })
</script>

<script>
    // $(document).ready(function() {
    //     if ({{ $isIndex ? 1 : 0 }}) {
    //         $(window).scroll(function() {
    //             var scroll = $(window).scrollTop();
    //             var categoriasOffset = $('#categorias').offset().top;

    //             const headerMenu = $('#header-menu')
    //             const logo = $('#logo-decotab')
    //             const items = $('#menu-items')
    //             const username = $('#username')
    //             const burguer = $('#menu-burguer')
    //             if (scroll >= categoriasOffset) {
    //                 headerMenu
    //                     .removeClass('absolute bg-transparent text-white')
    //                     .addClass('fixed top-0 bg-white shadow-lg');
    //                 items
    //                     .removeClass('text-white')
    //                     .addClass('text-[#272727]')
    //                 username
    //                     .removeClass('text-white')
    //                     .addClass('text-[#272727]')
    //                 // burguer
    //                 //   .removeClass('absolute')
    //                 //   .addClass('fixed')
    //                 logo.attr('src', 'images/svg/logo_decotab_header.svg')
    //                 $('#header-menu svg').attr('stroke', '#272727');
    //             } else {
    //                 headerMenu
    //                     .removeClass('fixed bg-white shadow-lg')
    //                     .addClass('absolute bg-transparent text-white');
    //                 items
    //                     .removeClass('text-[#272727]')
    //                     .addClass('text-white')
    //                 username
    //                     .removeClass('text-[#272727]')
    //                     .addClass('text-white')
    //                 // burguer
    //                 //   .removeClass('fixed')
    //                 //   .addClass('absolute')
    //                 logo.attr('src', '')
    //                 $('#header-menu svg').attr('stroke', 'white');
    //             }
    //         });
    //     }
    //     mostrarTotalItems()
    // })
</script>

<script src="{{ asset('js/storage.extend.js') }}"></script>

<script>
    var articulosCarrito = []
    articulosCarrito = Local.get('carrito') || [];

    function addOnCarBtn(id, isCombo) {
        let prodRepetido = articulosCarrito.map(item => {
            if (item.id === id && item.isCombo == isCombo) {

                item.cantidad += 1;
            }
            return item;
        });

        Local.set('carrito', articulosCarrito);
        limpiarHTML();
        PintarCarrito();
    }

    function deleteOnCarBtn(id, isCombo) {
        let prodRepetido = articulosCarrito.map(item => {
            if (item.id === id && item.isCombo == isCombo && item.cantidad > 0) {

                item.cantidad -= 1;
            }
            return item;
        });

        Local.set('carrito', articulosCarrito);
        limpiarHTML();
        PintarCarrito();
    }

    function deleteItem(id, isCombo) {

        let idCount = {};
        let duplicates = [];
        articulosCarrito.forEach(item => {
            if (idCount[item.id]) {
                idCount[item.id]++;
            } else {
                idCount[item.id] = 1;
            }
        });

        for (let id in idCount) {
            if (idCount[id] > 1) {
                duplicates.push(id);
            }
        }

        if (duplicates.length > 0) {
            let index = articulosCarrito.findIndex(item => item.id === id && item.isCombo == isCombo);
            if (index > -1) {
                articulosCarrito.splice(index, 1);
            }
        } else {
            articulosCarrito = articulosCarrito.filter(objeto => objeto.id !== id);

        }

        // return

        Local.set('carrito', articulosCarrito)
        limpiarHTML()
        PintarCarrito()
    }

    function limpiarHTML() {
        //forma lenta 
        /* contenedorCarrito.innerHTML=''; */
        $('#itemsCarrito').html('')
        $('#itemsCarritoCheck').html('')
    }

    var appUrl = "{{ env('APP_URL') }}";

    $(document).ready(function() {

        PintarCarrito()

        $('#buscarblog').keyup(function() {

            var query = $(this).val().trim();

            if (query !== '') {
                $.ajax({
                    url: '{{ route('buscarblog') }}',
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        var resultsHtml = '';
                        var url = '{{ asset('') }}';
                        data.forEach(function(result) {
                            resultsHtml +=
                                '<a class="z-50" href="/post/' + result.id +
                                '"> <div class=" z-50 w-full flex flex-row py-2 px-3 hover:bg-slate-200"> ' +
                                ' <div class="w-[30%]"><img class="w-full rounded-md" src="' +
                                url + result.url_image + result.name_image +
                                '" /></div>' +
                                ' <div class="flex flex-col justify-center w-[80%] pl-3"> ' +
                                ' <h2 class="text-left line-clamp-1">' + result
                                .title +
                                '</h2> ' +
                                '</div> ' +
                                '</div></a>';
                        });

                        $('#resultadosblog').html(resultsHtml);
                    }
                });
            } else {
                $('#resultadosblog').empty();
            }
        });

        document.addEventListener('click', function(event) {
            var input = document.getElementById('buscarproducto');
            var resultados = document.getElementById('resultados');
            var isClickInsideInput = input.contains(event.target);
            var isClickInsideResultados = resultados.contains(event.target);

            if (!isClickInsideInput && !isClickInsideResultados) {
                input.value = '';
                $('#resultados').empty();
            }
        });
    });
</script>

<script>
    document.addEventListener('click', function(event) {
        var input = document.getElementById('buscarblog');
        var resultados = document.getElementById('resultadosblog');

        // Check if both elements exist
        if (input && resultados) {
            var isClickInsideInput = input.contains(event.target);
            var isClickInsideResultados = resultados.contains(event.target);

            if (!isClickInsideInput && !isClickInsideResultados) {
                input.value = '';
                $('#resultadosblog').empty();
            }
        }
    });
</script>

<script>
    $(document).ready(function() {
        $(document).on('mouseenter', '.other-class', function() {
            cerrar()
        });
    })

    const categorias = @json($categorias);
    var activeHover = false
    
    document.getElementById('productos-link').addEventListener('mouseenter', function(event) {
        if (event.target === this) {
            // mostrar submenú de productos 
            let padre = document.getElementById('productos-link-h');
            let divcontainer = document.createElement('div');
            divcontainer.id = 'productos-link-container';
            divcontainer.className =
                'absolute top-[219px] border-b-2 border-b-black z-[10] left-1/2 transform -translate-x-1/2 m-0 flex flex-row bg-white gap-4 p-4 w-full overflow-x-auto';

            divcontainer.addEventListener('mouseenter', function() {
                this.addEventListener('mouseleave', cerrar);
            });

            categorias.forEach(element => {
                if (element.subcategories.length == 0) return;
                let ul = document.createElement('ul');
                ul.className =
                    'text-[#006BF6]  font-bold font-poppins text-md py-2 px-3 max-w-lg mx-auto  duration-300 w-full whitespace-nowrap gap-4';

                ul.innerHTML = element.name;
                
                element.subcategories.forEach(subcategoria => {
                    let li = document.createElement('li');
                    li.style.setProperty('padding-left', '4px', 'important');
                    li.style.setProperty('padding-right', '2px', 'important');

                    li.className =
                        'text-[#272727] px-2 rounded-sm cursor-pointer font-normal font-poppins text-[13px] py-2 px-3 hover:bg-blue-200 hover:opacity-75 transition-opacity duration-300 w-full whitespace-nowrap';
                    // Crear el elemento 'a'
                    let a = document.createElement('a');
                    a.href = `/catalogo?subcategoria=${subcategoria.id}`;
                    a.innerHTML = subcategoria.name;
                    a.className = ' w-full h-full'; // Para que el enlace ocupe todo el 'li'

                    // Añadir el elemento 'a' al 'li'
                    li.appendChild(a);
                    ul.appendChild(li);
                });
                
                divcontainer.appendChild(ul);
            });



            // limpia sus hijos antes de agregar los nuevos
            if (!activeHover) {
                padre.appendChild(divcontainer);
                activeHover = true;
            }
        }
    });



    function cerrar() {
        let padre = document.getElementById('productos-link-h');
        activeHover = false
        padre.innerHTML = '';
    }



    function aplicarDescuentosEnCarrito(articulosCarrito) {
        // Agrupar productos que tienen un discount_id
        let productosConDescuento = articulosCarrito.filter(item => item.discount_id !== null);
        // Agrupar por discount_id
        let gruposDescuentos = {};

        productosConDescuento.forEach(item => {
            if (!gruposDescuentos[item.discount_id]) {
                gruposDescuentos[item.discount_id] = {
                    productos: [],
                    take_product: item.take_product,
                    payment_product: item.payment_product,
                    type_id: item.type_id,
                };
            }
            gruposDescuentos[item.discount_id].productos.push(item);
        });

        

        // Aplicar descuentos a cada grupo
        for (let discount_id in gruposDescuentos) {
            let grupo = gruposDescuentos[discount_id];
            let cantidadTotal = grupo.productos.reduce((total, item) => total + item.cantidad, 0);
            let take_product = grupo.take_product;
            let payment_product = grupo.payment_product;
            let descuentoTipo = grupo.type_id;
            let productosDeMismoNombre = {}

         

            grupo.productos.forEach(item => {
                if (!productosDeMismoNombre[item.producto]) {
                    productosDeMismoNombre[item.producto] = {
                        productosf: [], // Lista de productos con el mismo nombre
                    };
                }
                productosDeMismoNombre[item.producto].productosf.push(item); // Agregar productos al grupo por nombre
            });

           

            switch (descuentoTipo) {
                case 1: // Descuento por Unidad
                    for (let productoNombre in productosDeMismoNombre) {
                        let productos = productosDeMismoNombre[productoNombre].productosf;
                        let cantidadTotalPorNombre = productos.reduce((total, item) => total + item.cantidad, 0);

                        if (cantidadTotalPorNombre >= take_product) {
                            let cantidadADescontar = Math.floor(cantidadTotalPorNombre / take_product) * (take_product - payment_product);
                            let productosRestantes = cantidadADescontar;
                            
                            productos.forEach(item => {
                                let cantidadProducto = item.cantidad;
                                // Aplicar descuento a los productos
                                if (cantidadADescontar > 0 && item.cantidad >= take_product) {
                                    // En este caso, pagas por 1 producto de cada 2
              
                                    item.recalcularcuando = 
                                    item.precioFinal = item.precio * payment_product / take_product; // Precio ajustado
                                    cantidadADescontar -= item.cantidad;
                                } else {
                                    item.precioFinal = item.precio; // Sin descuento
                                }
                            });
                        }
                    }
                    break;

                case 2: // Descuento Porcentual
                    if (cantidadTotal >= take_product) {
                        let porcentajeDescuento = payment_product / 100; 
                        grupo.productos.forEach(producto => {
                            producto.precioFinal = producto.precio * porcentajeDescuento;
                        });
                    }
                    break;

                case 3: // Descuento por Precio Fijo
                    if (cantidadTotal >= take_product) {
                        
                        let grupos = Math.floor(cantidadTotal / take_product);
                        let totalProductosConDescuento = grupos * payment_product;
                        let totalProductosSinDescuento = cantidadTotal % take_product;

                        grupo.productos.forEach(producto => {
                            if (totalProductosConDescuento > 0) {
                                producto.precioFinal = payment_product / take_product; 
                                totalProductosConDescuento -= producto.cantidad;
                            } else {
                                producto.precioFinal = producto.precio; 
                            }
                        });
                    }
                    break;

                default:
                   
                    grupo.productos.forEach(producto => {
                        producto.precioFinal = producto.precio;
                    });
                    break;
            }
        }
        return articulosCarrito;
    }

    function agregarAlCarrito(item, cantidad) {
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
                    color,
                    peso,
                    precio_reseller,
                    discount_id,
                    discount
                } = success.data

                let is_reseller = success.is_reseller

                if (is_reseller) {
                    descuento = precio_reseller
                }

                if (discount_id && discount) {
                    // Si existe un descuento, desestructuramos las propiedades
                    ({ 
                        take_product, 
                        payment_product, 
                        type_id, 
                        status 
                    } = discount);
                } else {
                    // Si no existe descuento, inicializamos las variables con valores por defecto
                    take_product = null;
                    payment_product = null;
                    type_id = null;
                    status = null;
                }

                /*let have_discount = success.discount_id
                if (!have_discount) {
                    take_product = null;
                    payment_product = 
                }*/

                let cantidad = Number(success.cantidad)
                
                let detalleProducto = {
                    id,
                    producto,
                    isCombo: false,
                    descuento,
                    precio,
                    imagen,
                    cantidad,
                    color,
                    peso,
                    discount_id,
                    discount,
                    take_product, 
                    payment_product, 
                    type_id, 
                    status 
                }


                let existeArticulo = articulosCarrito.some(item => item.id === detalleProducto.id && item
                    .isCombo ==
                    false, )

                if (existeArticulo) {
                    //sumar al articulo actual 
                    const prodRepetido = articulosCarrito.map(item => {
                        if (item.id === detalleProducto.id && item.isCombo == false) {
                            item.cantidad += Number(detalleProducto.cantidad);
                            // retorna el objeto actualizado 
                        }
                        return item; // retorna los objetos que no son duplicados 


                    });
                } else {
                    articulosCarrito = [...articulosCarrito, detalleProducto]

                }

                articulosCarrito = aplicarDescuentosEnCarrito(articulosCarrito);

                Local.set('carrito', articulosCarrito)
                let itemsCarrito = $('#itemsCarrito')
                let ItemssubTotal = $('#ItemssubTotal')
                let itemsTotal = $('#itemsTotal')
                limpiarHTML()
                PintarCarrito()
                mostrarTotalItems()

                Notify.add({
                    icon: '/images/svg/Boost.svg',
                    title: 'Producto agregado',
                    body: 'El producto se agregó correctamente al carrito',
                    type: 'success',
                })

            },
            error: function(error) {
                console.error(error)
            }

        })
    }
    
    $(document).on('click', '#btnAgregarCarritoPr', function() {
        //let url = window.location.href;
        //let partesURL = url.split('/');
        //let productoEncontrado = partesURL.find(parte => parte === 'producto');
        let item
        let cantidad

        let tallaSelected = $('.tallaSelected');
        let productId = tallaSelected.data('productid');

        //item = partesURL[partesURL.length - 1]
        cantidad = Number($('#cantidadSpan span').text());
        //item = $(this).data('id');
        try {
            agregarAlCarrito(productId, cantidad)

        } catch (error) {
            console.error(error)
        }
    })

    $(document).on('click', '#btnAgregarCarrito', function() {

        let item = $(this).data('id')

        let cantidad = 1
        try {
            agregarAlCarrito(item, cantidad)

        } catch (error) {
            console.error(error)

        }
    })

    
</script>

