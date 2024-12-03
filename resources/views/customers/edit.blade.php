@extends('layouts.app')

@section('title', 'Add Customers')

@section('content')
    <div
        style="display: flex;flex-direction: column;flex-wrap: wrap;width: 350px;max-width: 95%;margin-right: auto;margin-left: auto;margin-top: 30px;border: 1px solid black;border-radius: 20px;padding: 10px;justify-content: center; align-items: center; gap: 10px">
        <h4>Edit Customer</h4>
        <form action="{{ route('customer.update', [$customer->id]) }}" method="POST">
            @method('PUT')
            @csrf
            <div>
                <label for="name">Name:</label>
                <br>
                <input type="text" id="name" name="name" value="{{ $customer->name }}" autofocus autocomplete="off" />
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <br>
            <div>
                <label for="name">Email:</label>
                <br>
                <input type="email" id="email" name="email" value="{{ $customer->email }}" autocomplete="off" />
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <br>
            <div>
                <label for="name">Mobile:</label>
                <br>
                <input type="number" id="phone" name="phone" value="{{ $customer->phone }}" maxlength="10"
                    minlength="10" autocomplete="off" />
                @error('phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <br>
            <div style="text-align: center">
                <button class="btn btn-dark" type="submit">Update</button>
            </div>
        </form>
    </div>
@endsection
