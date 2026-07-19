<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Current Location API helpers.
 *
 * Browser → Geolocation API (lat/lng)
 * Laravel → OpenStreetMap Nominatim reverse geocoding (city/country)
 */
class LocationController extends Controller
{
    /**
     * Reverse-geocode latitude/longitude via Nominatim (AJAX JSON).
     *
     * GET /api/location/reverse?latitude=...&longitude=...
     */
    public function reverse(Request $request)
    {
        $validated = $request->validate([
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ], [
            'latitude.required'  => 'Latitude is required.',
            'latitude.numeric'   => 'Latitude must be a valid number.',
            'latitude.between'   => 'Latitude must be between -90 and 90.',
            'longitude.required' => 'Longitude is required.',
            'longitude.numeric'  => 'Longitude must be a valid number.',
            'longitude.between'  => 'Longitude must be between -180 and 180.',
        ]);

        $lat = (float) $validated['latitude'];
        $lng = (float) $validated['longitude'];

        try {
            // Nominatim requires a descriptive User-Agent.
            // withoutVerifying() avoids local XAMPP/OpenSSL CA issues during development.
            $response = Http::timeout(10)
                ->withoutVerifying()
                ->withHeaders([
                    'User-Agent' => 'AmarMart-University-Project/1.0 (contact: support@amarmart.com)',
                    'Accept'     => 'application/json',
                ])
                ->get('https://nominatim.openstreetmap.org/reverse', [
                    'format'           => 'json',
                    'lat'              => $lat,
                    'lon'              => $lng,
                    'zoom'             => 10,
                    'addressdetails'   => 1,
                    'accept-language'  => 'en',
                ]);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reverse geocoding API failed. Please try again.',
                    'display' => 'Location unavailable',
                ], 502);
            }

            $data    = $response->json();
            $address = $data['address'] ?? [];

            // Prefer city → town → village → county for the "city" label
            $city = $address['city']
                ?? $address['town']
                ?? $address['village']
                ?? $address['municipality']
                ?? null;

            $district = $address['state_district']
                ?? $address['county']
                ?? $address['state']
                ?? null;

            $country = $address['country'] ?? null;

            // Prefer a clean city label: "Khulna District" → "Khulna"
            $label = $city;
            if (!$label && $district) {
                $label = preg_replace('/\s+District$/i', '', $district);
            } elseif ($district && preg_match('/^(.+)\s+District$/i', $district, $m)) {
                // Use district city name when more recognizable (e.g. Khulna)
                $label = $m[1];
            }

            // Build short display: "Khulna, Bangladesh"
            $parts = array_filter([$label ?: $district, $country]);
            $display = !empty($parts) ? implode(', ', $parts) : ($data['display_name'] ?? 'Location found');

            // Full address for checkout autofill
            $fullAddress = $data['display_name'] ?? $display;

            $payload = [
                'success'      => true,
                'latitude'     => round($lat, 8),
                'longitude'    => round($lng, 8),
                'city'         => $city,
                'district'     => $district,
                'country'      => $country,
                'display'      => $display,
                'full_address' => $fullAddress,
            ];

            // Also keep in session for checkout page
            session(['user_location' => $payload]);

            return response()->json($payload);
        } catch (\Throwable $e) {
            Log::warning('Location reverse geocode failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Network error while resolving location.',
                'display' => 'Location unavailable',
            ], 503);
        }
    }

    /**
     * Store browser-detected location in session (AJAX).
     *
     * POST /api/location/store
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'latitude'     => 'required|numeric|between:-90,90',
            'longitude'    => 'required|numeric|between:-180,180',
            'city'         => 'nullable|string|max:255',
            'district'     => 'nullable|string|max:255',
            'country'      => 'nullable|string|max:255',
            'display'      => 'nullable|string|max:255',
            'full_address' => 'nullable|string|max:1000',
        ]);

        $payload = [
            'success'      => true,
            'latitude'     => round((float) $validated['latitude'], 8),
            'longitude'    => round((float) $validated['longitude'], 8),
            'city'         => $validated['city'] ?? null,
            'district'     => $validated['district'] ?? null,
            'country'      => $validated['country'] ?? null,
            'display'      => $validated['display'] ?? 'Current location',
            'full_address' => $validated['full_address'] ?? null,
        ];

        session(['user_location' => $payload]);

        return response()->json([
            'success' => true,
            'message' => 'Location saved to session.',
            'location' => $payload,
        ]);
    }

    /**
     * Return the location currently stored in session (AJAX).
     *
     * GET /api/location/current
     */
    public function current()
    {
        $location = session('user_location');

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'No location in session.',
            ], 404);
        }

        return response()->json([
            'success'  => true,
            'location' => $location,
        ]);
    }
}
