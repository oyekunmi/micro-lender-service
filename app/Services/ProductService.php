<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService{
   
    /**
     *
     * @var ProductRepository
     */
    private $repo;
    
    function __construct(
            ProductRepository $repo) {
        $this->repo = $repo;
    }
    
    function getProducts(){
        return $this->repo->getAll();
    }
    
}