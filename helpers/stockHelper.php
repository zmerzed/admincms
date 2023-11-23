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
 * updating a product quantity
 * @return boolean
 *
 **/
function productQuantityUpdate($product)
{
	global $db;

	try {
	
		$sql = "UPDATE products SET quantity={$product->quantity}, updated_at=now() WHERE product_id={$product->product_id}";
		mysqli_query($db->link, $sql);
		if(is_resource($db->link) && get_resource_type($db->link)==='mysql link'){
			//dd('test');
			$db->link->close();
		}
		return true;
	} catch (\Exception) {
		
	}

	return false;
}

/** 
 *	
 * updating a product status
 * @return boolean
 *
 **/
function productUpdateStatus($product, $status)
{
	global $db;

	try {

		$sql = "UPDATE products SET status='{$status}', updated_at=now() WHERE product_id={$product->product_id} LIMIT 1";

		mysqli_query($db->link, $sql);
		//$db->link->close();
		if(is_resource($db->link) && get_resource_type($db->link)==='mysql link'){
			$db->link->close(); //Object oriented style
			//mysqli_close($connection); //Procedural style 
		}
		return true;
	} catch (\Exception) {
		
	}

	return false;
}
/** 
 *	
 * updating a productLowQuantityLevelUpdate
 * @return boolean
 *
 **/
function productLowQuantityLevelUpdate($product)
{
	global $db;

	try {

		$sql = "UPDATE products SET low_quantity_level={$product->low_quantity_level}, updated_at=now() WHERE product_id={$product->product_id}";

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

		if(isset($params['date_from']) && isset($params['date_to'])) {
			$query =  "SELECT SUM(quantity) as total FROM `product_logs` where mode='{$mode}' and created_at";
			$query .= " BETWEEN '{$params['date_from']}' AND LAST_DAY('{$params['date_to']}')";
		}
		
		// if(isset($params['product_id'])) {
		// 	$query .= " AND WHERE product_id={$params['product_id']}";
		// }

		if (isset($params['product_id'])) {
			$query .= " AND product_id={$params['product_id']}";
		}

		//dd($query);
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
 * getting a logs
 * @return list of objects
 *
 **/
function productLogs($params=[])
{
	global $db;
	
	try {
		$query = "SELECT *, product_logs.quantity as log_quantity, product_logs.created_at as log_created_at FROM product_logs LEFT JOIN products ON product_logs.product_id=products.product_id";

		if (isset($params['product_id'])) {
			$query .= " WHERE product_logs.product_id={$params['product_id']}";
		}
		
		if(isset($params['date_from']) && isset($params['date_to'])) {
			$query .= " WHERE product_logs.created_at BETWEEN '{$params['date_from']}' AND LAST_DAY('{$params['date_to']}') order by product_logs.created_at ASC";
		}

		if (isset($params['order_by_date']))
		{
			$query .= " order by product_logs.created_at DESC";
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
		$query = "SELECT * FROM `products` where is_delete is null";
		
		if (isset($params['search'])) {
			$query = "SELECT * FROM `products` where product_name like '%{$params['search']}' and is_delete is null";
		}

		if(isset($params['date_from']) && isset($params['date_to'])) {
			$query =  "SELECT * FROM `products` WHERE created_at";
			$query .= " BETWEEN '{$params['date_from']}' AND LAST_DAY('{$params['date_to']}') AND is_delete is null";
		}


		if (isset($params['status']))
		{
			$query =  "SELECT * FROM `products` WHERE status='{$params['status']}'";
			$query .= " AND is_delete is null";
		}

		if (isset($params['sort_by']) && isset($params['sort_direction']))
		{
			$query .= " ORDER BY {$params['sort_by']} {$params['sort_direction']}";
		}

		
		$result = mysqli_query($db->link, $query);
		 
		   if ($result->num_rows > 0) 
		   {
			   $listing = [];
			   while($row = $result->fetch_assoc())
			   {
				   	if (isset($params['product_logs']))
				   	{
						$product = (object) $row;
						$product->logs = productLogs(['product_id' => $product->product_id]);
						$listing[] = $product;
						//dd($listing);
				   	} else {
						$listing[] = (object) $row;
				   	}
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
		$sql = "UPDATE products SET is_delete=1 WHERE product_id={$id} limit 1";

		mysqli_query($db->link, $sql);
		
		// $query = "DELETE FROM `product_logs` where product_id={$id}";
		// $result = mysqli_query($db->link, $query);
		
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

function getSuggestQuantity($product, $month=null, $year=null)
{

	if ($product->quantity <= $product->low_quantity_level) {

		$suggestedQuantity = $product->low_quantity_level * 2.5;

		return ceil($suggestedQuantity);
	}

	// $totalStockIn = 0;
	// $totalStockOut = 0;
	
	//global $db;
	
	// try {
		// $date = "{$year}-{$month}-01";
		// $dateFrom = date("Y-m-01", strtotime($date));
		// $dateTo = date("Y-m-t", strtotime($date));

		// $query1 = "SELECT SUM(quantity) FROM `product_logs` where `product_id`={$productId}";
		// $query1 .= " AND created_at BETWEEN '{$dateFrom}' AND LAST_DAY('{$dateTo}') AND mode='in'";

		// $result1 = mysqli_query($db->link, $query1);
		// while($row = mysqli_fetch_array($result1)) {
		// 	$totalStockIn = $row['SUM(quantity)'];
		// }

		// $query2 = "SELECT SUM(quantity) FROM `product_logs` where `product_id`={$productId}";
		// $query2 .= " AND created_at BETWEEN '{$dateFrom}' AND LAST_DAY('{$dateTo}') AND mode='out'";

		// $result2 = mysqli_query($db->link, $query2);
		// while($row = mysqli_fetch_array($result2)) {
		// 	$totalStockOut = $row['SUM(quantity)'];
		// }

		// return "lastYrStockIn: {$totalStockIn}, lastYrStockOut: {$totalStockOut}";

	// } catch (\Exception) {
		
	// }

	return '';
}