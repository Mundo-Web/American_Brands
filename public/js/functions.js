const checkbox = document.getElementById("check");
const bag = document.querySelector(".bag");
const bodyModalCarrito = document.querySelector(".body");
let isMenuOpen = false; // Variable para controlar el estado del menú
const card = document.querySelector(".cartContainer");
// checkbox.addEventListener("click", checkboxOnClick);

// Agregar event listener al checkbox para controlar el estado del menú
// function checkboxOnClick() {
//   // Cambiar el top del carrito
//   const scrollTopPosition = window.scrollY;
//   card.style.top = scrollTopPosition + "px";

//   isMenuOpen = checkbox.checked;
//   if (isMenuOpen) {
//     bodyModalCarrito.classList.add("dark");
//     bodyModalCarrito.classList.add("overflow-hidden");
//     // Agregar el event listener al documento cuando se abre el menú
//     document.addEventListener("click", handleDocumentClick);
//   } else {
//     bodyModalCarrito.classList.remove("dark");
//     bodyModalCarrito.classList.remove("overflow-hidden");
//     // Quitar el event listener del documento cuando se cierra el menú
//     document.removeEventListener("click", handleDocumentClick);
//   }
// }

// // Función para manejar el clic en el documento
// function handleDocumentClick(event) {
//   // Verificar si el menú está abierto y si el clic no ocurrió dentro del nav ni en el checkbox
//   if (isMenuOpen && !bag.contains(event.target) && event.target !== checkbox) {
//     bag.classList.add("hidden"); // Ocultar el nav
//     checkbox.checked = false; // Desmarcar el checkbox
//     bodyModalCarrito.classList.remove("dark");
//     bodyModalCarrito.classList.remove("overflow-hidden");
//     isMenuOpen = false; // Actualizar el estado del menú
//     // Quitar el event listener del documento después de cerrar el menú
//     document.removeEventListener("click", handleDocumentClick);
//   }
// }

// Detener la propagación de clics dentro del nav para evitar cerrarlo al hacer clic dentro
if (bag) {
  bag.addEventListener("click", function (event) {
    event.stopPropagation(); // Evitar que el clic se propague al documento
  });
}





function show() {
  document.querySelector(".hamburger").classList.toggle("open");
  document.querySelector(".navigation").classList.toggle("active");
}


/* --------------------------- CARROUSEL ---------------------------- */
var carrouselTestimonios = new Swiper(".myTestimonios", {
  slidesPerView: 4, //3
  spaceBetween: 25,
  loop: true,
  grabCursor: true,
  centeredSlides: true,
  initialSlide: 0,
  pagination: {
    el: ".swiper-pagination-testimonios",
    clickable: true,
    /* dynamicBullets: true, */
  },
  autoplay: {
    delay: 1500,
    disableOnInteraction: false,
  },

  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 2,
    },
    1024: {
      slidesPerView: 4,
    },
  },
});

/* ------------------------------------------------------------------ */

var carrouselBeneficios = new Swiper(".myBeneficios", {
  slidesPerView: 1,
  spaceBetween: 30,
  loop: true,
  grab: false,
  centeredSlides: false,
  initialSlide: 0, // Empieza en el cuarto slide (índice 3)
  pagination: {
    el: ".swiper-pagination-beneficios",
    clickable: true,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
  },
});

/* ------------------------------------------- */

var carrouselCategorias = new Swiper(".categorias", {
  slidesPerView: 1,
  spaceBetween: 30,
  loop: false,
  grab: false,
  centeredSlides: true,
  initialSlide: 0, // Empieza en el cuarto slide (índice 3)
  pagination: {
    el: ".swiper-pagination-categorias",
    clickable: true,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
  },
});

/* --------------------------------------------- */

var carrosuelDestacados = new Swiper('.productos-home', {
  slidesPerView: 2,
  spaceBetween: 20,
  loop: true,
  grab: false,

  centeredSlides: false,
  initialSlide: 0, // Empieza en el cuarto slide (índice 3)
  // pagination: {
  //   el: '.swiper-pagination-productos-home',
  //   clickable: true,
  // },
  navigation: {
    nextEl: '.swiper-button-next-productos-home',
    prevEl: '.swiper-button-prev-productos-home',
  },
  scrollbar: {
    el: '.swiper-scrollbar-productos-home',
  },
  breakpoints: {
    512: {
      slidesPerView: 2
    },
    640: {
      slidesPerView: 3
    },
    768: {
      slidesPerView: 4
    },
    1024: {
      slidesPerView: 5
    },
    1280: {
      slidesPerView: 6
    },
  },
});

