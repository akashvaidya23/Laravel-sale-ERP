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


    <h4 style="text-align: center">List of Products</h4>
    <br>
    <a class="btn btn-primary" href="{{ route('product.create') }}">Add New Product</a>
    <input type="text" placeholder="Search Product" id="search_product" name="search_product" style="float: right">
    <br><br>
    <table class="table table-striped" id="list_products">
        <thead>
            <tr>
                <th style="border: 1px solid black; text-align: center">Sr. No</th>
                <th style="border: 1px solid black; text-align: center">Name of the Product</th>
                <th style="border: 1px solid black; text-align: center">Amount</th>
                <th style="border: 1px solid black; text-align: center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $key => $product)
                <tr>
                    <td style="border: 1px solid black; text-align: center">{{ $products->firstItem() + $key }}</td>
                    <td style="border: 1px solid black; text-align: center">{{ $product->name }}</td>
                    <td style="border: 1px solid black; text-align: center">
                        {{ '₹ ' . number_format($product->amount, 2) . ' /-' }}</td>
                    <td style="border: 1px solid black; text-align: center">
                        <div style="display: inline-flex; align-items: center; gap: 10px;">
                            <a class="btn btn-info" href="{{ route('product.edit', [$product->id]) }}">Edit</a>
                            <form action="{{ route('product.destroy', [$product->id]) }}" method="POST">
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
    {{ $products->links() }}
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#search_product').on('input', function() {
            $.ajax({
                url: '/search/product',
                method: 'GET',
                data: {
                    'search_text': $("#search_product").val()
                },
                success: function(response) {
                    console.log(response);
                    if (response.table)
                        $('#list_products tbody').html(response.table);
                    else
                        $('#list_products tbody').html('No records found');
                },
                error: function(error) {
                    console.log('Error:', error.responseJSON);
                }
            });
        });
    });
</script>
@endsection
