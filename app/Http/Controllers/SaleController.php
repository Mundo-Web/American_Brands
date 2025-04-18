<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Classes\dxResponse;
use App\Models\ClientLogos;
use App\Models\Cupon;
use App\Models\dxDataGrid;
use App\Models\HistoricoCupon;
use App\Models\Price;
use App\Models\Products;
use App\Models\SaleDetail;
use App\Models\Status;
use App\Models\User;
use App\Models\UserDetails;
use Exception;
use SoDe\Extend\JSON;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use SoDe\Extend\Response;
use Throwable;

class SaleController extends Controller
{

    public function index(Request $request)
    {
        $statuses = Status::with('sales')->get();
        $cupones = Cupon::all();

        return view('pages.pedidos.index', compact('statuses', 'cupones'));
    }

    public function save(Request $request)
    {   
        $response = Response::simpleTryCatch(function () use ($request) {
            
            $cart = ProductsController::process($request->cart);
            $address = $request->address ?? [];
            $invited = $request->datos ?? [];
            $cuponData = is_array($request->cupon) ? $request->cupon : [];
            $Islogueado = $request->autenticado ?? false;
            
            if (empty($address['district_id']) || empty($address['street'])) {
                throw new Exception("La dirección no es válida");
            }

            $priceJpa = Price::find($address['price_id'] ?? null);
            $delivery = $priceJpa ? $priceJpa->price : 0;

            $microtime = microtime(true);
            $fechaActual = date('YmdHis');
            $microsegundos = sprintf("%06d", ($microtime - floor($microtime)) * 1000000);
            $orderId = $fechaActual . $microsegundos;

            
            // Verificar/crear usuario
            $existeUser = UserDetails::where('email', $invited['email'])->get()->toArray();
            // $user = auth()->user();
            // $email = $invited['email'] ?? ($user ? $user->email : null);
            // if (!$email) {
            //     throw new Exception("El correo electrónico es requerido");
            // }

            if (count($existeUser) === 0) {
                UserDetails::create([
                    'email' => $invited['email'],
                    'departamento_id' => $address['department_id'] ?? '-',
                    'provincia_id' => $address['province_id'] ?? '-',
                    'distrito_id' => $address['district_id'] ?? '-',
                    'dir_av_calle' => $address['street'] ?? '-',
                    'dir_numero' => $address['number'] ?? '-',
                    'dir_bloq_lote' => $address['description'] ?? '-',
                ]);   
                // return response()->json(['message' => 'Data procesada correctamente']);
            }else{
                
                // $existeUsuario = User::where('email', $invited['email'])->first();
               
                // if ($existeUsuario) {
                //     $user = Auth::user();

                //     if (!$user || $user->email === null) { 
                //         throw new Exception("Por favor regístrese e inicie sesión");
                //     } else {
                //         return response()->json(['message' => 'Todos los datos están correctos']);
                //     }
                    
                // } else { 
                    $userdetailU = UserDetails::where('email', $invited['email'])->first();
                    $userdetailU->update([
                        'email' => $invited['email'],
                        'departamento_id' => $address['department_id'] ?? '-',
                        'provincia_id' => $address['province_id'] ?? '-',
                        'distrito_id' => $address['district_id'] ?? '-',
                        'dir_av_calle' => $address['street'] ?? '-',
                        'dir_numero' => $address['number'] ?? '-',
                        'dir_bloq_lote' => $address['description'] ?? '-',
                    ]);
                // }

            }

            
            $idcupon = $cuponData['idcupon'] ?? 0;
            $descuento = 0;
            $hoyFecha = date('Y-m-d');
            $totalparcial = array_sum(array_map(fn($item) => $item['totalPrice'], $cart));

            $cupon = Cupon::where('id', '=', $idcupon)->where('fecha_caducidad', '>=', $hoyFecha)->where('status', 1)->where('visible', 1)->first();
            // $Usoesecupon =  HistoricoCupon::where('cupones_id', $cupon->id)->where('usado', true)->first();
            
            if ($cupon) {
                if ($cupon->porcentaje === 1) {
                    $descuento = ($totalparcial * (float) $cupon->monto) / 100; // Si el cupón es porcentual
                } else {
                    $descuento = (float) $cupon->monto; // Si el cupón es un monto fijo
                }
            }

            $totalfinal = $totalparcial - $descuento;
            $saleJpa = new Sale();
            $saleJpa->code = $orderId;
            $saleJpa->name = $user->name ?? '-';
            $saleJpa->lastname = $user->lastname ?? '-';
            $saleJpa->email = $user->email ?? $invited['email'];
            $saleJpa->phone = $user->phone ?? '-';
            $saleJpa->idcupon = $idcupon ?? 0;
            $saleJpa->cupon_monto = $descuento ?? 0;
            $saleJpa->subtotal = $totalparcial ?? 0;
            $saleJpa->address_department = $address['department'] ?? '-';
            $saleJpa->address_province = $address['province'] ?? '-';
            $saleJpa->address_district = $address['district'] ?? '-';
            $saleJpa->address_price = $delivery;
            $saleJpa->address_street = $address['street'] ?? '-';
            $saleJpa->address_number = $address['number'] ?? '-';
            $saleJpa->address_description = $address['description'] ?? '-';
            $saleJpa->total = $totalfinal;
            $saleJpa->status_id = 1;
            $saleJpa->status_message = 'La orden ha sido creada - Aún no se ha realizado un pago';
            $saleJpa->save();

            foreach ($cart as $item) {

                $detailJpa = new SaleDetail();
                $detailJpa->sale_id = $saleJpa->id;
                $detailJpa->product_image = $item['imagen'];
                $detailJpa->product_name = $item['producto'];
                $detailJpa->quantity = $item['cantidad'];
                $detailJpa->price = $item['precio'];
                $detailJpa->final_price = $item['totalPrice'];
                $detailJpa->product_id = $item['id'];
                $detailJpa->product_color = $item['color'];
                $detailJpa->talla = $item['peso'];
                

                if (!empty($item['marca_id'])) {
                    $clientLogo = ClientLogos::find($item['marca_id']);
                    if ($clientLogo) {
                        $detailJpa->marca = $clientLogo->title;
                    } else {
                        $detailJpa->marca = null;
                    }
                } else {
                    $detailJpa->marca = null;
                }

                $detailJpa->save();
            }
            return $saleJpa;
        });

        return \response($response->toArray(), $response->status);
    }

