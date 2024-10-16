<?php

namespace App\Http\Controllers;

use App\Models\ClientLogos;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\FlareClient\Http\Client;

class LogosClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logos = ClientLogos::where("status", "=", true)->get();
        return view('pages.logos.index', compact('logos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
       
        return view('pages.logos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
        ]);

        $post = new ClientLogos();

        if($request->hasFile("imagen")){
           
            $manager = new ImageManager(new Driver());
            
            $nombreImagen = Str::random(10) . '_' . $request->file('imagen')->getClientOriginalName();
               
            $img =  $manager->read($request->file('imagen'));
       
            $ruta = 'storage/images/logos/';
            if (!file_exists($ruta)) {
                mkdir($ruta, 0777, true); // Se crea la ruta con permisos de lectura, escritura y ejecución
            }
            
            $img->save($ruta.$nombreImagen);
            $post->url_image =  $ruta.$nombreImagen; 
        }


        if($request->hasFile("imagen2")){
           
            $manager = new ImageManager(new Driver());
            
            $nombreImagen = Str::random(10) . '_' . $request->file('imagen2')->getClientOriginalName();
               
            $img =  $manager->read($request->file('imagen2'));
       
            $ruta = 'storage/images/logos/';
            if (!file_exists($ruta)) {
                mkdir($ruta, 0777, true); // Se crea la ruta con permisos de lectura, escritura y ejecución
            }
            
            $img->save($ruta.$nombreImagen);
            $post->url_image2 =  $ruta.$nombreImagen; 
        }



        $post->title = $request->title;
        $post->description = $request->description;
        
        $post->status = 1;

       

        $post->save();
        return redirect()->route('logos.index')->with('success', 'Publicación creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       

        
    }

    function deleteLogo(Request $request) {

        $logo = ClientLogos::findOrfail($request->id); 
        
        
    
        // Eliminar la imagen si existe
        if ($logo->url_image && file_exists($logo->url_image)) {
            unlink($logo->url_image);
        }

        // Eliminar el logo de la base de datos
        $logo->delete();
        return response()->json(['message'=>'Logo eliminado']);
    }



    public function updateVisible(Request $request)
    {
        // Lógica para manejar la solicitud AJAX
        $cantidad = $this->contarCategoriasDestacadas();


        if ($cantidad >= 10000 && $request->status == 1) {
            return response()->json(['message' => 'Solo puedes destacar 10000 categorias'], 409);
        }


        $id = $request->id;

        $field = $request->field;

        $status = $request->status;

        $category = ClientLogos::findOrFail($id);

        $category->$field = $status;

        $category->save();

        $cantidad = $this->contarCategoriasDestacadas();


        return response()->json(['message' => 'Marca modificada',  'cantidad' => $cantidad]);
    }


    public function contarCategoriasDestacadas()
    {

        $cantidad = ClientLogos::where('destacar', '=', 1)->count();

        return  $cantidad;
    }
}
