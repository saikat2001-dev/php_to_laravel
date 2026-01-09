<?php

session_start();
if($_SERVER('METHOD_REQUEST') === 'POST') {
  $productId = $_POST['id'];
  //check if the product exist
  $updateQry = $pdo->
}