@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-9">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <p class="text-uppercase text-muted fw-semibold small mb-1">Observatorio ciudadano</p>
                <h3 class="fw-bold mb-0 section-title">Levantar reporte ciudadano</h3>
            </div>
            <div class="subtle-card d-none d-md-flex align-items-center gap-2">
                <span class="badge-soft rounded-pill px-3 py-2 fw-semibold">UX mejorada</span>
                <span class="small text-muted">Captura guiada y geolocalización precisa</span>
            </div>
        </div>

        <div class="form-card">
            <div class="d-flex align-items-start gap-3 mb-4">
                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 46px; height: 46px;">
                    📣
                </div>
                <p class="mb-0 text-muted">Comparte tu reporte con la mayor precisión posible. Los campos de contacto son opcionales y puedes enviar de forma anónima, pero ayudan a dar seguimiento ágil a tu solicitud.</p>
            </div>

            <form action="{{ route('reportes.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>✅ Éxito:</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Iniciar con redes sociales -->
                <div class="mb-4 p-3 rounded" style="background: rgba(14, 165, 233, 0.06); border: 1px solid rgba(14, 165, 233, 0.15);">
                    <p class="text-muted fw-semibold mb-3">Acceder rápidamente con</p>
                    <div class="d-flex flex-wrap justify-content-start gap-2">
                        <a href="" class="btn btn-light d-flex align-items-center px-3 border border-0 shadow-sm">
                            <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/google.svg" alt="Google" width="20" height="20" class="me-2">
                            Google
                        </a>
                        <a href="" class="btn btn-light d-flex align-items-center px-3 border border-0 shadow-sm">
                            <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/facebook.svg" alt="Facebook" width="20" height="20" class="me-2">
                            Facebook
                        </a>
                        <a href="" class="btn btn-light d-flex align-items-center px-3 border border-0 shadow-sm">
                            <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/twitter.svg" alt="Twitter" width="20" height="20" class="me-2">
                            Twitter / X
                        </a>
                    </div>
                </div>

                <div class="form-check form-switch mb-4">
                    <input type="hidden" name="anonimo" value="0">
                    <input class="form-check-input" type="checkbox" id="anonimoSwitch" name="anonimo" value="1" @checked(old('anonimo'))>
                    <label class="form-check-label fw-semibold" for="anonimoSwitch">
                        Enviar de forma anónima
                    </label>
                    <p class="text-muted small mb-0">Si activas esta opción, ocultaremos tus datos de contacto y solo usaremos la ubicación del reporte.</p>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nombre de contacto</label>
                        <input type="text" name="nombre_contacto" class="form-control contact-field input-elevated @error('nombre_contacto') is-invalid @enderror" placeholder="Escribe tu nombre completo" value="{{ old('nombre_contacto') }}">
                        @error('nombre_contacto')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Teléfono de contacto (Whatsapp/Telegram)</label>
                        <input type="number" name="telefono_contacto" class="form-control contact-field input-elevated @error('telefono_contacto') is-invalid @enderror" placeholder="10 dígitos" value="{{ old('telefono_contacto') }}">
                        @error('telefono_contacto')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Facebook</label>
                        <input type="url" name="facebook" class="form-control contact-field input-elevated" placeholder="https://facebook.com/usuario" value="{{ old('facebook') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Twitter / X</label>
                        <input type="url" name="twitter" class="form-control contact-field input-elevated" placeholder="https://x.com/usuario" value="{{ old('twitter') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Instagram</label>
                        <input type="url" name="instagram" class="form-control contact-field input-elevated" placeholder="https://instagram.com/usuario" value="{{ old('instagram') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tipo de reporte <small class="text-muted">(agua, bache, basura, etc...)</small></label>
                        <select name="tipo_reporte_id" class="form-select input-elevated @error('tipo_reporte_id') is-invalid @enderror">
                            <option value="" disabled {{ old('tipo_reporte_id') ? '' : 'selected' }}>Selecciona un tipo de reporte</option>
                            @forEach($tipo_reporte as $tipo)
                            <option value="{{ $tipo->id }}" {{ old('tipo_reporte_id')==$tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                            @endForEach
                        </select>
                        @error('tipo_reporte_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Estado</label>
                        <input type="hidden" name="estado_id" value="{{ $estados->first()->id }}">
                        <input type="text" class="form-control input-elevated" value="{{ $estados->first()->estado }}" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Municipio</label>
                        <select name="municipio_id" class="form-select input-elevated @error('municipio_id') is-invalid @enderror">
                            <option value="" disabled selected>Selecciona un municipio</option>
                            @forEach($municipios as $municipio)
                            <option value="{{ $municipio->id }}" {{ old('municipio_id')==$municipio->id ? 'selected' : '' }}>{{ $municipio->municipio }}</option>
                            @endForEach
                        </select>
                        @error('municipio_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Código Postal</label>
                        <input type="number" name="codigo_postal" class="form-control input-elevated @error('codigo_postal') is-invalid @enderror" placeholder="Ej. 64000" value="{{ old('codigo_postal') }}" maxlength="5" pattern="\d{5}">
                        @error('codigo_postal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-semibold">Colonia</label>
                        <select name="colonia_id" class="form-select input-elevated @error('colonia_id') is-invalid @enderror">
                            <option value="" disabled {{ old('colonia_id') ? '' : 'selected' }}>Selecciona una colonia</option>
                        </select>
                        @error('colonia_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Comentario</label>
                    <textarea name="comentario" class="form-control input-elevated" rows="3" placeholder="Describe lo sucedido...">{{ old('comentario') }}</textarea>
                </div>

                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label fw-semibold mb-0">Ubicación precisa</label>
                        <span class="badge text-bg-light" id="location-status">Coloca el pin en la ubicación exacta</span>
                    </div>
                    <div class="subtle-card mb-2">
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                            <span class="text-muted small">Desliza el pin o usa la geolocalización para obtener latitud y longitud con máxima precisión.</span>
                            <div class="text-md-end">
                                <div class="small text-uppercase text-muted">Coordenadas</div>
                                <div class="fw-bold" id="coords-display">--</div>
                            </div>
                        </div>
                    </div>
                    <div class="map-container mb-3" id="map"></div>
                    <div class="d-flex flex-column flex-md-row gap-2">
                        <button type="button" id="open-location-modal" class="btn btn-primary w-100 py-2 fw-bold">📍 Capturar mi ubicación</button>
                        <button type="button" id="center-marker" class="btn btn-outline-dark w-100 py-2 fw-bold">Recentrar marcador</button>
                    </div>
                    <small class="text-muted d-block mt-2" id="accuracy-text">Precisión no calculada aún.</small>

                    <input type="hidden" id="lat" name="lat" value="{{ old('lat') }}">
                    <input type="hidden" id="lng" name="lng" value="{{ old('lng') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Subir hasta 3 fotos</label>
                    <input type="file" name="fotos[]" class="form-control input-elevated" multiple accept="image/*" max="3">
                    <small class="form-text text-muted">Si el formulario falla, vuelve a seleccionar las fotos (por seguridad el navegador no repuebla archivos).</small>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-dark px-5 py-2 fw-semibold">Enviar reporte</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para solicitar permisos de ubicación -->
<div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title" id="locationModalLabel">Permitir acceso a tu ubicación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px;">📍</div>
                    <p class="mb-0 text-muted">Usaremos tu GPS solo para este reporte. Mejora la precisión y acelera la atención de tu solicitud.</p>
                </div>
                <ul class="text-muted small mb-0">
                    <li>Activa el GPS para obtener coordenadas exactas.</li>
                    <li>Si estás en interiores, acércate a una ventana para mayor precisión.</li>
                    <li>Podrás ajustar el pin manualmente después de capturar la ubicación.</li>
                </ul>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Ahora no</button>
                <button type="button" id="confirm-location" class="btn btn-primary">Permitir ubicación precisa</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?quarterly&region=MX&language=es&key=AIzaSyAcaQ7bBft6w89zoAteFbP9kaPc7kd0D3Y&libraries=places&callback=initMap" async defer></script>
<script>
    let map, marker;

    const locationStatus = document.getElementById('location-status');
    const coordsDisplay = document.getElementById('coords-display');
    const accuracyText = document.getElementById('accuracy-text');
    const latInput = document.getElementById('lat');
    const lngInput = document.getElementById('lng');
    const centerButton = document.getElementById('center-marker');
    const locationModal = new bootstrap.Modal(document.getElementById('locationModal'));
    const modalTrigger = document.getElementById('open-location-modal');
    const confirmLocationBtn = document.getElementById('confirm-location');

    document.querySelector('form').addEventListener('submit', function (e) {
        const lat = latInput.value;
        const lng = lngInput.value;

        if (!lat || !lng) {
            e.preventDefault();
            alert('Por favor selecciona tu ubicación en el mapa antes de enviar el reporte.');
        }
    });

    function updateStatus(message, type = 'info') {
        const styles = {
            info: 'badge text-bg-light',
            success: 'badge text-bg-success',
            warning: 'badge text-bg-warning text-dark',
            danger: 'badge text-bg-danger'
        };
        locationStatus.className = styles[type] || styles.info;
        locationStatus.textContent = message;
    }

    function setCoordinates(lat, lng, accuracy) {
        if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
            coordsDisplay.textContent = '--';
            return;
        }

        latInput.value = lat;
        lngInput.value = lng;
        coordsDisplay.textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        accuracyText.textContent = accuracy ? `Precisión estimada: ±${Math.round(accuracy)} m` : 'Precisión basada en el pin seleccionado.';
    }

    function initMap() {
        const storedLat = parseFloat(latInput.value);
        const storedLng = parseFloat(lngInput.value);
        const center = {
            lat: Number.isFinite(storedLat) ? storedLat : 20.127597,
            lng: Number.isFinite(storedLng) ? storedLng : -98.731807
        };
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 16,
            center: center,
            streetViewControl: false,
            mapTypeControl: false
        });

        marker = new google.maps.Marker({
            position: center,
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP
        });

        setCoordinates(center.lat, center.lng);
        updateStatus('Arrastra el pin a la ubicación exacta');

        google.maps.event.addListener(marker, 'dragend', function (event) {
            setCoordinates(event.latLng.lat(), event.latLng.lng());
            updateStatus('Ubicación ajustada manualmente', 'info');
        });

        google.maps.event.addListener(map, 'click', function (event) {
            const clickedLocation = event.latLng;
            marker.setPosition(clickedLocation);
            setCoordinates(clickedLocation.lat(), clickedLocation.lng());
            updateStatus('Ubicación actualizada desde el mapa', 'success');
        });
    }

    function recenterMarker() {
        const lat = parseFloat(latInput.value);
        const lng = parseFloat(lngInput.value);
        const fallback = { lat: 20.127597, lng: -98.731807 };
        const coords = { lat, lng };
        const target = Number.isFinite(lat) && Number.isFinite(lng) ? coords : fallback;
        map.setCenter(target);
        marker.setPosition(target);
        setCoordinates(target.lat, target.lng);
        updateStatus('Marcador recentrado', 'info');
    }

    function handleLocationSuccess(position) {
        const coords = { lat: position.coords.latitude, lng: position.coords.longitude };
        map.setCenter(coords);
        marker.setPosition(coords);
        setCoordinates(coords.lat, coords.lng, position.coords.accuracy);
        updateStatus('Ubicación obtenida con GPS', 'success');
    }

    function handleLocationError(error) {
        const messages = {
            1: 'Debes permitir el acceso a tu ubicación para mayor precisión.',
            2: 'La ubicación no está disponible en este momento.',
            3: 'Tiempo de espera agotado al obtener tu ubicación.'
        };
        updateStatus(messages[error.code] || 'No se pudo obtener tu ubicación.', 'warning');
        alert(messages[error.code] || 'No se pudo obtener tu ubicación.');
    }

    function requestLocation() {
        updateStatus('Obteniendo ubicación precisa...', 'info');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                handleLocationSuccess,
                handleLocationError,
                { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
            );
        } else {
            updateStatus('Tu navegador no soporta geolocalización.', 'danger');
        }
    }

    modalTrigger.addEventListener('click', () => locationModal.show());

    confirmLocationBtn.addEventListener('click', () => {
        locationModal.hide();
        requestLocation();
    });

    centerButton.addEventListener('click', recenterMarker);

    function toggleContactFields(isAnon) {
        const fields = document.querySelectorAll('.contact-field');
        fields.forEach(field => {
            if (isAnon) {
                field.value = "";
                field.setAttribute("disabled", "disabled");
                field.classList.add("bg-light");
            } else {
                field.removeAttribute("disabled");
                field.classList.remove("bg-light");
            }
        });
    }

    const anonymousSwitch = document.getElementById('anonimoSwitch');
    anonymousSwitch.addEventListener('change', function () {
        toggleContactFields(this.checked);
    });

    toggleContactFields(anonymousSwitch.checked);

    const municipioSelect = document.querySelector('select[name="municipio_id"]');
    const cpInput = document.querySelector('input[name="codigo_postal"]');
    const coloniaSelect = document.querySelector('select[name="colonia_id"]');

    function cargarColonias() {
        const municipioId = municipioSelect.value;
        const codigoPostal = cpInput.value;

        if (municipioId && codigoPostal.length === 5) {
            coloniaSelect.innerHTML = '<option value="">Cargando...</option>';

            fetch(`{{ url('colonias') }}/${municipioId}/${codigoPostal}`)
                .then(response => response.json())
                .then(data => {
                    coloniaSelect.innerHTML = '<option value="">Selecciona una colonia</option>';
                    data.forEach(colonia => {
                        coloniaSelect.innerHTML += `<option value="${colonia.id}">${colonia.nombre}</option>`;
                    });
                })
                .catch(() => {
                    coloniaSelect.innerHTML = '<option value="">Error al cargar colonias</option>';
                });
        }
    }

    municipioSelect.addEventListener('change', cargarColonias);
    cpInput.addEventListener('input', cargarColonias);
</script>
@endsection
