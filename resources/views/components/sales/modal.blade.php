@php
  $isAdmin = isset($isAdmin) ? 1 : 0;
  $statuses = isset($statuses) ? $statuses : [];
@endphp

<div id="invoice-modal" class="modal !max-w-[820px] relative">
  @csrf
  <input type="hidden" id="invoice-id" value="">
  <div class="relative md:absolute border rounded-lg right-8 top-6 py-2 px-3 mb-2 text-center">
    <b class="block" id="address-tipo-comprobante"></b>
    <b class="block" id="n_document"></b>
    <h4 class="h4 mb-1">S/. <span id="invoice-price"></span></h4>
    {{--  <span id="invoice-address-price"
      class="w-max block mx-auto text-xs font-medium px-2.5 py-0.5 mb-1 rounded-full"></span> --}}
  </div>
  <h4 class="h4 mb-2 mt-2">Orden #<span id="invoice-code"></span></h4>
  <p id="invoice-client" class="mb-2 font-bold"></p>
  <div class="flex flex-row gap-2"><span>Email: </span><p id="email-client"></p></div>
  <div class="flex flex-row gap-2"><span>Dni/Ruc: </span><p id="dni-client" class=""></p></div>
  <div class="flex flex-row gap-2"><span>Telefono: </span><p id="phone-client" class=""></p></div>
  <div class="flex flex-row gap-2"><span>Direccion Envio:</span>
  <p id="invoice-address" class="text-gray-700 mb-2"></p></div>

  <div id="seccioncomprobante" class="flex flex-col gap-2">
    <p class="font-bold"> Datos Facturacion: </p>
    <p id="razonsocial">
      <span>Nombre / Razon Social: </span>
      <span id="razonS"></span>
    </p>
    <p id="direccion" class="mb-2">
      <span> Direccion Fiscal:</span>
      <span id="dirFact"></span>
    </p>
  </div>

  @if ($isAdmin)
    <div class="mb-2 flex gap-2 items-center">
      <span>Estado:</span>
      <select name="status_id" id="invoice-status-id" class="rounded-md px-3 py-1">
        @foreach ($statuses as $status)
          <option value="{{ $status->id }}">{{ $status->name }}</option>
        @endforeach
      </select>
    </div>
  @else
    <p class="mb-2">Estado: <span id="invoice-status" class="font-bold"></span></p>
  @endif

  <div class="flex gap-4">
    <label class="inline-flex items-center cursor-pointer"
      @if (!$isAdmin) title="Marca si recibiste los productos correctamente" tippy @endif>
      <input id="confirmation_client" name="invoice-confirmation" type="checkbox" value="client" class="sr-only peer"
        @if ($isAdmin) disabled @endif>
      <div
        class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
      </div>
      <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
        @if (!$isAdmin)
          Marcar conformidad
        @else
          Conformidad del cliente
        @endif
      </span>
    </label>
    <label class="inline-flex items-center cursor-pointer"
      @if (!$isAdmin) title="Se marca cuando el vendedor indica que entrego los productos al cliente" tippy @endif>
      <input id="confirmation_user" name="invoice-confirmation" type="checkbox" value="user" class="sr-only peer"
        @if (!$isAdmin) disabled @endif>
      <div
        class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
      </div>
      <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
        @if (!$isAdmin)
          Productos entregados
        @else
          Marcar como entregado
        @endif
      </span>
    </label>
  </div>
  <hr class="my-4">

  <div class="relative overflow-x-auto mb-4">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr class="border-b">
          <th scope="col" class="px-6 py-3">
            Producto
          </th>
          <th scope="col" class="px-6 py-3">
            P. Unit.
          </th>
          <th scope="col" class="px-6 py-3">
            Cant.
          </th>
          <th scope="col" class="px-6 py-3">
            P. total
          </th>
        </tr>
      </thead>
      <tbody id="invoice-products">
      </tbody>
    </table>
  </div>
</div>

