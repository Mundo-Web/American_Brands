<?php

namespace App\Jobs;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ClientLogos;
use App\Models\Discount;
use App\Models\Galerie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Products;
use App\Models\ProductTag;
use App\Models\Specifications;
use App\Models\SubCategory;
use App\Models\Tag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SoDe\Extend\File;
use SoDe\Extend\JSON;
use SoDe\Extend\Text;

class SaveItems implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  private array $items;
  private string $image_route_pattern;

  public function __construct(array $items, string $image_route_pattern)
  {
    $this->items = $items;
    $this->image_route_pattern = $image_route_pattern;
  }

  public function handle()
  {
    // Ruta base para buscar imágenes
    $path2search = "./storage/images/products/";
    $images = [];

    // Escanear imágenes en el directorio de productos
    try {
      $images = File::scan($path2search);
      $imageMap = array_flip($images); // Crear índice de imágenes para búsquedas rápidas
    } catch (\Throwable $th) {
      dump($th->getMessage());
    }

    // Deshabilitar restricciones de claves foráneas para operaciones masivas
    DB::statement('SET foreign_key_checks = 0');

    DB::transaction(function () use ($images, $imageMap) {
      // Desactivar visibilidad de categorías, subcategorías y logos de clientes
      Category::where('visible', 1)->update(['visible' => 0]);
      SubCategory::where('visible', 1)->update(['visible' => 0]);
      ClientLogos::where('visible', 1)->update(['visible' => 0]);

      // Reiniciar datos de especificaciones, galerías y productos
      Specifications::truncate();
      Galerie::truncate();
      Products::truncate();

      // Reiniciar índices de las tablas
      DB::statement('ALTER TABLE specifications AUTO_INCREMENT = 1');
      DB::statement('ALTER TABLE galeries AUTO_INCREMENT = 1');
      DB::statement('ALTER TABLE products AUTO_INCREMENT = 1');

      dump('Inició la carga masiva: ' . count($this->items) . ' items');

      foreach ($this->items as $item) {
        try {
          // Generar ruta de imagen basada en el patrón
          $imageRoute = \str_replace('{1}', $item[1], $this->image_route_pattern);
          $imageRoute = \str_replace('{10}', $item[10], $imageRoute);

          $productImages = array_filter($images, fn($image) => isset($imageMap[$imageRoute]));

          // Buscar o crear categoría
          $category = Category::updateOrCreate(
            ['name' => $item[5]],
            ['slug' => Str::slug($item[5]), 'visible' => 1]
          );

          // Buscar o crear subcategoría
          $subcategory = SubCategory::updateOrCreate(
            ['category_id' => $category->id, 'name' => $item[6]],
            ['slug' => Str::slug($item[6]), 'visible' => 1]
          );

          // Buscar o crear marca
          $brand = ClientLogos::updateOrCreate(
            ['title' => $item[7]],
            ['visible' => 1]
          );

          // Buscar descuento si aplica
          $discount = Discount::where('name', $item[15])->where('status', true)->first();

          // Calcular porcentaje de descuento
          $price = \floatval($item[8]);
          $discountValue = $item[9] == '' ? 0 : floatval($item[9]);
          $percent = $discountValue > 0 ? (1 - ($discountValue / $price)) * 100 : 0;

          // Crear o actualizar producto
          $product = Products::updateOrCreate(
            ['sku' => $item[0]],
            [
              'codigo' => $item[1],
              'producto' => $item[2],
              'extract' => $item[3],
              'description' => $item[4],
              'categoria_id' => $category->id,
              'subcategory_id' => $subcategory->id,
              'marca_id' => $brand->id,
              'precio' => $price,
              'descuento' => $discountValue,
              'color' => $item[10],
              'peso' => $item[12],
              'stock' => $item[13],
              'discount_id' => $discount?->id,
              'visible' => 1,
              'percent_discount' => $percent
            ]
          );

          // Asociar imágenes al producto
          $i = 0;
          Galerie::where('product_id', $product->id)->delete(); // Limpiar imágenes previas
          if (count($productImages) == 0) {
            $product->visible = 0; // Marcar producto como invisible si no tiene imágenes
            $product->save();
          } else {
            foreach ($productImages as $image) {
              $productImage = 'storage/images/products/' . $image;
              if ($i == 0) {
                $product->imagen = $productImage;
                $product->save();
              } else {
                Galerie::create(['product_id' => $product->id, 'imagen' => $productImage]);
              }
              $i++;
            }
          }

          // Asociar etiquetas al producto
          $tags = array_filter(array_map('trim', explode(',', $item[14] ?? '')));
          ProductTag::where('producto_id', $product->id)->delete(); // Limpiar etiquetas previas
          foreach ($tags as $tagName) {
            if (Text::nullOrEmpty($tagName)) continue;
            $tag = Tag::firstOrCreate(['name' => $tagName], ['slug' => Str::slug($tagName), 'status' => true, 'visible' => true]);
            ProductTag::create(['producto_id' => $product->id, 'tag_id' => $tag->id]);
          }

          // Asociar especificaciones al producto
          if (!Text::nullOrEmpty($item[11])) {
            Specifications::updateOrCreate(
              ['product_id' => $product->id, 'tittle' => 'Color (HEX)'],
              ['specifications' => $item[11]]
            );
          }

          dump("Producto cargado: {$product->producto}");
        } catch (\Throwable $th) {
          dump("Error en SKU {$item[0]}: " . $th->getMessage());
        }
      }

      dump('Finalizó la carga masiva');
    });

    // Restaurar restricciones de claves foráneas
    DB::statement('SET foreign_key_checks = 1');
  }

}