new Swiper('.categories-header', {
  slidesPerView: 1,
  spaceBetween: 10,
  loop: true,
  grab: false,

  centeredSlides: false,
  initialSlide: 0, // Empieza en el cuarto slide (índice 3)
  // pagination: {
  //   el: '.swiper-pagination-categories-header',
  //   clickable: true,
  // },
  navigation: {
    nextEl: '.swiper-button-next-categories-header',
    prevEl: '.swiper-button-prev-categories-header',
  },
  scrollbar: {
    el: '.swiper-scrollbar-categories-header',
  },
  breakpoints: {
    512: {
      slidesPerView: 1
    },
    768: {
      slidesPerView: 2
    },
    1024: {
      slidesPerView: 3
    },
    1280: {
      slidesPerView: 4
    },
  },
});

/* --------------------------------------------- */

var carrouselOferta = new Swiper(".productos-oferta", {
  slidesPerView: 4,
  spaceBetween: 10,
  loop: true,
  grab: false,
  centeredSlides: false,
  initialSlide: 0, // Empieza en el cuarto slide (índice 3)
  pagination: {
    el: ".swiper-pagination-productos-oferta",
    clickable: true,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 2,
    },
    1024: {
      slidesPerView: 4,
    },
  },
});

/* --------------------------------------------- */

var carrosuelComplementario = new Swiper(".productos-complementarios", {
  slidesPerView: 4,
  spaceBetween: 10,
  loop: true,
  grab: false,
  centeredSlides: false,
  initialSlide: 0, // Empieza en el cuarto slide (índice 3)

  pagination: {
    el: ".swiper-pagination-producto-complementario",
    clickable: true,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 2,
    },
    1024: {
      slidesPerView: 4,
    },
  },
});

/* --------------------------------------------- */


/* ------------------------------------------ */

var carrosuelProductoSlider = new Swiper(".producto-slider", {
  slidesPerView: 1,
  spaceBetween: 10,
  loop: true,
  grab: true,
  centeredSlides: false,
  initialSlide: 0, // Empieza en el cuarto slide (índice 3)
  pagination: {
    el: ".swiper-pagination-productos",
    clickable: true,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
  },
});

/* ------------------------------------------ */

var CarrosuelCatalogo = new Swiper(".producto-catalogo", {
  slidesPerView: 1,
  spaceBetween: 10,
  loop: true,
  grab: true,
  centeredSlides: false,
  initialSlide: 0, // Empieza en el cuarto slide (índice 3)
  pagination: {
    el: ".swiper-pagination-producto-catalogo",
    clickable: true,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
  },
});



var input = document.querySelector(".input-box");

(input ?? {}).onclick = function () {
  this.classList.toggle("open");
  let list = this.nextElementSibling;
  if (list.style.maxHeight) {
    list.style.maxHeight = null;
    list.style.boxShadow = null;
  } else {
    list.style.maxHeight = list.scrollHeight + "px";
    list.style.boxShadow =
      "0 1px 2px 0 rgba(0, 0, 0, 0.15),0 1px 3px 1px rgba(0, 0, 0, 0.1)";
  }
};

var rad = document.querySelectorAll(".radio");
rad.forEach((item) => {
  item.addEventListener("change", () => {
    input.innerHTML = item.nextElementSibling.innerHTML;
    input.click();
  });
});




var inputDistrito = document.querySelector(".input-box-distrito");
(inputDistrito ?? {}).onclick = function () {
  this.classList.toggle("open-distrito");
  let listDistrito = this.nextElementSibling;
  if (listDistrito.style.maxHeight) {
    listDistrito.style.maxHeight = null;
    listDistrito.style.boxShadow = null;
  } else {
    listDistrito.style.maxHeight = listDistrito.scrollHeight + "px";
    listDistrito.style.boxShadow =
      "0 1px 2px 0 rgba(0, 0, 0, 0.15),0 1px 3px 1px rgba(0, 0, 0, 0.1)";
  }
};

