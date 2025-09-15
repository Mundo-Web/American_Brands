<x-app-layout>
  <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Breadcrumb -->
    <div class="mb-6">
      <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
          <li class="inline-flex items-center">
            <a href="{{ route('clientes.index') }}" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
              <i class="fas fa-users mr-2"></i>
              Clientes
            </a>
          </li>
          <li>
            <div class="flex items-center">
              <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
              <span class="text-gray-500">{{ $client->name }} {{ $client->lastname }}</span>
            </div>
          </li>
        </ol>
      </nav>
    </div>

    <div class="max-w-6xl mx-auto">
      
      <!-- Información del Cliente -->
      <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
        <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
          <h2 class="font-semibold text-slate-800 dark:text-slate-100 text-xl">Información del Cliente</h2>
        </header>
        <div class="p-5">
          <div class="flex items-start space-x-4 mb-6">
            <div class="flex-shrink-0">
              <img class="w-20 h-20 rounded-full object-cover" 
                   src="{{ $client->profile_photo_url }}" 
                   alt="{{ $client->name }}"
                   onerror="this.src='/images/default-avatar.png'">
            </div>
            <div class="flex-1 min-w-0">
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                  <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Nombre Completo</label>
                  <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                    {{ $client->name }} {{ $client->lastname }}
                  </p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                  <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $client->email }}</p>
             
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Cliente desde</label>
                  <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                    {{ $client->created_at->format('d/m/Y') }}
                  </p>
                </div>
                
                @if($client->direccion && $client->direccion->first())
                <div>
                  <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
                  <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                    {{ $client->direccion->first()->phone ?? 'No registrado' }}
                  </p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Dirección Principal</label>
                  <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                    {{ $client->direccion->first()->dir_av_calle }} {{ $client->direccion->first()->dir_numero }}
                  </p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Ubicación</label>
                  <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                    {{ $client->direccion->first()->district->description ?? '' }}{{ $client->direccion->first()->district && $client->direccion->first()->province ? ', ' : '' }}{{ $client->direccion->first()->province->description ?? '' }}
                  </p>
                </div>
                @endif

             
              </div>
            </div>
          </div>

          <!-- Acciones -->
          <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
            <div class="flex flex-wrap gap-3">
              <button onclick="enviarEmail('{{ $client->email }}')" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <i class="fas fa-envelope mr-2"></i>
                Enviar Email
              </button>
              <button onclick="llamarCliente('{{ $client->direccion && $client->direccion->first() ? $client->direccion->first()->phone : '' }}')" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <i class="fas fa-phone mr-2"></i>
                Llamar
              </button>
          <!--Agregar boton regresar a clientes-->
              <button onclick="window.location='{{ route('clientes.index') }}'" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <i class="fas fa-arrow-left mr-2"></i>
                Regresar a Clientes
              </button>
            </div>
          </div>
        </div>
      </div>

  


    </div>

  </div>

  <script>
    function enviarEmail(email) {
      if (!email) {
        Swal.fire({
          title: 'Error',
          text: 'No hay email disponible para este cliente',
          icon: 'error'
        });
        return;
      }
      
      // Abrir el cliente de email del sistema
      window.location.href = 'mailto:' + email + '?subject=Contacto desde American Brands&body=Estimado/a cliente,%0D%0A%0D%0A';
    }

    function llamarCliente(telefono) {
      if (!telefono) {
        Swal.fire({
          title: 'Sin teléfono',
          text: 'Este cliente no tiene un número de teléfono registrado',
          icon: 'warning'
        });
        return;
      }
      
      Swal.fire({
        title: 'Llamar a cliente',
        text: `¿Deseas llamar al número ${telefono}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, llamar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          // Intentar abrir la aplicación de teléfono
          window.location.href = 'tel:' + telefono;
        }
      });
    }

    function confirmDeactivate(clientId) {
      Swal.fire({
        title: '¿Desactivar cliente?',
        text: "Esta acción desactivará la cuenta del cliente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, desactivar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: `{{ route('clientes.borrar') }}`,
            method: 'POST',
            data: {
              _token: $('meta[name="csrf-token"]').attr('content'),
              id: clientId,
            }
          }).done(function(res) {
            Swal.fire({
              title: 'Cliente desactivado',
              text: res.message,
              icon: 'success'
            }).then(() => {
              window.location.href = '{{ route('clientes.index') }}';
            });
          }).fail(function(xhr) {
            Swal.fire({
              title: 'Error',
              text: 'No se pudo desactivar el cliente',
              icon: 'error'
            });
          });
        }
      });
    }
  </script>

</x-app-layout>