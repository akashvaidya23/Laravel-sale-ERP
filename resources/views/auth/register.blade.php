@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div
        style="display: flex;flex-direction: column;flex-wrap: wrap;width: 350px;max-width: 95%;margin-right: auto;margin-left: auto;margin-top: 30px;border: 1px solid black;border-radius: 20px;padding: 10px;justify-content: center; align-items: center; gap: 10px">
        <h4 style="text-align: center">Register Here</h4>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div>
                <label for="">Name</label>
                <br>
                <input style="border: 1px solid black" class="form-control" type="text" name="name" id="name"
                    autocomplete="off" value="{{ old('name') }}" required>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <br>
            <div>
                <label for="email">Email</label>
                <br>
                <input style="border: 1px solid black" class="form-control" type="email" name="email" id="email"
                    autocomplete="off" value="{{ old('email') }}" required>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <br>
            <div>
                <label for="password">Password</label>
                <br>
                <input style="border: 1px solid black" class="form-control" type="password" name="password" id="password"
                    autocomplete="off" required>
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <br>
            <div>
                <label for="confirm_password">Name</label>
                <br>
                <input style="border: 1px solid black" class="form-control" type="password" name="password_confirmation"
                    id="password_confirmation" autocomplete="off" required>
            </div>
            <br>
            <div style="display: inline-flex; justify-content: center; gap: 10px; width: 100%; text-align: center;">
                <button type="submit" class="btn btn-dark">Register</button>
            </div>
        </form>
    </div>
    <p style="text-align: center">
        Aleady Registered ? <a style="text-decoration: none" href="{{ route('login') }}">Login</a>
    </p>
@endsection
