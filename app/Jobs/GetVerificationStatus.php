<?php

namespace App\Jobs;

use App\Events\FinishGetVerificationStatus;
use App\Exceptions\InvalidVerificationStatusResult;
use App\Models\VerificationStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class GetVerificationStatus implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected VerificationStatus $verificationStatus
    ) {}

    public function handle(): void
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64; rv:130.0) Gecko/20100101 Firefox/130.0',
                'Accept' => 'application/json',
                'Accept-Language' => 'en-US,en;q=0.5',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
                'X-XSRF-TOKEN' => $this->verificationStatus->x_xsrf_token,
                'DNT' => '1',
                'Sec-GPC' => '1',
                'Connection' => 'keep-alive',
                'Sec-Fetch-Dest' => 'empty',
                'Sec-Fetch-Mode' => 'cors',
                'Sec-Fetch-Site' => 'same-origin',
            ])->withCookies($this->verificationStatus->cookies, 'daftar-sscasn.bkn.go.id')
                ->get('https://daftar-sscasn.bkn.go.id/resume/resume.json');

            throw_if(
                ! $response->successful(),
                new InvalidVerificationStatusResult(
                    $response, $this->verificationStatus, 'Failed to process'
                )
            );

            $result = $response->json();

            throw_if(
                ! isset($result['result']),
                new InvalidVerificationStatusResult(
                    $response, $this->verificationStatus, 'Invalid response or empty'
                )
            );

            $lulusVerifikasi = ($result['result']['lulusVerifikasi'] === null)
                ? 'Belum Diketahui'
                : $result['result']['lulusVerifikasi'];

            $this->verificationStatus->update([
                'status' => $lulusVerifikasi,
            ]);

            $this->verificationStatus->touch();

            event(new FinishGetVerificationStatus($this->verificationStatus, $lulusVerifikasi));

        } catch (InvalidVerificationStatusResult $e) {
            $e->report();
        }
    }
}
