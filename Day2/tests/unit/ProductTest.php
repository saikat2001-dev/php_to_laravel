<?php

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase{
  public function test_can_get_product_by_id(){
    $product = new Product();
    $this->assertEquals("boot", $product->getProductById(15)['name']);
  }
}