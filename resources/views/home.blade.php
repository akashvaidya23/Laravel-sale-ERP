@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    @php
        $user = Auth::user();
    @endphp
    <div>
        <p>Welcome {{ $user->name }}</p>
    </div>
@endsection
