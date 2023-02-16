<?php

namespace App\Repo;

use App\Interfaces\ProductInterface;
use App\Models\Product;

class ProductRepo implements ProductInterface {

    public function get() {
        return Product::paginate(10);
    }

    public function get_item($id) {
        return Product::findOrFail($id);
    }

    public function get_products_by_type($type) {
        return Product::where('type', $type)->paginate(15);
    }

    public function create_product(array $product) {
        return Product::create($product);
    }

    public function update_product($id, array $product) {
        return Product::where('id', $id)->update($product);
    }

    public function delete_product($id) {
        return Product::destroy($id);
    }

    public function get_product_owner_details($id) {
        return Product::with('owner')->findOrFail($id)->owner;
    }
    
}