var radDistrito = document.querySelectorAll(".radio-distrito");
radDistrito.forEach((item) => {
  item.addEventListener("change", () => {
    inputDistrito.innerHTML = item.nextElementSibling.innerHTML;
    inputDistrito.click();
  });
});




var inputProvincia = document.querySelector(".input-box-provincia");
(inputProvincia ?? {}).onclick = function () {
  this.classList.toggle("open-provincia");
  let listProvincia = this.nextElementSibling;
  if (listProvincia.style.maxHeight) {
    listProvincia.style.maxHeight = null;
    listProvincia.style.boxShadow = null;
  } else {
    listProvincia.style.maxHeight = listProvincia.scrollHeight + "px";
    listProvincia.style.boxShadow =
      "0 1px 2px 0 rgba(0, 0, 0, 0.15),0 1px 3px 1px rgba(0, 0, 0, 0.1)";
  }
};

var radProvincia = document.querySelectorAll(".radio-provincia");
radProvincia.forEach((item) => {
  item.addEventListener("change", () => {
    inputProvincia.innerHTML = item.nextElementSibling.innerHTML;
    inputProvincia.click();
  });
});






var input = document.querySelector(".input-box");

(input ?? {}).onclick = function () {

  this.classList.toggle("open");
  let list = this.nextElementSibling;
  if (list.style.maxHeight) {
    list.style.maxHeight = null;
    list.style.boxShadow = null;
  } else {
    list.style.maxHeight = list.scrollHeight + "px";
    list.style.boxShadow =
      "0 1px 2px 0 rgba(0, 0, 0, 0.15),0 1px 3px 1px rgba(0, 0, 0, 0.1)";
  }
};

var rad = document.querySelectorAll(".radio");
rad.forEach((item) => {
  item.addEventListener("change", () => {

    input.innerHTML = item.nextElementSibling.innerHTML;
    input.click();
  });
});



const cuentas = document.querySelectorAll(".cuentas");
const depositoCuenta = document.querySelector(".deposito__cuenta");
const radioInputTarjeta = document.querySelector(".inputVoucher");
cuentas.forEach((cuenta) => {
  cuenta.addEventListener("click", (e) => {
    if (e.target.classList.contains("inputVoucher")) {
      depositoCuenta.classList.remove("hidden");
    } else {
      depositoCuenta.classList.add("hidden");
    }
  });
});

Math.sum = function (...items) {
  let total = 0
  items.filter(Number).forEach(x => {
    total += Number(x)
  })
  return total
}

const Number2Currency = (number, currency = 'en-US') => {
  return (Number(number) || 0)
    .toLocaleString(currency, {
      maximumFractionDigits: 2,
      minimumFractionDigits: 2
    })
}

function generateDiscountArray(quantity, take, pay) {
  const result = new Array(quantity).fill(0)
  let remainingPay = pay
  let currentTake = 0

  for (let i = 0; i < quantity; i++) {
    if (currentTake == take) {
      currentTake = 0
      remainingPay = pay
    }

    if (remainingPay >= 1) {
      result[i] = 1
      remainingPay -= 1
    } else if (remainingPay > 0) {
      result[i] = remainingPay
      remainingPay = 0
    }
    currentTake++
  }

  return result.sort((a, b) => b - a)
}

