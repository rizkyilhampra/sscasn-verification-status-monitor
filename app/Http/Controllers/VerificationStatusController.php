<?php

namespace App\Http\Controllers;

use App\Jobs\GetVerificationStatus;
use App\Models\VerificationStatus;
use Illuminate\Http\Request;

class VerificationStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('verification-status.verification-status', [
            'verificationStatus' => auth('web')->user()->verificationStatus,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('verification-status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'curl_command' => 'required',
        ]);

        $parsedCurlCommand = $this->parseCurlCommand($request->curl_command);

        $verificationStatus = $request->user()->verificationStatus()->create([
            'x_xsrf_token' => $parsedCurlCommand['x_xsrf_token'],
            'cookies' => $parsedCurlCommand['cookies'],
            'status' => 'Sedang diproses'
        ]);

        dispatch(new GetVerificationStatus($verificationStatus));

        return redirect()->route('verification-status.verification-status');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VerificationStatus $verificationStatus)
    {
        return view('verification-status.edit', compact('verificationStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VerificationStatus $verificationStatus)
    {
        $request->validate([
            'curl_command' => 'required',
        ]);

        $parsedCurlCommand = $this->parseCurlCommand($request->curl_command);

        $verificationStatus->update([
            'cookies' => $parsedCurlCommand['cookies'],
            'x_xsrf_token' => $parsedCurlCommand['x_xsrf_token'],
        ]);

        $verificationStatus->touch();

        dispatch(new GetVerificationStatus($verificationStatus));

        return redirect()->route('verification-status.verification-status');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VerificationStatus $verificationStatus)
    {
        $verificationStatus->delete();

        return redirect()->route('verification-status.verification-status');
    }
}
