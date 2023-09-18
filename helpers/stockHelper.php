<?php

function store($username, $password) 
{
	global $db;
	$result = mysqli_query($db->link, "SELECT * FROM users WHERE username = '$username' and password = '$password'");

	// Fetch the next row of a result set as an associative array
	$resultData = mysqli_fetch_assoc($result);

	if (!empty($resultData)) {
		$_SESSION['auth'] = $resultData;
	}

	return empty($resultData) ? false : true;
}

/** 
*	
* Insert a product
* @return boolean
**/
function productStore($product) 
{
	global $db;
	
	try {
		$sql = "INSERT INTO products (product_name, quantity, category, created_at, updated_at) 
				VALUES ('{$product->product_name}', {$product->quantity}, '{$product->category}', now(), now())";
		mysqli_query($db->link, $sql);
		$db->link->close();

		return true;
	} catch (\Exception) {
		
	}

	return false;
}

function productList($params)
{
	global $db;
	
	try {
		 $query = "SELECT * FROM `products`";
		 $result = mysqli_query($db->link, $query);
		 
		   if ($result->num_rows > 0) 
		   {
			   $listing = [];
			   while($row = $result->fetch_assoc())
			   {
				   $listing[] = (object) $row;
			   }

			   return $listing;
		   } 
	} catch (\Exception) {
		
	}

	return [];
}

function productUpdate()
{

}

function productFindById($id=null)
{

	global $db;
	
	try {
		 $query = "SELECT * FROM `products` where product_id={$id} limit 1";
		 $result = mysqli_query($db->link, $query);
		
		   if ($result->num_rows > 0) 
		   {
			   return (object) $result->fetch_assoc(); 
		   } 
	} catch (\Exception) {
		
	}

	return productGetEmptyForm();
}

function productGetEmptyForm()
{
	return (object) [
		'product_name' => null,
		'category' => null,
		'quantity' => null,
		'created_at' => null,
		'updated_at' => null
	];
}