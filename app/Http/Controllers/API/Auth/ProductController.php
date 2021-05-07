<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Http\Controllers\API\BaseController;

class ProductController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }


    
    public function entity()
    {
        return Product::class;
    } 
        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ProductCollection::collection(Product::paginate(5));
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return auth()->user()->id;
        // dd();

        $product = [
            'name'      =>  $request->name,
            'detail'    =>  $request->detail,
            'price'     =>  $request->price,
            'stock'     =>  $request->stock,
            'discount'  =>  $request->discount,
            'user_id'   =>  auth()->user()->id
        ];

        $data = $this->entity()::create($product);

        return response(
        )->json([
            'data'  =>  $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return $this->entity()::all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    protected function userAuthorize($product)
    {
        if(Auth::user()->id != $product->user_id)
        {
            return 'You are not an owner of this product.';
        }
    }
}
