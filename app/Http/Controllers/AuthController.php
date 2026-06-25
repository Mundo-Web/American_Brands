<?php

namespace App\Http\Controllers;

use App\Helpers\EmailConfig;
use App\Http\Services\ReCaptchaService;
use App\Models\Constant;
use App\Models\ModelHasRoles;
use App\Models\User;
use App\Models\Person;
use App\Models\PreUser;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use SoDe\Extend\Crypto;
use SoDe\Extend\Response;
use SoDe\Extend\Trace;

class AuthController extends Controller
{

    public function confirmEmailView(Request $request, string $token)
  {
    if (Auth::check()) return redirect('/home');

    $preUserJpa = PreUser::where('token', $token)->first();
    if (!$preUserJpa) return redirect('/login');

    return Inertia::render('ConfirmEmail', [
      'email' => $preUserJpa->email
    ])->rootView('auth');
  }
    public function loginView(Request $request, string $confirmation = null)
    {
        if (Auth::check()) return redirect('/');

        if ($confirmation) {
            try {
                //code...
                $preUserJpa = PreUser::select()
                    ->with('person')
                    ->where('confirmation_token', $confirmation)
                    ->first();
                if (!$preUserJpa) return redirect('/login');

                $userJpa = User::where('person_id', $preUserJpa->person_id)->exists();
                if ($userJpa) $message = 'Este correo ya ha sido verificado anteriormente.';
                else {
                    User::create([
                        'name' => explode(' ', $preUserJpa->person->name)[0],
                        'lastname' => explode(' ', $preUserJpa->person->lastname)[0],
                        'email' => $preUserJpa->email,
                        'email_verified_at' => Trace::getDate('mysql'),
                        'password' => $preUserJpa->password,
                        'person_id' => $preUserJpa->person_id,
                        'birthdate' => $preUserJpa->birthdate,
                        'relative_id' => Crypto::randomUUID()
                    ])->assignRole('Reseller');
                    $message = 'La confirmacion se ha realizado con exito';
                }
                $preUserJpa->delete();
                return redirect('/login?message=' . $message);
            } catch (\Throwable $th) {
                return redirect('/login');
            }
        }

        return Inertia::render('Login', [
            'APP_PROTOCOL' => config('app.protocol', 'https'),
            'APP_DOMAIN' => config('app.domain'),
            'APP_URL' => config('app.url'),
            'PUBLIC_RSA_KEY' => Controller::$PUBLIC_RSA_KEY,
            'message' => $message ?? null
        ])->rootView('auth');
    }

    public function registerView()
    {
        if (Auth::check()) return redirect('/home');

        // return view('admin')
        // ->with('PUBLIC_RSA_KEY', Controller::$PUBLIC_RSA_KEY)
        // ...

        return Inertia::render('Register', [
            'APP_PROTOCOL' => config('app.protocol', 'https'),
            'PUBLIC_RSA_KEY' => Controller::$PUBLIC_RSA_KEY,
            'RECAPTCHA_SITE_KEY' => config('captcha.sitekey'),
            'APP_URL' => config('app.url'),
            'terms' => Constant::value('terms')
        ])->rootView('auth');
    }

    /*  public function login(Request $request): HttpResponse | ResponseFactory | RedirectResponse
    {
        $response = new Response();
        try {
            $email = $request->email;
            $password = $request->password;

            if (!Auth::attempt([
                'email' => Controller::decode($email),
                'password' => Controller::decode($password)
            ])) {
                throw new Exception('Credenciales invalidas');
            }

            $request->session()->regenerate();

            $response->status = 200;
            $response->message = 'Autenticacion correcta';
        } catch (\Throwable $th) {
            $response->status = 400;
            $response->message = $th->getMessage();
        } finally {
            return response(
                $response->toArray(),
                $response->status
            );
        }

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME_CUSTOMER);
    } */
    public function signup(Request $request): HttpResponse | ResponseFactory | RedirectResponse
    {
        $response = new Response();
        try {
            $request->validate([
                'document_type' => 'required|string|max:3|min:2',
                'document_number' => 'required|string|max:9|min:8',
                'name' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string',
                'confirmation' => 'required|string',
                'captcha' => 'required|string',
                'terms' => 'required|accepted'
            ]);

            $body = $request->all();

            if (!isset($request->password) || !isset($request->confirmation)) throw new Exception('Debes ingresar una contraseña para el nuevo usuario');
            if (Controller::decode($request->password) != Controller::decode($request->confirmation)) throw new Exception('Las contraseñas deben ser iguales');

            if (!ReCaptchaService::verify($request->captcha)) throw new Exception('Captcha invalido. Seguro que no eres un robot?');

            $personJpa = Person::select()
                ->where('document_type', $body['document_type'])
                ->where('document_number', $body['document_number'])
                ->first();

            if (!$personJpa) {
                $personJpa = Person::create([
                    'document_type' => $body['document_type'],
                    'document_number' => $body['document_number'],
                    'name' => $body['name'],
                    'lastname' => $body['lastname'],
                ]);
            }

            $existsUser = User::where('person_id', $personJpa->id)->exists();

            if ($existsUser) throw new Exception('Ya existe un usuario registrado con ese documento');

            $preUserJpa = PreUser::updateOrCreate([
                'email' => $body['email']
            ], [
                'email' => $body['email'],
                'password' => Controller::decode($body['password']),
                'person_id' => $personJpa->id,
                'confirmation_token' => Crypto::randomUUID(),
                'token' => Crypto::randomUUID(),
            ]);

            $content = Constant::value('confirm-email');
            $content = str_replace('{URL_CONFIRM}', config('app.url') . '/confirmation/' . $preUserJpa->confirmation_token, $content);

            $name = '';
            $mensaje = "";
            $mailer = EmailConfig::config($name, $mensaje);
            $mailer->Subject = 'Confirmacion - Boost Peru';
            $mailer->Body = $content;
            $mailer->addAddress($preUserJpa->email);
            $mailer->isHTML(true);
            $mailer->send();
            
            
            $response->status = 200;
            $response->message = 'Operacion correcta';
            $response->data = $preUserJpa->token;
        } catch (\Throwable $th) {
            $response->status = 400;
            $response->message = $th->getMessage();
            // $response->message = $th;
        } finally {
            return response(
                $response->toArray(),
                $response->status
            );
        }
    }
}
