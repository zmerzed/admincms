<?php

/** 
 *	
 * saving a product
 * @return boolean
 *
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

/** 
 *	
 * getting a list of products
 * @return list of objects
 *
 **/
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

/** 
 *	
 * updating a product record
 * @return boolean
 *
 **/
function productUpdate()
{

}

/** 
 *	
 * find a product by id
 * @return a product
 *
 **/
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

/** 
 *	
 * find a product by id
 * @return a product
 *
 **/
function productDelete($id=null)
{

	global $db;
	
	$result = false;

	try {
		$query = "DELETE FROM `products` where product_id={$id} limit 1";
		$result = mysqli_query($db->link, $query);
		
	} catch (\Exception) {
		
	}

	return $result;
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