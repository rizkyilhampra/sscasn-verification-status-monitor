<?php
namespace App\Jobs;

use App\Events\ResumeProcessed;
use App\Exceptions\InvalidResponseProcessRequest;
use App\Models\UserRequestHeader;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProcessRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected UserRequestHeader $userRequestHeader
    ) {}

    public function handle(): void
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64; rv:130.0) Gecko/20100101 Firefox/130.0',
                'Accept' => 'application/json',
                'Accept-Language' => 'en-US,en;q=0.5',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
                'X-XSRF-TOKEN' => $this->userRequestHeader->x_xsrf_token,
                'DNT' => '1',
                'Sec-GPC' => '1',
                'Connection' => 'keep-alive',
                'Sec-Fetch-Dest' => 'empty',
                'Sec-Fetch-Mode' => 'cors',
                'Sec-Fetch-Site' => 'same-origin',
            ])->withCookies($this->userRequestHeader->cookie, 'daftar-sscasn.bkn.go.id')
                ->get('https://daftar-sscasn.bkn.go.id/resume/resume.json');

            throw_if(
                ! $response->successful(),
                new InvalidResponseProcessRequest(
                    $response, $this->userRequestHeader, 'Failed to process request'
                )
            );

            $result = $response->json();

            throw_if(
                ! isset($result['result']),
                new InvalidResponseProcessRequest(
                    $response, $this->userRequestHeader, 'Invalid response or empty'
                )
            );

            $lulusVerifikasi = ($result['result']['lulusVerifikasi'] === null)
                ? 'Belum Diketahui'
                : $result['result']['lulusVerifikasi'];

            event(new ResumeProcessed($this->userRequestHeader, $lulusVerifikasi));
        } catch (InvalidResponseProcessRequest $e) {
            $e->report();
        }
    }
}
