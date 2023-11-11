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

	try {
		$sql = "INSERT INTO users (name, username, password, phone_number, access_level, created_at, updated_at) 
				VALUES ('{$user->name}', '{$user->username}', '{$user->password}', '{$user->phone_number}', {$user->access_level}, now(), now())";
		mysqli_query($db->link, $sql);
		$db->link->close();

		return true;
	} catch (\Exception) {
		
	}

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
 * count total users
 * @return integer
 *
 **/
function userTotal()
{
	global $db;
	
	try {
		$query = "SELECT count(*)FROM `users`";

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
 * updating a user record
 * @return boolean
 *
 **/
function userUpdate($user)
{
	global $db;

	try {

		$sql = "UPDATE users SET name='{$user->name}', username='{$user->username}', password='{$user->password}', phone_number='{$user->phone_number}', access_level={$user->access_level}, updated_at=now() WHERE id={$user->id}";

		mysqli_query($db->link, $sql);
		$db->link->close();
		return true;
	} catch (\Exception) {
		
	}

	return false;
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
 * check by username
 * @return a boolean
 *
 **/
function userIsExistUserName($user)
{

	global $db;
	
	try {
		if ($user->id) 
		{
			$query = "SELECT * FROM `users` where username='{$user->username}' limit 1";
			$result = mysqli_query($db->link, $query);
		   
			if ($result->num_rows > 0) 
			{
				$existingUser = (object) $result->fetch_assoc();
				if ($existingUser->id != $user->id) {
					return true;
				}
			} 

		} else {

			$query = "SELECT * FROM `users` where username='{$user->username}' limit 1";
			$result = mysqli_query($db->link, $query);
			
			if ($result->num_rows > 0) 
			{
				return true;
			} 
		}

	} catch (\Exception) {
		
	}

	return false;
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

function userAdmins()
{
	$users = [];
	return $users;
}

/** 
 *	
 * get user admin
 * @return a user
 *
 **/
function getAdminUser()
{

	global $db;
	
	try {
		 $query = "SELECT * FROM `users` where access_level=1 limit 1";
		 $result = mysqli_query($db->link, $query);
		
		if ($result->num_rows > 0) 
		{
			return (object) $result->fetch_assoc(); 
		} 
	} catch (\Exception) {
		
	}

	return null;
}