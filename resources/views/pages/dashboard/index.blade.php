@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex flex-col gap-4 rounded-3xl border border-slate-200 bg-white/70 p-6 shadow-sm lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Tablero de control</p>
            <h3 class="mt-2 text-2xl font-bold text-slate-900 md:text-3xl">Resultados en tiempo real</h3>
            <p class="mt-2 text-sm text-slate-500">Vista ejecutiva con métricas reales, evidencia y tendencias actualizadas de los reportes ciudadanos.</p>
        </div>
        <div class="rounded-2xl border border-dashed border-sky-200 bg-sky-50 px-4 py-3 text-sm text-sky-700">
            <div class="font-semibold">Datos actualizados</div>
            <div class="text-xs text-sky-600">Basado en reportes registrados en el sistema</div>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($metricas as $metrica)
            <div class="rounded-3xl bg-slate-900 p-4 text-slate-100 shadow-xl">
                <div class="flex items-start justify-between">
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ $metrica['label'] }}</span>
                    <span class="rounded-full bg-white/10 px-2 py-1 text-xs">{{ $metrica['delta'] }}</span>
                </div>
                <div class="mt-4 text-3xl font-bold">{{ $metrica['value'] }}</div>
                <p class="mt-1 text-xs text-slate-400">Indicador actualizado</p>
            </div>
        @endforeach
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        @foreach($datosDuros as $dato)
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">{{ $dato['titulo'] }}</p>
                <div class="mt-3 flex items-center gap-3">
                    <span class="text-3xl font-bold text-emerald-600">{{ $dato['valor'] }}</span>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Dato verificado</span>
                </div>
                <p class="mt-2 text-sm text-slate-500">{{ $dato['detalle'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xl">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h5 class="text-lg font-bold text-slate-900">Reportes recientes con evidencia</h5>
                <p class="text-sm text-slate-500">Galería con latitud/longitud y evidencia registrada en el sistema.</p>
                <p class="text-xs font-semibold text-slate-400">Se muestran los últimos 6 reportes con evidencia.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm">Exportar PDF</button>
                <button class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm">Compartir enlace</button>
            </div>
        </div>

        <div class="mt-4 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach($reportesDestacados->take(6) as $reporte)
                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <div class="relative h-44 w-full bg-slate-100" data-carousel data-images='@json($reporte['imagenes'])'>
                        <img src="{{ $reporte['imagenes'][0] ?? asset('assets/img/NA.png') }}" class="h-full w-full object-cover" alt="Imagen del reporte" data-lightbox data-gallery='@json($reporte['imagenes'])' data-index="0" data-carousel-image onerror="this.src='{{ asset('assets/img/NA.png') }}'" loading="lazy">
                        @if(!$reporte['tiene_evidencia'])
                            <span class="absolute left-3 top-3 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-slate-600">Sin evidencia</span>
                        @endif
                        @if(count($reporte['imagenes']) > 1)
                            <button type="button" class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-white/80 px-2 py-1 text-xs font-semibold text-slate-700 shadow" data-carousel-prev>‹</button>
                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-white/80 px-2 py-1 text-xs font-semibold text-slate-700 shadow" data-carousel-next>›</button>
                            <div class="absolute bottom-3 right-3 rounded-full bg-slate-900/70 px-2 py-1 text-xs font-semibold text-white" data-carousel-count>
                                1 / {{ count($reporte['imagenes']) }}
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <span class="rounded-full {{ $reporte['tiene_evidencia'] ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }} px-3 py-1 text-xs font-semibold">
                                {{ $reporte['tiene_evidencia'] ? 'Con evidencia' : 'Sin evidencia' }}
                            </span>
                            <span class="text-xs text-slate-500">{{ $reporte['fecha'] }}</span>
                        </div>
                        <h6 class="mt-3 text-base font-bold text-slate-900">{{ $reporte['tipo'] }}</h6>
                        <p class="text-sm text-slate-500">{{ $reporte['colonia'] }} · {{ $reporte['estado'] }}</p>
                        <div class="mt-3 flex justify-between text-xs text-slate-500">
                            <span>Lat: <strong class="text-slate-900">{{ $reporte['lat'] ?? 'N/D' }}</strong></span>
                            <span>Lng: <strong class="text-slate-900">{{ $reporte['lng'] ?? 'N/D' }}</strong></span>
                        </div>
                    </div>
                </div>
            @endforeach
            @if($reportesDestacados->isEmpty())
                <div class="rounded-3xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
                    No hay reportes recientes para mostrar.
                </div>
            @endif
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-gradient-to-br from-sky-50 to-emerald-50 p-6 shadow-sm">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Focos de atención</p>
                <h5 class="mt-2 text-lg font-bold text-slate-900">Puntos críticos por zona</h5>
                <p class="mt-2 text-sm text-slate-500">Resumen operativo basado en reportes geolocalizados para monitorear concentración por zona.</p>
            </div>
            <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-600">Últimos 30 días</span>
        </div>
        <div class="mt-4 overflow-hidden rounded-3xl border border-slate-200 bg-white">
            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200 bg-slate-50 px-4 py-3 text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <span class="rounded-full bg-sky-100 px-2 py-1 text-xs font-semibold text-sky-700">Mapa en vivo</span>
                    <span>Cobertura urbana · Últimos 30 días</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="rounded-full bg-sky-100 px-2 py-1 text-xs font-semibold text-sky-700">Alta densidad</span>
                    <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">Media</span>
                    <span class="rounded-full bg-slate-200 px-2 py-1 text-xs font-semibold text-slate-600">Baja</span>
                </div>
            </div>
            <div id="heatmap-map" class="h-80 w-full"></div>
            <div class="border-t border-slate-200 bg-white px-4 py-4">
                <div class="flex flex-wrap items-center justify-between gap-3 text-sm">
                    <div>
                        <div class="font-semibold text-slate-900">Áreas con mayor fricción</div>
                        <div class="text-xs text-slate-500">Clic en cada punto para ver lat/lng y descripción.</div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span>Última actualización:</span>
                        <span class="rounded-full bg-slate-100 px-2 py-1 font-semibold text-slate-700">{{ $ultimaActualizacion }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 flex items-center justify-between text-xs text-slate-500">
            <span>Última actualización</span>
            <span class="rounded-full bg-white px-3 py-1 font-semibold text-slate-700 shadow-sm">{{ $ultimaActualizacion }}</span>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xl">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Evidencia reciente</p>
                    <h5 class="mt-2 text-lg font-bold text-slate-900">Reportes con imágenes</h5>
                </div>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">Últimas capturas</span>
            </div>
            <p class="mt-2 text-sm text-slate-500">Últimos reportes con evidencia fotográfica registrada.</p>

            <div class="mt-4 flex flex-col gap-3">
                @forelse($reportesEvidencia as $reporte)
                    <div class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="h-20 w-20 overflow-hidden rounded-2xl">
                            <img src="{{ $reporte['imagen'] ?: asset('assets/img/NA.png') }}" class="h-full w-full object-cover" alt="Miniatura" data-lightbox data-gallery='@json($reporte['imagenes'])' data-index="0" onerror="this.src='{{ asset('assets/img/NA.png') }}'" loading="lazy">
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between text-xs text-slate-500">
                                <span class="rounded-full bg-emerald-100 px-2 py-1 font-semibold text-emerald-700">Con evidencia</span>
                                <span>{{ $reporte['fecha'] }}</span>
                            </div>
                            <h6 class="mt-2 text-sm font-bold text-slate-900">{{ $reporte['tipo'] }}</h6>
                            <p class="text-xs text-slate-500">{{ $reporte['colonia'] }}</p>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-200 p-4 text-center text-sm text-slate-500">
                        Aún no hay reportes con evidencia fotográfica.
                    </div>
                @endforelse
            </div>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Tipos de eventualidad</p>
            <h5 class="mt-2 text-lg font-bold text-slate-900">Distribución por tipo</h5>
            <p class="mt-2 text-sm text-slate-500">Top de reportes clasificados por tipo de eventualidad.</p>
            <div class="mt-4 space-y-3">
                @foreach($graficas['tipos'] as $tipo)
                    <div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-semibold text-slate-700">{{ $tipo['label'] }}</span>
                            <span class="text-slate-500">{{ $tipo['total'] }} reportes</span>
                        </div>
                        <div class="mt-2 h-2 rounded-full bg-slate-100">
                            <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $tipo['percent'] }}%"></div>
                        </div>
                    </div>
                @endforeach
                @if($graficas['tipos']->isEmpty())
                    <div class="text-sm text-slate-500">Sin reportes registrados.</div>
                @endif
            </div>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Calidad de evidencia</p>
            <h5 class="mt-2 text-lg font-bold text-slate-900">Cobertura fotográfica</h5>
            <p class="mt-2 text-sm text-slate-500">Comparativo de reportes con y sin evidencia.</p>
            <div class="mt-4 space-y-4">
                @foreach($graficas['evidencia'] as $item)
                    <div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-semibold text-slate-700">{{ $item['label'] }}</span>
                            <span class="text-slate-500">{{ $item['total'] }} reportes</span>
                        </div>
                        <div class="mt-2 h-2 rounded-full bg-slate-100">
                            <div class="h-2 rounded-full {{ $item['color'] }}" style="width: {{ $item['percent'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Colonias con más reportes</p>
        <h5 class="mt-2 text-lg font-bold text-slate-900">Distribución por colonia y municipio</h5>
        <p class="mt-2 text-sm text-slate-500">Comparativo total de reportes por colonia con su municipio asociado.</p>
        <div class="mt-4 space-y-4">
            @foreach($graficas['colonias'] as $colonia)
                <div>
                    <div class="flex flex-wrap items-center justify-between gap-2 text-sm">
                        <span class="font-semibold text-slate-700">{{ $colonia['colonia'] }} · <span class="font-normal text-slate-500">{{ $colonia['municipio'] }}</span></span>
                        <span class="text-slate-500">{{ $colonia['total'] }} reportes</span>
                    </div>
                    <div class="mt-2 h-2 rounded-full bg-slate-100">
                        <div class="h-2 rounded-full bg-sky-500" style="width: {{ $colonia['percent'] }}%"></div>
                    </div>
                </div>
            @endforeach
            @if($graficas['colonias']->isEmpty())
                <div class="text-sm text-slate-500">Aún no hay colonias registradas.</div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?region=MX&language=es&key={{ config('services.google_maps.key') }}&callback=initDashboardMap" async defer></script>
<script>
    function initDashboardMap() {
        const mapElement = document.getElementById('heatmap-map');
        if (!mapElement) {
            return;
        }

        const puntos = @json($mapaPuntos);
        const defaultCenter = { lat: 25.6866, lng: -100.3161 };
        const map = new google.maps.Map(mapElement, {
            zoom: 12,
            center: defaultCenter,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false
        });

        const bounds = new google.maps.LatLngBounds();
        const infoWindow = new google.maps.InfoWindow();

        puntos.forEach((punto) => {
            const lat = parseFloat(punto.lat);
            const lng = parseFloat(punto.lng);

            if (Number.isNaN(lat) || Number.isNaN(lng)) {
                return;
            }

            const intensidad = Number(punto.intensidad) || 0.6;
            const color = intensidad >= 0.75 ? '#0ea5e9' : intensidad >= 0.5 ? '#10b981' : '#94a3b8';

            const marker = new google.maps.Marker({
                position: { lat, lng },
                map: map,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 8 + intensidad * 6,
                    fillColor: color,
                    fillOpacity: Math.min(Math.max(intensidad, 0.35), 0.9),
                    strokeColor: '#ffffff',
                    strokeWeight: 2
                }
            });

            marker.addListener('click', () => {
                infoWindow.setContent(`
                    <div style="min-width: 180px; font-family: 'Inter', sans-serif;">
                        <div style="font-weight: 600; margin-bottom: 4px;">${punto.reporte}</div>
                        <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">${punto.lat}, ${punto.lng}</div>
                        ${punto.comentario ? `<div style="font-size: 12px; color: #475569;">${punto.comentario}</div>` : ''}
                    </div>
                `);
                infoWindow.open(map, marker);
            });

            bounds.extend(marker.getPosition());
        });

        if (puntos.length) {
            map.fitBounds(bounds, { padding: 40 });
        }
    }

    function initDashboardCarousels() {
        const carousels = document.querySelectorAll('[data-carousel]');

        carousels.forEach((carousel) => {
            const images = JSON.parse(carousel.getAttribute('data-images') || '[]');
            const imageElement = carousel.querySelector('[data-carousel-image]');
            const prevButton = carousel.querySelector('[data-carousel-prev]');
            const nextButton = carousel.querySelector('[data-carousel-next]');
            const counter = carousel.querySelector('[data-carousel-count]');

            if (!images.length || !imageElement) {
                return;
            }

            let index = 0;

            const updateCarousel = () => {
                const src = images[index] || images[0];
                imageElement.src = src;
                imageElement.setAttribute('data-index', index.toString());
                imageElement.setAttribute('data-gallery', JSON.stringify(images));
                if (counter) {
                    counter.textContent = `${index + 1} / ${images.length}`;
                }
            };

            if (prevButton) {
                prevButton.addEventListener('click', (event) => {
                    event.preventDefault();
                    index = (index - 1 + images.length) % images.length;
                    updateCarousel();
                });
            }

            if (nextButton) {
                nextButton.addEventListener('click', (event) => {
                    event.preventDefault();
                    index = (index + 1) % images.length;
                    updateCarousel();
                });
            }

            updateCarousel();
        });
    }

    document.addEventListener('DOMContentLoaded', initDashboardCarousels);
</script>
@endsection
