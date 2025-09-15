<?php

namespace App\Http\Controllers;

use App\Http\Classes\dxResponse;
use App\Models\dxDataGrid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SoDe\Extend\Response;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener solo usuarios con el rol 'Customer'
        $clients = User::whereHas('roles', function ($query) {
            $query->where('name', 'Customer');
        })->get();

        return view('pages.clients.index', compact('clients'));
    }

    /**
     * Paginate clients for DataGrid
     */
    public function paginate(Request $request)
    {
        $response = new dxResponse();
        try {
            $instance = User::select([
                'users.*'
            ])
            ->with(['roles', 'direccion.department', 'direccion.province', 'direccion.district'])
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Customer');
            });

            if ($request->group != null) {
                [$grouping] = $request->group;
                $selector = \str_replace('.', '__', $grouping['selector']);
                $instance = User::select([
                    "{$selector} AS key"
                ])
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'Customer');
                })
                ->groupBy($selector);
            }

            if ($request->filter) {
                $instance->where(function ($query) use ($request) {
                    dxDataGrid::filter($query, $request->filter ?? [], false);
                });
            }

            if ($request->sort != null) {
                foreach ($request->sort as $sorting) {
                    $selector = $sorting['selector'];
                    $instance->orderBy(
                        $selector,
                        $sorting['desc'] ? 'DESC' : 'ASC'
                    );
                }
            } else {
                $instance->orderBy('users.id', 'DESC');
            }

            $totalCount = 0;
            if ($request->requireTotalCount) {
                $totalCount = $instance->count();
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = User::with([
            'roles', 
            'direccion.department', 
            'direccion.province', 
            'direccion.district',
            'wishlistItems.products'
        ])
        ->whereHas('roles', function ($query) {
            $query->where('name', 'Customer');
        })
        ->findOrFail($id);

        return view('pages.clients.show', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateVisible(Request $request)
    {
        $id = $request->id;
        $field = $request->field;
        $status = $request->status;

        // Verificar si el cliente existe
        $client = User::find($id);

        if (!$client) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        // Actualizar el campo dinámicamente
        $client->update([
            $field => $status
        ]);

        return response()->json(['message' => 'Cliente actualizado']);
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function borrar(Request $request)
    {
        $client = User::find($request->id);
        
        // En lugar de un campo status, podemos desactivar removiendo roles o usando otros métodos
        // Por ahora solo eliminaremos el rol Customer
        $client->removeRole('Customer');

        return response()->json(['message' => 'Cliente desactivado correctamente']);
    }
}