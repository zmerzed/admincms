<?php

/** 
 *	
 * saving a user
 * @return boolean
 *
 **/
function userStore($user) 
{
	global $db;
	// dd($user);
	//try {
		$sql = "INSERT INTO users (name, username, password, phone_number, access_level, created_at, updated_at) 
				VALUES ('{$user->name}', '{$user->username}', '{$user->password}', '{$user->phone_number}', {$user->access_level}, now(), now())";
		mysqli_query($db->link, $sql);
		$db->link->close();

		return true;
	// } catch (\Exception) {
		
	// }

	return false;
}

/** 
 *	
 * getting a list of users
 * @return list of objects
 *
 **/
function userList($params)
{
	global $db;
	
	try {
		 $query = "SELECT * FROM `users`";
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
 * updating a user record
 * @return boolean
 *
 **/
function userUpdate()
{

}

/** 
 *	
 * find a user by id
 * @return a user
 *
 **/
function userFindById($id=null)
{

	global $db;
	
	try {
		 $query = "SELECT * FROM `users` where id={$id} limit 1";
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
 * delete a user
 * @return a bool
 *
 **/
function userDelete($id=null)
{

	global $db;
	
	$result = false;

	try {
		$query = "DELETE FROM `users` where id={$id} limit 1";
		$result = mysqli_query($db->link, $query);
		
	} catch (\Exception) {
		
	}

	return $result;
}


function userGetEmptyForm()
{
	return (object) [
		'name' => null,
		'username' => null,
        'phone_number' => null,
		'access_level' => null,
		'password' => null,
		'created_at' => null,
		'updated_at' => null
	];
}