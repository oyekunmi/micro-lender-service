<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ProductService;

class ProductsController extends Controller
{
    /**
     *
     * @var ProductService
     */
    private $service;
    
    function __construct(ProductService $service) {
        $this->service = $service;
    }
    //
    public function index(){
        return $this->service->getProducts();
    }
}
