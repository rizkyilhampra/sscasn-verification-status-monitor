@extends('layouts.app')

@section('content')
@if($errors->any())
<ul>
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
</ul>

@endif

<form action="{{ route('login') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password">
    </div>

    <button type="submit">Login</button>
</form>
@endsection
