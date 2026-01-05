@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-11">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
            <div>
                <p class="text-uppercase text-muted fw-semibold small mb-1">Tablero de control</p>
                <h3 class="fw-bold mb-2 section-title">Demo de resultados en tiempo real</h3>
                <p class="text-muted mb-0">Vista ejecutiva para mostrar impacto, tiempos de atención y evidencia visual sin depender de datos reales.</p>
            </div>
            <div class="subtle-card d-flex align-items-center gap-2">
                <span class="badge-soft rounded-pill px-3 py-2 fw-semibold">UX enfocada en lectura</span>
                <span class="small text-muted">Tarjetas limpias, jerarquía visual y evidencias fotográficas</span>
            </div>
        </div>

        <div class="row g-3 mb-4">
            @foreach($metricas as $metrica)
                <div class="col-6 col-lg-3">
                    <div class="p-3 rounded-3 h-100" style="background: #0b172a; color: #e2e8f0; box-shadow: 0 20px 50px rgba(0,0,0,0.2);">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-uppercase fw-semibold" style="letter-spacing: .4px; opacity: .8;">{{ $metrica['label'] }}</span>
                            <span class="badge bg-{{ $metrica['accent'] }} bg-opacity-25 text-white border border-0">{{ $metrica['delta'] }}</span>
                        </div>
                        <div class="display-6 fw-bold">{{ $metrica['value'] }}</div>
                        <div class="small text-white-50">Indicador demo en tiempo real</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-3 mb-4">
            @foreach($datosDuros as $dato)
                <div class="col-12 col-lg-4">
                    <div class="form-card h-100 shadow-sm" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <p class="text-uppercase text-muted fw-semibold small mb-1">{{ $dato['titulo'] }}</p>
                        <div class="d-flex align-items-baseline gap-2 mb-1">
                            <span class="display-6 fw-bold" style="color: #0f766e;">{{ $dato['valor'] }}</span>
                            <span class="badge bg-light text-dark rounded-pill">Dato duro</span>
                        </div>
                        <p class="text-muted mb-0">{{ $dato['detalle'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="form-card mb-4">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Reportes recientes con evidencia</h5>
                    <p class="text-muted mb-0">Galería con latitud/longitud y estado operativo para mostrar seguimiento ágil.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-primary btn-sm px-3 fw-semibold">Exportar PDF</button>
                    <button class="btn btn-outline-dark btn-sm px-3 fw-semibold">Compartir enlace</button>
                </div>
            </div>

            <div class="row g-3">
                @foreach($reportesDestacados as $reporte)
                    <div class="col-12 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                            <div class="ratio ratio-16x9 bg-light">
                                <img src="{{ $reporte['imagen'] }}" class="w-100 h-100 object-fit-cover" alt="Imagen del reporte">
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge text-bg-{{ $reporte['badge'] }}">{{ $reporte['estatus'] }}</span>
                                    <span class="text-muted small">{{ $reporte['fecha'] }}</span>
                                </div>
                                <h6 class="fw-bold mb-1">{{ $reporte['tipo'] }}</h6>
                                <p class="text-muted mb-2">{{ $reporte['colonia'] }} · {{ $reporte['estado'] }}</p>
                                <div class="d-flex justify-content-between small text-muted">
                                    <span>Lat: <strong class="text-dark">{{ $reporte['lat'] }}</strong></span>
                                    <span>Lng: <strong class="text-dark">{{ $reporte['lng'] }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-6">
                <div class="form-card h-100" style="background: linear-gradient(135deg, rgba(14,165,233,.08), rgba(15,118,110,.1));">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <p class="text-uppercase text-muted fw-semibold small mb-1">Mapa de calor</p>
                            <h5 class="fw-bold mb-0">Puntos críticos por zona</h5>
                        </div>
                        <span class="badge-soft rounded-pill px-3 py-2 fw-semibold">Demo</span>
                    </div>
                    <p class="text-muted">Usa esta plantilla para conectar con tu API y mostrar densidad de reportes. Incluye controles para rango de fechas y tipo de incidencia.</p>
                    <div class="bg-dark bg-opacity-75 rounded-4 position-relative overflow-hidden" style="height: 260px; background: radial-gradient(circle at 20% 30%, rgba(56,189,248,.25), transparent 35%), radial-gradient(circle at 80% 70%, rgba(16,185,129,.25), transparent 30%), #0f172a;">
                        <div class="position-absolute top-0 bottom-0 start-0 end-0" style="background-image: url('https://api.mapbox.com/styles/v1/mapbox/light-v10/static/-100.3161,25.6866,11.5,0/800x600?access_token=pk.eyJ1IjoiZGVtb3VzZXIiLCJhIjoiY2ttcWx2aGd0MGgycTJvcXVxdWdqa2VqZCJ9.dummy'); opacity: .12; background-size: cover;"></div>
                        @foreach($mapaPuntos as $index => $punto)
                            @php
                                $left = 10 + ($index * 18);
                                $top = 12 + ($index * 15);
                            @endphp
                            <div class="position-absolute" style="left: calc({{ $left }}% - 10px); top: calc({{ $top }}% - 10px);">
                                <div class="rounded-circle border border-2 border-white shadow" style="width: 18px; height: 18px; background: linear-gradient(135deg, #0ea5e9, #0f766e); opacity: {{ $punto['intensidad'] }};"></div>
                                <div class="bg-white text-dark rounded-4 px-3 py-2 mt-2 shadow-sm" style="min-width: 190px;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-primary bg-opacity-25 text-primary">{{ $punto['estatus'] }}</span>
                                        <span class="small text-muted">{{ $punto['lat'] }}</span>
                                    </div>
                                    <div class="fw-semibold">{{ $punto['reporte'] }}</div>
                                    <div class="small text-muted">Lng {{ $punto['lng'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3 d-flex flex-wrap gap-2">
                        @foreach($heatmap as $punto)
                            <div class="border rounded-3 px-3 py-2 d-flex justify-content-between align-items-center" style="min-width: 200px;">
                                <span class="fw-semibold">{{ $punto['label'] }}</span>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress" role="progressbar" aria-valuenow="{{ $punto['valor'] }}" aria-valuemin="0" aria-valuemax="100" style="width: 120px; height: 8px;">
                                        <div class="progress-bar bg-info" style="width: {{ $punto['valor'] }}%"></div>
                                    </div>
                                    <span class="fw-bold">{{ $punto['valor'] }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-card h-100">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <p class="text-uppercase text-muted fw-semibold small mb-1">Experiencia móvil</p>
                            <h5 class="fw-bold mb-0">Feed de evidencia ciudadana</h5>
                        </div>
                        <button class="btn btn-outline-dark btn-sm fw-semibold">Descargar mockup</button>
                    </div>
                    <p class="text-muted">Panel compacto para mostrar visualmente cómo se ven los reportes en un dispositivo móvil. Incluye estados de carga, fotos y tags por prioridad.</p>

                    <div class="d-flex flex-column gap-3">
                        <div class="p-3 border rounded-4 shadow-sm" style="background: #0f172a; color: #e2e8f0;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-success text-white">Prioridad alta</span>
                                <span class="small text-white-50">Hace 35 min</span>
                            </div>
                            <div class="d-flex gap-3 align-items-center">
                                <div class="rounded-3 overflow-hidden" style="width: 84px; height: 84px;">
                                    <img src="https://images.unsplash.com/photo-1523474253046-8cd2748b5fd2?auto=format&fit=crop&w=400&q=80" class="w-100 h-100 object-fit-cover" alt="Miniatura">
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Acumulación de escombro</h6>
                                    <p class="mb-1 text-white-75 small">Col. Las Fuentes · Foto y geolocalización confirmadas.</p>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <span class="badge bg-light text-dark">Geo OK</span>
                                        <span class="badge bg-info text-white">Imagen 2/3</span>
                                        <span class="badge bg-warning text-dark">Atención 4h</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 border rounded-4 shadow-sm bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary bg-opacity-25 text-primary">Programado</span>
                                <span class="small text-muted">Hace 2h</span>
                            </div>
                            <div class="d-flex gap-3 align-items-center">
                                <div class="rounded-3 overflow-hidden" style="width: 84px; height: 84px;">
                                    <img src="https://images.unsplash.com/photo-1504595403659-9088ce801e29?auto=format&fit=crop&w=400&q=80" class="w-100 h-100 object-fit-cover" alt="Miniatura">
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Falla de alumbrado</h6>
                                    <p class="mb-1 text-muted small">Col. Anáhuac · Enviado a cuadrilla con pin exacto.</p>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <span class="badge bg-light text-dark">Lat/Lng precisa</span>
                                        <span class="badge bg-secondary">Ticket #5841</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 border rounded-4 shadow-sm bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-secondary">Cerrado</span>
                                <span class="small text-muted">Ayer</span>
                            </div>
                            <div class="d-flex gap-3 align-items-center">
                                <div class="rounded-3 overflow-hidden" style="width: 84px; height: 84px;">
                                    <img src="https://images.unsplash.com/photo-1508896694512-1eade558679a?auto=format&fit=crop&w=400&q=80" class="w-100 h-100 object-fit-cover" alt="Miniatura">
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Reparación de bache</h6>
                                    <p class="mb-1 text-muted small">Centro · Cerrado con evidencia fotográfica antes/después.</p>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <span class="badge bg-success text-white">Fotografías listas</span>
                                        <span class="badge bg-light text-dark">Encuesta de satisfacción</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-12 col-lg-4">
                <div class="form-card h-100">
                    <p class="text-uppercase text-muted fw-semibold small mb-1">Tipos de eventualidad</p>
                    <h5 class="fw-bold mb-3">Distribución demo</h5>
                    <div class="d-flex flex-column gap-3">
                        @foreach($graficas['tipos'] as $tipo)
                            <div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-semibold">{{ $tipo['label'] }}</span>
                                    <span class="text-muted">{{ $tipo['valor'] }} reportes</span>
                                </div>
                                <div class="progress" role="progressbar" aria-valuenow="{{ $tipo['valor'] }}" aria-valuemin="0" aria-valuemax="100" style="height: 10px;">
                                    <div class="progress-bar bg-info" style="width: {{ $tipo['valor'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="form-card h-100">
                    <p class="text-uppercase text-muted fw-semibold small mb-1">Municipios con más reportes</p>
                    <h5 class="fw-bold mb-3">Concentración</h5>
                    <div class="d-flex flex-column gap-3">
                        @foreach($graficas['municipios'] as $municipio)
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle" style="width: 12px; height: 12px; background: linear-gradient(135deg, #0ea5e9, #0f766e);"></div>
                                    <span class="fw-semibold">{{ $municipio['label'] }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress" style="width: 120px; height: 8px;">
                                        <div class="progress-bar bg-success" style="width: {{ $municipio['valor'] }}%"></div>
                                    </div>
                                    <span class="fw-bold">{{ $municipio['valor'] }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="form-card h-100">
                    <p class="text-uppercase text-muted fw-semibold small mb-1">Tendencia semanal</p>
                    <h5 class="fw-bold mb-3">Volumen diario</h5>
                    <div class="d-flex align-items-end gap-2" style="height: 180px;">
                        @foreach($graficas['tendencia'] as $dia)
                            <div class="flex-grow-1 text-center">
                                <div class="rounded-top-4 bg-primary bg-opacity-75 mx-auto" style="height: calc({{ $dia['valor'] }}% * 1.4); max-height: 140px;"></div>
                                <small class="d-block mt-2 text-muted fw-semibold">{{ $dia['label'] }}</small>
                            </div>
                        @endforeach
                    </div>
                    <p class="small text-muted mb-0">Interpreta la tendencia sin depender de datos reales. Sustituye los valores por tu API.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
