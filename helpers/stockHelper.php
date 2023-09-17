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

function productUpdate()
{

}

function productFindById($id=null)
{
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