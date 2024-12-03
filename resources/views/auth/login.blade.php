@extends('layouts.app')

@section('title', 'Login Page')

@section('content')

    <div
        style="display: flex;flex-direction: column;flex-wrap: wrap;width: 350px;max-width: 95%;margin-right: auto;margin-left: auto;margin-top: 30px;border: 1px solid black;border-radius: 20px;padding: 10px;justify-content: center; align-items: center; gap: 10px">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h4 style="text-align: center">Login Here</h4>
        <form action="{{ route('login_post') }}" method="POST">
            @csrf
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
            <div style="display: inline-flex; justify-content: center; gap: 10px; width: 100%; text-align: center;">
                <button type="submit" class="btn btn-dark">Login</button>
            </div>
        </form>
    </div>
    <p style="text-align: center; margin">
        New To Us? <a style="text-decoration: none" href="{{ route('register_page') }}">Register</a>
    </p>
@endsection
