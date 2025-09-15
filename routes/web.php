<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AttributesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\BeneficiosSinInteresesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CampaignController;

use App\Http\Controllers\MessageController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CampanasPublicitariasController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CuponController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\GalerieController;
use App\Http\Controllers\LogosClientController;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LibroReclamacionesController;
use App\Http\Controllers\NewsletterSubscriberController;
use App\Http\Controllers\NuestrasTiendasController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlazosDeReembolsoController;
use App\Http\Controllers\PoliticaDatosController;
use App\Http\Controllers\PoliticasCookiesController;
use App\Http\Controllers\PolyticsConditionController;
use App\Http\Controllers\PopupController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SeguimientoPedidoController;
use App\Http\Controllers\ShortcodeController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\StrengthController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ValoresAtributosController;

use App\Http\Controllers\TagController;
use App\Http\Controllers\TermsAndConditionController;
use App\Http\Controllers\TimeAndPriceDeliveryController;
use App\Http\Controllers\TratamientoAdicionalDatosController;
use App\Models\AboutUs;
use App\Models\Discount;
use App\Models\LibroReclamaciones;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Las rutas publicas */
// Route::get('/login-rev', [AuthController::class, 'loginView'])->name('Login.jsx');
Route::get('/register-rev', [AuthController::class, 'registerView'])->name('Register.jsx');
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/nosotros', [IndexController::class, 'nosotros'])->name('nosotros');
Route::get('/servicios', [IndexController::class, 'servicios'])->name('servicios');
Route::get('/comentario', [IndexController::class, 'comentario'])->name('comentario');
Route::post('/comentario/nuevo', [IndexController::class, 'hacerComentario'])->name('nuevocomentario');
Route::get('/contacto', [IndexController::class, 'contacto'])->name('contacto');
Route::get('/libro-de-reclamaciones', [IndexController::class, 'librodereclamaciones'])->name('librodereclamaciones');
Route::get('/blog/{filtro}', [IndexController::class, 'blog'])->name('blog');
Route::get('/post/{id}', [IndexController::class, 'detalleBlog'])->name('detalleBlog');

/* Proceso de pago */
Route::get('/carrito', [IndexController::class, 'carrito'])->name('carrito');
Route::get('/pago/{code}', [IndexController::class, 'pago'])->name('pago');
Route::post('/agradecimiento', [IndexController::class, 'agradecimiento'])->name('agradecimiento');


Route::post('/procesar/pago', [IndexController::class, 'procesarPago'])->name('procesar.pago');
/* Catálogo y producto */
Route::get('/producto/{slug}', [IndexController::class, 'producto'])->name('producto');
// Route::get('/catalogo', [IndexController::class, 'catalogo'])->name('catalogo.all');
// Route::get('/catalogo/{category}', [IndexController::class, 'catalogo'])->name('catalogo');
// Route::get('/catalogo/{category}/{subcategory}', [IndexController::class, 'catalogo'])->name('catalogo.sub');
Route::post('carrito/buscarProducto', [CarritoController::class, 'buscarProducto'])->name('carrito.buscarProducto');
Route::get('/buscar', [IndexController::class, 'searchProduct'])->name('buscar');
Route::get('/ayuda', [IndexController::class, 'help'])->name('help');
/* Página 404 */
Route::get('/404', [IndexController::class, 'error'])->name('error');
/* Formulario de contacto */
Route::post('guardarContactos', [IndexController::class, 'guardarContacto'])->name('guardarContactos');
Route::post('guardarformulario', [LibroReclamacionesController::class, 'storePublic'])->name('guardarFormReclamo');

Route::get('/obtenerProvincia/{departmentId}', [IndexController::class, 'obtenerProvincia'])->name('obtenerProvincia');
Route::get('/obtenerDistritos/{provinceId}', [IndexController::class, 'obtenerDistritos'])->name('obtenerDistritos');

Route::get('/politicas-de-devolucion', [IndexController::class, 'politicasDevolucion'])->name('politicas_dev');
Route::get('/terminos-y-condiciones', [IndexController::class, 'TerminosyCondiciones'])->name('terms_condition');



