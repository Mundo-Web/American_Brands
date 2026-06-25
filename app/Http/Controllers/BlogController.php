<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Tag;
use Illuminate\Http\Request;


use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $posts = Blog::where('status', '=', true)->where('visible', '=', true)->get();

    return view('pages.blog.index', compact('posts'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $categories = Category::where('status', '=', true)->where('visible', '=', true)->get();
    
    return view('pages.blog.create', compact('categories'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function saveImg($file, $route, $nombreImagen)
  {
      $manager = new ImageManager(new Driver());
      $img = $manager->read($file);
      // $img->coverDown(672, 700, 'center');
      if (!file_exists($route)) {
          mkdir($route, 0777, true); // Se crea la ruta con permisos de lectura, escritura y ejecución
      }
      $img->save($route . $nombreImagen);
  }


  public function store(Request $request)
  {

    $appUrl = config('app.url');
    $newsletter = new NewsletterSubscriberController();
    
    $request->validate([
      'title' => 'required',
    ]);

    $post = new Blog();

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $routeImg = 'storage/images/post/';
            $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();

            $this->saveImg($file, $routeImg, $nombreImagen);

            $post->url_image = $routeImg;
            $post->name_image = $nombreImagen;
        } else {
            $routeImg = 'images/img/';
            $nombreImagen = 'noimagenslider.jpg';

            $post->url_image = $routeImg;
            $post->name_image = $nombreImagen;
        }
    $url = $request->video;
    $post->url_video = $this->getYTVideoId($url);
    $post->category_id = $request->category_id;
    $post->title = $request->title;
    $post->description = $request->description;
    $post->extract = $request->extract;
    $post->meta_title = $request->meta_title;
    $post->meta_description = $request->meta_description;
    $post->meta_keywords = $request->meta_keywords;
    $post->status = 1;
    $post->visible = 1;
    $post->save();
    
    $plantilla = '<html lang="es">
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
                height: 1050px;
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
                      <span style="display: block">' . $post->title . ' </span>
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
                     Acaba de ser publicado 
                      <span ></span>
                    </p>
                    <img src="'. $appUrl .'/'. $post->url_image . $post->name_image.'" alt="Boost_Peru"  style="
                    margin: auto; width: 500px; height: 300px; object-fit: cover; border-radius: 10px; margin-top: 20px; margin-bottom: 20px;
                  "/>
                  </td>
                </tr>
                <tr>
                  <td style="height: 10px">
                    <p
                      style="
                        
                        font-weight: 500;
                        font-size: 18px;
                        text-align: center;
                        width: 370px;
                        margin: 0 auto;
                        font-family: Montserrat, sans-serif;
                        line-height: 30px;
                      "
                    >
                      '.mb_substr($post->extract, 0, 200).' ...
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
                      href="' . $appUrl .'post/'.$post->id. '"
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
                      <span>Sigue Leyendo </span>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </main>
        </body>
      </html>
      ';


   
    //envioMasivo($plantilla, $blog)

    $newsletter->envioMasivo($plantilla);

    return redirect()->route('blog.index')->with('success', 'Publicación creado exitosamente.');
  }


  private function getYTVideoId($url)
  {
      $patterns = [
        '/(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', // URL estándar
        '/(?:https?:\/\/)?(?:www\.)?youtu\.be\/([a-zA-Z0-9_-]+)/', // URL corta
        '/(?:https?:\/\/)?(?:www\.)?youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', // URL embebida
        '/(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)(?:&.*)?/', // URL estándar con parámetros adicionales
      ];
      foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url, $matches)) {
          return $matches[1];
        }
      }
      return null;
  }
  /**
   * Display the specified resource.
   */
  public function show(Blog $blog)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  //public function edit(Blog $blog, $id)

  public function edit(Blog $blog)
  {
    
    $categories = Category::where('status', '=', true)->where('visible', '=', true)->get();
    return view('pages.blog.edit', compact('blog', 'categories'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {

    $post = Blog::find($request->id);


    if ($request->hasFile('imagen')) {
      $file = $request->file('imagen');
      $routeImg = 'storage/images/post/';
      $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();

      if ($post->url_image !== 'images/img/') {
          File::delete($post->url_image . $post->name_image);
      }

      $this->saveImg($file, $routeImg, $nombreImagen);

      $post->url_image = $routeImg;
      $post->name_image = $nombreImagen;
  }

    $url = $request->video;
    
    if ($post->url_video == $url) {
      $post->url_video == $url;
    }else{
      $post->url_video = $this->getYTVideoId($url);
    }
    
   
    $post->category_id = $request->category_id;
    $post->title = $request->title;
    $post->description = $request->description;
    $post->extract = $request->extract;
    $post->meta_title = $request->meta_title;
    $post->meta_description = $request->meta_description;
    $post->meta_keywords = $request->meta_keywords;


    $post->update();

    return redirect()->route('blog.index')->with('success', 'Post actualizado');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Blog $blog)
  {
    //
  }


  public function deleteBlog(Request $request)
  {
    //Recupero el id mandado mediante ajax
    $id = $request->id;
    //Busco el servicio con id como parametro
    $service = Blog::findOrfail($id);
    //Modifico el status a false
    $service->status = false;
    //Guardo 
    $service->save();

    // Devuelvo una respuesta JSON u otra respuesta según necesites
    return response()->json(['message' => 'Post eliminado.']);
  }



  public function updateVisible(Request $request)
  {
    // Lógica para manejar la solicitud AJAX
    //return response()->json(['mensaje' => 'Solicitud AJAX manejada con éxito']);
    $id = $request->id;

    $field = $request->field;

    $status = $request->status;

    $service = Blog::findOrFail($id);

    $service->$field = $status;

    $service->save();

    return response()->json(['message' => 'Servicio eliminado.']);
  }
}
