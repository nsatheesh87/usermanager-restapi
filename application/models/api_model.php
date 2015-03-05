<?php

/**
* CodeIgniter REST API Model
*
* A fully RESTful server implementation for CodeIgniter using one library, one config file and one controller.
*
* @package CodeIgniter
* @subpackage Models
* @category Mode;
* @author Satheesh Narayanan
* @license MIT
* @link https://github.com/nsatheesh87/usermanager-restapi
*/

class Api_model extends CI_Model {


	/**
    * Get user by his id
    * @param int $id 
    * @return array
    */
    public function get_user_by_id($id)
    {
    	$response = array();
    	$response['status'] 	= 'true';
		$this->db->select('*');
		$this->db->from('member');
		$this->db->where('id', $id);
		$query = $this->db->get();
		if($query->num_rows() == 0)
		{
			$response['status'] 	= 'false';
			$response['response'] 	= 'Invalid User Details';
		}  else{
			$response['response']		= $query->result_array(); 
		}
		
		return $response;
    }


    /**
    * Get group by id
    * @param int $groupID 
    * @return array
    */
    public function get_group_by_id($groupID)
    {
    	$response = array();
    	$response['status'] 	= 'true';
		$this->db->select('*');
		$this->db->from('group');
		$this->db->where('groupID', $groupID);
		$query = $this->db->get();
		if($query->num_rows() == 0)
		{
			$response['status'] 	= 'false';
			$response['response'] 	= 'Invalid Group Details';
		}  else{
			$response['response']		= $query->result_array(); 
		}
		
		return $response;
    }

    /**
    * Fetch all user information
    * @param int $limit 
    * @return array
    */
    public function getUserlist($limit = 50)
    {
    	$response = array();
    	$response['status'] 	= 'true';
		$this->db->select('*');
		$this->db->from('member');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() == 0)
		{
			$response['status'] 	= 'false';
			$response['response'] 	= 'No Users found';
		}  else{
			$response['response']		= $query->result_array(); 
		}
		
		return $response;
    }

    /**
    * Fetch all group records
    * @param int $limit
    * @return array
    */
    public function getGrouplist($limit = 50)
    {
    	$response = array();
    	$response['status'] 	= 'true';
		$this->db->select('*');
		$this->db->from('group');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() == 0)
		{
			$response['status'] 	= 'false';
			$response['response'] 	= 'No Group found';
		}  else{
			$response['response']		= $query->result_array(); 
		}
		
		return $response;
    }

    /**
    * Create a new group
    * @param STRING $groupName
    * @return array
    */
    public function createGroup($groupName)
    {
    	$response = array();
    	$response['status'] 	= 'true';
    	$insert = $this->db->insert('group', array('Name' =>$groupName));
		$response['response'] 	= 'Success';
		return $response;


    }

    /**
    * Create a new user
    * @param Array $paramaters
    * @return array
    */
    public function createUser($parameters = '')
    {
    	$response = array();
    	$response['status'] 	= 'true';

    	if(!$this->isGroupExist($parameters['groupID'])){
    		$response['status'] 	= 'false';
			$response['response'] 	= 'Not a valid Group';

			return $response;
    	}

    	if(!empty($parameters))
    	{
    		$this->db->where('email_address', $parameters['email_address']);
			$query = $this->db->get('member');
			$rc = 0;
			$action = 'insert';
			if(!empty($id)){
				$rc = 1;
				$action = 'update';
				$this->db->where('id', $id);
			}
	        if($query->num_rows > $rc){
	        	$response['status'] 	= 'false';
				$response['response'] 	= 'Email Address Already Exist';
			}else{

				$new_member_insert_data = array(
					'groupID'    => $parameters['groupID'],
					'first_name' => $parameters['first_name'],
					'last_name' => $parameters['last_name'],
					'email_address' => $parameters['email_address']);				
				$insert = $this->db->$action('member', $new_member_insert_data);
			   $response['response'] 	= 'Success';
			}

    	}
    	return $response;
    }

    /**
    * Check the group is valid or not
    * @param int $groupID
    * @return VOID
    */
    private function isGroupExist($groupID = '')
    {
    	if(!empty($groupID))
    	{
    		$this->db->where('groupID', $groupID);
			$query = $this->db->get('group');
			if($query->num_rows > 0){
				return true;
			}
    	}
    	return false;
    }

    /**
    * Update group name
    * @param array $group
    * @return array
    */
    public function updateGroup($group)
    {
    	$response = array();
    	$response['status'] 	= 'true';
    	$this->db->where('groupID',$group['groupID']);	
    	$insert = $this->db->update('group', array('Name' =>$group['Name']));
		$response['response'] 	= 'Success';
		return $response;

    }

    /**
    * Update user information
    * @param  array $parameters
    * @return array
    */
    public function updateUser($parameters = '')
    {
    	$response = array();
    	$response['status'] 	= 'true';

    	if(!$this->isGroupExist($parameters['groupID'])){
    		$response['status'] 	= 'false';
			$response['response'] 	= 'Not a valid Group';

			return $response;
    	}

    	if(!empty($parameters))
    	{
    		$where = array('id' => $parameters['id']);
    		$this->db->where($where);
			$query = $this->db->get('member');
			$rc = 0;
			$action = 'insert';
			if(!empty($id)){
				$rc = 1;
				$action = 'update';
				$this->db->where('id', $id);
			}
	        if($query->num_rows != 1){
	        	$response['status'] 	= 'false';
				$response['response'] 	= 'User doesnt exist';
			}else{

				$new_member_insert_data = array(
					'groupID'    => $parameters['groupID'],
					'first_name' => $parameters['first_name'],
					'last_name' => $parameters['last_name'],
					'email_address' => $parameters['email_address']);
					$this->db->where('id',$parameters['id']);				
				$insert = $this->db->update('member', $new_member_insert_data);
			   $response['response'] 	= 'Success';
			}

    	}
    	return $response;

    }

    /**
    * Delete user by id
    * @param int $id 
    * @return array
    */
    public function deleteUser($id = '')
    {
    	$response = array();
    	$response['status'] 	= 'true';
    	$response['response'] 	= 'Parameter Missing';
    	if(!empty($id)){
    		$this->db->where('id', $id);
			$this->db->delete('member'); 
			$response['response'] 	= 'Success';
    	}

    	return $response;
    }

    /**
    * Check the user valid or not
    * @param int $groupID 
    * @return array
    */
    private function isUserExistbyGroupid($groupID)
    {
    	$this->db->where('groupID', $groupID);
			$query = $this->db->get('member');
			if($query->num_rows > 0){
				return true;
			}
		return false;
    }

    /**
    * Delete user detail by ID
    * @param int $groupID
    * @return array
    */
    public function deleteGroup($groupID = '')
    {
    	$response = array();
    	$response['status'] 	= 'true';
    	$response['response'] 	= 'Parameter Missing';

    	if($this->isUserExistbyGroupid($groupID)){
    		$response['status'] 	= 'false';
			$response['response'] 	= 'Users are already exist in the group';

			return $response;
    	}

    	if(!empty($groupID)){
    		$this->db->where('groupID', $groupID);
			$this->db->delete('group'); 
			$response['response'] 	= 'Success';
    	}

    	return $response;
    }

}
