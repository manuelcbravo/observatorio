@extends('layouts.app')

@section('content')
<div class="mx-auto flex w-full max-w-5xl flex-col gap-6">
    <div class="flex flex-col gap-3 rounded-3xl border border-slate-200 bg-white/70 p-6 shadow-sm md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Observatorio ciudadano</p>
            <h3 class="mt-2 text-2xl font-bold text-slate-900 md:text-3xl">Levantar reporte ciudadano</h3>
            <p class="mt-2 text-sm text-slate-500">Comparte tu reporte con la mayor precisión posible. Tus datos de contacto son opcionales y puedes enviar de forma anónima.</p>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xl">
        @if(session('success'))
            <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                <strong class="font-semibold">✅ Éxito:</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="mb-5 rounded-2xl border border-sky-200 bg-sky-50 px-4 py-3 text-sm text-sky-800">
                <strong class="font-semibold">ℹ️ Información:</strong> {{ session('info') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reportes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="rounded-2xl border border-sky-100 bg-sky-50/60 p-4">
                <p class="text-sm font-semibold text-slate-600">Acceder rápidamente con</p>
                <div class="mt-3 flex flex-wrap gap-2">
                    <a href="{{ route('socialite.redirect', ['provider' => 'google']) }}" class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md" data-provider="google" data-socialite>
                        <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/google.svg" alt="Google" width="18" height="18">
                        Google
                    </a>
                    <a href="{{ route('socialite.redirect', ['provider' => 'facebook']) }}" class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md" data-provider="facebook" data-socialite>
                        <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/facebook.svg" alt="Facebook" width="18" height="18">
                        Facebook
                    </a>
                    <a href="{{ route('socialite.redirect', ['provider' => 'twitter']) }}" class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md" data-provider="twitter" data-socialite>
                        <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/twitter.svg" alt="Twitter" width="18" height="18">
                        Twitter / X
                    </a>
                </div>
                <p class="mt-2 text-xs text-slate-500">Botones listos para integrar Socialite con tus proveedores.</p>
            </div>

            <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                <div>
                    <p class="text-sm font-semibold text-slate-800">Enviar de forma anónima</p>
                    <p class="text-xs text-slate-500">Si activas esta opción ocultaremos tus datos de contacto.</p>
                </div>
                <label class="relative inline-flex cursor-pointer items-center">
                    <input type="hidden" name="anonimo" value="0">
                    <input class="peer sr-only" type="checkbox" id="anonimoSwitch" name="anonimo" value="1" @checked(old('anonimo'))>
                    <div class="h-6 w-11 rounded-full bg-slate-300 after:absolute after:left-1 after:top-1 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition peer-checked:bg-emerald-500 peer-checked:after:translate-x-5"></div>
                </label>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-700">Nombre de contacto</label>
                    <input type="text" name="nombre_contacto" class="contact-field mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('nombre_contacto') border-rose-400 ring-rose-200 @enderror" placeholder="Escribe tu nombre completo" value="{{ old('nombre_contacto') }}">
                    @error('nombre_contacto')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Teléfono de contacto (Whatsapp/Telegram)</label>
                    <input type="number" name="telefono_contacto" class="contact-field mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('telefono_contacto') border-rose-400 ring-rose-200 @enderror" placeholder="10 dígitos" value="{{ old('telefono_contacto') }}">
                    @error('telefono_contacto')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="text-sm font-semibold text-slate-700">Facebook</label>
                    <input type="url" name="facebook" class="contact-field mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200" placeholder="https://facebook.com/usuario" value="{{ old('facebook') }}">
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Twitter / X</label>
                    <input type="url" name="twitter" class="contact-field mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200" placeholder="https://x.com/usuario" value="{{ old('twitter') }}">
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Instagram</label>
                    <input type="url" name="instagram" class="contact-field mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200" placeholder="https://instagram.com/usuario" value="{{ old('instagram') }}">
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-700">Tipo de reporte <span class="text-xs font-normal text-slate-400">(agua, bache, basura, etc...)</span></label>
                    <select name="tipo_reporte_id" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('tipo_reporte_id') border-rose-400 ring-rose-200 @enderror" required>
                        <option value="" disabled {{ old('tipo_reporte_id') ? '' : 'selected' }}>Selecciona un tipo de reporte</option>
                        @forEach($tipo_reporte as $tipo)
                            <option value="{{ $tipo->id }}" {{ old('tipo_reporte_id')==$tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                        @endForEach
                    </select>
                    @error('tipo_reporte_id')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Estado</label>
                    <input type="hidden" name="estado_id" value="{{ $estados->first()->id }}">
                    <input type="text" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-500" value="{{ $estados->first()->estado }}" readonly>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Municipio</label>
                    <select name="municipio_id" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('municipio_id') border-rose-400 ring-rose-200 @enderror">
                        <option value="" disabled>Selecciona un municipio</option>
                        @forEach($municipios as $municipio)
                            <option value="{{ $municipio->id }}" {{ old('municipio_id', 47)==$municipio->id ? 'selected' : '' }}>{{ $municipio->municipio }}</option>
                        @endForEach
                    </select>
                    @error('municipio_id')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Código Postal <small class="text-muted"> (El código postal carga las colonias) </small></label>
                    <input type="number" name="codigo_postal" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('codigo_postal') border-rose-400 ring-rose-200 @enderror" placeholder="Ej. 64000" value="{{ old('codigo_postal') }}"  required
                    maxlength="5"
                    pattern="[0-9]{5}"
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,5);">
                    @error('codigo_postal')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="text-sm font-semibold text-slate-700">Colonia</label>
                    <select name="colonia_id" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('colonia_id') border-rose-400 ring-rose-200 @enderror" required data-selected="{{ old('colonia_id') }}">
                        <option value="" disabled {{ old('colonia_id') ? '' : 'selected' }}>Selecciona una colonia</option>
                    </select>
                    @error('colonia_id')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">Comentario</label>
                <textarea name="comentario" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200" rows="3" placeholder="Describe lo sucedido...">{{ old('comentario') }}</textarea>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-800">Ubicación precisa</p>
                        <p class="text-xs text-slate-500">Desliza el pin o usa geolocalización para precisión máxima.</p>
                    </div>
                    <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-600 shadow-sm" id="location-status">Coloca el pin en la ubicación exacta</span>
                </div>
                <div class="mt-3 flex flex-col gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600 md:flex-row md:items-center md:justify-between">
                    <span>Coordenadas</span>
                    <span class="font-semibold text-slate-900" id="coords-display">--</span>
                </div>
                <div class="mt-3 h-80 w-full overflow-hidden rounded-2xl border border-slate-200" id="map"></div>
                <div class="mt-3 grid gap-2 md:grid-cols-2">
                    <button type="button" id="open-location-modal" class="rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/20">📍 Capturar mi ubicación</button>
                    <button type="button" id="center-marker" class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm">Recentrar marcador</button>
                </div>
                <p class="mt-2 text-xs text-slate-500" id="accuracy-text">Precisión no calculada aún.</p>
                <input type="hidden" id="lat" name="lat" value="{{ old('lat') }}">
                <input type="hidden" id="lng" name="lng" value="{{ old('lng') }}">
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">Subir hasta 4 fotos</label>
                <div class="mt-2 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 p-4 text-center transition hover:border-sky-300 hover:bg-sky-50/40" id="fotos-dropzone">
                    <input type="file" name="fotos[]" id="fotos-input" class="sr-only" multiple accept="image/*">
                    <label for="fotos-input" class="cursor-pointer">
                        <div class="text-sm font-semibold text-slate-700">Arrastra y suelta tus imágenes aquí</div>
                        <div class="mt-1 text-xs text-slate-500">o haz clic para seleccionar archivos (máximo 4).</div>
                    </label>
                </div>
                <div class="mt-3 grid gap-3 sm:grid-cols-4" id="fotos-preview">
                    @for($i = 0; $i < 4; $i++)
                        <div class="flex h-20 items-center justify-center rounded-xl border border-dashed border-slate-200 bg-white text-xs text-slate-400" data-foto-slot>
                            Vista previa
                        </div>
                    @endfor
                </div>
                <p class="mt-2 text-xs text-slate-500" id="fotos-helper">0 de 4 imágenes seleccionadas.</p>
                <p class="mt-1 text-xs text-slate-500">Si el formulario falla, vuelve a seleccionar las fotos (el navegador no repuebla archivos por seguridad).</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-sm font-semibold text-slate-700">Verificación reCAPTCHA</p>
                <p class="text-xs text-slate-500">Protege el envío con reCAPTCHA de Google. Configura tu sitio y secreto en las variables de entorno.</p>
                <div class="mt-3">
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="rounded-xl bg-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-600/30 transition hover:bg-sky-700">Enviar reporte</button>
            </div>
        </form>
    </div>
</div>

<div class="fixed inset-0 z-40 hidden items-center justify-center bg-slate-900/60 px-4" id="locationModal" aria-hidden="true">
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
        <div class="flex items-start justify-between">
            <h5 class="text-lg font-semibold text-slate-900">Permitir acceso a tu ubicación</h5>
            <button type="button" class="rounded-full bg-slate-100 px-3 py-1 text-sm text-slate-600" data-close-modal>Cerrar</button>
        </div>
        <div class="mt-4 flex gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-sky-600 text-xl text-white">📍</div>
            <p class="text-sm text-slate-600">Usaremos tu GPS solo para este reporte. Mejora la precisión y acelera la atención de tu solicitud.</p>
        </div>
        <ul class="mt-4 list-disc space-y-2 pl-5 text-xs text-slate-500">
            <li>Activa el GPS para obtener coordenadas exactas.</li>
            <li>Si estás en interiores, acércate a una ventana para mayor precisión.</li>
            <li>Podrás ajustar el pin manualmente después de capturar la ubicación.</li>
        </ul>
        <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:justify-end">
            <button type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600" data-close-modal>Ahora no</button>
            <button type="button" id="confirm-location" class="rounded-xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white">Permitir ubicación precisa</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://maps.googleapis.com/maps/api/js?region=MX&language=es&key={{ config('services.google_maps.key') }}&libraries=places&callback=initMap" async defer></script>
<script>
    let map, marker;

    const locationStatus = document.getElementById('location-status');
    const coordsDisplay = document.getElementById('coords-display');
    const accuracyText = document.getElementById('accuracy-text');
    const latInput = document.getElementById('lat');
    const lngInput = document.getElementById('lng');
    const centerButton = document.getElementById('center-marker');
    const modalTrigger = document.getElementById('open-location-modal');
    const confirmLocationBtn = document.getElementById('confirm-location');
    const locationModal = document.getElementById('locationModal');
    const closeModalButtons = document.querySelectorAll('[data-close-modal]');

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
            info: 'rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-600 shadow-sm',
            success: 'rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700',
            warning: 'rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700',
            danger: 'rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700'
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
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: center,
            streetViewControl: false,
            mapTypeControl: false,
            fullscreenControl: false
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

    function openModal() {
        locationModal.classList.remove('hidden');
        locationModal.classList.add('flex');
        locationModal.setAttribute('aria-hidden', 'false');
    }

    function closeModal() {
        locationModal.classList.add('hidden');
        locationModal.classList.remove('flex');
        locationModal.setAttribute('aria-hidden', 'true');
    }

    modalTrigger.addEventListener('click', openModal);
    closeModalButtons.forEach(button => button.addEventListener('click', closeModal));

    confirmLocationBtn.addEventListener('click', () => {
        closeModal();
        requestLocation();
    });

    centerButton.addEventListener('click', recenterMarker);

    function toggleContactFields(isAnon) {
        const fields = document.querySelectorAll('.contact-field');
        fields.forEach(field => {
            if (isAnon) {
                field.value = "";
                field.setAttribute('disabled', 'disabled');
                field.classList.add('bg-slate-100');
            } else {
                field.removeAttribute('disabled');
                field.classList.remove('bg-slate-100');
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
    let selectedColoniaId = coloniaSelect?.dataset.selected || '';

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
                        const selected = selectedColoniaId && String(colonia.id) === String(selectedColoniaId) ? 'selected' : '';
                        coloniaSelect.innerHTML += `<option value="${colonia.id}" ${selected}>${colonia.nombre}</option>`;
                    });
                    selectedColoniaId = '';
                })
                .catch(() => {
                    coloniaSelect.innerHTML = '<option value="">Error al cargar colonias</option>';
                });
        }
    }

    municipioSelect.addEventListener('change', cargarColonias);
    cpInput.addEventListener('input', cargarColonias);

    if (municipioSelect.value && cpInput.value.length === 5) {
        cargarColonias();
    }

    const fotosInput = document.getElementById('fotos-input');
    const dropzone = document.getElementById('fotos-dropzone');
    const previewContainer = document.getElementById('fotos-preview');
    const helperText = document.getElementById('fotos-helper');
    const maxFotos = 4;

    const updatePreviews = (files) => {
        const slots = previewContainer.querySelectorAll('[data-foto-slot]');
        slots.forEach((slot, index) => {
            const file = files[index];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    slot.innerHTML = `<img src="${event.target.result}" alt="Vista previa ${index + 1}" class="h-full w-full rounded-xl object-cover">`;
                };
                reader.readAsDataURL(file);
            } else {
                slot.textContent = 'Vista previa';
                slot.classList.add('text-slate-400');
            }
        });
        if (helperText) {
            helperText.textContent = `${files.length} de ${maxFotos} imágenes seleccionadas.`;
        }
    };

    const enforceFileLimit = (files) => {
        const list = Array.from(files).slice(0, maxFotos);
        const transfer = new DataTransfer();
        list.forEach(file => transfer.items.add(file));
        fotosInput.files = transfer.files;
        updatePreviews(list);
    };

    if (fotosInput) {
        fotosInput.addEventListener('change', () => {
            enforceFileLimit(fotosInput.files);
        });
    }

    if (dropzone) {
        dropzone.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropzone.classList.add('border-sky-400', 'bg-sky-50/60');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('border-sky-400', 'bg-sky-50/60');
        });

        dropzone.addEventListener('drop', (event) => {
            event.preventDefault();
            dropzone.classList.remove('border-sky-400', 'bg-sky-50/60');
            if (event.dataTransfer?.files?.length) {
                enforceFileLimit(event.dataTransfer.files);
            }
        });
    }
</script>
@endsection
