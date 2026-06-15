<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    public function getConvertedData($amount, $fromCurrency)
    {
        $toCurrency = $fromCurrency === 'EUR' ? 'USD' : 'EUR';

        try {
            $response = Http::get("https://open.er-api.com/v6/latest/{$fromCurrency}");

            if ($response->successful()) {
                $rates = $response->json()['rates'];
                $rate = $rates[$toCurrency] ?? ($fromCurrency === 'EUR' ? 1.08 : 0.92);

                return [
                    'price' => round($amount * $rate, 2),
                    'currency' => $toCurrency
                ];
            }
        } catch (\Exception $e) {
            Log::error('Currency API kļūda: ' . $e->getMessage());
        }

        $fallbackRate = $fromCurrency === 'EUR' ? 1.08 : 0.92;
        return [
            'price' => round($amount * $fallbackRate, 2),
            'currency' => $toCurrency
        ];
    }
}