<script>
  const isAdmin = {{ $isAdmin }};
  const openSaleModal = (data) => {
    const isFree = !Boolean(Number(data.address_price))
    const envio = data.address_price
    const idcupon = data.idcupon
    const montocupon = data.cupon_monto ?? 0
    const nombrecupon = data.cupon?.codigo ?? "sin cupon"
    

    $('#invoice-id').val(data.id)
    $('#address-tipo-comprobante').text(data.tipo_comprobante.toUpperCase())
    $('#n_document').text(data.doc_number)


      if (!data.razon_fact && !data.direccion_fact) {
          $('#seccioncomprobante').hide();
      } else { 
          $('#seccioncomprobante').show();

      if (data.razon_fact) {
          $('#razonS').text(data.razon_fact);
          $('#razonsocial').show(); 
      } else {
          $('#razonsocial').hide(); 
      }

      if (data.direccion_fact) {
          $('#dirFact').text(data.direccion_fact);
          $('#direccion').show(); 
      } else {
          $('#direccion').hide(); 
      }
    }


    let totalInvoice = Number(data.total) + Number(envio)
    $('#invoice-price').text(totalInvoice)
    /* $('#invoice-address-price').text(isFree ? 'Envio gratis' :
      `S/. ${Number(data.address_price).toFixed(2)}`) */
    if (isFree) $('#invoice-address-price')
      .addClass('bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300')
      .removeClass('bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300')
    else $('#invoice-address-price')
      .addClass('bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300')
      .removeClass('bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300')
    $('#invoice-code').text(data.code)
    $('#invoice-client').text(`${data.name} ${data.lastname}`)
    $('#email-client').text(`${data.email}`)
    $('#dni-client').text(`${data.doc_number}`)
    $('#phone-client').text(`${data.phone}`)
    $('#invoice-address').text(data.address_description ?
      `${data.address_department}, ${data.address_province}, ${data.address_district} - ${data.address_street} #${data.address_number}` :
      'Recojo en tienda')

    $('#invoice-status-id').val(data.status?.id ?? null)
    $('#invoice-status').text(data.status?.name ?? 'Sin estado')
    $('#confirmation_client').prop('checked', data.confirmation_client)
    $('#confirmation_user').prop('checked', data.confirmation_user)

    $('#invoice-products').html(`<tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
      <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
        <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-full"></div>
      </th>
      <td class="px-6 py-4">
        <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-8"></div>
      </td>
      <td class="px-6 py-4">
        <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-4"></div>
      </td>
      <td class="px-6 py-4">
        <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-8"></div>
      </td>
    </tr>`)
    fetch(`/api/saledetails/${data.id}`)
      .then(res => res.json())
      .then(data => {
        $('#invoice-products').empty()
        if (data.length == 0) {
          $('#invoice-products').html(`<tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <th colspan="4" scope="row" class="px-6 py-4 font-normal whitespace-nowrap dark:text-white text-center">
              <i class="text-gray-500">- No hay productos -</i>
            </th>
          </tr>`)
          return
        }
        data.forEach(item => {
          const shouldStrikePrice = (item.price * item.quantity) > item.final_price;
          const unitPrice = Number(item.final_price / item.quantity).toFixed(2);
          const discountPercentage = shouldStrikePrice
          ? ((1 - (item.final_price / (item.price * item.quantity))) * 100).toFixed(2)
          : null;

          $('#invoice-products').append(`
                <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        ${item.product_name} <br>
                        <span class="text-xs font-bold">
                          COLOR: <span class="text-xs font-normal">${item.product_color}</span><br> 
                          TALLA: <span class="text-xs font-normal">${item.talla}</span><br>
                          MARCA: <span class="text-xs font-normal">${item.marca ? item.marca : "Sin Marca"}</span>
                        </span>
                    </th>
                    <td class="px-6 py-2">
                        ${shouldStrikePrice
                            ? `<s class="text-xs">S/. ${Number(item.price).toFixed(2)}</s><br>S/. ${unitPrice}<br> 
                              <span class="text-green-500 text-xs text-red-500">(${discountPercentage}% dcto)</span>`
                            : `S/. ${Number(item.price).toFixed(2)}`
                        }
                    </td>
                    <td class="px-6 py-2">
                        ${item.quantity}
                    </td>
                    <td class="px-6 py-2">
                        S/. ${Number(item.final_price).toFixed(2)}
                    </td>
                </tr>
            `)
        });

        if (montocupon > 0) {
            $('#invoice-products').append(`
                <tr class="bg-white text-red-600 border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="text-red-600 px-6 py-4 font-medium  whitespace-nowrap dark:text-white">
                        Cupón (${nombrecupon}) <i class="fa-solid fa-ticket"></i>
                    </th>
                    <td class="px-6 py-4">
                        - S/. ${montocupon}
                    </td>
                    <td class="px-6 py-4">
                        1
                    </td>
                    <td class="px-6 py-4">
                        - S/. ${montocupon}
                    </td>
                </tr>
            `);
        }

        $('#invoice-products').append(`<tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              Envio 
            </th>
            <td class="px-6 py-4">
              S/. ${envio}
            </td>
            <td class="px-6 py-4">
              1
            </td>
            <td class="px-6 py-4">
              S/. ${envio}
            </td>
          </tr>`)
          
      })

    $('#invoice-modal').modal('show')
  }

  $('[name="invoice-confirmation"]').on('click', async function(e) {
    const checked = $(this).prop('checked')
    const id = $('#invoice-id').val()
    const field = $(this).val()
    if (!checked) return e.preventDefault()
    const {
      isConfirmed
    } = await Swal.fire({
      title: "Seguro?",
      text: field == 'client' ? 'Marcalo cuando hayas recibido los productos' :
        'Marcalo cuando hayas entregado los productos al cliente',
      icon: "warning",
      confirmButtonText: "Si, marcar"
    })
    if (!isConfirmed) return $(this).prop('checked', false)

    const res = await fetch("{{ route('sales.confirmation') }}", {
      method: 'POST',
      headers: {
        'Content-type': 'application/json',
        'XSRF-TOKEN': decodeURIComponent(Cookies.get('XSRF-TOKEN'))
      },
      body: JSON.stringify({
        _token: $('[name="_token"]').val(),
        id,
        field
      })
    })

    if (!res.ok) return $(this).prop('checked', false)
    if (field == 'client') $('#confirmation_user').prop('checked', true)
    salesDataGrid.refresh()
  })

  $('#invoice-status-id').on('change', function() {
    const id = $('#invoice-id').val()
    const status_id = this.value
    fetch("{{ route('sales.status') }}", {
      method: 'PATCH',
      headers: {
        'Content-type': 'application/json',
        'XSRF-TOKEN': decodeURIComponent(Cookies.get('XSRF-TOKEN'))
      },
      body: JSON.stringify({
        _token: $('[name="_token"]').val(),
        id,
        status_id
      })
    }).then(res => {
      if (!res.ok) return
      salesDataGrid.refresh()
    })
  })
</script>
