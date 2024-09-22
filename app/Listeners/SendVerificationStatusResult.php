<?php

namespace App\Listeners;

use App\Events\FinishGetVerificationStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendVerificationStatusResult implements ShouldQueue
{
    public function handle(FinishGetVerificationStatus $event): void
    {
        $this->sendMessage(
            $event->verificationStatus->user->phone_number,
            'Hasil kelulusan verifikasi: '.$event->result
        );
    }

    /**
     * @param  mixed  $number
     * @param  mixed  $message
     */
    private function sendMessage($number, $message): void
    {
        $whatsappUri = env('WHATSAPP_API_URL');

        $whatsappUri = $whatsappUri.'/send-message';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($whatsappUri, [
            'number' => $number,
            'message' => $message,
        ]);

        if (! $response->successful()) {
            Log::error('Failed to send message to whatsapp', [
                'response' => $response->json(),
            ]);
        }
    }
}