    public function updateBilling(Request $request) {
        
        $response = Response::simpleTryCatch(function () use ($request) {
            $userdetailU = UserDetails::where('email', $request->email)->first();
            
            if ($userdetailU) {
                $userdetailU->update([
                    'nombre' => $request->name ?? '-',
                    'apellidos' => $request->lastname ?? '-',
                    'phone' => $request->phone ?? '-',
                ]);
            }
            
            $saleJpa = Sale::where('code', $request->ordenId)->first();
            $saleJpa->name = $request->name;
            $saleJpa->lastname = $request->lastname;
            $saleJpa->phone = $request->phone;
            $saleJpa->tipo_comprobante = $request->billing_type;
            $saleJpa->doc_number = $request->billing_number;
            $saleJpa->razon_fact = $request->billing_name;
            $saleJpa->direccion_fact = $request->billing_address;
            $saleJpa->save();
        });

        return response($response->toArray(), $response->status);
    }

    public function paginate(Request $request): HttpResponse|ResponseFactory
    {   
        $estado = $request->estado ?? 0;
        $response =  new dxResponse();
        try {
            $instance = Sale::select()->with(['status','cupon']);
            
            if ($estado !== null && $estado != 0) {
                $instance->where('status_id', $estado);
            }

            if ($request->group != null) {
                [$grouping] = $request->group;
                
                $selector = \str_replace('.', '_', $grouping['selector']);
                $instance = Sale::select([
                    "{$selector} AS key"
                ])->with('status')
                    ->groupBy($selector);

            }
            
            if (!Auth::user()->hasRole('Admin') || $request->data == 'mine') {
                $instance->where('email', Auth::user()->email);
            }
            
            if ($request->filter) {
                $instance->where(function ($query) use ($request) {
                    dxDataGrid::filter($query, $request->filter ?? []);
                });
            }

            if ($request->sort != null) {
                foreach ($request->sort as $sorting) {
                    $selector = \str_replace('.', '__', $sorting['selector']);
                    $instance->orderBy(
                        $selector,
                        $sorting['desc'] ? 'DESC' : 'ASC'
                    );
                }
            } else {
                $instance->orderBy('id', 'DESC');
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

            $results = [];

            foreach ($jpas as $jpa) {
                $result = JSON::unflatten($jpa->toArray(), '__');
                $results[] = $result;
            }

            $response->status = 200;
            $response->message = 'Operación correcta';
            $response->data = $results;
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

    public function confirmation(Request $request): HttpResponse|ResponseFactory
    {
        $response =  new Response();
        try {
            $sale = Sale::findOrfail($request->id);

            if ($request->field == 'client') {
                $sale->confirmation_client = true;
                $sale->confirmation_user = true;
            } else if ($request->field == 'user') {
                $sale->confirmation_user = true;
                if (!User::where('email', $sale->email)->exists()) {
                    $sale->confirmation_client = true;
                }
            }

            $sale->save();

            $response->status = 200;
            $response->message = 'Operación correcta';
        } catch (Throwable $th) {
            $response->status = 400;
            $response->message = $th->getMessage();
        } finally {
            return response(
                $response->toArray(),
                $response->status
            );
        }
    }

    public function status(Request $request): HttpResponse|ResponseFactory
    {
        $response =  new Response();
        try {
            $sale = Sale::findOrfail($request->id);

            $sale->status_id = $request->status_id;
            $sale->save();

            $response->status = 200;
            $response->message = 'Operación correcta';
        } catch (Throwable $th) {
            $response->status = 400;
            $response->message = $th->getMessage();
        } finally {
            return response(
                $response->toArray(),
                $response->status
            );
        }
    }
}
