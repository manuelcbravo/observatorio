<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
use App\Models\cat_colonia;
use App\Models\cat_estado;
use App\Models\cat_municipio;
use App\Models\CatTipoReporte;

use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.home.index',
            [
                'estados' => cat_estado::where('id', 13)->orderBy('estado', 'asc')->get(),
                'municipios' => cat_municipio::where('id_estado', 13)->orderBy('municipio', 'asc')->get(),
                'tipo_reporte' => CatTipoReporte::orderBy('nombre', 'asc')->get()
            ]
        );
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
        try {
            $rules = [
                'nombre_contacto' => 'nullable|string|max:255',
                'telefono_contacto' => 'nullable|string|max:20',
                'facebook' => 'nullable|url',
                'twitter' => 'nullable|url',
                'instagram' => 'nullable|url',
                'anonimo' => 'boolean',
                'tipo_reporte_id' => 'nullable|integer',
                'estado_id' => 'required|integer',
                'municipio_id' => 'required|integer',
                'codigo_postal' => 'required|digits:5', 
                'colonia_id' => 'required|integer',
                'comentario' => 'nullable|string',
                'lat' => 'required|numeric',
                'lng' => 'required|numeric',
                'fotos.*' => 'nullable|image|max:2048',
            ];
    
            if (!($request->has('anonimo') && $request->input('anonimo') == '1')) {
                $rules['nombre_contacto'] = 'required|string|max:255';
                $rules['telefono_contacto'] = 'required|string|max:20';
            }

            $data = $request->validate($rules);
    
            // Subir fotos
            $fotos = [];
            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $foto) {
                    $path = $foto->store('reportes', 'public');
                    $fotos[] = $path;
                }
            }
            $data['fotos'] = $fotos;
    
            Reporte::create($data);
    
            return redirect()->back()->with('success', 'Reporte enviado con éxito.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors($th->validator)->with('error', 'Hubo un error al enviar tu reporte. Intenta de nuevo.');
        }
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
        //
    }

    public function getColonias($municipioId, $cp)
    {
        $colonias = cat_colonia::where('id_municipio', $municipioId)
            ->where('cp', $cp)
            ->get(['id', 'nombre']);

        return response()->json($colonias);
    }

    public function dashboardDemo()
    {
        $metricas = [
            [
                'label' => 'Reportes capturados',
                'value' => '248',
                'delta' => '+12%',
                'accent' => 'primary',
            ],
            [
                'label' => 'Atendidos en 72h',
                'value' => '186',
                'delta' => '75%',
                'accent' => 'success',
            ],
            [
                'label' => 'Promedio de respuesta',
                'value' => '14h',
                'delta' => '-2h vs semana pasada',
                'accent' => 'info',
            ],
            [
                'label' => 'Reportes con imagen',
                'value' => '92%',
                'delta' => '+6%',
                'accent' => 'warning',
            ],
        ];

        $reportesDestacados = [
            [
                'tipo' => 'Bache y pavimento',
                'colonia' => 'Centro Histórico',
                'estado' => 'Nuevo León',
                'fecha' => 'Hace 2h',
                'estatus' => 'En gestión',
                'badge' => 'info',
                'imagen' => 'https://images.unsplash.com/photo-1508896694512-1eade558679a?auto=format&fit=crop&w=800&q=80',
                'lat' => '25.6866° N',
                'lng' => '100.3161° O',
            ],
            [
                'tipo' => 'Alumbrado público',
                'colonia' => 'San Nicolás',
                'estado' => 'Nuevo León',
                'fecha' => 'Hace 5h',
                'estatus' => 'Enviado a cuadrilla',
                'badge' => 'success',
                'imagen' => 'https://images.unsplash.com/photo-1504595403659-9088ce801e29?auto=format&fit=crop&w=800&q=80',
                'lat' => '25.7497° N',
                'lng' => '100.2895° O',
            ],
            [
                'tipo' => 'Basura y escombro',
                'colonia' => 'Obispado',
                'estado' => 'Nuevo León',
                'fecha' => 'Ayer',
                'estatus' => 'Cerrado',
                'badge' => 'secondary',
                'imagen' => 'https://images.unsplash.com/photo-1523474253046-8cd2748b5fd2?auto=format&fit=crop&w=800&q=80',
                'lat' => '25.6751° N',
                'lng' => '100.3451° O',
            ],
        ];

        $heatmap = [
            ['label' => 'Centro', 'valor' => 76],
            ['label' => 'San Pedro', 'valor' => 42],
            ['label' => 'Guadalupe', 'valor' => 58],
            ['label' => 'Apodaca', 'valor' => 33],
        ];

        return view('pages.dashboard.demo', compact('metricas', 'reportesDestacados', 'heatmap'));
    }
}
