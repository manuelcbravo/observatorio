@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-11">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
            <div>
                <p class="text-uppercase text-muted fw-semibold small mb-1">Tablero de control</p>
                <h3 class="fw-bold mb-2 section-title">Resultados en tiempo real</h3>
                <p class="text-muted mb-0">Vista ejecutiva con métricas reales, evidencia y tendencias actualizadas de los reportes ciudadanos.</p>
            </div>
            <div class="subtle-card d-flex align-items-center gap-2">
                <span class="badge-soft rounded-pill px-3 py-2 fw-semibold">Datos actualizados</span>
                <span class="small text-muted">Basado en reportes registrados en el sistema</span>
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
                        <div class="small text-white-50">Indicador actualizado</div>
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
                            <span class="badge bg-light text-dark rounded-pill">Dato verificado</span>
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
                    <p class="text-muted mb-0">Galería con latitud/longitud y evidencia registrada en el sistema.</p>
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
                            @if($reporte['imagen'])
                                <div class="ratio ratio-16x9 bg-light">
                                    <img src="{{ $reporte['imagen'] }}" class="w-100 h-100 object-fit-cover" alt="Imagen del reporte">
                                </div>
                            @else
                                <div class="ratio ratio-16x9 bg-light d-flex align-items-center justify-content-center text-muted">
                                    <span class="small fw-semibold">Sin evidencia fotográfica</span>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    @if($reporte['tiene_evidencia'])
                                        <span class="badge text-bg-success">Con evidencia</span>
                                    @else
                                        <span class="badge text-bg-secondary">Sin evidencia</span>
                                    @endif
                                    <span class="text-muted small">{{ $reporte['fecha'] }}</span>
                                </div>
                                <h6 class="fw-bold mb-1">{{ $reporte['tipo'] }}</h6>
                                <p class="text-muted mb-2">{{ $reporte['colonia'] }} · {{ $reporte['estado'] }}</p>
                                <div class="d-flex justify-content-between small text-muted">
                                    <span>Lat: <strong class="text-dark">{{ $reporte['lat'] ?? 'N/D' }}</strong></span>
                                    <span>Lng: <strong class="text-dark">{{ $reporte['lng'] ?? 'N/D' }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if($reportesDestacados->isEmpty())
                    <div class="col-12">
                        <div class="p-4 border rounded-4 text-center text-muted">
                            No hay reportes recientes para mostrar.
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
        <style>
            .dashboard-map-shell {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 20px;
                overflow: hidden;
            }

            .dashboard-map-header {
                background: linear-gradient(135deg, rgba(14, 165, 233, 0.08), rgba(15, 118, 110, 0.12));
                border-bottom: 1px solid rgba(148, 163, 184, 0.35);
            }

            #heatmap-map {
                height: 280px;
                width: 100%;
            }
        </style>

        <div class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-6">
                <div class="form-card h-100" style="background: linear-gradient(135deg, rgba(14,165,233,.08), rgba(15,118,110,.1));">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <p class="text-uppercase text-muted fw-semibold small mb-1">Mapa de calor</p>
                            <h5 class="fw-bold mb-0">Puntos críticos por zona</h5>
                        </div>
                        <span class="badge-soft rounded-pill px-3 py-2 fw-semibold">Últimos 30 días</span>
                    </div>
                    <p class="text-muted">Mapa operativo con base en reportes geolocalizados para monitorear concentración por zona.</p>
                    <div class="dashboard-map-shell">
                        <div class="dashboard-map-header px-3 py-2 d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge text-bg-primary">Mapa en vivo</span>
                                <span class="small text-muted">Cobertura urbana · Últimos 30 días</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success bg-opacity-25 text-success">Alta densidad</span>
                                <span class="badge bg-warning bg-opacity-25 text-warning">Media</span>
                                <span class="badge bg-secondary bg-opacity-25 text-secondary">Baja</span>
                            </div>
                        </div>
                        <div id="heatmap-map"></div>
                        <div class="px-3 py-3 bg-white border-top">
                            <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between">
                                <div>
                                    <div class="fw-semibold">Áreas con mayor fricción</div>
                                    <div class="small text-muted">Clic en cada punto para ver lat/lng y descripción.</div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="small text-muted">Última actualización:</span>
                                    <span class="badge bg-light text-dark">{{ $ultimaActualizacion }}</span>
                                </div>
                            </div>
                        </div>
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
                        @if($heatmap->isEmpty())
                            <div class="border rounded-3 px-3 py-2 text-muted">
                                Aún no hay datos geolocalizados para mostrar.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-card h-100">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <p class="text-uppercase text-muted fw-semibold small mb-1">Evidencia reciente</p>
                            <h5 class="fw-bold mb-0">Reportes con imágenes</h5>
                        </div>
                        <span class="badge bg-light text-dark">Últimas capturas</span>
                    </div>
                    <p class="text-muted">Últimos reportes con evidencia fotográfica registrada.</p>

                    <div class="d-flex flex-column gap-3">
                        @forelse($reportesEvidencia as $reporte)
                            <div class="p-3 border rounded-4 shadow-sm bg-white">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-success bg-opacity-25 text-success">Con evidencia</span>
                                    <span class="small text-muted">{{ $reporte['fecha'] }}</span>
                                </div>
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="rounded-3 overflow-hidden" style="width: 84px; height: 84px;">
                                        <img src="{{ $reporte['imagen'] }}" class="w-100 h-100 object-fit-cover" alt="Miniatura">
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $reporte['tipo'] }}</h6>
                                        <p class="mb-1 text-muted small">{{ $reporte['colonia'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 border rounded-4 text-center text-muted">
                                Aún no hay reportes con evidencia fotográfica.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-12">
                <div class="form-card h-100">
                    <p class="text-uppercase text-muted fw-semibold small mb-1">Tipos de eventualidad</p>
                    <h5 class="fw-bold mb-3">Distribución por tipo</h5>
                    <div class="d-flex flex-column gap-3">
                        @foreach($graficas['tipos'] as $tipo)
                            <div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-semibold">{{ $tipo['label'] }}</span>
                                    <span class="text-muted">{{ $tipo['total'] }} reportes</span>
                                </div>
                                <div class="progress" role="progressbar" aria-valuenow="{{ $tipo['percent'] }}" aria-valuemin="0" aria-valuemax="100" style="height: 10px;">
                                    <div class="progress-bar bg-info" style="width: {{ $tipo['percent'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                        @if($graficas['tipos']->isEmpty())
                            <div class="text-muted">Sin reportes registrados.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mapElement = document.getElementById('heatmap-map');
            if (!mapElement) {
                return;
            }

            const puntos = @json($mapaPuntos);
            const map = L.map(mapElement, { zoomControl: false, scrollWheelZoom: false }).setView([25.6866, -100.3161], 12);

            L.control.zoom({ position: 'bottomright' }).addTo(map);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            const bounds = [];

            puntos.forEach((punto) => {
                const lat = parseFloat(punto.lat);
                const lng = parseFloat(punto.lng);

                if (Number.isNaN(lat) || Number.isNaN(lng)) {
                    return;
                }

                const intensidad = Number(punto.intensidad) || 0.6;
                const color = intensidad >= 0.75 ? '#0ea5e9' : intensidad >= 0.5 ? '#10b981' : '#94a3b8';

                const marker = L.circleMarker([lat, lng], {
                    radius: 10,
                    color: '#ffffff',
                    weight: 2,
                    fillColor: color,
                    fillOpacity: Math.min(Math.max(intensidad, 0.35), 0.9)
                }).addTo(map);

                marker.bindPopup(`
                    <div style="min-width: 180px;">
                        <div class="fw-semibold mb-1">${punto.reporte}</div>
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>${punto.lat}, ${punto.lng}</span>
                        </div>
                        ${punto.comentario ? `<div class="small text-muted">${punto.comentario}</div>` : ''}
                    </div>
                `);

                bounds.push([lat, lng]);
            });

            if (bounds.length) {
                map.fitBounds(bounds, { padding: [30, 30] });
            }
        });
    </script>
@endsection
