<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use SoDe\Extend\Crypto;
use SoDe\Extend\Fetch;
use SoDe\Extend\Math;
use SoDe\Extend\Response;

class IzipayController extends Controller
{
    public static function token(Sale $sale)
    {

        $clientId = env('IZIPAY_CLIENT_ID');
        $clientSecret = env('IZIPAY_CLIENT_SECRET');
        $auth = base64_encode($clientId . ':' . $clientSecret);

        $url = env('IZIPAY_URL');

        $totalAmount = $sale->total + $sale->address_price;

        $attempts = 0;
        $maxAttempts = 3;
        $data = null;

        while ($attempts < $maxAttempts) {
            $res = new Fetch($url, [
                'method' => 'POST',
                'headers' => [
                    'Authorization' => 'Basic ' . $auth,
                    'Content-Type' => 'application/json',
                ],
                'body' => [
                    'amount' => Math::round($totalAmount * 100),
                    'currency' => 'PEN',
                    'orderId' => $sale->code,
                    'customer' => [
                        'email' => $sale->email,
                    ],
                ]
            ]);

            if ($res->ok) {
                $data = $res->json();
                break; // Salir del bucle si la respuesta es ok
            }

            $attempts++;
        }

        return $data && isset($data['answer']) && isset($data['answer']['formToken']) ? $data['answer']['formToken'] : null; // Retornar null si no se obtuvo un token
    }
}
