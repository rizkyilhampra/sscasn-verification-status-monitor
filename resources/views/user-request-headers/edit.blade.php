@extends('layouts.app')
@section('content')
@if($errors->any())
<ul>
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
</ul>
@endif

<form action="{{route('user-request-headers.update', $userRequestHeader->id)}}" method="post">
    @method('PUT')
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name">
    </div>

    <div class="form-group">
        <label for="curl_command">Curl Command</label>
        <textarea name="curl_command" id="curl_command"></textarea>
    </div>

    <div class="form-group">
        <label for="phone_number">Phone Number</label>
        <input type="number" name="phone_number" id="phone_number">
    </div>

    <button type="submit">Simpan</button>
</form>
@endsection
