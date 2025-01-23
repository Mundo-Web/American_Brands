<style>
  .jquery-modal.blocker.current {
    z-index: 30;
  }
</style>
<div id="cart-modal"
  class="bag !fixed top-0 right-0 md:w-[450px] cartContainer border shadow-2xl !rounded-l-2xl !rounded-r-none !p-0 !z-30"
  style="display: none">
  <div class="p-4 flex flex-col h-screen justify-between gap-2">
    <div class="flex flex-col">
      <div class="flex justify-between ">
        <h2 class="font-medium text-[28px] text-[#151515] pb-5">Carrito xD</h2>
        <div id="close-cart" class="cursor-pointer">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-6 h-6">
            <path stroke="#272727" stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
          </svg>
        </div>
      </div>
      <div class="overflow-y-scroll h-[calc(100vh-200px)] scroll__carrito">
        <table class="w-full">
          <tbody id="itemsCarrito">
            {{-- <div class="flex flex-col gap-10 align-top" id="itemsCarrito"></div> --}}
          </tbody>
        </table>
      </div>
    </div>
    <div class="font-poppins flex flex-col gap-2 pt-2">
      <div class="text-[#141718] font-medium text-[20px] flex justify-between items-center">
        <p>Total</p>
        <p id="itemsTotal">S/ 0.00</p>
      </div>
      <div>
        <a href="/carrito"
          class="font-semibold text-base bg-[#006BF6] py-3 px-5 rounded-2xl text-white cursor-pointer w-full inline-block text-center">Checkout</a>
      </div>
    </div>
  </div>
</div>

<script>
  const getTotalPrice = () => {
    const carrito = Local.get('carrito') ?? []
    const productPrice = carrito.reduce((total, x) => {
      let price = Number(x.precio) * x.cantidad
      if (Number(x.descuento)) {
        price = Number(x.descuento) * x.cantidad
      }
      total += price
      return total
    }, 0)
    return productPrice
  }

  const getCostoEnvio = () => {
    if ($('[name="envio"]:checked').val() == 'recojo') return 0
    const priceStr = $('#distrito_id option:selected').attr('data-price')
    const price = Number(priceStr) || 0
    return price
  }

  function calcularTotal() {
    const precioProductos = getTotalPrice()
    $('#itemSubtotal').text(`S/. ${precioProductos.toFixed(2)}`)
    const precioEnvio = getCostoEnvio()
    const total = precioProductos + precioEnvio

    $('#itemTotal').text(`S/. ${total.toFixed(2)} `)
    $('#itemsTotal').text(`S/. ${total.toFixed(2)} `)
  }

  function mostrarTotalItems() {
    let articulos = Local.get('carrito') ?? []
    let contarArticulos = articulos.reduce((total, articulo) => {
      return total + articulo.cantidad;
    }, 0);

    $('#itemsCount').text(contarArticulos)
  }

  function PintarCarrito() {
    const articulosCarrito = (Local.get('carrito') ?? []).filter(x => x.cantidad > 0);
    let itemsCarrito = $('[id="itemsCarrito"]')
    let itemsCarritoCheck = $('[id="itemsCarritoCheck"]')

    Local.set('carrito', articulosCarrito);

    articulosCarrito.forEach(element => {
      let plantilla = `<tr class=" font-poppins border-b">
          <td class="p-2">
            <img src="/${element.imagen}" class="block bg-[#F3F5F7] rounded-md p-0" alt="producto" style="width: 100px; height: 75px; object-fit: contain; object-position: center;" />
          </td>
          <td class="p-2">
            <p class="font-semibold text-[14px] text-[#151515] mb-1">
              ${element.producto}
            </p>
            <div class="flex w-20 justify-center text-[#151515] border-[1px] border-[#6C7275] rounded-md">
              <button type="button" onClick="(deleteOnCarBtn(${element.id}, '-'))" class="w-6 h-6 flex justify-center items-center ">
                <span  class="text-[20px]">-</span>
              </button>
              <div class="w-6 h-6 flex justify-center items-center">
                <span  class="font-semibold text-[12px]">${element.cantidad}</span>
              </div>
              <button type="button" onClick="(addOnCarBtn(${element.id}, '+'))" class="w-6 h-6 flex justify-center items-center ">
                <span class="text-[20px]">+</span>
              </button>
            </div>
          </td>
          <td class="p-2 text-end">
            <p class="font-semibold text-[14px] text-[#151515] w-max">
              S/${Number(element.descuento) !== 0 ? element.descuento : element.precio}
            </p>
            <button type="button" onClick="(deleteItem(${element.id}))" class="w-6 h-6 flex justify-center items-center mx-auto">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#272727" class="w-6 h-6">
                <path stroke="#272727" stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
              </svg>
            </button>

          </td>
        </tr>`

      itemsCarrito.append(plantilla)
      itemsCarritoCheck.append(plantilla)

    });

    mostrarTotalItems()
    calcularTotal()
  }
  PintarCarrito()
</script>
