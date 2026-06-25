# Reporte de Corrección de Errores y Compatibilidad con Caché de Configuración

Este documento detalla las correcciones y mejoras realizadas en el proyecto para solucionar el Error 500 al ingresar a la pasarela de pagos (`/pago/<code>`) y prevenir futuros errores relacionados con el almacenamiento en caché de la configuración en entornos de producción.

---

## 1. Diagnóstico del Error
El servidor de producción reportaba un error crítico:
> `SoDe\Extend\Fetch::__construct(): Argument #1 ($url) must be of type string, null given, called in IzipayController.php`

### Causa Raíz:
En Laravel, cuando se ejecuta el comando de producción `php artisan config:cache`, el framework unifica todos los archivos de configuración en una única caché y deja de leer el archivo `.env`. Como consecuencia directa de este comportamiento oficial de Laravel, **todas las llamadas a la función `env()` realizadas fuera de los archivos de la carpeta `config/` retornan `null`**. 

El controlador de Izipay llamaba directamente a `env('IZIPAY_URL')`, lo que provocaba que la URL fuera `null` en producción, desencadenando el Error 500.

---

## 2. Acciones Realizadas

### A. Registro de Variables en Archivos de Configuración (`config/`)
Registramos todas las credenciales de servicios de terceros en la estructura oficial de configuración de Laravel para permitir que sean cacheadas de manera segura:
1. **Credenciales de Izipay y Culqi**: Registradas en [config/services.php](file:///c:/xampp/htdocs/projects/americanbrands_old/config/services.php):
   ```php
   'izipay' => [
       'url' => env('IZIPAY_URL'),
       'client_id' => env('IZIPAY_CLIENT_ID'),
       'client_secret' => env('IZIPAY_CLIENT_SECRET'),
       'public_key' => env('IZIPAY_PUBLIC_KEY'),
       'hash_key' => env('IZIPAY_HASH_KEY'),
   ],
   'culqi' => [
       'public_key' => env('CULQI_PUBLIC_KEY'),
       'private_key' => env('CULQI_PRIVATE_KEY'),
   ],
   ```
2. **Protocolo y Dominio**: Registrados en [config/app.php](file:///c:/xampp/htdocs/projects/americanbrands_old/config/app.php):
   ```php
   'protocol' => env('APP_PROTOCOL', 'https'),
   'domain' => env('APP_DOMAIN'),
   ```

### B. Reemplazo de llamadas a `env()` por `config()`
Modificamos todas las clases, controladores y vistas Blade para consumir los valores desde el helper `config()` en lugar de `env()` directamente:
* En la pasarela de pagos y controladores de Izipay/Culqi.
* En las configuraciones de ReCaptcha (usando `config('captcha.secret')` y `config('captcha.sitekey')`).
* En las vistas Blade para mostrar el nombre de la app (`config('app.name')`) y resolver URLs dinámicas (`config('app.url')`).

---

## 3. Lista de Archivos Modificados

### Archivos de Configuración
* [config/services.php](file:///c:/xampp/htdocs/projects/americanbrands_old/config/services.php) — Registro de llaves de Izipay y Culqi.
* [config/app.php](file:///c:/xampp/htdocs/projects/americanbrands_old/config/app.php) — Registro de variables `protocol` y `domain`.

### Controladores y Servicios
* [app/Http/Controllers/IzipayController.php](file:///c:/xampp/htdocs/projects/americanbrands_old/app/Http/Controllers/IzipayController.php) — Migrado a `config()` para obtener las llaves y URL de Izipay.
* [app/Http/Controllers/IndexController.php](file:///c:/xampp/htdocs/projects/americanbrands_old/app/Http/Controllers/IndexController.php) — Migrado a `config()` para URL, llaves de Culqi y nombre de la app.
* [app/Http/Controllers/PaymentController.php](file:///c:/xampp/htdocs/projects/americanbrands_old/app/Http/Controllers/PaymentController.php) — Migrado a `config()` para llaves de Culqi y nombre de la app.
* [app/Http/Controllers/NewsletterSubscriberController.php](file:///c:/xampp/htdocs/projects/americanbrands_old/app/Http/Controllers/NewsletterSubscriberController.php) — Corrección de `env()` a `config()`.
* [app/Http/Controllers/BlogController.php](file:///c:/xampp/htdocs/projects/americanbrands_old/app/Http/Controllers/BlogController.php) — Corrección de `env()` a `config()`.
* [app/Http/Controllers/AuthController.php](file:///c:/xampp/htdocs/projects/americanbrands_old/app/Http/Controllers/AuthController.php) — Migración a `config()` para protocolo, dominio, recaptcha y app URL.
* [app/Http/Services/ReCaptchaService.php](file:///c:/xampp/htdocs/projects/americanbrands_old/app/Http/Services/ReCaptchaService.php) — Uso de `config('captcha.secret')`.
* [app/Http/Responses/RegisterResponse.php](file:///c:/xampp/htdocs/projects/americanbrands_old/app/Http/Responses/RegisterResponse.php) — Uso de `config('app.url')` y `config('app.name')`.

### Vistas Blade (HTML / Frontend)
* [resources/views/public/checkout_pago.blade.php](file:///c:/xampp/htdocs/projects/americanbrands_old/resources/views/public/checkout_pago.blade.php) — Carga la llave pública de Izipay usando `config('services.izipay.public_key')`.
* [resources/views/layouts/app.blade.php](file:///c:/xampp/htdocs/projects/americanbrands_old/resources/views/layouts/app.blade.php) — Uso de `config('app.name')`.
* [resources/views/components/public/matrix.blade.php](file:///c:/xampp/htdocs/projects/americanbrands_old/resources/views/components/public/matrix.blade.php) — Uso de `config('app.name')`.
* [resources/views/components/public/headerbk.blade.php](file:///c:/xampp/htdocs/projects/americanbrands_old/resources/views/components/public/headerbk.blade.php) — Uso de `config('app.url')`.
* [resources/views/components/public/header.blade.php](file:///c:/xampp/htdocs/projects/americanbrands_old/resources/views/components/public/header.blade.php) — Uso de `config('app.url')`.
* [resources/views/app.blade.php](file:///c:/xampp/htdocs/projects/americanbrands_old/resources/views/app.blade.php) — Uso de `config('app.name')`.
* [resources/views/admin.blade.php](file:///c:/xampp/htdocs/projects/americanbrands_old/resources/views/admin.blade.php) — Uso de `config('app.name')`.

---

## 4. Instrucciones para la Implementación en Producción

Para aplicar y activar las correcciones en el servidor, por favor siga estos pasos:

1. **Subir los cambios**: Suba al servidor todos los archivos listados en la sección anterior.
2. **Actualizar la caché del servidor**: Ejecute los siguientes comandos en la terminal de producción para refrescar la configuración:
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```
3. **Validación**: Ingrese al sitio web y complete un flujo de pago para validar la carga de la pasarela y la correcta comunicación con el tokenizador de Izipay.
