<x-app-layout>
  <link href="/js/dxdatagrid/css/dx.light.css?v=06d3ebc8-645c-4d80-a600-c9652743c425" rel="stylesheet" type="text/css"
    id="dg-default-stylesheet" />
  <script src="/js/dxdatagrid/js/dx.all.js"></script>
  <script src="/js/dxdatagrid/js/localization/dx.messages.es.js"></script>
  <script src="/js/moment/min/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

  <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <div
      class="col-span-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">

      <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100 text-2xl tracking-tight">Clientes</h2>
        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Gestión de usuarios registrados como clientes</p>
      </header>
      
      <div class="p-3">
        <div class="overflow-x-auto">
          <div id="gridContainer"></div>
        </div>
      </div>
    </div>

  </div>

</x-app-layout>

<script>
  const clientsDataGrid = $('#gridContainer').dxDataGrid({
    language: "es",
    dataSource: {
      load: async (params) => {
        const res = await fetch("/api/clients/paginate", {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'XSRF-TOKEN': decodeURIComponent(Cookies.get('XSRF-TOKEN'))
          },
          body: JSON.stringify({
            _token: $('[name="_token"]').val(),
            ...params
          })
        })
        const data = await res.json()
        return data
      },
    },
    onToolbarPreparing: (e) => {
      const items = e.toolbarOptions.items;
      items.unshift({
        widget: 'dxButton',
        location: 'after',
        options: {
          icon: 'revert',
          hint: 'REFRESCAR TABLA',
          onClick: () => {
            clientsDataGrid.refresh()
          }
        }
      });
    },
    remoteOperations: true,
    columnResizingMode: "widget",
    allowColumnResizing: true,
    allowColumnReordering: true,
    columnAutoWidth: true,
    scrollbars: 'auto',
    searchPanel: {
      visible: true
    },
    rowAlternationEnabled: true,
    showBorders: true,
    paging: {
      pageSize: 10,
    },
    pager: {
      visible: true,
      allowedPageSizes: [5, 10, 25, 50, 100],
      showPageSizeSelector: true,
      showInfo: true,
      showNavigationButtons: true,
    },
    allowFiltering: true,
    scrolling: {
      mode: 'standard',
      useNative: true,
      preloadEnabled: true,
      rowRenderingMode: 'standard'
    },
    columns: [
      {
        dataField: 'name',
        caption: 'NOMBRE',
        width: '25%',
        cellTemplate: (container, { data }) => {
          const profilePhoto = data.profile_photo_url || '/images/default-avatar.png';
          const userDetail = data.direccion && data.direccion.length > 0 ? data.direccion[0] : null;
          const phone = userDetail ? userDetail.phone : '';
          container.html(
            `<div class="flex items-center gap-3">
              <img class="w-10 h-10 rounded-full object-cover" src="${profilePhoto}" alt="${data.name}" onerror="this.src='/images/default-avatar.png'">
              <div>
                <div class="font-medium text-slate-800 dark:text-slate-100">${data.name} ${data.lastname || ''}</div>
                <div class="text-sm text-slate-500">${phone ? 'Tel: ' + phone : 'Sin teléfono'}</div>
              </div>
            </div>`
          )
        }
      },
      {
        dataField: 'email',
        caption: 'EMAIL',
        width: '25%'
      },
      {
        caption: 'UBICACIÓN',
        width: '20%',
        cellTemplate: (container, { data }) => {
          const userDetail = data.direccion && data.direccion.length > 0 ? data.direccion[0] : null;
          let locationText = 'Sin ubicación';
          
          if (userDetail) {
            const department = userDetail.department ? userDetail.department.description : '';
            const province = userDetail.province ? userDetail.province.description : '';
            const district = userDetail.district ? userDetail.district.description : '';
            
            if (department || province || district) {
              locationText = [district, province, department].filter(Boolean).join(', ');
            }
          }
          
          container.html(
            `<div class="text-sm">
              <div class="text-slate-800 dark:text-slate-100">${locationText}</div>
            </div>`
          )
        }
      },
      
      {
        dataField: 'created_at',
        caption: 'FECHA REGISTRO',
        dataType: 'datetime',
        format: 'yyyy-MM-dd HH:mm:ss',
     
      },
      {
        caption: 'ACCIONES',
        width: '180px',
        cellTemplate: (container, { data }) => {
          container.addClass('!px-3 !py-2 !text-center')
          container.css('vertical-align', 'middle')
          container.html(`
            <a href="/admin/clientes/${data.id}" 
               class="inline-block bg-blue-500 hover:bg-blue-600 px-3 py-2 rounded text-white mr-2 tippy-here" 
               title="Ver detalles del cliente">
              <i class="fas fa-eye"></i>
            </a>
         
          `)
        }
      }
    ],
    onContentReady: (...props) => {
      tippy('.tippy-here', {
        arrow: true,
        animation: 'scale'
      })
    }
  }).dxDataGrid('instance')

  // Manejar eliminación de clientes
  $(document).on("click", ".btn_delete", function(e) {
    e.preventDefault()

    let id = $(this).attr('data-idService');

    Swal.fire({
      title: "¿Seguro que deseas eliminar este cliente?",
      text: "Esta acción desactivará la cuenta del cliente",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminar!",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `{{ route('clientes.borrar') }}`,
          method: 'POST',
          data: {
            _token: $('input[name="_token"]').val(),
            id: id,
          }
        }).done(function(res) {
          Swal.fire({
            title: res.message,
            icon: "success"
          });
          clientsDataGrid.refresh();
        }).fail(function(xhr) {
          Swal.fire({
            title: "Error",
            text: "No se pudo eliminar el cliente",
            icon: "error"
          });
        });
      }
    });
  });
</script>