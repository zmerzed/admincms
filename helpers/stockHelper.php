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
 * updating a product record
 * @return boolean
 *
 **/
function productQuantityUpdate($product)
{
	global $db;

	try {

		$sql = "UPDATE products SET quantity={$product->quantity}, updated_at=now() WHERE product_id={$product->product_id}";

		mysqli_query($db->link, $sql);
		$db->link->close();
		return true;
	} catch (\Exception) {
		
	}

	return false;
}

/** 
 *	
 * inserting a product log
 * @return boolean
 *
 **/
function productLogStore($product, $mode, $quantity) 
{
	if (empty($mode)) {

		return false;
	}

	global $db;
	
	try {
		$sql = "INSERT INTO product_logs (mode, quantity, product_id, created_at) 
				VALUES ('{$mode}', $quantity, {$product->product_id}, now())";
		mysqli_query($db->link, $sql);
		//$db->link->close();

		return true;
	} catch (\Exception) {
		
	}

	return false;
}

/** 
 *	
 * inserting a product log
 * @return boolean
 *
 **/
function productLogTotal($params, $mode='') 
{
	if (empty($mode)) {

		return false;
	}

	global $db;
	
	try {
		$query = "";

		// dd($params);
		if(isset($params['date_from']) && isset($params['date_to'])) {
			$query =  "SELECT SUM(quantity) as total FROM `product_logs` where mode='{$mode}' and created_at";
			$query .= " BETWEEN '{$params['date_from']}' AND LAST_DAY('{$params['date_to']}')";
		}
		
		if (isset($params['product_id'])) {
			$query .= " AND product_id={$params['product_id']}";
		}

		$result = mysqli_query($db->link, $query);
		 
		while($row = $result->fetch_assoc())
		{
			return $row['total'];
		}

	} catch (\Exception) {
		
	}

	return false;
}

/** 
 *	
 * getting a list of products in
 * @return list of objects
 *
 **/
function productGetProductsByLogs($params)
{
	global $db;
	
	try {
		$query = "SELECT distinct product_id FROM `product_logs`";

		if(isset($params['date_from']) && isset($params['date_to'])) {
			$query =  "SELECT distinct product_id FROM `product_logs` WHERE created_at";
			$query .= " BETWEEN '{$params['date_from']}' AND LAST_DAY('{$params['date_to']}')";
		}
		
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
 * getting a list of products
 * @return list of objects
 *
 **/
function productList($params)
{
	global $db;
	
	try {
		$query = "SELECT * FROM `products`";

		if(isset($params['date_from']) && isset($params['date_to'])) {
			$query =  "SELECT * FROM `products` WHERE created_at";
			$query .= " BETWEEN '{$params['date_from']}' AND LAST_DAY('{$params['date_to']}')";
		}
		
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
 * count total products
 * @return list of objects
 *
 **/
function productTotal()
{
	global $db;
	
	try {
		$query = "SELECT count(*)FROM `products`";

		$result = mysqli_query($db->link, $query);
		$count = 0;
		while($row = mysqli_fetch_array($result)) {
			$count = $row['count(*)'];
		}

		return $count;

	} catch (\Exception) {
		
	}

	return 0;
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
		
		$query = "DELETE FROM `product_logs` where product_id={$id}";
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