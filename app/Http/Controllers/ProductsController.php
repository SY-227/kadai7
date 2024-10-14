<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function index(Request $request) {
        $products = Product::all();

        return view('zhnk.index', compact('products'));
    

        $query = Product::query();
    
        if($search = $request->search){
            $query->where('product_name', 'LIKE', "%{$search}%");
        }

        if($min_price = $request->min_price){
            $query->where('price', '>=', $min_price);
        }

        if($max_price = $request->max_price){
            $query->where('price', '<=', $max_price);
        }

        if($min_stock = $request->min_stock){
            $query->where('stock', '>=', $min_stock);
        }

        if($max_stock = $request->max_stock){
            $query->where('stock', '<=', $max_stock);
        }

        $products = $query->paginate(10);

        return view('products.index', ['products' => $products]);
    }


    public function create() {
        $companies = Company::all();

        return view('zhnk.create', compact('companies'));
    }

    public function store(Request $request) {
        $request->validate([
            'company_id' => 'required',
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'nullable',
            'img_path' => 'nullable|imge|max:2048',
        ]);

        $product =new Product([
            'company_id' => $request->get('company_id'),
            'paroduct_name' => $request->get('product_name'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'comment' => $request->get('comment'),
        ]);

        if($request->hasFile('img_path')){
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/' . $filePath;
        }

        $product->save();

        return redirect('products');
    }

    public function show(Product $product) {
        return view('zhnk.show', ['product' => $product]);
    }

    public function edit(Product $product) {
        $companies = Company::all();

        return view('zhnk.edit', compact('product', 'companies'));
    }

    public function update(Request $request, Product $product) {
        $request->validate([
            'product_name' => 'required',
            // 'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;

        $product->save();

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product) {
        $product->delete();

        return redirect('/products');
    }
}
