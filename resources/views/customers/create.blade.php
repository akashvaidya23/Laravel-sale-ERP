    @extends('layouts.app')

    @section('title', 'Add Customers')

    @section('content')
        <div
            style="display: flex;flex-direction: column;flex-wrap: wrap;width: 350px;max-width: 95%;margin-right: auto;margin-left: auto;margin-top: 30px;border: 1px solid black;border-radius: 20px;padding: 10px;justify-content: center; align-items: center; gap: 10px">
            <h4>Create New Customer</h4>
            <form action="{{ route('customer.store') }}" method="POST">
                @csrf
                <div>
                    <label for="name">Name:</label>
                    <br>
                    <input style="border: 1px solid black" class="form-control" type="text" id="name" name="name"
                        value="{{ old('name') }}" autofocus autocomplete="off" />
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <div>
                    <label for="name">Email:</label>
                    <br>
                    <input style="border: 1px solid black" class="form-control" type="email" id="email" name="email"
                        value="{{ old('email') }}" autocomplete="off" />
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <div>
                    <label for="name">Mobile:</label>
                    <br>
                    <input style="border: 1px solid black" class="form-control" type="number" id="phone" name="phone"
                        value="{{ old('phone') }}" maxlength="10" minlength="10" autocomplete="off" />
                    @error('phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <div style="text-align: center">
                    <button class="btn btn-dark" type="submit">Save</button>
                </div>
            </form>
        </div>
    @endsection
