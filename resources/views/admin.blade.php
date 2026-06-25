@php
  $component = Route::currentRouteName();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{config('app.name')}}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..700&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <!-- funciones -->

  {{-- colorpicker  --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css" />
  <!-- 'classic' theme -->
  <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>


  <!-- DataTable -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.tailwindcss.css">
  <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.0.3/js/dataTables.tailwindcss.js"></script>
  {{-- <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script> --}}
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

  <!-- Sweetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <!-- TinyMCE -->
  <script src="https://cdn.tiny.cloud/1/ghrt2o720w7v1cwfkm9r7pl85ultx89hqfla88bsjvt0m6zc/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>
  <a></a>
  {{-- kj7rz3ruf2k1dwv5rrw0v3iekjqj1h0xy6wn1ago86ohjn3l --}}
  <!-- Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <!-- Scripts -->
  @vite(['resources/js/' . $component, 'resources/css/app.css', 'resources/js/app.js'])

  <!-- Styles -->
  @livewireStyles

  <script>
    if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
      document.querySelector('html').classList.remove('dark');
      document.querySelector('html').style.colorScheme = 'light';
    } else {
      document.querySelector('html').classList.add('dark');
      document.querySelector('html').style.colorScheme = 'dark';
    }
  </script>

  {{-- AOS Animation --}}
  <link href="//unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="//unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="/js/tippy.all.min.js"></script>
  <script src="/js/cookies.extend.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>

  <style>
    .jquery-modal.blocker.current {
      z-index: 40;
    }
  </style>

</head>

<body class="font-inter antialiased bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400"
  :class="{ 'sidebar-expanded': sidebarExpanded }" x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }" x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">

  <script>
    if (localStorage.getItem('sidebar-expanded') == 'true') {
      document.querySelector('body').classList.add('sidebar-expanded');
    } else {
      document.querySelector('body').classList.remove('sidebar-expanded');
    }
  </script>

  <!-- Page wrapper -->
  <div class="flex h-[100dvh] overflow-hidden">

    <x-app.sidebar />

    <!-- Content area -->
    <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden " x-ref="contentarea">

      <x-app.header />

      <main class="grow">
        @inertia()
      </main>

    </div>

  </div>

  @livewireScripts

  <script>
    AOS.init();
  </script>

</body>

</html>
