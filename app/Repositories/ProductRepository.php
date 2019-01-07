<?php

namespace App\Repositories;

use App\Product;

class ProductRepository{
    
    function getById($id){
        return Product::find($id);
    }
    
    function getBySlug($slug){
        return Product::where('slug', $slug)->first();
    }
    
    function getAll(){
        return Product::all();
    }
    
}