Route::get('/buscarblog', [IndexController::class, 'searchBlog'])->name('buscarblog');

Route::post('guardarUserNewsLetter', [NewsletterSubscriberController::class, 'guardarUserNewsLetter'])->name('guardarUserNewsLetter');

Route::get('/confirm-email/{token}', [AuthController::class, 'confirmEmailView'])->name('ConfirmEmail.jsx');
Route::get('/confirmation/{token}', [AuthController::class, 'loginView']);

Route::post('buscarTalla', [IndexController::class, 'buscarTalla'])->name('buscarTalla');


Route::middleware(['auth:sanctum', 'verified', 'can:Admin'])->group(function () {

    Route::prefix('admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('analytics');
        Route::get('/dashboard/fintech', [DashboardController::class, 'fintech'])->name('fintech');

        Route::resource('/politicas-de-devolucion', PolyticsConditionController::class);
        Route::resource('/terminos-y-condiciones', TermsAndConditionController::class);

        Route::resource('/tiempo-y-costos-envio', TimeAndPriceDeliveryController::class);
        Route::resource('/plazos-de-reembolso', PlazosDeReembolsoController::class);
        Route::resource('/tratamiento-adicional-datos', TratamientoAdicionalDatosController::class);
        Route::resource('/politica-cookies', PoliticasCookiesController::class);
        Route::resource('/campanas-publicitarias', CampanasPublicitariasController::class);
        Route::resource('/beneficios-cero-intereses', BeneficiosSinInteresesController::class);
        Route::resource('/seguimiento-de-pedido', SeguimientoPedidoController::class);
        Route::resource('/nuestras-tiendas', NuestrasTiendasController::class);

        Route::resource('/shortcode', ShortcodeController::class);

        Route::resource('/pedidos', SaleController::class);
        Route::resource('/clientes', \App\Http\Controllers\ClientsController::class);
        Route::post('/clientes/borrar', [\App\Http\Controllers\ClientsController::class, 'borrar'])->name('clientes.borrar');

        Route::get('/politica-datos/{id}', [PoliticaDatosController::class, 'edit'])->name('politicadatos.detalle');
        Route::post('/politica-datos/update/{id}', [PoliticaDatosController::class, 'update'])->name('politicadatos.act');

        //messages
        Route::resource('/mensajes', MessageController::class);
        Route::post('/mensajes/borrar', [MessageController::class, 'borrar'])->name('mensajes.borrar');

        //Libro de reclamaciones
        Route::resource('/reclamo', LibroReclamacionesController::class);
        Route::post('/reclamo/borrar', [LibroReclamacionesController::class, 'borrar'])->name('reclamo.borrar');

        //Datos Generales
        Route::resource('/datosgenerales', GeneralController::class);

        //Testimonies
        Route::resource('/testimonios', TestimonyController::class);
        Route::post('/testimonios/deleteTestimony', [TestimonyController::class, 'deleteTestimony'])->name('testimonios.deleteTestimony');
        Route::post('/testimonios/updateVisible', [TestimonyController::class, 'updateVisible'])->name('testimonios.updateVisible');

        //Reglas de descuento
        Route::resource('/reglasDescuentos', DiscountController::class);
        Route::post('/reglasDescuentos/deletereglasDescuentos', [DiscountController::class, 'deletereglasDescuentos'])->name('reglasDescuentos.deletereglasDescuentos');
        Route::post('/reglasDescuentos/updateVisible', [DiscountController::class, 'updateVisible'])->name('reglasDescuentos.updateVisible');

        // Estados
        Route::resource('/estados', StatusController::class);
        Route::delete('/estados/{estado}', [StatusController::class, 'delete'])->name('estados.delete');

        //Categorías
        Route::resource('/categorias', CategoryController::class);
        Route::post('/categorias/deleteCategory', [CategoryController::class, 'deleteCategory'])->name('categorias.deleteCategory');
        Route::post('/categorias/updateVisible', [CategoryController::class, 'updateVisible'])->name('categorias.updateVisible');
        Route::get('/categorias/contarCategorias', [CategoryController::class, 'contarCategoriasDestacadas'])->name('categorias.contarCategoriasDestacadas');

        Route::resource('/subcategories', SubCategoryController::class);
        Route::delete('/subcategories', [SubCategoryController::class, 'delete'])->name('subcategories.delete');
        Route::post('/subcategories', [SubCategoryController::class, 'save'])->name('subcategories.save');
        Route::patch('/subcategories', [SubCategoryController::class, 'update'])->name('subcategories.update');
        Route::get('/subcategories/count', [SubCategoryController::class, 'contarCategoriasDestacadas'])->name('subcategories.count');

        //Precios
        Route::resource('/prices', PriceController::class);
        Route::get('/prices/create', [PriceController::class, 'save'])->name('prices.create');
        Route::get('/prices/update/{priceId}', [PriceController::class, 'save'])->name('prices.update');
        Route::post('/getProvincia', [PriceController::class, 'getProvincias'])->name('prices.getProvincias');
        Route::post('/getDistrito', [PriceController::class, 'getDistrito'])->name('prices.getDistrito');
        Route::post('/calculeEnvio', [PriceController::class, 'calculeEnvio'])->name('prices.calculeEnvio');
        Route::post('/deletePrice', [PriceController::class, 'deletePrice'])->name('prices.deletePrice');
        Route::post('/prices/updateVisible', [PriceController::class, 'updateVisible'])->name('prices.updateVisible');

        //Servicios
        Route::resource('/servicios', ServiceController::class);
        Route::post('/servicios/deleteService', [ServiceController::class, 'deleteService'])->name('servicio.deleteService');
        Route::post('/servicios/updateVisible', [ServiceController::class, 'updateVisible'])->name('servicio.updateVisible');

        //Blog
        Route::resource('/blog', BlogController::class);
        Route::post('/blog/deleteBlog', [BlogController::class, 'deleteBlog'])->name('blog.deleteBlog');
        Route::post('/blog/updateVisible', [BlogController::class, 'updateVisible'])->name('blog.updateVisible');

        //Crud Logos
        Route::resource('/logos', LogosClientController::class);
        Route::post('/logos/deleteLogo', [LogosClientController::class, 'deleteLogo'])->name('logos.deleteLogo');
        Route::post('/logos/updateVisible', [LogosClientController::class, 'updateVisible'])->name('logos.updateVisible');
        Route::get('/logos/contarCategorias', [LogosClientController::class, 'contarCategoriasDestacadas'])->name('logos.contarCategoriasDestacadas');

        //Crud cupones
        Route::resource('/cupones', CuponController::class);
        Route::post('/cupones/updateVisible', [CuponController::class, 'updateVisible'])->name('cupones.updateVisible');

        //Equipo
        Route::resource('/staff', StaffController::class);
        Route::post('/staff/updateVisible', [StaffController::class, 'updateVisible'])->name('staff.updateVisible');

        //Beneficios    
        Route::resource('/strength', StrengthController::class);
        Route::post('/strength/updateVisible', [StrengthController::class, 'updateVisible'])->name('strength.updateVisible');
        Route::post('/strength/borrar', [StrengthController::class, 'borrar'])->name('strength.borrar');


        //Nosotros
        Route::resource('/aboutus', AboutUsController::class);
        Route::post('/aboutus/updateVisible', [AboutUsController::class, 'updateVisible'])->name('aboutus.updateVisible');
        Route::post('/aboutus/borrar', [AboutUsController::class, 'borrar'])->name('aboutus.borrar');

        //Atributes
        Route::resource('/attributes', AttributesController::class);
        Route::post('/attributes/updateVisible', [AttributesController::class, 'updateVisible'])->name('attributes.updateVisible');
        Route::post('/attributes/borrar', [AttributesController::class, 'borrar'])->name('attributes.borrar');

        //valores atributes
        Route::resource('/valoresattributes', ValoresAtributosController::class);
        Route::post('/valoresattributes/borrar', [ValoresAtributosController::class, 'borrar'])->name('valoresattributes.borrar');
        Route::post('/valoresattributes/updateVisible', [ValoresAtributosController::class, 'updateVisible'])->name('valoresattributes.updateVisible');

        //Etiquetas
        Route::resource('/tags', TagController::class);
        Route::post('/tags/deleteTags', [TagController::class, 'deleteTags'])->name('tags.deleteTags');
        Route::post('/tags/updateVisible', [TagController::class, 'updateVisible'])->name('tags.updateVisible');


        //Productos
        Route::resource('/products', ProductsController::class);
        Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
        Route::post('/products/updateVisible', [ProductsController::class, 'updateVisible'])->name('products.updateVisible');
        Route::post('/products/borrar', [ProductsController::class, 'borrar'])->name('products.borrar');
        Route::post('/products/borrarficha', [ProductsController::class, 'borrarFichaTecnica'])->name('activity.borrarficha');
        //Preguntas frecuentes
        Route::resource('/faqs', FaqsController::class);
        Route::post('/faqs/updateVisible', [FaqsController::class, 'updateVisible'])->name('faqs.updateVisible');
        Route::post('/faqs/borrar', [FaqsController::class, 'borrar'])->name('faqs.borrar');

        //Sliders   
        Route::resource('/slider', SliderController::class);
        Route::post('/slider/updateVisible', [SliderController::class, 'updateVisible'])->name('slider.updateVisible');
        Route::post('/slider/deleteSlider', [SliderController::class, 'deleteSlider'])->name('slider.deleteSlider');

        //Galeria
        Route::resource('/galerie', GalerieController::class);
        Route::post('/galery', [GalerieController::class, 'saveImage']);
        Route::post('/galerie', [GalerieController::class, 'store'])->name('galerie.store');
        Route::post('/galerie/updateVisible', [GalerieController::class, 'updateVisible'])->name('galerie.updateVisible');
        Route::post('/galerie/borrar', [GalerieController::class, 'borrar'])->name('galerie.borrar');

        Route::resource('/banners', BannersController::class);
        Route::post('/banners/deleteBanner', [BannersController::class, 'deleteBanner'])->name('banners.deleteBanner');
        Route::post('/banners/updateVisible', [BannersController::class, 'updateVisible'])->name('banner.updateVisible');

        Route::resource('/popup', PopupController::class);
        Route::post('/popup/deleteBanner', [PopupController::class, 'deleteBanner'])->name('popup.deleteBanner');
        Route::post('/popup/updateVisible', [PopupController::class, 'updateVisible'])->name('popup.updateVisible');

        Route::get('/subscripciones', [NewsletterSubscriberController::class, 'showSubscripciones'])->name('subscripciones');

        Route::fallback(function () {
            return view('pages/utility/404');
        });
    });
});


Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    
    Route::get('/micuenta', [IndexController::class, 'micuenta'])->name('micuenta');
    Route::get('/micuenta/pedidos', [IndexController::class, 'pedidos'])->name('pedidos');
    Route::get('/micuenta/direccion', [IndexController::class, 'direccion'])->name('direccion');
    Route::get('/micuenta/listadeseos', [IndexController::class, 'listadeseos'])->name('listadeseos');

    Route::post('/micuenta/cambiofoto', [IndexController::class, 'cambiofoto'])->name('cambiofoto');
    Route::post('/micuenta/direccion/cambiofoto', [IndexController::class, 'cambiofoto'])->name('cambiofoto');
    Route::post('/micuenta/pedidos/cambiofoto', [IndexController::class, 'cambiofoto'])->name('cambiofoto');


    Route::post('/micuenta/actualizarPerfil', [IndexController::class, 'actualizarPerfil'])->name('actualizarPerfil');
    Route::post('/micuenta/wishList', [IndexController::class, 'wishListAdd'])->name('wishlist.store');
});
