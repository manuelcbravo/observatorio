<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
use App\Models\cat_colonia;
use App\Models\cat_estado;
use App\Models\cat_municipio;
use App\Models\CatTipoReporte;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
    
            $reporte = Reporte::create($data);
            if (!empty($fotos)) {
                $reporte->fotos()->createMany(
                    collect($fotos)->map(fn ($ruta) => ['ruta' => $ruta])->all()
                );
            }
    
            return redirect()->back()->with('success', 'Reporte enviado con éxito.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors($th->validator)->with('error', 'Hubo un error al enviar tu reporte. Intenta de nuevo.');
        }
    }

    public function getColonias($municipioId, $cp)
    {
        $colonias = cat_colonia::where('id_municipio', $municipioId)
            ->where('cp', $cp)
            ->get(['id', 'nombre']);

        return response()->json($colonias);
    }

    public function dashboard()
    {
        $now = Carbon::now();

        $reportesTotal = Reporte::count();
        $reportesUltimas24 = Reporte::where('created_at', '>=', $now->copy()->subDay())->count();
        $reportesDiaPrevio = Reporte::whereBetween('created_at', [$now->copy()->subDays(2), $now->copy()->subDay()])->count();
        $reportesUltimos7 = Reporte::where('created_at', '>=', $now->copy()->subDays(7))->count();
        $reportesPrevios7 = Reporte::whereBetween('created_at', [$now->copy()->subDays(14), $now->copy()->subDays(7)])->count();
        $reportesUltimos30 = Reporte::where('created_at', '>=', $now->copy()->subDays(30))->count();
        $reportesConEvidencia = Reporte::whereHas('fotos')->count();
        $municipiosActivos = Reporte::whereNotNull('municipio_id')
            ->distinct('municipio_id')
            ->count('municipio_id');
        $coloniasActivas = Reporte::whereNotNull('colonia_id')
            ->distinct('colonia_id')
            ->count('colonia_id');

        $ultimoReporte = Reporte::orderByDesc('created_at')->first();
        $ultimoReporteLabel = $ultimoReporte?->created_at?->locale('es')->diffForHumans() ?? 'Sin reportes';

        $formatDelta = function (int $actual, int $previo, string $sufijo = 'vs periodo previo'): string {
            if ($previo === 0) {
                return $actual > 0 ? 'Nuevo' : 'Sin variación';
            }

            $diferencia = (($actual - $previo) / $previo) * 100;
            $signo = $diferencia >= 0 ? '+' : '';

            return $signo . round($diferencia) . '% ' . $sufijo;
        };

        $porcentajeEvidencia = $reportesTotal > 0
            ? round(($reportesConEvidencia / $reportesTotal) * 100)
            : 0;

        $metricas = [
            [
                'label' => 'Reportes totales',
                'value' => number_format($reportesTotal),
                'delta' => 'Últimos 7 días: ' . number_format($reportesUltimos7),
                'accent' => 'primary',
            ],
            [
                'label' => 'Reportes últimas 24h',
                'value' => number_format($reportesUltimas24),
                'delta' => $formatDelta($reportesUltimas24, $reportesDiaPrevio, 'vs día previo'),
                'accent' => 'success',
            ],
            [
                'label' => 'Municipios activos',
                'value' => number_format($municipiosActivos),
                'delta' => 'Con reportes registrados',
                'accent' => 'info',
            ],
            [
                'label' => 'Reportes con evidencia',
                'value' => number_format($reportesConEvidencia),
                'delta' => $porcentajeEvidencia . '% del total',
                'accent' => 'warning',
            ],
        ];

        $datosDuros = [
            [
                'titulo' => 'Colonias con reportes',
                'valor' => number_format($coloniasActivas),
                'detalle' => 'Cobertura actual registrada',
            ],
            [
                'titulo' => 'Último reporte',
                'valor' => $ultimoReporteLabel,
                'detalle' => 'Actualización más reciente',
            ],
            [
                'titulo' => 'Promedio diario (30 días)',
                'valor' => $reportesUltimos30 > 0 ? number_format($reportesUltimos30 / 30, 1) : '0',
                'detalle' => 'Promedio de capturas',
            ],
        ];

        $reportesDestacados = Reporte::query()
            ->with('fotos')
            ->leftJoin('cat_tipo_reportes', 'reportes.tipo_reporte_id', '=', 'cat_tipo_reportes.id')
            ->leftJoin('cat_colonias', 'reportes.colonia_id', '=', 'cat_colonias.id')
            ->leftJoin('cat_estados', 'reportes.estado_id', '=', 'cat_estados.id')
            ->select(
                'reportes.*',
                'cat_tipo_reportes.nombre as tipo_nombre',
                'cat_colonias.nombre as colonia_nombre',
                'cat_estados.estado as estado_nombre'
            )
            ->orderByDesc('reportes.created_at')
            ->take(6)
            ->get()
            ->map(function ($reporte) {
                $fotoModel = $reporte->fotos->first();
                $foto = $fotoModel ? Storage::url($fotoModel->ruta) : null;

                return [
                    'tipo' => $reporte->tipo_nombre ?? 'Sin clasificar',
                    'colonia' => $reporte->colonia_nombre ?? 'Sin colonia',
                    'estado' => $reporte->estado_nombre ?? 'Sin estado',
                    'fecha' => $reporte->created_at?->locale('es')->diffForHumans() ?? 'Sin fecha',
                    'imagen' => $foto,
                    'lat' => $reporte->lat,
                    'lng' => $reporte->lng,
                    'tiene_evidencia' => $foto !== null,
                ];
            });

        $reportesEvidencia = Reporte::query()
            ->whereHas('fotos')
            ->with('fotos')
            ->leftJoin('cat_tipo_reportes', 'reportes.tipo_reporte_id', '=', 'cat_tipo_reportes.id')
            ->leftJoin('cat_colonias', 'reportes.colonia_id', '=', 'cat_colonias.id')
            ->select(
                'reportes.*',
                'cat_tipo_reportes.nombre as tipo_nombre',
                'cat_colonias.nombre as colonia_nombre'
            )
            ->orderByDesc('reportes.created_at')
            ->take(3)
            ->get()
            ->map(function ($reporte) {
                $fotoModel = $reporte->fotos->first();
                $foto = $fotoModel ? Storage::url($fotoModel->ruta) : null;

                return [
                    'tipo' => $reporte->tipo_nombre ?? 'Sin clasificar',
                    'colonia' => $reporte->colonia_nombre ?? 'Sin colonia',
                    'fecha' => $reporte->created_at?->locale('es')->diffForHumans() ?? 'Sin fecha',
                    'imagen' => $foto,
                ];
            });

        $mapaPuntos = Reporte::query()
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->where('reportes.created_at', '>=', $now->copy()->subDays(30))
            ->leftJoin('cat_tipo_reportes', 'reportes.tipo_reporte_id', '=', 'cat_tipo_reportes.id')
            ->select('reportes.*', 'cat_tipo_reportes.nombre as tipo_nombre')
            ->orderByDesc('reportes.created_at')
            ->take(60)
            ->get()
            ->map(function ($reporte) use ($now) {
                $dias = $reporte->created_at ? $reporte->created_at->diffInDays($now) : 30;
                $intensidad = max(0.35, 1 - min($dias / 30, 1));

                return [
                    'lat' => (float) $reporte->lat,
                    'lng' => (float) $reporte->lng,
                    'reporte' => $reporte->tipo_nombre ?? 'Reporte ciudadano',
                    'comentario' => $reporte->comentario,
                    'intensidad' => $intensidad,
                ];
            });

        $heatmapRaw = Reporte::query()
            ->leftJoin('cat_municipios', 'reportes.municipio_id', '=', 'cat_municipios.id')
            ->select('cat_municipios.municipio as label', DB::raw('count(*) as total'))
            ->whereNotNull('reportes.municipio_id')
            ->groupBy('cat_municipios.municipio')
            ->orderByDesc('total')
            ->take(4)
            ->get();

        $heatmap = $heatmapRaw->map(function ($registro) use ($reportesTotal) {
            $porcentaje = $reportesTotal > 0 ? round(($registro->total / $reportesTotal) * 100) : 0;

            return [
                'label' => $registro->label ?? 'Sin municipio',
                'valor' => $porcentaje,
                'total' => $registro->total,
            ];
        });

        $tiposRaw = Reporte::query()
            ->leftJoin('cat_tipo_reportes', 'reportes.tipo_reporte_id', '=', 'cat_tipo_reportes.id')
            ->select('cat_tipo_reportes.nombre as label', DB::raw('count(*) as total'))
            ->whereNotNull('reportes.tipo_reporte_id')
            ->groupBy('cat_tipo_reportes.nombre')
            ->orderByDesc('total')
            ->take(4)
            ->get();

        $tiposMax = $tiposRaw->max('total') ?: 1;
        $tipos = $tiposRaw->map(function ($registro) use ($tiposMax) {
            return [
                'label' => $registro->label ?? 'Sin clasificar',
                'total' => $registro->total,
                'percent' => round(($registro->total / $tiposMax) * 100),
            ];
        });

        $graficas = [
            'tipos' => $tipos,
        ];

        $ultimaActualizacion = $now->locale('es')->diffForHumans();

        return view('pages.dashboard.index', compact(
            'metricas',
            'datosDuros',
            'reportesDestacados',
            'reportesEvidencia',
            'heatmap',
            'mapaPuntos',
            'graficas',
            'ultimaActualizacion'
        ));
    }
}
