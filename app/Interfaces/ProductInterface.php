<?php

namespace App\Interfaces;

interface ProductInterface
{
        // Get
        public function get();
        public function get_item($id);
    
        public function get_products_by_type($type);
    
        // Creat
        public function create_product(array $product);
    
        // Update
        public function update_product($id, array $product);
    
        // Delete
        public function delete_product($id);
    
        // product owner
        public function get_product_owner_details($id);
}

