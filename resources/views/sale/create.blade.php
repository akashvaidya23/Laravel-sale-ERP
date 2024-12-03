@extends('layouts.app')

@section('title', 'Customers')

@section('content')
    @php
        $user = Auth::user();
    @endphp
    <div class="container" style="margin-top: 20px">
        <div class="row">
            <div class="col-4">
                <input class="form-control" type="text" placeholder="Search Customer" id="search_customer">
            </div>
            <div class="col-8">
                <input class="form-control" type="text" placeholder="Search Product" id="search_product">
            </div>
        </div>
    </div>
    <br><br>
    <div style="max-width: 80%; margin-left: auto; margin-right: auto;">
        <table class="table table-striped" id="order_products">
            <thead>
                <tr>
                    <th style="border: 1px solid black; text-align:center;">Sr. No</th>
                    <th style="border: 1px solid black; text-align:center;">Name of the Product</th>
                    <th style="border: 1px solid black; text-align:center;">Quantity</th>
                    <th style="border: 1px solid black; text-align:center;">Price</th>
                    <th style="border: 1px solid black; text-align:center;">Sub-Total</th>
                    <th style="border: 1px solid black; text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th style="border: 1px solid black; text-align:center;" colspan="2"></th>
                    <th style="border: 1px solid black; text-align:center;">Total Quantity:</th>
                    <th style="border: 1px solid black; text-align:center;"></th>
                    <th style="border: 1px solid black; text-align:center;">Total Amount:</th>
                    <th style="border: 1px solid black; text-align:center;"></th>
                </tr>
            </tfoot>
        </table>

    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#search_product").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "/autocomplete/product", // Replace with your endpoint
                        method: "GET",
                        data: {
                            search: request.term
                        },
                        success: function(data) {
                            console.log("data ", data);
                            response(data);
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    console.log("Selected: " + ui.item.value);
                    $.ajax({
                        url: "/render/product",
                        method: "GET",
                        type: "html",
                        data: {
                            search: ui.item.value
                        },
                        success: function(data) {
                            const productData = JSON.parse(data)[0];
                            const {
                                id,
                                name,
                                amount
                            } = productData;
                            console.log({
                                id,
                                name,
                                amount
                            });

                            let found = false;

                            $("#order_products tbody tr").each(function() {
                                const rowProductId = $(this).data('product-id');

                                if (rowProductId === id) {
                                    found = true;
                                    const qtyInput = $(this).find(
                                        '.quantity input');
                                    const subtotalCell = $(this).find('.subtotal');

                                    let quantity = parseInt(qtyInput.val());
                                    quantity += 1;
                                    qtyInput.val(quantity);

                                    const newSubtotal = quantity * parseFloat(
                                        amount);
                                    subtotalCell.text(newSubtotal.toFixed(2));

                                    updateTotals();
                                    $('#search_product').val("");
                                    $('#search_product').select().focus();
                                    return false;
                                }
                            });

                            if (!found) {
                                const newRow = `
                            <tr data-product-id="${id}">
                                <td style='border: 1px solid black' class="text-center">${$("#order_products tbody tr").length + 1}</td>
                                <td style='border: 1px solid black' class="text-center">${name}</td>
                                <td style='border: 1px solid black' class="text-center quantity">
                                    <input type="number" class="form-control text-center" value="1" min="1">
                                </td>
                                <td style='border: 1px solid black' class="text-center price">${parseFloat(amount).toFixed(2)}</td>
                                <td style='border: 1px solid black' class="text-center subtotal">${parseFloat(amount).toFixed(2)}</td>
                                <td style='border: 1px solid black' class="text-center">
                                    <button class="btn btn-danger btn-sm remove-row">Remove</button>
                                </td>
                            </tr>
                        `;
                                $("#order_products tbody").append(newRow);
                                updateTotals();
                                $('#search_product').val("");
                                $('#search_product').select().focus();
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            // Update subtotal, total quantity, and total amount when quantity changes
            $("#order_products").on("input", ".quantity input", function() {
                const row = $(this).closest("tr");
                const quantity = parseInt($(this).val()) || 0; // Handle invalid input
                const price = parseFloat(row.find(".price").text());
                const subtotal = quantity * price;

                // Update the subtotal cell
                row.find(".subtotal").text(subtotal.toFixed(2));

                // Update totals
                updateTotals();
            });

            // Handle row removal
            $("#order_products").on("click", ".remove-row", function() {
                $(this).closest("tr").remove();
                updateRowNumbers();
                updateTotals(); // Update totals after row removal
            });

            // Function to update row numbers
            function updateRowNumbers() {
                $("#order_products tbody tr").each(function(index) {
                    $(this).find("td:first").text(index + 1);
                });
            }

            // Function to calculate total quantity and total amount
            function updateTotals() {
                let totalQuantity = 0;
                let totalAmount = 0;

                $("#order_products tbody tr").each(function() {
                    const quantity = parseInt($(this).find(".quantity input").val()) || 0;
                    const subtotal = parseFloat($(this).find(".subtotal").text()) || 0;

                    totalQuantity += quantity;
                    totalAmount += subtotal;
                });

                // Update the footer cells
                $("#order_products tfoot th").eq(1).text(`Total Quantity: ${totalQuantity}`);
                $("#order_products tfoot th").eq(3).text(`Total Amount: ${totalAmount.toFixed(2)}`);
            }
        });
    </script>
@endsection
