@extends('layouts.app')

@section('content')
<div class="form-card">
    <h4 class="mb-4 fw-bold text-center text-secondary">Levantar reporte ciudadano</h4>

    <form action="{{ route('reportes.store') }}" method="POST" enctype="multipart/form-data">
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
        <div class="mb-4 text-center">
            <p class="text-muted fw-semibold">Registrar con</p>
            <div class="d-flex justify-content-center gap-2">
                <!-- Google -->
                <a href="" class="btn btn-outline-danger d-flex align-items-center px-3">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/google.svg" alt="Google"
                        width="20" height="20" class="me-2">
                    Google
                </a>
                <!-- Facebook -->
                <a href="" class="btn btn-outline-primary d-flex align-items-center px-3">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/facebook.svg" alt="Facebook"
                        width="20" height="20" class="me-2">
                    Facebook
                </a>
                <!-- Twitter / X -->
                <a href="" class="btn btn-outline-info d-flex align-items-center px-3">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/twitter.svg" alt="Twitter"
                        width="20" height="20" class="me-2">
                    Twitter / X
                </a>
            </div>
        </div>
        <div class="form-check form-switch mb-4">
            {{-- Hidden input para asegurar que siempre llegue un valor (0 si no marcado) --}}
            <input type="hidden" name="anonimo" value="0">
            <input class="form-check-input" type="checkbox" id="anonimoSwitch" name="anonimo" value="1"
                @checked(old('anonimo'))>
            <label class="form-check-label fw-semibold" for="anonimoSwitch">
                Enviar de forma anónima
            </label>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Nombre de contacto</label>
                <input type="text" name="nombre_contacto"
                    class="form-control contact-field  @error('nombre_contacto') is-invalid @enderror"
                    placeholder="Escribe tu nombre completo" value="{{ old('nombre_contacto') }}">
                @error('nombre_contacto')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Teléfono -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Teléfono de contacto (Whatsapp/Telegram)</label>
                <input type="number" name="telefono_contacto"
                    class="form-control contact-field @error('telefono_contacto') is-invalid @enderror"
                    placeholder="10 dígitos" value="{{ old('telefono_contacto') }}">
                @error('telefono_contacto')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Redes sociales -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Facebook</label>
                <input type="url" name="facebook" class="form-control contact-field"
                    placeholder="https://facebook.com/usuario" value="{{ old('facebook') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Twitter / X</label>
                <input type="url" name="twitter" class="form-control contact-field" placeholder="https://x.com/usuario"
                    value="{{ old('twitter') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Instagram</label>
                <input type="url" name="instagram" class="form-control contact-field"
                    placeholder="https://instagram.com/usuario" value="{{ old('instagram') }}">
            </div>
        </div>

        <!-- Estado y Municipio (usé valores numéricos ejemplo) -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Tipo de reporte <small class="text-muted">(agua, bache, basura,
                        etc...)</small></label>
                <select name="tipo_reporte_id" class="form-select @error('tipo_reporte_id') is-invalid @enderror">
                    <option value="" disabled {{ old('tipo_reporte_id') ? '' : 'selected' }}>Selecciona un tipo de
                        reporte</option>
                    @forEach($tipo_reporte as $tipo)
                    <option value="{{ $tipo->id }}" {{ old('tipo_reporte_id')==$tipo->id ? 'selected' : '' }}>{{
                        $tipo->nombre }}</option>
                    @endForEach
                </select>
                @error('tipo_reporte_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Estado</label>
                <input type="hidden" name="estado_id" value="{{ $estados->first()->id }}">
                <input type="text" class="form-control" value="{{ $estados->first()->estado }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Municipio</label>
                <select name="municipio_id" class="form-select @error('municipio_id') is-invalid @enderror">
                    <option value="" disabled selected>Selecciona un municipio</option>
                    @forEach($municipios as $municipio)
                    <option value="{{ $municipio->id }}" {{ old('municipio_id')==$municipio->id ? 'selected' : '' }}>{{
                        $municipio->municipio }}</option>
                    @endForEach
                </select>
                @error('municipio_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Código Postal</label>
                <input type="number" name="codigo_postal"
                    class="form-control @error('codigo_postal') is-invalid @enderror" placeholder="Ej. 64000"
                    value="{{ old('codigo_postal') }}" maxlength="5" pattern="\d{5}">
                @error('codigo_postal')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-8 mb-3">
                <label class="form-label fw-semibold">Colonia</label>
                <select name="colonia_id" class="form-select @error('colonia_id') is-invalid @enderror">
                    <option value="" disabled {{ old('colonia_id') ? '' : 'selected' }}>Selecciona una colonia</option>
                </select>
                @error('colonia_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Comentario -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Comentario</label>
            <textarea name="comentario" class="form-control" rows="3"
                placeholder="Describe lo sucedido...">{{ old('comentario') }}</textarea>
        </div>

        <!-- Google Maps -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Ubicación</label>
            <div id="map" class="map-container" style="height: 280px;"></div>

            <button type="button" id="get-location" class="btn btn-primary w-100 py-2 fw-bold mt-3">
                📍 Usar mi ubicación actual
            </button>

            <input type="hidden" id="lat" name="lat" value="{{ old('lat') }}">
            <input type="hidden" id="lng" name="lng" value="{{ old('lng') }}">
        </div>

        <!-- Fotos -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Subir hasta 3 fotos</label>
            <input type="file" name="fotos[]" class="form-control" multiple accept="image/*" max="3">
            <small class="form-text text-muted">Si el formulario falla, debes volver a seleccionar las fotos (por
                seguridad el navegador no repuebla archivos).</small>
        </div>

        <!-- Botón -->
        <div class="text-center">
            <button type="submit" class="btn btn-dark px-5">Enviar reporte</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<!-- Google Maps API -->
<script
    src="https://maps.googleapis.com/maps/api/js?quarterly&region=MX&language=es&key=AIzaSyAcaQ7bBft6w89zoAteFbP9kaPc7kd0D3Y&libraries=places&callback=initMap"
    async defer></script>
<script>
    let map, marker;

    document.querySelector('form').addEventListener('submit', function (e) {
        const lat = document.getElementById('lat').value;
        const lng = document.getElementById('lng').value;

        if (!lat || !lng) {
            e.preventDefault(); // Evita que se envíe el formulario
            alert('Por favor selecciona tu ubicación en el mapa antes de enviar el reporte.');
        }
    });

    function initMap() {
        const center = { lat: 20.127597, lng: -98.731807 };
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 16,
            center: center,
        });

        marker = new google.maps.Marker({
            position: center,
            map: map,
            draggable: true,
        });

        // // Guardar lat/lng inicial
        // document.getElementById('lat').value = center.lat;
        // document.getElementById('lng').value = center.lng;

        // Cuando el usuario arrastre el marcador
        google.maps.event.addListener(marker, 'dragend', function (event) {
            document.getElementById('lat').value = event.latLng.lat();
            document.getElementById('lng').value = event.latLng.lng();
        });

        // Cuando el usuario haga clic en el mapa
        google.maps.event.addListener(map, 'click', function (event) {
            const clickedLocation = event.latLng;
            marker.setPosition(clickedLocation);
            document.getElementById('lat').value = clickedLocation.lat();
            document.getElementById('lng').value = clickedLocation.lng();
        });
    }

    // Botón para usar la ubicación actual
    document.getElementById('get-location').addEventListener('click', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    const coords = { lat: pos.coords.latitude, lng: pos.coords.longitude };
                    map.setCenter(coords);
                    marker.setPosition(coords);
                    document.getElementById('lat').value = coords.lat;
                    document.getElementById('lng').value = coords.lng;
                },
                (error) => {
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            alert("Debes permitir el acceso a tu ubicación.");
                            break;
                        case error.POSITION_UNAVAILABLE:
                            alert("La ubicación no está disponible.");
                            break;
                        case error.TIMEOUT:
                            alert("Tiempo de espera agotado.");
                            break;
                        default:
                            alert("No se pudo obtener tu ubicación.");
                    }
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        } else {
            alert("Tu navegador no soporta geolocalización.");
        }
    });

    document.getElementById('anonimoSwitch').addEventListener('change', function () {
        const isAnon = this.checked;

        // Selecciona todos los inputs de contacto/redes
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
    });

    const municipioSelect = document.querySelector('select[name="municipio_id"]');
    const cpInput = document.querySelector('input[name="codigo_postal"]');
    const coloniaSelect = document.querySelector('select[name="colonia_id"]');

    function cargarColonias() {
        const municipioId = municipioSelect.value;
        const codigoPostal = cpInput.value;

        // Solo dispara si hay municipio y CP de 5 dígitos
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

    // Detectar cambios
    municipioSelect.addEventListener('change', cargarColonias);
    cpInput.addEventListener('input', cargarColonias);
</script>
@endsection