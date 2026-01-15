<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController {
  public function getAllCategory() {
    $category = Category::getAllCategory();
  }
  public function createCategory(){

  }
}