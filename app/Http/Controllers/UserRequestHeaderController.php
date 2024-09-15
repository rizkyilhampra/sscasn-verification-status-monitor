<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessRequest;
use App\Models\User;
use App\Models\UserRequestHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRequestHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user-request-headers.index', [
            'userRequestHeaders' => UserRequestHeader::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user-request-headers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'curl_command' => 'required',
            'name' => 'required|exists:users',
            'phone_number' => 'required|exists:users',
        ]);

        $user = User::query()->firstOrCreate([
            'name' => $request->name,
        ], [
            'name' => $request->name,
            'email' => $request->name.'@example.com',
            'password' => Hash::make('password'),
            'phone_number' => $request->phone_number,
        ]);

        $parsedCurlCommand = $this->parseCurlCommand($request->curl_command);

        $userRequestHeader = $user->requestHeaders()->create([
            'cookie' => $parsedCurlCommand['cookies'],
            'x_xsrf_token' => $parsedCurlCommand['x_xsrf_token'],
        ]);

        dispatch(new ProcessRequest($userRequestHeader));

        return redirect()->route('user-request-headers.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserRequestHeader $userRequestHeader)
    {
        return view('user-request-headers.edit', compact('userRequestHeader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserRequestHeader $userRequestHeader)
    {
        $request->validate([
            'curl_command' => 'required',
        ]);

        $parsedCurlCommand = $this->parseCurlCommand($request->curl_command);

        $userRequestHeader->update([
            'cookie' => $parsedCurlCommand['cookies'],
            'x_xsrf_token' => $parsedCurlCommand['x_xsrf_token'],
        ]);

        dispatch(new ProcessRequest($userRequestHeader));

        return redirect()->route('user-request-headers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserRequestHeader $userRequestHeader)
    {
        $userRequestHeader->delete();

        return redirect()->route('user-request-headers.index');
    }

}
