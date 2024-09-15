@extends('layouts.app')

@section('content')

<a href="{{route('user-request-headers.create')}}">Create</a>

<table>
    <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Last Update</th>
        </tr>
    </thead>
    <tbody>
        @forelse($userRequestHeaders as $userRequestHeader)
        <tr>
            <td>
                <a href="{{route('user-request-headers.edit', $userRequestHeader->id)}}">Edit</a>
                <form action="{{route('user-request-headers.destroy', $userRequestHeader->id)}}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>

            </td>
            <td>{{$loop->iteration}}</td>
            <td>{{$userRequestHeader->user->name}}</td>
            <td>{{$userRequestHeader->user->phone_number}}</td>
            <td>{{$userRequestHeader->updated_at}}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4">No data</td>
        </tr>
        @endforelse
    </tbody>
</table>
