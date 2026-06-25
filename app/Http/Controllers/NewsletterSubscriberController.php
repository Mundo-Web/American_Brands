<?php

namespace App\Http\Controllers;

use App\Helpers\EmailConfig;
use App\Models\General;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterSubscriberController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(NewsletterSubscriber $newsletterSubscriber)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(NewsletterSubscriber $newsletterSubscriber)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, String $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(NewsletterSubscriber $newsletterSubscriber)
  {
    //
  }

  public function showSubscripciones()
  {
    $subscripciones = NewsletterSubscriber::orderBy('created_at', 'desc')->get();

    return view('pages.subscripciones.index', compact('subscripciones'));
  }

  public function guardarUserNewsLetter(Request $request)
  {
    NewsletterSubscriber::create($request->all());
    $data = $request->all();
    $data['nombre'] = '';
    $this->envioCorreo($data);
    $this->envioCorreoInterno($data);
    return response()->json(['message' => 'Usuario suscrito']);
  }

  private function envioCorreo($data)
  {

    $appUrl = config('app.url');
    $appName = config('app.name');
    $name = '';
    $mensaje = "Gracias por comunicarte con $appName";
    $mail = EmailConfig::config($name, $mensaje);
    $general = General::all()->first();
    // dd($mail);
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
                height: 850px;
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
                    <img src="' . $appUrl . '/images/Group1.png" alt="img_logo"  style="
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
                        color: #006bf6;
                        font-size: 40px;
                        font-family: Montserrat, sans-serif;
                        font-weight: bold;
                        line-height: 60px;
                      "
                    >
                      Nos alegra mucho que te hayas unido a nuestra lista de suscriptores</span>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td style="height: 10px">
                    <p
                      style="
                        
                        font-weight: 500;
                        font-size: 18px;
                        text-align: center;
                        width: 250px;
                        margin: 0 auto;
                        font-family: Montserrat, sans-serif;
                        line-height: 30px;
                      "
                    >
                       Pronto recibirás nuestras últimas noticias, artículos y promociones directamente en tu correo. 
                    </p>
                  </td>
                </tr>
                <tr>
                  <td
                    style="
                    text-align: center;
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
      // dump($th);
    }
  }

  private function envioCorreoInterno($data)
  {
    /* $name = $data['full_name']; */
    $name = 'Tienes un nuevo mensaje,';
    $mensaje = 'MIC&JS';
    $mail = EmailConfig::config($name, $mensaje);
    $emailCliente = General::all()->first();
    $general = General::all()->first();

    try {
      $mail->addAddress($emailCliente->email);
      $mail->Body =
        '<html lang="en">
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
                    margin: 0 auto;
                    text-align: center;
                    background-image: url(https://micjc.mundoweb.pe/mailing/ImagenFondo.png);
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: cover;
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
                          padding:0 80px;
                        "
                      >
                        <img
                          src="https://micjc.mundoweb.pe/mailing/Logo.png"
                          alt="dimension lider"
                        />
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <p
                          style="
                            color: #ffffff;
                            font-weight: 500;
                            font-size: 18px;
                            text-align: center;
                            width: 500px;
                            margin: 0 auto;
                            padding: 20px 0;
                            font-family: Montserrat, sans-serif;
                          "
                        >
                          <span style="display: block">Hola MIC&JC</span>
                          <span style="display: block">Tienes un nuevo mensaje</span>
                        </p>
                      </td>
                    </tr>
                    
                    <tr>
                      <td>
                        <a
                          target="_blank"
                          href="https://micjc.mundoweb.pe/"
                          style="
                            text-decoration: none;
                            background-color: #fdfefd;
                            color: #254f9a;
                            padding: 16px 20px;
                            display: inline-flex;
                            justify-content: center;
                            border-radius: 10px;
                            align-items: center;
                            gap: 10px;
                            font-weight: 600;
                            font-family: Montserrat, sans-serif;
                            font-size: 16px;
                            
                          "
                        >
                          <span>Visita nuestra web</span>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td style="text-align: center">
                        <img
                          src="https://micjc.mundoweb.pe/mailing/producto.png"
                          alt="MICJC"
                          style="width: 80%"
                        />
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <a
                          href="https://' .
        htmlspecialchars($general->facebook, ENT_QUOTES, 'UTF-8') .
        '"
                          target="_blank"
                          style="padding: 0 5px 30px 0; display: inline-block"
                        >
                          <img src="https://micjc.mundoweb.pe/mailing/facebook.png" alt=""
                        /></a>
          
                        <a
                          href="https://' .
        htmlspecialchars($general->instagram, ENT_QUOTES, 'UTF-8') .
        '"
                          target="_blank"
                          style="padding: 0 5px 30px 0; display: inline-block"
                        >
                          <img src="https://micjc.mundoweb.pe/mailing/instagram.png" alt=""
                        /></a>
          
                        <a
                          href="https://' .
        htmlspecialchars($general->twitter, ENT_QUOTES, 'UTF-8') .
        '"
                          target="_blank"
                          style="padding: 0 5px 30px 0; display: inline-block"
                        >
                          <img src="https://micjc.mundoweb.pe/mailing/twitter.png" alt=""
                        /></a>
          
                        <a
                          href="https://' .
        htmlspecialchars($general->linkedin, ENT_QUOTES, 'UTF-8') .
        '"
                          target="_blank"
                          style="padding: 0 5px 30px 0; display: inline-block"
                        >
                          <img src="https://micjc.mundoweb.pe/mailing/linkedin.png" alt=""
                        /></a>
          
                        <a
                          href="https://' .
        htmlspecialchars($general->youtube, ENT_QUOTES, 'UTF-8') .
        '"
                          target="_blank"
                          style="padding: 0 5px 30px 0; display: inline-block"
                        >
                          <img src="https://micjc.mundoweb.pe/mailing/youtube.png" alt=""
                        /></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </main>
            </body>
          </html>';
      $mail->isHTML(true);
      $mail->send();
    } catch (\Throwable $th) {
      //throw $th;
    }
  }

  public function envioMasivo($plantilla){
    try {
      //code...
      $subscripciones = NewsletterSubscriber::all();
      $general = General::all()->first();
      $appUrl = config('app.url');
      $name = '';
      $mensaje = config('app.name'). 'Acaba de publicar un nuevo post ';
      $mail = EmailConfig::config($name, $mensaje);
      $mail->Subject = 'Nuevo Post Publicado';
      $mail->Body = $plantilla;
      $mail->isHTML(true);
      foreach ($subscripciones as $subscripcion) {
        $mail->addBCC($subscripcion->email);
        
      }
      $mail->send();
      return response()->json(['message' => 'Correo enviado']);
    } catch (\Throwable $th) {
      //throw $th;
      // dump($th);
    }
   
  }
}
