@extends('layouts.app')

@section('title', 'Add Products')

@section('content')
    <div
        style="display: flex;flex-direction: column;flex-wrap: wrap;width: 350px;max-width: 95%;margin-right: auto;margin-left: auto;margin-top: 30px;border: 1px solid black;border-radius: 20px;padding: 10px;justify-content: center; align-items: center; gap: 10px">
        <h4>Create New Customer</h4>
        <form action="{{ route('product.update', [$product->id]) }}" method="POST">
            @method('PUT')
            @csrf
            <div>
                <label for="name">Name:</label>
                <br>
                <input class="form-control" type="text" id="name" name="name" value="{{ $product->name }}" autofocus
                    autocomplete="off" />
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <br>
            <div>
                <label for="name">Amount:</label>
                <br>
                <input class="form-control" type="number" id="amount" name="amount" value="{{ $product->amount }}"
                    autocomplete="off" />
                @error('email')
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
