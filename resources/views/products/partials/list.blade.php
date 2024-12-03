<tr data-product_id={{ $product[0]->id }}>
    <input type="hidden" name="products[{{ $product[0]->id }}]['product_id']" value="{{ $product[0]->id }}">
    <td style="border: 1px solid black; text-align:center;"></td>
    <td style="border: 1px solid black; text-align:center;">{{ $product[0]->name }}</td>
    <td style="border: 1px solid black; text-align:center;">
        <input class="form-control" type="number" name="products[{{ $product[0]->id }}]['quantity']" value="1">
    </td style="border: 1px solid black; text-align:center;">
    <td style="border: 1px solid black; text-align:center;">{{ number_format($product[0]->amount, 2) }}</td>
    <td style="border: 1px solid black; text-align:center;">{{ number_format($product[0]->amount * 1, 2) }}</td>
    <td style="border: 1px solid black; text-align:center;"></td>
</tr>
