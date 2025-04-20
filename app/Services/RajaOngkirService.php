<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl;
    protected $origin;

    public function __construct()
    {
        $this->apiKey = config('services.rajaongkir.api_key'); // Perhatikan 'services.'
        $this->baseUrl = config('services.rajaongkir.base_url');
        $this->origin = config('services.rajaongkir.origin');
    }

    public function testConnection()
    {
        $response = Http::withHeaders(['key' => $this->apiKey])
            ->get($this->baseUrl . '/city'); // PASTIKAN ADA SLASH SEBELUM 'city'
        
        return $response->status();
    }

    public function getShippingCost($destination, $weight, $courier = 'jne')
{
    $response = Http::withHeaders([
        'key' => $this->apiKey
    ])->post($this->baseUrl . '/cost', [  // Perhatikan slash sebelum 'cost'
        'origin' => $this->origin,
        'destination' => $destination,
        'weight' => $weight,
        'courier' => $courier
    ]);

    if ($response->failed()) {
        throw new \Exception("RajaOngkir API Error: " . $response->body());
    }

    return $response->json();
}
public function getBaseUrl()
{
    return $this->baseUrl;
}
}