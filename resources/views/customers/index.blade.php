@extends('layouts.app')

@section('title', 'Customers')

@section('content')
    @php
        $user = Auth::user();
    @endphp
    <div style="max-width: 70%; margin-left:auto; margin-right:auto; margin-top: 20px;">
    @section('success')
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('danger'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('danger') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    @endsection

    <h4 style="text-align: center">List of Customers</h4>
    <br>
    <a class="btn btn-primary" href="{{ route('customer.create') }}">Add New Customer</a>
    <input type="text" placeholder="Search Customer" id="search_customer" name="search_customer"
        style="float: right">
    <br> <br>
    <table class="table table-striped" id="list_customers">
        <thead>
            <tr>
                <th style="border: 1px solid black; text-align: center">Sr. No</th>
                <th style="border: 1px solid black; text-align: center">Name</th>
                <th style="border: 1px solid black; text-align: center">Mobile</th>
                <th style="border: 1px solid black; text-align: center">Email</th>
                <th style="border: 1px solid black; text-align: center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $key => $customer)
                <tr>
                    <td style="border: 1px solid black; text-align: center">{{ $customers->firstItem() + $key }}</td>
                    <td style="border: 1px solid black; text-align: center">{{ $customer->name }}</td>
                    <td style="border: 1px solid black; text-align: center">{{ $customer->phone }}</td>
                    <td style="border: 1px solid black; text-align: center">{{ $customer->email }}</td>
                    <td style="border: 1px solid black; text-align: center">
                        <div style="display: inline-flex; align-items: center; gap: 10px;">
                            <a class="btn btn-info" href="{{ route('customer.edit', [$customer->id]) }}">Edit</a>
                            <form action="{{ route('customer.destroy', [$customer->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $customers->links() }}
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#search_customer').on('input', function() {
            $.ajax({
                url: '/search/customer',
                method: 'GET',
                data: {
                    'search_text': $("#search_customer").val()
                },
                success: function(response) {
                    console.log(response);
                    if (response.table)
                        $('#list_customers tbody').html(response.table);
                    else
                        $('#list_customers tbody').html('No records found');
                },
                error: function(error) {
                    console.log('Error:', error.responseJSON);
                }
            });
        });
    });
</script>
@endsection
