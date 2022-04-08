<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(session()->get('user')[0]->role);
        if (session()->get('user')) {
            $product = Product::query();
            $productList = $product->where(['isActive' => 1])->get();
            return view('product.indexProduct', [
                'title' => 'Products',
                'productList' => $productList
            ]);
        } else {
            return redirect()->route('auth.login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return view('products.createProduct', ['title' => 'Laravel Create Product']);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate([
            'article' => 'required|unique:products',
            'name' => 'required|min:10',
            'status' => 'required',
            'data' => 'nullable',
        ]);

        $product = Product::query();
        $product->create($request->all());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $product = Product::query();
    //     $show = $product->findOrFail($id);
    //     // dd($product->isActive);
    //     return view('products.editProduct', ['title' => 'Edit Product', 'product' => $show[0]]);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::query();
        $data = $product->findOrFail($id);
        $data->update($request->all());

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::query();
        $product->find($id)->update(['isActive' => 0]);

        return redirect()->route('product.index');
    }
}
