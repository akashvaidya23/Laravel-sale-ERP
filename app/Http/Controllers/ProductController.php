<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(100);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = new Product();
        $product->name = $request->name;
        $product->amount = $request->amount;
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product = Product::find($product->id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = Product::find($product->id);
        $product->name = $request->name;
        $product->amount = $request->amount;
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('danger', 'Product Deleted Successfully');
    }

    public function search(Request $request)
    {
        $search = $request->input('search_text');
        $products = Product::where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('amount', 'like', '%' . $search . '%');
        })->paginate(100);

        $output = '';
        foreach ($products as $key => $product) {
            $output .= "<tr>
                    <td style='border: 1px solid black; text-align:center;'>" . ($products->firstItem() + $key) . "</td>
                    <td style='border: 1px solid black; text-align:center;'>{$product->name}</td>
                    <td style='border: 1px solid black; text-align:center;'>₹ " . number_format($product->amount, 2) . " /-</td>
                    <td style='border: 1px solid black; text-align:center;'>
                        <div class='action-buttons'>
                            <a class='btn btn-info' href='" . route('product.edit', [$product->id]) . "'>Edit</a>
                            <form action='" . route('product.destroy', [$product->id]) . "' method='POST' style='display: inline;'>
                                <input type='hidden' name='_token' value='" . csrf_token() . "'>
                                <input type='hidden' name='_method' value='DELETE'>
                                <button class='btn btn-danger' type='submit' onclick='return confirm(\"Are you sure you want to delete this customer?\")'>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>";
        }

        $paginationLinks = $products->links()->render();

        return response()->json([
            'table' => $output,
            'pagination' => $paginationLinks,
        ]);
    }

    public function searchProduct(Request $request)
    {
        $search_term = $request->search;
        return $products = Product::where('name', 'like', '%' . $search_term . '%')
            ->pluck('name', 'id');

        // return response()->json([$products]);
    }

    public function renderProduct(Request $request)
    {
        $product = Product::where('name', $request->search)
            ->get()
            ->toJSON();

        return $product;
    }
}
