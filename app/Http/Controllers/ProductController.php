<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-product|create-product|edit-product|delete-product', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-product', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-product', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-product', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        if (request()->ajax()) {
            $products = Product::query();
            return DataTables::of($products)
                ->make();
        }
        return view('products.index');
    }


    public function create(): View
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $productData = $request->all();

        Product::create($productData);

        return redirect()->route('products.index')
            ->withSuccess('New product is added successfully.');
    }

    public function show(Product $product): View
    {
        return view('products.show', [
            'product' => $product
        ]);
    }



    public function edit(Product $product): View
    {
        return view('products.edit', [
            'product' => $product
        ]);
    }


    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->all());
        return redirect()->back()
            ->withSuccess('Product is updated successfully.');
    }


    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully']);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
}
}
}
