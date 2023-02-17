<?php

namespace App\Repo;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use App\Models\ProductHistory;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ProductRepo implements ProductInterface {

    public function get() {
        return Product::paginate(10);
    }

    public function get_item($id) {
        return Product::findOrFail($id);
    }

    public function get_products_by_type($type) {
        return Product::where('type', $type)->paginate(10);
    }

    public function create_product(array $product) {
        $product['user_id'] = User::first()->id;
        return Product::create($product);
    }

    public function create_product_history(array $product)
    {
        // $product['user_id'] = User::first()->id;
        return ProductHistory::create($product);
    }

    public function update_product($id, array $product) {
        $old_product = Product::findOrFail($id);


        $product_history = [
            'user_id' => $old_product->user_id,
            'product_id' => $id,
            'name' => $old_product->name,
            'price' => $old_product->price,
            'status' => $old_product->status,
            'type' => $old_product->type,
        ];

        $this->create_product_history($product_history);
        
        Product::where('id', $id)->update($product);

        $old_product->refresh();
        return $old_product;
    }

    public function delete_product($id) {
        return Product::destroy($id);
    }

    public function get_product_owner_details($id) {
        return Product::with('user')->findOrFail($id)->user;
    }

    public function search($phrase)
    {
        return Product::whereHas('user', function($query) use ($phrase) {
            $query->where('name', 'like', "%{$phrase}%");
        })->orWhere('name', 'like', "%{$phrase}%")->paginate(10);
    }

    public function get_product_changes($id) {
        return ProductHistory::where('product_id', $id)->orderBy('id', 'DESC')->get();
    }
    
}

