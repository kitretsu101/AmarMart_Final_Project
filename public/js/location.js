/**
 * AmarMart — Current Location Feature
 * ------------------------------------
 * 1) HTML5 Geolocation API → get latitude & longitude
 * 2) Fetch API (AJAX) → Laravel reverse-geocode endpoint
 * 3) Laravel → OpenStreetMap Nominatim → City / District / Country
 * 4) Update navbar text + Google Map (no page reload)
 */
(function () {
    'use strict';

    const textEl     = document.getElementById('navLocationText');
    const spinnerEl  = document.getElementById('navLocationSpinner');
    const alertEl    = document.getElementById('navLocationAlert');
    const mapWrap    = document.getElementById('navMapWrap');
    const mapFrame   = document.getElementById('navMapFrame');
    const mapHidden  = document.getElementById('navMapHiddenMsg');

    // Shared state for checkout page autofill
    window.AmarMartLocation = window.AmarMart?.sessionLocation || null;

    function csrf() {
        return document.querySelector('meta[name="csrf-token"]')?.content || '';
    }

    function setLoading() {
        if (!textEl) return;
        textEl.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Loading...';
        hideMap();
        hideAlert();
    }

    function setUnavailable(reason) {
        if (textEl) {
            textEl.textContent = 'Location unavailable';
        }
        hideMap();
        if (alertEl && reason) {
            alertEl.textContent = reason;
            alertEl.classList.remove('d-none');
        }
        // Dispatch event so checkout can react
        window.dispatchEvent(new CustomEvent('amarmart:location', {
            detail: { success: false, message: reason || 'Location unavailable' },
        }));
    }

    function hideAlert() {
        alertEl?.classList.add('d-none');
    }

    function hideMap() {
        mapWrap?.classList.add('d-none');
        mapHidden?.classList.remove('d-none');
        if (mapFrame) mapFrame.removeAttribute('src');
    }

    function showMap(lat, lng) {
        if (!mapFrame || !mapWrap) return;
        mapFrame.src = `https://maps.google.com/maps?q=${lat},${lng}&z=15&output=embed`;
        mapWrap.classList.remove('d-none');
        mapHidden?.classList.add('d-none');
    }

    function setSuccess(data) {
        const display = data.display || 'Current location';
        if (textEl) {
            // Icon stays in the navbar Blade markup — only update the label text
            textEl.textContent = display;
        }
        hideAlert();
        showMap(data.latitude, data.longitude);

        window.AmarMartLocation = data;

        window.dispatchEvent(new CustomEvent('amarmart:location', {
            detail: { success: true, location: data },
        }));
    }

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    /**
     * Call Laravel → Nominatim reverse geocoding (AJAX, no reload)
     */
    async function reverseGeocode(lat, lng) {
        const base = window.AmarMart?.routes?.locationReverse;
        if (!base) throw new Error('Location API route missing.');

        const url = base + '?latitude=' + encodeURIComponent(lat) + '&longitude=' + encodeURIComponent(lng);

        const res = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrf(),
            },
        });

        const data = await res.json().catch(() => ({}));

        if (!res.ok || !data.success) {
            throw new Error(data.message || 'API Failure: could not resolve location.');
        }

        return data;
    }

    /**
     * Persist location in Laravel session (for checkout autofill)
     */
    async function storeLocation(data) {
        const url = window.AmarMart?.routes?.locationStore;
        if (!url) return;

        try {
            await fetch(url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf(),
                },
                body: JSON.stringify({
                    latitude: data.latitude,
                    longitude: data.longitude,
                    city: data.city,
                    district: data.district,
                    country: data.country,
                    display: data.display,
                    full_address: data.full_address,
                }),
            });
        } catch (_) {
            // Non-fatal — navbar still works without session store
        }
    }

    /**
     * Main flow: request browser permission → reverse geocode → update UI
     */
    function detectLocation() {
        if (!textEl) return; // layout without navbar location

        // If session already has location, show it immediately (still refresh in background optional)
        if (window.AmarMart?.sessionLocation?.success) {
            setSuccess(window.AmarMart.sessionLocation);
            return;
        }

        if (!navigator.geolocation) {
            setUnavailable('Geolocation is not supported by this browser.');
            return;
        }

        setLoading();

        navigator.geolocation.getCurrentPosition(
            async (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                try {
                    // AJAX reverse geocoding (no page reload)
                    const data = await reverseGeocode(lat, lng);
                    setSuccess(data);
                    await storeLocation(data);
                } catch (err) {
                    // Still show coords-based fallback if API fails
                    const fallback = {
                        success: true,
                        latitude: Number(lat.toFixed(8)),
                        longitude: Number(lng.toFixed(8)),
                        city: null,
                        district: null,
                        country: null,
                        display: 'Current location',
                        full_address: '',
                    };
                    setSuccess(fallback);
                    showAlertSoft(err.message || 'Could not resolve city name.');
                    await storeLocation(fallback);
                }
            },
            (error) => {
                let reason = 'Location unavailable';
                if (error.code === error.PERMISSION_DENIED) {
                    reason = 'Permission denied. Enable location access in your browser.';
                } else if (error.code === error.POSITION_UNAVAILABLE) {
                    reason = 'Location unavailable from your device.';
                } else if (error.code === error.TIMEOUT) {
                    reason = 'Location request timed out.';
                }
                setUnavailable(reason);
            },
            {
                enableHighAccuracy: true,
                timeout: 12000,
                maximumAge: 60000,
            }
        );
    }

    function showAlertSoft(message) {
        if (!alertEl) return;
        alertEl.textContent = message;
        alertEl.classList.remove('d-none', 'alert-warning');
        alertEl.classList.add('alert-info');
    }

    // Auto-run when page loads (asynchronous — does not block UI)
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', detectLocation);
    } else {
        detectLocation();
    }

    // Expose for checkout page reuse
    window.AmarMartDetectLocation = detectLocation;
})();