function PintarCarrito() {

  let itemsCarrito = $('#itemsCarrito')
  let itemsCarritoCheck = $('#itemsCarritoCheck')

  itemsCarrito.empty()
  itemsCarritoCheck.empty()

  const carrito = Local.get('carrito') ?? [];
  const cupon = Local.get('cupon') ?? []
  const login = Local.get('autenticado') ?? []
  const carritoDescuentoMismoProducto = []
  const carritoDescuentoDistintoProducto = []
  const carritoSinDescuento = [];

  const carritoPorProcesar = [];

  const descuentosPorProcesar = [];

  for (const item of carrito) {
    if (!item.discount_id) {
      carritoSinDescuento.push(item)
      continue
    }
    const cantidadAgrupar = item.cantidad % item.discount.take_product

    const cantidadSinAgrupar = item.cantidad - cantidadAgrupar

    if (cantidadSinAgrupar != 0) carritoDescuentoMismoProducto.push({ ...item, cantidad: cantidadSinAgrupar })
    if (item.cantidad - cantidadSinAgrupar != 0) {
      if (!descuentosPorProcesar.find(x => x.id == item.discount_id)) descuentosPorProcesar.push(item.discount)
      const suelto = item.cantidad - cantidadSinAgrupar
      carritoPorProcesar.push({
        ...item,
        cantidad: suelto,
      })
    }
  }

  // Procesando distintos productos
  for (const discount of descuentosPorProcesar) {
    // Filtra productos que tienen el mismo descuento y los ordena por el precio
    const products = carritoPorProcesar
      .filter(item => item.discount_id == discount.id)
      .sort((a, b) => b.precio - a.precio)
    const totalByDiscount = Math.sum(...products.map(x => x.cantidad)); // total de productos con un mismo descuento
    if (totalByDiscount >= discount.take_product) {
      const modulo = totalByDiscount % discount.take_product
      const descuentoDistintoProducto = [] // productos que forman parte de un descuento
      let cuota = totalByDiscount - modulo // total de producto
      for (const item of products) {
        const cantidadPorProducto = cuota >= item.cantidad ? item.cantidad : item.cantidad - cuota;
        if (cuota >= item.cantidad) {
          descuentoDistintoProducto.push({ ...item, cantidad: cantidadPorProducto })
        } else {
          descuentoDistintoProducto.push({ ...item, cantidad: cuota })
          carritoSinDescuento.push({ ...item, cantidad: cantidadPorProducto, discount: null })
        }
        cuota -= cantidadPorProducto
      }
      carritoDescuentoDistintoProducto.push(descuentoDistintoProducto)
    } else {
      carritoSinDescuento.push(...(products.map(x => ({ ...x, discount: null }))))
    }
  }

  const carritoFinal = [
    ...carritoDescuentoMismoProducto.map(x => ([x])),
    ...carritoDescuentoDistintoProducto,
    ...carritoSinDescuento.map(x => ([x]))
  ];

  const carritoParaPintar = [];

  for (const group of carritoFinal) {
    let cuota = Number(group[0].discount?.take_product ?? 0)
    const payment = Number(group[0].discount?.payment_product ?? 0)
    const cantidadTotal = Math.sum(...group.map(x => x.cantidad))
    let discountArray = generateDiscountArray(cantidadTotal, cuota, payment)
    let iterator = 0

    for (const index in group) {
      const item = group[index]

      let finalPrice = Math.min(...[Number(item.precio), Number(item.descuento)].filter(Boolean));
      let totalPrice = finalPrice * item.cantidad

      if (item.discount) {
        if (item.discount.type_id == 1) {
          if (item.discount.apply_to == 'self') {
            finalPrice = (item.precio * item.discount.payment_product) / item.discount.take_product
            totalPrice = finalPrice * item.cantidad
          } else if (item.discount.apply_to == 'lower') {
            finalPrice = 0
            totalPrice = 0
            for (let index = 0; index < item.cantidad; index++) {
              const cobrar = discountArray[iterator]
              finalPrice += item.precio * cobrar / item.cantidad
              totalPrice += item.precio * cobrar
              iterator++
            }
          }
        } else {
          finalPrice = (item.precio * payment) / 100
          totalPrice = finalPrice * item.cantidad
        }
      }

      cuota -= item.cantidad

      const found = carritoParaPintar.findIndex(x => x.id == item.id)
      if (found == -1) {
        carritoParaPintar.push({
          ...item,
          finalPrice,
          totalPrice
        })
      } else {
        carritoParaPintar[found].cantidad += item.cantidad
        carritoParaPintar[found].totalPrice += totalPrice
      }
    }
  }

  let descuento = 0;
  let isPorcentaje = 0;
  let descuentofinal = 0;
  let logueado = false;
  let total = 0;


  if (cupon && typeof cupon === 'object') {
    descuento = cupon.montof ?? 0;
    isPorcentaje = cupon.porcentaje ?? 0;
    logueado = login.autenticado;
    console.log(logueado);
    if (isPorcentaje) {
      descuentofinal = descuento / 100;
    } else {
      descuentofinal = descuento;
    }

  }

  carritoParaPintar.forEach(item => {
    total += item.totalPrice
    let plantilla = `<tr class="font-Urbanist_Regular border-b">
          <td class="p-2 w-24">
            <img src="${appUrl}/${item.imagen}" class="block bg-[#F3F5F7] rounded-md p-0 w-24 object-contain" alt="producto" onerror="this.onerror=null;this.src='/images/img/noimagen.jpg';"  style="width: 100px; height: 75px; object-fit: contain; object-position: center;" />
          </td>

          <td class="p-2">
            <div class="flex flex-col mb-1">
              <p class="limited-text font-semibold text-[14px] text-[#151515] line-clamp-1">
                ${item.producto}
              </p>
              <span class="font-light text-[12px] text-[#151515]">${item.color} - ${item.peso}</span>
            </div>
            <div class="flex gap-2 items-center">
              <div class="flex w-15 justify-center text-[#151515] border-[1px] border-[#6C7275] rounded-md">
                <button type="button" onClick="(deleteOnCarBtn(${item.id}, ${item.isCombo}))" class="w-5 h-5 text-[14px]  py-0 flex justify-center items-center ">
                <div><i class="fa-solid fa-minus text-xs"></i></div>
                </button>
                <div class="w-5 h-5 text-[14px] flex justify-center items-center">
                  <span  class="font-semibold text-sm">${item.cantidad}</span>
                </div>
                <button type="button" onClick="(addOnCarBtn(${item.id}, ${item.isCombo}))" class="w-5 h-5 text-[14px] py-0  flex justify-center items-center ">
                  <div><i class="fa-solid fa-plus text-xs"></i></div>
                </button>
              </div>
              <div class="text-[12px] text-[#151515] font-bold">
              <span class="block">S/.${Number2Currency(item.precio)} c/u</span>
              </div>
              
              </div>
              ${item.discount ? `<span class="block text-[#c1272d] text-[12px] mt-1 truncate text-ellipsis">${item.discount.name}</span>` : ''}
          </td>

          <td class="p-2 text-end">
            ${item.precio > item.finalPrice ? `<p class="text-[12px] text-[#acacac] line-through text-nowrap">S/ ${Number2Currency(item.precio * item.cantidad)}</p>` : ''}
            <p class="font-semibold text-[14px] text-[#151515] text-nowrap">
              S/ ${Number2Currency(item.totalPrice)}
            </p>
            <button type="button" onClick="(deleteItem(${item.id} , ${item.isCombo}))" class="h-6 text-xl text-[#272727]">
              <i class="fa fa-trash-alt"></i>
            </button>
          </td>

        </tr>`

    itemsCarrito.append(plantilla)
    itemsCarritoCheck.append(plantilla)
  })

  const costoEnvio = getCostoEnvio()

  $('#itemSubtotal').text(`S/. ${Number2Currency(total)}`)

  if (descuentofinal > 0 && logueado) {
    if (isPorcentaje) {
      $('#itemTotal').text(`S/. ${Number2Currency(total + costoEnvio - descuentofinal * total)} `)
    } else {
      $('#itemTotal').text(`S/. ${Number2Currency(total + costoEnvio - descuentofinal)} `)
    }
  } else {
    $('#itemTotal').text(`S/. ${Number2Currency(total + costoEnvio)} `)
  }

  $('#itemsTotal').text(`S/. ${Number2Currency(total + costoEnvio)} `)

  mostrarTotalItems()
}

const getCostoEnvio = () => {
  const address = Local.get('address') ?? {}
  if (address.envio == 'recoger') return 0
  return Number(address.price ?? 0)
}

function mostrarTotalItems() {
  let articulos = Local.get('carrito')
  let contarArticulos = articulos.reduce((total, articulo) => {
    return total + articulo.cantidad;
  }, 0);

  $('#itemsCount').text(contarArticulos)
}

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

  // $('#itemsTotal').text(`S/. ${suma.toFixed(2)} `)
  // console.log("tofixed  ", suma.toFixed(2))

}

window.addEventListener('storage', (e) => {
  if (e.key === 'carrito') {
    if (typeof articulosCarrito != 'undefined') {
      articulosCarrito = Local.get('carrito') || []
    }
    PintarCarrito(); // Llama a la función para actualizar el carrito
  }
});
