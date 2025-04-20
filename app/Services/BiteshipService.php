<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

// class BiteshipService
// {
//     protected $apiKey;
//     protected $baseUrl;
//     protected $originPostalCode;

//     public function __construct()
//     {
//         $this->apiKey = config('services.biteship.api_key');
//         $this->baseUrl = config('services.biteship.base_url');
//         $this->originPostalCode = config('services.biteship.origin_postal_code');
        
//         if (empty($this->apiKey)) {
//             throw new \RuntimeException('Biteship API key not configured. Please set BITESHIP_API_KEY in your .env file');
//         }
        
//         if (empty($this->originPostalCode)) {
//             throw new \RuntimeException('Seller postal code not configured. Please set SELLER_POSTAL_CODE in your .env file');
//         }
//     }

//     public function getShippingRates($destinationPostalCode, $weight)
//     {
//         try {
//             $response = Http::withHeaders([
//                 'Authorization' => $this->apiKey,
//                 'Content-Type' => 'application/json',
//             ])->post("{$this->baseUrl}/v1/rates/couriers", [
//                 'origin_postal_code' => $this->originPostalCode,
//                 'destination_postal_code' => $destinationPostalCode,
//                 'weight' => $weight,
//                 'couriers' => 'jne,jnt,sicepat,anteraja,gosend,grab,lex'
//             ]);
    
//             if ($response->failed()) {
//                 Log::error('Biteship API Error', [
//                     'status' => $response->status(),
//                     'headers' => $response->headers(),
//                     'body' => $response->body(),
//                     'request' => [
//                         'origin' => $this->originPostalCode,
//                         'destination' => $destinationPostalCode,
//                         'weight' => $weight
//                     ]
//                 ]);
//                 return null;
//             }
    
//             return $response->json();
//         } catch (\Exception $e) {
//             Log::error('Biteship Service Exception', [
//                 'message' => $e->getMessage(),
//                 'trace' => $e->getTraceAsString()
//             ]);
//             return null;
//         }
//     }
// }