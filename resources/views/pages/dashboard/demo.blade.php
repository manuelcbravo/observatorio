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
                    <div class="bg-dark bg-opacity-75 rounded-4 position-relative overflow-hidden" style="height: 260px;">
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                            <div class="spinner-border text-info mb-2" role="status"></div>
                            <div class="fw-semibold">Mapa interactivo en desarrollo</div>
                            <small class="d-block text-white-50">Integra tu proveedor de mapas o heatmaps aquí</small>
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
    </div>
</div>
@endsection
