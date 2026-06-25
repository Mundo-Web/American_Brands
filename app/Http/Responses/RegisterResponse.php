<?php

namespace App\Http\Responses;

use App\Helpers\EmailConfig;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;


class RegisterResponse implements RegisterResponseContract
{

    public function toResponse($request)
    {
        $role = Auth::user()->roles->pluck('name');
        $usuario = Auth::user();
        
        if ($request->wantsJson()) {
            return response()->json(['two_factor' => false]);
        }

        Session::flash('welcome_message', "¡Bienvenido, {$usuario->name}!");
        
        switch ($role[0]) {
            case 'Admin':
                return redirect()->intended(config('fortify.home'));
            case 'Customer':
                $this-> envioCorreo($usuario);
                return redirect()->intended(config('fortify.home_public'));
            default:
                return redirect()->intended(config('fortify.home_public'));
        }
    }



    private function envioCorreo($data){
        
        $appUrl = config('app.url');
        $name = $data['name'];
        $mensaje = "Gracias por registrarse en " . config('app.name');
        $mail = EmailConfig::config($name, $mensaje);
        try {
            $mail->addAddress($data['email']);
            $mail->Body = '<html lang="es">
            <head>
              <meta charset="UTF-8" />
              <meta name="viewport" content="width=device-width, initial-scale=1.0" />
              <title>Mundo web</title>
              <link rel="preconnect" href="https://fonts.googleapis.com" />
              <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
              <link
                href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
                rel="stylesheet"
              />
              <style>
                * {
                  margin: 0;
                  padding: 0;
                  box-sizing: border-box;
                }
              </style>
            </head>
            <body>
              <main>
                <table
                  style="
                    width: 600px;
                    height: 700px;
                    margin: 0 auto;
                    text-align: center;
                    background-image:url(' . $appUrl . '/images/Ellipse_18.png),  url(' . $appUrl . '/images/Tabpanel.png);
                  background-repeat: no-repeat, no-repeat;
                  background-position: center bottom , center bottom;;
                  background-size: fit , fit;
                  background-color: #f9f9f9;
                  "
                >
                  <thead>
                    <tr>
                      <th
                        style="
                          display: flex;
                          flex-direction: row;
                          justify-content: center;
                          align-items: center;
                          margin: 40px;
                        "
                      >
                        <img src="' . $appUrl . '/images/Group1.png" alt="Boost_Peru"  style="
                    margin: auto;
                  "/>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="height: 10px">
                        <p
                          style="
                            color: #ffffff;
                            font-weight: 500;
                            font-size: 18px;
                            text-align: center;
                            width: 500px;
                            margin: 0 auto;
                            font-family: Montserrat, sans-serif;
                            line-height: 30px;
                          "
                        >
                          <span style="display: block">Hola </span>
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td style="height: 10px">
                        <p
                          style="
                            color: #ffffff;
                            font-size: 40px;
                            font-family: Montserrat, sans-serif;
                            line-height: 60px;
                          "
                        >
                          <span style="display: block">' . $name . ' </span>
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td style="height: 10px">
                        <p
                          style="
                            color: #006BF6;
                            font-size: 40px;
                            font-family: Montserrat, sans-serif;
                            font-weight: bold;
                            line-height: 60px;
                          "
                        >
                          !Gracias
                          <span style="color: #ffffff">por escribirnos!</span>
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td style="height: 10px">
                        <p
                          style="
                            color: #ffffff;
                            font-weight: 500;
                            font-size: 18px;
                            text-align: center;
                            width: 250px;
                            margin: 0 auto;
                            font-family: Montserrat, sans-serif;
                            line-height: 30px;
                          "
                        >
                          En breve estaremos comunicandonos contigo.
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td
                        style="
                          display: flex;
                          align-items: start;
                          justify-content: center;
                          padding-top: 20px;
                        "
                      >
                        <a
                      href="' . $appUrl . '"
                      style="
                        text-decoration: none;
                        background-color: #006bf6;
                        color: white;
                        padding: 10px 16px;
                        display: inline-flex;
                        justify-content: center;
                        align-items: center;
                        gap: 10px;
                        font-weight: 600;
                        font-family: Montserrat, sans-serif;
                        font-size: 16px;
                        border-radius: 30px;
                      "
                    >
                      <span>Visita nuestra web</span>
                    </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </main>
            </body>
          </html>
          ';
            $mail->isHTML(true);
            $mail->send();
            
        } catch (\Throwable $th) {
            //throw $th;
        }
}

}