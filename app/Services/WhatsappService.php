<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsappService
{
    public function send(string $rawPhone, string $message): bool
    {
        $provider = strtolower((string) env('WA_PROVIDER', 'gateway'));

        if ($provider === 'fonnte' || $provider === 'fonte') {
            return $this->sendFonnte($rawPhone, $message);
        }

        $url = env('WA_GATEWAY_URL');
        if (! $url) {
            return false;
        }

        $phone = $this->normalizePhone($rawPhone);
        if (! $phone) {
            return false;
        }

        $token = env('WA_GATEWAY_TOKEN');

        $request = Http::timeout(15);
        if ($token) {
            $request = $request->withHeaders([
                'Authorization' => 'Bearer '.$token,
            ]);
        }

        $response = $request->post($url, [
            'phone' => $phone,
            'message' => $message,
        ]);

        return $response->successful();
    }

    private function sendFonnte(string $rawPhone, string $message): bool
    {
        $token = env('FONNTE_TOKEN') ?: env('WA_GATEWAY_TOKEN');
        if (! $token) {
            return false;
        }

        $url = env('FONNTE_URL', 'https://api.fonnte.com/send');

        $target = $this->normalizePhoneForFonnte($rawPhone);
        if (! $target) {
            return false;
        }

        $payload = [
            'target' => $target['target'],
            'message' => $message,
        ];

        if ($target['countryCode']) {
            $payload['countryCode'] = $target['countryCode'];
        }

        $response = Http::timeout(15)
            ->withHeaders([
                'Authorization' => $token,
            ])
            ->asForm()
            ->post($url, $payload);

        return $response->successful();
    }

    private function normalizePhone(string $raw): ?string
    {
        $value = trim($raw);
        if ($value === '') {
            return null;
        }

        $isPlus = str_starts_with($value, '+');
        $digits = preg_replace('/\D+/', '', $value);
        if (! $digits) {
            return null;
        }

        if ($isPlus) {
            return '+'.$digits;
        }

        if (str_starts_with($digits, '0')) {
            return '+62'.substr($digits, 1);
        }

        if (str_starts_with($digits, '62')) {
            return '+'.$digits;
        }

        return '+'.$digits;
    }

    private function normalizePhoneForFonnte(string $raw): ?array
    {
        $value = trim($raw);
        if ($value === '') {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $value);
        if (! $digits) {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            return [
                'target' => $digits,
                'countryCode' => '62',
            ];
        }

        if (str_starts_with($digits, '62')) {
            return [
                'target' => $digits,
                'countryCode' => null,
            ];
        }

        return [
            'target' => $digits,
            'countryCode' => null,
        ];
    }
}
