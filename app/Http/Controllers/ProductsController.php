<?php

namespace App\Http\Controllers;

use App\Http\Classes\dxResponse;
use App\Models\AttributeProductValues;
use App\Models\Attributes;
use App\Models\AttributesValues;
use App\Models\Category;
use App\Models\ClientLogos;
use App\Models\Discount;
use App\Models\dxDataGrid;
use App\Models\Galerie;
use App\Models\Products;
use App\Models\Specifications;
use App\Models\SubCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use SoDe\Extend\JSON;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;
use SoDe\Extend\Response;

use function PHPUnit\Framework\isNull;

class ProductsController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $products =  Products::where("status", "=", true)->get();

    return view('pages.products.index', compact('products'));
  }

  public function reactView()
  {
    $products = Products::all();

    return Inertia::render('Admin/Products', [
      'products' => $products,
    ])->rootView('admin');
  }

  public function paginate(Request $request)
  {
    //validar el rol del usuario logueado 
    // $user = Auth::user();
    // dump($user->hasRole('Reseller'));

    $user = false;
    $admin = $request->is_admin ? true : false;
    $outlet = $request->hasTag51;

    $response =  new dxResponse();
    try {
      $instance = Products::select([
        DB::raw('DISTINCT products.*')
      ])
        ->with(['category', 'tags', 'marcas', 'colors', 'discount'])
        // ->leftJoin('attribute_product_values AS apv', 'products.id', 'apv.product_id')
        // ->leftJoin('attributes AS a', 'apv.attribute_id', 'a.id')
        ->leftJoin('tags_xproducts AS txp', 'txp.producto_id', 'products.id')
        ->leftJoin('categories', 'categories.id', 'products.categoria_id')
        ->leftJoin('client_logos', 'client_logos.id', 'products.marca_id')
        ->where('products.status', 1);

      if (!$admin) {
        $instance->whereIn('products.id', function ($query) {
          $query->select(DB::raw('MIN(id)'))
            ->from('products')
            ->where('products.visible', 1)
            ->groupBy('producto');
        })
          ->where('products.visible', 1)
          ->where('categories.visible', 1);

        if ($outlet) {
          $instance->orderBy('products.percent_discount', 'DESC');
        } else {
          $instance->orderBy('products.percent_discount', 'ASC');
        }
      }


      if (Auth::check()) {
        $user = Auth::user();
        $user = $user->hasRole('Reseller');
        if ($user) { // Cambia 'admin' por el rol que deseas validar
          $instance->where('products.precio_reseller', '>', 0);
        }
      }



      if ($request->group != null) {
        [$grouping] = $request->group;
        $selector = \str_replace('.', '__', $grouping['selector']);
        $instance = Products::select([
          "{$selector} AS key"
        ])
          ->groupBy($selector);
      }

      if ($request->filter) {
        $instance->where(function ($query) use ($request) {
          dxDataGrid::filter($query, $request->filter ?? [], false);
        });
      }


      if ($request->sort != null) {
        foreach ($request->sort as $sorting) {
          // $selector = \str_replace('.', '__', $sorting['selector']);
          $selector = $sorting['selector'];
          $instance->orderBy(
            $selector,
            $sorting['desc'] ? 'DESC' : 'ASC'
          );
        }
      } else {
        $instance->orderBy('products.id', 'DESC');
      }




      $totalCount = 0;
      if ($request->requireTotalCount) {
        $totalCount = $instance->distinct()->count('products.id');
      }

      $jpas = [];
      if (!$request->ignoreData) {
        $jpas = $request->isLoadingAll
          ? $instance->get()
          : $instance
          ->skip($request->skip ?? 0)
          ->take($request->take ?? 10)
          ->get();
      }

      // $results = [];

      // foreach ($jpas as $jpa) {
      //   $result = JSON::unflatten($jpa->toArray(), '__');
      //   $results[] = $result;
      // }

      $response->status = 200;
      $response->message = 'Operación correcta';
      $response->data = $jpas;
      $response->totalCount = $totalCount;
      $response->is_proveedor = $user;
    } catch (\Throwable $th) {
      $response->status = 400;
      $response->message = $th->getMessage() . " " . $th->getFile() . ' Ln.' . $th->getLine();
    } finally {
      return response(
        $response->toArray(),
        $response->status
      );
    }
  }


  public function stock(Request $request)
  {
    $response = Response::simpleTryCatch(function () use ($request) {
      $body = $request->all();
      return Products::select(['id', 'stock'])->whereIn('id', $body)->get()->map(function ($item) {
        $item->stock = \intval($item->stock);
        return $item;
      });
    });

    return response($response->toArray(), $response->status);
  }

  public function paginateOffers(Request $request)
  {
    $response =  new dxResponse();
    try {
      $instance = Products::select([
        DB::raw('DISTINCT products.*')
      ])
        ->with(['category', 'tags'])
        ->leftJoin('attribute_product_values AS apv', 'products.id', 'apv.product_id')
        ->leftJoin('attributes AS a', 'apv.attribute_id', 'a.id')
        ->leftJoin('tags_xproducts AS txp', 'txp.producto_id', 'products.id')
        ->where('descuento', '>', 0);

      if ($request->group != null) {
        [$grouping] = $request->group;
        $selector = \str_replace('.', '__', $grouping['selector']);
        $instance = Products::select([
          "{$selector} AS key"
        ])
          ->groupBy($selector);
      }

      if ($request->filter) {
        $instance->where(function ($query) use ($request) {
          dxDataGrid::filter($query, $request->filter ?? [], false);
        });
      }

      if ($request->sort != null) {
        foreach ($request->sort as $sorting) {
          // $selector = \str_replace('.', '__', $sorting['selector']);
          $selector = $sorting['selector'];
          $instance->orderBy(
            $selector,
            $sorting['desc'] ? 'DESC' : 'ASC'
          );
        }
      } else {
        $instance->orderBy('products.id', 'DESC');
      }

      $totalCount = 0;
      if ($request->requireTotalCount) {
        $totalCount = $instance->count('*');
      }

      $jpas = [];
      if (!$request->ignoreData) {
        $jpas = $request->isLoadingAll
          ? $instance->get()
          : $instance
          ->skip($request->skip ?? 0)
          ->take($request->take ?? 10)
          ->get();
      }

      // $results = [];

      // foreach ($jpas as $jpa) {
      //   $result = JSON::unflatten($jpa->toArray(), '__');
      //   $results[] = $result;
      // }

      $response->status = 200;
      $response->message = 'Operación correcta';
      $response->data = $jpas;
      $response->totalCount = $totalCount;
    } catch (\Throwable $th) {
      $response->status = 400;
      $response->message = $th->getMessage() . " " . $th->getFile() . ' Ln.' . $th->getLine();
    } finally {
      return response(
        $response->toArray(),
        $response->status
      );
    }
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $product = new Products();
    $atributos = Attributes::where("status", "=", true)->get();
    $valorAtributo = AttributesValues::where("status", "=", true)->get();
    $tags = Tag::where("status", "=", true)->get();
    $marcas = ClientLogos::where("status", "=", true)->get();
    $categoria = Category::all();
    $subcategories = SubCategory::all();
    $descuentos = Discount::where("status", "=", true)->get();
    $galery = [];
    $especificacion = [json_decode('{"tittle":"", "specifications":""}', false)];
    return view('pages.products.save', compact('descuentos', 'product', 'marcas', 'atributos', 'valorAtributo', 'categoria', 'tags', 'especificacion', 'subcategories', 'galery'));
  }

  public function edit(string $id)
  {

    $product =  Products::with('tags')->find($id);
    $atributos = Attributes::where("status", "=", true)->get();
    $valorAtributo = AttributesValues::where("status", "=", true)->get();
    $especificacion = Specifications::where("product_id", "=", $id)->get();
    if ($especificacion->count() == 0) $especificacion = [json_decode('{"tittle":"", "specifications":""}', false)];
    $tags = Tag::where('status', 1)->get();
    $marcas = ClientLogos::where("status", "=", true)->get();
    $categoria = Category::where("status", "=", true)->get();
    $descuentos = Discount::where("status", "=", true)->get();
    $subcategories = SubCategory::all();
    $valoresdeatributo = AttributeProductValues::where("product_id", "=", $id)->get();
    $galery = Galerie::where("product_id", "=", $id)->get();

    return view('pages.products.save', compact('descuentos', 'product', 'marcas', 'atributos', 'valorAtributo', 'tags', 'categoria', 'especificacion', 'subcategories', 'galery', 'valoresdeatributo'));
  }

  private function saveImg(Request $request, string $field)
  {
    try {
      //code...
      if (isset($request->id)) {
        $producto = Products::find($request->id);
        $ruta = $producto->$field;

        // dump($ruta);
        //borrar imagen
        if (!empty($ruta) && file_exists($ruta)) {
          // Borrar imagen
          unlink($ruta);
        }
      }
      if ($request->hasFile($field)) {
        $file = $request->file($field);
        $route = "storage/images/productos/{$request->categoria_id}/";
        // $route = "storage/images/productos/$request->categoria_id/";
        $nombreImagen = Str::random(10) . '_' . $field . '.' . $file->getClientOriginalExtension();
        // $nombreImagen = $request->sku.'.png';
        $manager = new ImageManager(new Driver());
        $img =  $manager->read($file);
        // $img->coverDown(340, 340, 'center');

        if (!file_exists($route)) {
          mkdir($route, 0777, true);
        }

        // $img->save($route . $nombreImagen);
        $img->save($route . $nombreImagen);
        return $route . $nombreImagen;
      }
      return null;
    } catch (\Throwable $th) {
      //throw $th;

    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {

    try {
      $especificaciones = [];
      $data = $request->all();

      $atributos = null;
      $tagsSeleccionados = $request->input('tags_id');
      // $valorprecio = $request->input('precio') - 0.1;

      $request->validate([
        'producto' => 'required',
        'precio' => 'min:0|required|numeric',
        // 'descuento' => 'lt:' . $request->input('precio'),
      ]);

      // Imagenes
      $data['descuento'] = $data['descuento'] ?? 0;

      if ($data['descuento'] > 0) {
        $data['percent_discount'] = (1 - ($data['descuento'] / $data['precio'])) * 100;
      } else {
        $data['percent_discount'] = 0;
      }

      if ($request->hasFile('imagen')) {
        $data['imagen'] = $this->saveImg($request, 'imagen');
      }
      if ($request->hasFile('imagen_ambiente')) {
        $data['imagen_ambiente'] = $this->saveImg($request, 'imagen_ambiente');
      }
      if ($request->hasFile('image_texture')) {
        $data['image_texture'] = $this->saveImg($request, 'image_texture');
      }
      // $data['imagen_2'] = $this->saveImg($request, 'imagen_2');
      // $data['imagen_3'] = $this->saveImg($request, 'imagen_3');
      // $data['imagen_4'] = $this->saveImg($request, 'imagen_4');

      foreach ($data as $key => $value) {
        if (strstr($key, '-')) {
          //strpos primera ocurrencia que enuentre
          if (strpos($key, 'tittle-') === 0 || strpos($key, 'title-') === 0) {
            $num = substr($key, strrpos($key, '-') + 1); // Obtener el número de la especificación
            $especificaciones[$num]['tittle'] = $value; // Agregar el título al array asociativo
          } elseif (strpos($key, 'specifications-') === 0) {
            $num = substr($key, strrpos($key, '-') + 1); // Obtener el número de la especificación
            $especificaciones[$num]['specifications'] = $value; // Agregar las especificaciones al array asociativo
          }
        }
      }

      if (array_key_exists('destacar', $data)) {
        if (strtolower($data['destacar']) == 'on') $data['destacar'] = 1;
      }
      if (array_key_exists('recomendar', $data)) {
        if (strtolower($data['recomendar']) == 'on') $data['recomendar'] = 1;
      }

      $cleanedData = Arr::where($data, function ($value, $key) {
        return !is_null($value);
      });

      if (!isset($cleanedData['stock'])) {
        $cleanedData['stock'] = 0;
      }

      if (!isset($cleanedData['discount_id']) || $cleanedData['discount_id'] === '') {
        $cleanedData['discount_id'] = null;
      }

      $slug = strtolower(str_replace(' ', '-', $request->producto . '-' . $request->color));

      if (Category::where('slug', $slug)->exists()) {
        $slug .= '-' . rand(1, 1000);
      }

      // Busca el producto, si existe lo actualiza, si no lo crea
      $producto = Products::find($request->id);
      if ($producto) {
        $cleanedData['max_stock'] = $this->gestionarMaxStock($producto->max_stock, $cleanedData['stock']);
        $producto->update($cleanedData);
      } else {
        $cleanedData['max_stock'] = $cleanedData['stock'];
        $producto = Products::create($cleanedData);
      }

      AttributeProductValues::where('product_id', $producto->id)->delete();

      if (isset($data['attributes']) && is_array($data['attributes'])) {
        foreach ($data['attributes'] as $attribute_id => $value_id) {
          if (is_array($value_id)) {
            foreach ($value_id as $id) {
              AttributeProductValues::create([
                'product_id' => $producto->id,
                'attribute_id' => $attribute_id,
                'attribute_value_id' => $id
              ]);
            }
          } else {
            AttributeProductValues::create([
              'product_id' => $producto->id,
              'attribute_id' => $attribute_id,
              'attribute_value_id' => $value_id
            ]);
          }
        }
      }

      $this->GuardarEspecificaciones($producto->id, $especificaciones);
      $producto->tags()->sync($tagsSeleccionados);

      Galerie::where('product_id', $producto->id)->delete();
      if ($request->galery) {
        foreach ($request->galery as $value) {
          [$id, $name] = explode('|', $value);
          Galerie::updateOrCreate([
            'product_id' => $id,
            'id' => $id
          ], [
            'imagen' => $name,
            'product_id' => $producto->id
          ]);
        }
      }

      return redirect()->route('products.index')->with('success', 'Publicación creado exitosamente.');
    } catch (\Throwable $th) {
      // dump($th->getMessage());
    }
  }

  private function TagsXProducts($id, $nTags)
  {
    DB::delete('delete from tags_xproducts where producto_id = ?', [$id]);
    foreach ($nTags as $key => $value) {
      DB::insert('insert into tags_xproducts (producto_id, tag_id) values (?, ?)', [$id, $value]);
    }
  }

  private function gestionarMaxStock($stock_actual, $nuevo_stock)
  {
    if ($nuevo_stock > $stock_actual) {
      return $nuevo_stock;
    }
    return $stock_actual;
  }


  private function GuardarEspecificaciones($id, $especificaciones)
  {
    Specifications::where('product_id', $id)->delete();
    foreach ($especificaciones as $value) {
      if (!$value['tittle'] || !$value['specifications']) continue;
      $value['product_id'] = $id;
      Specifications::create($value);
    }
  }

  private function actualizarEspecificacion($especificaciones)
  {
    foreach ($especificaciones as $key => $value) {
      $espect = Specifications::find($key);
      $espect->tittle = $value['tittle'];
      $espect->specifications = $value['specifications'];

      if ($value['specifications'] == null) {
        $espect->delete();
      } else {
        $espect->save();
      }
    }
  }

  private function stringToObject($key, $atributos)
  {

    $parts = explode(':', $key);
    $nombre = strtolower($parts[0]); // Nombre del atributo
    $valor = strtolower($parts[1]); // Valor del atributo en minúsculas

    // Verifica si el atributo ya existe en el array
    if (isset($atributos[$nombre])) {
      // Si el atributo ya existe, agrega el nuevo valor a su lista
      $atributos[$nombre][] = $valor;
    } else {
      // Si el atributo no existe, crea una nueva lista con el valor
      $atributos[$nombre] = [$valor];
    }
    return $atributos;
  }

  /**
   * Display the specified resource.
   */
  public function show(Products $products)
  {
    //
  }


  public function borrarFichaTecnica(Request $request)
  {
    try {

      $obtenerproducto = Products::find($request->id);

      if (!$obtenerproducto) {
        return response()->json(['message' => 'Producto no encontrado'], 404);
      }


      $rutaCompleta = $obtenerproducto->imagen_ambiente;


      if (file_exists($rutaCompleta)) {

        if (unlink($rutaCompleta)) {

          $obtenerproducto->imagen_ambiente = "";
          $obtenerproducto->update();

          return response()->json(['message' => 'Ficha Técnica eliminada con éxito']);
        } else {
          return response()->json(['message' => 'No se pudo eliminar el archivo físico'], 500);
        }
      } else {
        return response()->json(['message' => 'El archivo no existe'], 404);
      }
    } catch (\Throwable $th) {
      return response()->json(['message' => 'No se ha podido eliminar la Ficha Técnica', 'error' => $th->getMessage()], 400);
    }
  }


  /**
   * Update the specified resource in storage.
   */
  // public function update(Request $request, string $id)
  // {
  //   $especificaciones = [];
  //   $product = Products::find($id);
  //   $tagsSeleccionados = $request->input('tags_id');
  //   $data = $request->all();
  //   $atributos = null;







  //   $request->validate([
  //     'producto' => 'required',
  //   ]);

  //   if ($request->hasFile("imagen")) {
  //     $file = $request->file('imagen');
  //     $routeImg = 'storage/images/imagen/';
  //     $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();

  //     $this->saveImg($file, $routeImg, $nombreImagen);

  //     $data['imagen'] = $routeImg . $nombreImagen;
  //     // $AboutUs->name_image = $nombreImagen;
  //   }

  //   if ($request->hasFile("imagen_ambiente")) {
  //     $file = $request->file('imagen_ambiente');
  //     $routeImg = 'storage/images/imagen_ambiente/';
  //     $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();

  //     $this->saveImg($file, $routeImg, $nombreImagen);

  //     $data['imagen_ambiente'] = $routeImg . $nombreImagen;
  //     // $AboutUs->name_image = $nombreImagen;
  //   }

  //   foreach ($request->all() as $key => $value) {

  //     if (strstr($key, ':')) {
  //       // Separa el nombre del atributo y su valor
  //       $atributos = $this->stringToObject($key, $atributos);
  //       unset($request[$key]);
  //     } elseif (strstr($key, '-')) {
  //       //strpos primera ocurrencia que enuentre
  //       if (strpos($key, 'tittle-') === 0 || strpos($key, 'title-') === 0) {
  //         $num = substr($key, strrpos($key, '-') + 1); // Obtener el número de la especificación
  //         $especificaciones[$num]['tittle'] = $value; // Agregar el título al array asociativo
  //       } elseif (strpos($key, 'specifications-') === 0) {

  //         $num = substr($key, strrpos($key, '-') + 1); // Obtener el número de la especificación
  //         $especificaciones[$num]['specifications'] = $value; // Agregar las especificaciones al array asociativo
  //       }
  //     }
  //   }








  //   $jsonAtributos = json_encode($atributos);

  //   if (array_key_exists('destacar', $data)) {
  //     if (strtolower($data['destacar']) == 'on') $data['destacar'] = 1;
  //   }
  //   if (array_key_exists('recomendar', $data)) {
  //     if (strtolower($data['recomendar']) == 'on') $data['recomendar'] = 1;
  //   }



  //   $data['atributes'] = $jsonAtributos;
  //   $cleanedData = Arr::where($data, function ($value, $key) {
  //     return !is_null($value);
  //   });
  //   $product->update($cleanedData);

  //   DB::delete('delete from attribute_product_values where product_id = ?', [$product->id]);

  //   if (isset($atributos)) {
  //     foreach ($atributos as $atributo => $valores) {
  //       $idAtributo = Attributes::where('titulo', $atributo)->first();

  //       foreach ($valores as $valor) {
  //         $idValorAtributo = AttributesValues::where('valor', $valor)->first();

  //         if ($idAtributo && $idValorAtributo) {
  //           DB::table('attribute_product_values')->insert([
  //             'product_id' => $product->id,
  //             'attribute_id' => $idAtributo->id,
  //             'attribute_value_id' => $idValorAtributo->id,
  //           ]);
  //         }
  //       }
  //     }
  //   }

  //   DB::delete('delete from tags_xproducts where producto_id = ?', [$id]);
  //   if (!is_null($tagsSeleccionados)) {
  //     $this->TagsXProducts($id, $tagsSeleccionados);
  //   }
  //   $this->actualizarEspecificacion($especificaciones);
  //   return redirect()->route('products.index')->with('success', 'Producto editado exitosamente.');
  // }

  /**
   * Remove the specified resource from storage.
   */
  public function borrar(Request $request)
  {
    //softdelete
    $product = Products::find($request->id);
    $product->status = 0;
    $product->save();
  }

  public function updateVisible(Request $request)
  {
    $id = $request->id;
    $field = $request->field;
    $status = $request->status;

    // Verificar si el producto existe
    $product = Products::find($id);

    if (!$product) {
      return response()->json(['message' => 'Producto no encontrado'], 404);
    }

    // Actualizar el campo dinámicamente
    $product->update([
      $field => $status
    ]);
    return response()->json(['message' => 'registro actualizado']);
  }

  private static function generateDiscountArray($quantity, $take, $pay)
  {
    $result = array_fill(0, $quantity, 0);
    $remainingPay = $pay;
    $currentTake = 0;

    for ($i = 0; $i < $quantity; $i++) {
      if ($currentTake == $take) {
        $currentTake = 0;
        $remainingPay = $pay;
      }

      if ($remainingPay >= 1) {
        $result[$i] = 1;
        $remainingPay -= 1;
      } else if ($remainingPay > 0) {
        $result[$i] = $remainingPay;
        $remainingPay = 0;
      }
      $currentTake++;
    }

    // Ordenar el resultado en orden descendente
    rsort($result);
    return $result;
  }


  public static function process(array $cart = [])
  {
    $ids = array_map(fn($item) => $item['sku'], $cart);

    $productsJpa = Products::with(['discount'])
      ->whereIn('sku', $ids)
      ->get();

    $cartSameDiscount = [];
    $cartDiffDiscount = [];
    $cartWODiscount = [];

    $cart2process = [];
    $discounts2Process = [];

    foreach ($productsJpa as $productJpa) {
      $product = $productJpa->toArray();
      $item = array_filter($cart, fn($cartItem) => $cartItem['id'] == $product['id']);
      $item = reset($item);
      if (!$product['discount']) {
        $cartWODiscount[] = array_merge($product, [
          'cantidad' => $item['cantidad']
        ]);
        continue;
      }
      $quantityGroup = $item['cantidad'] % $product['discount']['take_product'];
      $quantityWOGroup = $item['cantidad'] - $quantityGroup;
      if ($quantityWOGroup != 0) {
        $cartSameDiscount[] = array_merge($product, [
          'cantidad' => $quantityWOGroup
        ]);
      }
      if ($item['cantidad'] - $quantityWOGroup != 0) {
        if (!in_array($product['discount'], $discounts2Process)) {
          $discounts2Process[] = $product['discount'];
        }
        $suelto = $item['cantidad'] - $quantityWOGroup;
        $cart2process[] = array_merge($product, [
          'cantidad' => $suelto
        ]);
      }
    }

    foreach ($discounts2Process as $discount) {
      // Filtrar productos que tienen el mismo descuento y ordenarlos por precio
      $products = array_filter($cart2process, fn($item) => $item['discount']['id'] == $discount['id']);

      // Ordenar los productos por precio (de mayor a menor)
      usort($products, fn($a, $b) => $b['precio'] <=> $a['precio']);

      // Total de productos con el mismo descuento
      $totalByDiscount = array_sum(array_map(fn($x) => $x['cantidad'], $products));

      if ($totalByDiscount >= $discount['take_product']) {
        $modulo = $totalByDiscount % $discount['take_product'];
        $descuentoDistintoProducto = []; // Productos que forman parte del descuento
        $cuota = $totalByDiscount - $modulo; // Total de productos a procesar para el descuento

        foreach ($products as $item) {
          $cantidadPorProducto = $cuota >= $item['cantidad'] ? $item['cantidad'] : $cuota;

          if ($cuota >= $item['cantidad']) {
            // Si la cuota cubre la cantidad del producto, se añade al grupo con descuento
            $descuentoDistintoProducto[] = array_merge($item, ['cantidad' => $cantidadPorProducto]);
          } else {
            // Si no, parte va con descuento y parte sin descuento
            $descuentoDistintoProducto[] = array_merge($item, ['cantidad' => $cuota]);
            $cartWODiscount[] = array_merge($item, [
              'cantidad' => $item['cantidad'] - $cuota,
              'discount' => null
            ]);
          }
          // Reducir la cuota según la cantidad procesada
          $cuota = $cuota - $cantidadPorProducto;
        }

        // Añadir productos procesados con descuento
        $cartDiffDiscount[] = $descuentoDistintoProducto;
      } else {
        // Si no se alcanza el mínimo para el descuento, todos van sin descuento
        foreach ($products as $product) {
          $cartWODiscount[] = array_merge($product, ['discount' => null]);
        }
      }
    }

    // Combinar los tres arreglos en un solo carrito final
    $cartFinal = array_merge(
      array_map(fn($x) => [$x], $cartSameDiscount),
      $cartDiffDiscount,
      array_map(fn($x) => [$x], $cartWODiscount)
    );

    $cartToDraw = [];

    foreach ($cartFinal as $group) {
      $cuota = isset($group[0]['discount']['take_product']) ? (float) $group[0]['discount']['take_product'] : 0;
      $payment = isset($group[0]['discount']['payment_product']) ? (float) $group[0]['discount']['payment_product'] : 0;
      $cantidadTotal = array_sum(array_map(fn($x) => $x['cantidad'], $group));

      // Generar un arreglo de descuento (presumo que tienes una función `generateDiscountArray` en PHP)
      $discountArray = ProductsController::generateDiscountArray($cantidadTotal, $cuota, $payment);

      $iterator = 0;

      foreach ($group as $index => $item) {
        // Calcular el precio final y total
        $finalPrice = min(array_filter([floatval($item['precio']), floatval($item['descuento'])]));
        $totalPrice = $finalPrice * $item['cantidad'];

        if (isset($item['discount'])) {
          if ($item['discount']['type_id'] == 1) {
            if ($item['discount']['apply_to'] == 'self') {
              $finalPrice = ($item['precio'] * $item['discount']['payment_product']) / $item['discount']['take_product'];
              $totalPrice = $finalPrice * $item['cantidad'];
            } elseif ($item['discount']['apply_to'] == 'lower') {
              $finalPrice = 0;
              $totalPrice = 0;
              for ($i = 0; $i < $item['cantidad']; $i++) {
                $cobrar = $discountArray[$iterator];
                $finalPrice += $item['precio'] * $cobrar / $item['cantidad'];
                $totalPrice += $item['precio'] * $cobrar;
                $iterator++;
              }
            }
          } else {
            $finalPrice = ($item['precio'] * $payment) / 100;
            $totalPrice = $finalPrice * $item['cantidad'];
          }
        }

        $cuota -= $item['cantidad'];

        // Verificar si el item ya está en el carrito para pintar, si no, añadirlo
        $foundIndex = array_search($item['id'], array_column($cartToDraw, 'id'));

        if ($foundIndex === false) {
          $cartToDraw[] = array_merge($item, [
            'finalPrice' => $finalPrice,
            'totalPrice' => $totalPrice
          ]);
        } else {
          $cartToDraw[$foundIndex]['cantidad'] += $item['cantidad'];
          $cartToDraw[$foundIndex]['totalPrice'] += $totalPrice;
        }
      }
    }

    return $cartToDraw;
  }
}
