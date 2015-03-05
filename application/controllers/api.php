<?php
require(APPPATH.'libraries/REST_Controller.php');

/**
* CodeIgniter REST API Controller
*
* A fully RESTful server implementation for CodeIgniter using one library, one config file and one controller.
*
* @package CodeIgniter
* @subpackage Controllers
* @category Controller
* @author Satheesh Narayanan
* @license MIT
* @link https://github.com/nsatheesh87/usermanager-restapi
*/
 
class Api extends REST_Controller {

	 /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
       $this->load->model('Api_model');
       
    }

    /**
    * Get Group information By ID
    *
    * @param INT
    * @return XML|JSON
    */
    public function group_get()
    {
         if(!$this->get('groupID'))
        {
            
            $this->response('Oops! Invalid Access.');
        }

        $group =$this->Api_model->get_group_by_id($this->get('groupID'));
        $this->response($group,200); 
 

    }

    /**
    * Fetch user information by ID
    *
    * @param INT $id
    * @return XML|JSON
    */
   public function user_get()
    {

       if(!$this->get('id'))
        {
        	
            $this->response('Oops! Invalid Access.');
        }

        $user =$this->Api_model->get_user_by_id( $this->get('id') );
        $this->response($user,200); 
 
    }

    /**
    * List all user records
    *
    * @param INT $limit {Optional}
    * @return XML|JSON
    */
    public function userlist_get()
    {
        $limit = $this->get('limit');
        if(empty($limit)){
            $limit = 50;
        }
        $user =$this->Api_model->getUserlist($limit);
        $this->response($user,200); 
    }

    /**
    * Fetch all group names
    *
    * @param INT $limit {optional}
    * @return XML|JSON
    */
    public function grouplist_get()
    {
        $limit = $this->get('limit');
        if(empty($limit)){
            $limit = 50;
        }
        $user =$this->Api_model->getGrouplist($limit);
        $this->response($user,200); 
    }


    /**
    * Delete user information by ID
    *
    * @param INT $id
    * @return XML|JSON
    */
    public function user_delete()
    {
         if(!$this->delete('id'))
        {
            
            $this->response('Oops! Invalid Access.');
        }

        $user =$this->Api_model->deleteUser( $this->delete('id') );
        $this->response($user,200); 

    }

    /**
    * Delete Group information by ID
    *
    * @param INT $groupID
    * @return XML|JSON
    */
    public function group_delete()
    {
         if(!$this->delete('groupID'))
        {
            
            $this->response('Oops! Invalid Access.');
        }

        $user =$this->Api_model->deleteGroup( $this->delete('groupID') );
        $this->response($user,200); 

    }


    /**
    * Create user information
    *
    * @param INT $id
    * @param STRING $first_name
    * @param STRING $last_name
    * @param INT $groupID
    * @param STRING $email_address
    * @return XML|JSON
    */
    public function user_put()
    {
        $first_name = $this->put('first_name');
        $last_name = $this->put('last_name');
        $email_address = $this->put('email_address');
        $groupID = $this->put('groupID');
        if(empty($first_name) || empty($last_name) || empty($email_address) || empty($groupID))
        {
             $this->response('Invalid parameters');
        }
         $parameters = array('first_name' => $first_name, 'last_name' => $last_name, 'email_address' => $email_address,'groupID' => $groupID);

        $user =$this->Api_model->createUser($parameters);
        $this->response($user,200); 
      
    }

    /**
    * Create Group
    *
    * @param STRING $group_name
    * @return XML|JSON
    */
    public function group_put()
    {
        $group_name = $this->put('group_name');
        if(empty($group_name))
        {
             $this->response('Invalid parameters');
        }

        $user =$this->Api_model->createGroup($group_name);
        $this->response($user,200); 

    }

    /**
    * Update group information by ID
    *
    * @param INT $id
    * @param STRING $group_name
    * @return XML|JSON
    */
    public function group_post()
    {
         if(!$this->post('groupID'))
        {
            $this->response('Invalid Parameter');
        }
        $parameter = array();
        $parameter['groupID']    = $this->post('groupID');
        $parameter['Name']  = $this->post('group_name');
       
        $user =$this->Api_model->updateGroup($parameter);
        $this->response($user,200); 
    }
    
    /**
    * Update user information by ID
    *
    * @param INT $id
    * @param STRING $first_name {optional}
    * @param STRING $last_name {optional}
    * @param INT $groupID {optional}
    * @param STRING $email_address {optional}
    * @return XML|JSON
    */
    public function user_post()
    {
         if(!$this->post('id'))
        {
            $this->response('Invalid Parameter');
        }
        $parameter = array();
        $parameter['id']    = $this->post('id');
        $parameter['first_name']  = $this->post('first_name');
        $parameter['last_name']  = $this->post('last_name');
        $parameter['email_address']  = $this->post('email_address');
        $parameter['groupID']  = $this->post('groupID');
       
        $user =$this->Api_model->updateUser($parameter);
        $this->response($user,200); 
    }
 
   
}