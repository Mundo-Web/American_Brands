<div x-data="{ showAmbiente: false }" @mouseenter="showAmbiente = true" @mouseleave="showAmbiente = false"
  class="flex flex-col relative" data-aos="zoom-in-left">
  <div class="bg-[#f2f2f2] product_container basis-4/5 flex flex-col justify-center relative">
    {{-- @php
      echo json_encode($item->tags);
    @endphp --}}
    <div class="absolute top-2 left-2">
      @foreach ($item->tags as $tag)
        <div class="px-4 mb-1">
          <span
            class="block font-semibold text-[8px] md:text-[12px] bg-black py-2 px-2 flex-initial w-24 text-center text-white rounded-[5px] relative top-[18px] z-10"
            style="background-color: {{ $tag->color }}">

            {{ $tag->name }}
          </span>
        </div>
      @endforeach
    </div>
    <div>
      <div class="relative flex justify-center items-center h-[300px]">
        @php
          $category = $item->categoria();
        @endphp
        @if ($item->imagen)
          <img x-show="!showAmbiente" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300 transform"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            src="{{ asset($item->imagen) }}" alt="{{ $item->name }}"
            class="w-full h-[300px] object-{{ $category->fit }} absolute inset-0" />
        @else
          <img x-show="!showAmbiente" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300 transform"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            src="{{ asset('images/img/noimagen.jpg') }}" alt="imagen_alternativa"
            class="w-full h-[300px] object-{{ $category->fit }} absolute inset-0" />
        @endif
        @if ($item->imagen_ambiente)
          <img x-show="showAmbiente" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300 transform"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            src="{{ asset($item->imagen_ambiente) }}" alt="{{ $item->name }}"
            class="w-full h-[300px] object-cover absolute inset-0" />
        @else
          <img x-show="showAmbiente" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300 transform"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            src="{{ asset('images/img/noimagen.jpg') }}" alt="imagen_alternativa"
            class="w-full h-[300px] object-cover absolute inset-0" />
        @endif
      </div>
      <!-- ------ -->
      <div class="addProduct text-center flex justify-center h-0">
        <a href="{{ route('producto', $item->slug) }}"
          class="font-semibold text-[16px]  bg-[#006BF6] py-2 px-4 text-center text-white rounded-3xl h-10">
          Ver producto
        </a>
      </div>
    </div>
  </div>
  <div class="my-2 flex flex-col items-start gap-2 basis-1/5 px-2">
    <p class="font-bolder text-[20px] text-[#121212] flex gap-5">
      @if ($item->descuento == 0)
        <span>S/. {{ $item->precio }}</span>
      @else
        <span class="text-[#FF5E14]">S/. {{ $item->descuento }}</span>
        <span class="font-normal text-[20px] text-[#6C7275] line-through">{{ $item->precio }}</span>
      @endif
    </p>
    <h2 class="font-semibold text-[18px] text-[#141718]">
      {{ $item->producto }}
    </h2>
  </div>
</div>
