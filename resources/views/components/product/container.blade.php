<div x-data="{ showAmbiente: false }" @mouseenter="showAmbiente = true" @mouseleave="showAmbiente = false"
  class="flex flex-col relative w-full md:{{ $width }} {{ $bgcolor }}  md:min-h-[425px] gap-1">
  <div class="{{ $bgcolor }} product_container basis-4/5 flex flex-col justify-center relative">
    {{-- @php
      echo json_encode($item->tags);
    @endphp --}}

    {{-- <div class="absolute top-2 left-2 w-max">
      <div className='flex flex-wrap gap-1.5'>
        @if ($item->tags)
          @foreach ($item->tags as $tag)
            <div class="px-4 mb-1">
              <span
                class="block font-semibold text-[8px] md:text-[12px] bg-black py-2 px-2 flex-initial w-24 text-center text-white rounded-[5px] relative top-[18px] z-10"
                style="background-color: {{ $tag->color }}">

                {{ $tag->name }}
              </span>
            </div>
          @endforeach
        @endif
      </div>     
    </div> --}}
    <div class="absolute top-2 left-2 w-max">
      <div class='flex flex-wrap gap-1.5'>
        @if ($item->descuento > 0)
          <div class="mb-1">
            <span
              class="block font-Urbanist_Semibold text-[8px] md:text-[12px] bg-black py-1 px-3 flex-initial w-full text-center rounded-none text-white relative z-10"
              style="background-color: #c1272d;"
            >
              -{{ round(100 - (($item->descuento * 100) / $item->precio)) }}%
            </span>
          </div>
        @endif
    
        @if ($item->tags)
          @foreach ($item->tags as $tag)
            <div class="mb-1">
              <span
                class="block font-semibold text-[8px] font-Urbanist_Regular md:text-[12px] bg-black py-1 px-2 flex-initial w-full text-center text-white rounded-none relative z-10"
                style="background-color: {{ $tag->color }}"
              >
                {{ $tag->name }}
              </span>
            </div>
          @endforeach
        @endif
      </div>     
    </div>

    <a href="{{ route('producto', $item->slug) }}">
      <div>
        <div class="relative flex justify-center items-center aspect-square">
          @php
            $category = $item->categoria();
          @endphp
          @if ($item->imagen)
            <img x-show="{{ isset($item->imagen_ambiente) }} || !showAmbiente"
              x-transition:enter="transition ease-out duration-300 transform"
              x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
              x-transition:leave="transition ease-in duration-300 transform"
              x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
              src="{{ asset($item->imagen) }}" alt="{{ $item->name }}"
              class="w-full object-contain md:object-cover absolute inset-0 aspect-square"
              onerror="this.onerror=null;this.src='/images/img/noimagen.jpg';" />
          @else
            <img x-show="{{ isset($item->imagen_ambiente) }} || !showAmbiente"
              x-transition:enter="transition ease-out duration-300 transform"
              x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
              x-transition:leave="transition ease-in duration-300 transform"
              x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
              src="{{ asset('images/img/noimagen.jpg') }}" alt="imagen_alternativa"
              class="w-full object-contain md:object-cover absolute inset-0 aspect-square" />
          @endif
        </div>
      </div>
    </a>
    
  </div>

  <div>
    @if ($item->marcas && $item->marcas->url_image)
      <div class="flex justify-start items-center mt-0 md:mt-1 h-6 lg:h-7">
          <img
              src="{{ asset($item->marcas->url_image) }}"
              class="h-4 w-auto"
          />
      </div>
    @endif
  </div>

  <a href="{{ route('producto', $item->slug) }}">
    <h2 id="h2Container"
      class="block text-sm xl:text-base text-left overflow-hidden font-medium text-[#808080] font-Urbanist_Regular"
       style="display: -webkit-box;-webkit-line-clamp: 1;text-overflow: ellipsis;-webkit-box-orient: vertical;overflow: hidden;height: 20px;"
      title="{{ $item->producto }}">
      {{-- {{ mb_strimwidth($item->producto, 0, 100, '...') }} --}}
      {{$item->producto}}
    </h2>
    <span class='text-[14px] font-Urbanist_Light'>{{$item->color}} - {{$item->peso}}</span>
    <div class="flex content-between flex-row gap-4 items-center justify-start !font-Helvetica_Medium pb-4">
      @if ($item->descuento == 0)
        <span class="text-[#c1272d] font-Urbanist_Regular font-bold"> S/. {{ $item->precio }}</span>
      @else
        <div class="flex flex-row gap-2 items-center">
          <span class="text-[#c1272d] font-Urbanist_Regular font-bold">S/. {{ $item->descuento }}</span>
          <span class="text-[#808080] opacity-80 line-through font-Urbanist_Regular text-[12px] md:text-sm">S/. {{ $item->precio }}</span>
        </div>
      @endif
    </div>
  </a>

</div>

<style>
  .cortartexto {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    text-overflow: ellipsis;
    max-height: 20px;
  }
</style>

<script>
  $(document).ready(function() {
    tippy('.tippy', {
      arrow: true,
      followCursor: true,
      placement: 'right',

    })
  })
</script>
