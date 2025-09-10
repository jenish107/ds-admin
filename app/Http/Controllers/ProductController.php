<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function productList()
    {
        return view('product.product');
    }

    public function getAllProduct(Request $request)
    {
        $length = $request->input('length');
        $start  = $request->input('start');
        $search = $request->input('search.value');

        $query = Product::when($search, function ($query) use ($search) {
            $query->where('product_name', 'like', "%{$search}%");
        });

        $recordsFiltered = $query->count();

        $product = $query->offset($start)->limit($length)->get();

        $recordsTotal = Product::count();

        $data = $product->map(function ($product) {
            return [
                'id' => $product->id,
                'product_name' => $product->product_name,
                'price' => $product->price,
                'action'     => '
                    <a href="' . route('showProductForm', [$product->id]) . '" 
                       class="btn btn-success btn-sm text-white">Edit</a>
                    <button type="button" data-id="' . $product->id . '" 
                       class="btn btn-danger btn-sm text-white delete_btn">Delete</button>
                ',
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function showProductForm($id = null)
    {
        if ($id == null) {
            return view('product.form');
        } else {
            $product = Product::find($id);
            return view('product.form', compact('product'));
        }
    }

    public function updateProduct(Request $request)
    {
        $validate = $request->validate([
            'product_name' => 'required',
            'price' => 'required',
        ]);

        Product::where('id',  $request->input('id'))->update([
            'product_name' => $validate['product_name'],
            'price' => $validate['price'],
        ]);
        return redirect()->route('showProductList');
    }

    public function addProduct(Request $request)
    {
        $validate = $request->validate([
            'product_name' => 'required',
            'price' => 'required',
        ]);

        Product::create([
            'product_name' => $request->product_name,
            'price' => $request->price,
        ]);
        return redirect()->route('showProductList');
    }

    public function deleteProduct($id)
    {
        return Product::where('id', $id)->delete();
    }
}
