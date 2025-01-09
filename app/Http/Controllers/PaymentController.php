<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Offer;
use App\Models\Price;
use App\Models\Products;
use App\Models\Sale;
use App\Models\SaleDetail;
use Culqi\Culqi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SoDe\Extend\JSON;
use SoDe\Extend\Response;

class PaymentController extends Controller
{
  public function culqi(Request $request)
  {
    $body = $request->all();
    $response = new Response();
    $culqi = new Culqi(['api_key' => env('CULQI_PRIVATE_KEY')]);

    $sale = new Sale();
    try {

      $products = array_filter($body['cart'], fn($x) => !(isset($x['isCombo']) && $x['isCombo'] == true));
      $offers = array_filter($body['cart'], fn($x) => isset($x['isCombo']) && $x['isCombo'] == true);

      $productsJpa = [];

      if (Auth::check() && Auth::user()->hasRole('Reseller')) {

        $productsJpa = Products::select(['id', 'imagen', 'producto', 'color', 'precio', 'precio_reseller as descuento'])
          ->whereIn('id', array_map(fn($x) => $x['id'], $products))
          ->get();
      } else {
        $productsJpa = Products::select(['id', 'imagen', 'producto', 'color', 'precio', 'descuento'])
          ->whereIn('id', array_map(fn($x) => $x['id'], $products))
          ->get();
      }


      $offersJpa = [];
      if (count($offers) > 0) {
        $offersJpa = Offer::select(['id', 'imagen', 'producto', DB::raw('null AS color'), 'precio', 'descuento'])
          ->whereIn('id', array_map(fn($x) => $x['id'], $offers))
          ->get();
      }


      $totalCost = 0;
      foreach ($productsJpa as $productJpa) {
        $key = array_search($productJpa->id, array_column($body['cart'], 'id'));
        if ($body['cart'][$key]['quantity'] == 0) continue;
        if ($productJpa->descuento > 0) {
          $totalCost += $productJpa->descuento * $body['cart'][$key]['quantity'];
        } else {
          $totalCost += $productJpa->precio * $body['cart'][$key]['quantity'];
        }
      }

      foreach ($offersJpa as $offerJpa) {
        $key = array_search($offerJpa->id, array_column($body['cart'], 'id'));
        if ($body['cart'][$key]['quantity'] == 0) continue;
        if ($offerJpa->descuento > 0) {
          $totalCost += $offerJpa->descuento * $body['cart'][$key]['quantity'];
        } else {
          $totalCost += $offerJpa->precio * $body['cart'][$key]['quantity'];
        }
      }

      $sale->name = $body['contact']['name'];
      $sale->lastname = $body['contact']['lastname'];
      $sale->email = Auth::check() ? Auth::user()->email : $body['contact']['email'];
      $sale->phone = $body['contact']['phone'];
      $sale->address_price = 0;
      $sale->total = $totalCost;
      $sale->tipo_comprobante = $body['tipo_comprobante'];
      $sale->doc_number = $body['contact']['doc_number'] ?? null;
      $sale->razon_fact = $body['contact']['razon_fact'] ?? null;
      $sale->direccion_fact = $body['contact']['direccion_fact'] ?? null;
      $sale->code = '000000000000';

      if ($request->address) {
        $price = Price::with([
          'district',
          'district.province',
          'district.province.department'
        ])
          ->where('prices.id', $body['address']['id'])
          ->first();

        if ($price) {
          $totalCost += $price->price;

          $sale->address_department = $price->district->province->department->description;
          $sale->address_province = $price->district->province->description;
          $sale->address_district = $price->district->description;
          $sale->address_street = $body['address']['street'];
          $sale->address_number = $body['address']['number'];
          $sale->address_description = $body['address']['description'];
          $sale->address_price = $price->price;
          try {
            if ($request->saveAddress) {
              Address::create([
                'email' =>  Auth::check() ? Auth::user()->email : $body['contact']['email'],
                'price_id' => $price->id,
                'street' =>  $body['address']['street'],
                'number' => $body['address']['number'],
                'description' => $body['address']['description'],
              ]);
            }
          } catch (\Throwable $th) {
            // dump('No se pudo guardar la direccion', $th);
          }
        }
      }

      $sale->status_id = 1;
      $sale->status_message = 'La venta se ha creado. Aun no se ha pagado';

      $sale->save();

      foreach ($productsJpa as $productJpa) {
        $key = array_search($productJpa->id, array_column($body['cart'], 'id'));
        $quantity = $body['cart'][$key]['quantity'];
        if ($quantity == 0) continue;
        $price = $productJpa->descuento > 0 ? $productJpa->descuento : $productJpa->precio;

        SaleDetail::create([
          'sale_id' => $sale->id,
          'product_image' => $productJpa->imagen,
          'product_name' => $productJpa->producto,
          'product_color' => $productJpa->color,
          'quantity' => $quantity,
          'price' => $price
        ]);
      }

      foreach ($offersJpa as $offerJpa) {
        $key = array_search($offerJpa->id, array_column($body['cart'], 'id'));
        $quantity = $body['cart'][$key]['quantity'];
        if ($quantity == 0) continue;
        $price = $offerJpa->descuento > 0 ? $offerJpa->descuento : $offerJpa->precio;

        $name = '<b>' . $offerJpa->producto . '</b><ul class="mb-1">';

        foreach ($offerJpa->products as $productJpa) {
          $name .= '<li class="text-xs text-nowrap overflow-hidden text-ellipsis w-[270px]">' . $productJpa->producto . '</li>';
        }

        $name .= '</ul>';

        SaleDetail::create([
          'sale_id' => $sale->id,
          'product_image' => $offerJpa->imagen,
          'product_name' => $name,
          'product_color' => $offerJpa->color,
          'quantity' => $quantity,
          'price' => $price
        ]);
      }




      $config = [
        "amount" => round($totalCost * 100),
        "capture" => true,
        "currency_code" => "PEN",
        "description" => "Compra en " . env('APP_NAME'),
        "email" => $body['culqi']['email'] ?? $body['contact']['email'],
        "installments" => 0,
        "antifraud_details" => [
          "address" => isset($request['address']['street']) ? $request['address']['street'] : 'Sin direccion',
          "address_city" => isset($request['address']['city']) ? $request['address']['city'] : 'Sin ciudad',
          "country_code" => "PE",
          "first_name" => $request['contact']['name'],
          "last_name" => $request['contact']['lastname'],
          "phone_number" => $request['contact']['phone'],
        ],
        "source_id" => $request['culqi']['id']
      ];

      $charge = $culqi->Charges->create($config);

      if (gettype($charge) == 'string') {
        $res = JSON::parse($charge);
        throw new Exception($res['user_message']);
      }

      $response->status = 200;
      $response->message = "Cargo creado correctamente";
      $response->data = [
        'charge' => $charge,
        'reference_code' => $charge?->reference_code ?? null,
        'amount' => $totalCost
      ];

      $sale->status_id = 3;
      $sale->status_message = 'La venta se ha generado y ha sido pagada';
      $sale->code = $charge?->reference_code ?? null;

      $indexController = new IndexController();
      $datacorreo = [
        'nombre' => $sale->name . ' ' . $sale->lastname,

        'email' => $sale->email,

      ];
      $indexController->envioCorreoCompra($datacorreo);
    } catch (\Throwable $th) {
      $response->status = 400;
      $response->message = $th->getMessage();

      if (!$sale->code) {
        $sale->code = '000000000000';
      }
      $sale->status_id = 2;
      $sale->status_message = $th->getMessage();
    } finally {

      $sale->save();
      return response($response->toArray(), $response->status);
    }
  }
}
