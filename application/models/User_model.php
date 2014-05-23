<?php
/*
 * Filename : getsetDB.php
 * Author : BEJAN NOURI
 * Date : 1-22-2013
 * Summary: THIS FILE CREATED AS PART OF THE TUTORIAL DEMONSTRATION FOR 
 * 			LEARNING CODEIGNITER. USED TO GET AND SET DB VALUES. 
 * 
 * */

class User_model extends CI_Model {

public function can_log_in()	{
		$this->db->where('email', $this->input->post('email'));
		$this->db->where('password', md5($this->input->post('password')));
		$query = $this->db->get('user');		
		if($query->num_rows() == 1){
			return true;
			}else{
			return false;
			}		
	}	
	
	
public function is_active()	{
		$this->db->where('email', $this->input->post('email'));
		$this->db->where('password', md5($this->input->post('password')));
		$this->db->where('status','ACTIVE');
		$query = $this->db->get('user');		
		if($query->num_rows() == 1){
			return true;
			}else{
			return false;
			}		
	}	

public function is_unlocked()	{
		$this->db->where('email', $this->input->post('email'));
		$this->db->where('password', md5($this->input->post('password')));
		$this->db->where('locked',0);
		$query = $this->db->get('user');		
		if($query->num_rows() == 1){
			return true;
			}else{
			return false;
			}		
	}	
	
public function register_new_user($data){
			$user_data = array(
								'first'=>$this->input->post('first'),
								'last'=>$this->input->post('last'),
								'email'=>$this->input->post('email'),
								'password'=>md5($this->input->post('password')),
								'created'=>date("Y-m-d H:i:s"),
								'status' => 'PENDING',
								'locked' => 0
			);
         $this->db->insert('temp_user', $data);
         $this->db->insert('user',$user_data);
         if($this->db->affected_rows() > 0){
	         return true;
	         }else{
				return false;         
	         }
	}

public function confirm_key($key){
		$this->db->where('temp_key', $key);
		$query = $this->db->get('temp_user');		
		if($query->num_rows() == 1){
			return true;
			}else{
			return false;
			}	
}

public function activate_new_user($key){
	$this->db->where('temp_key',$key);
	$query = $this->db->get('temp_user');
	foreach($query->result() as $row)
	{
		$email = $row->email;
	}
   $user_data = array(
								'last_updated'=>date("Y-m-d H:i:s"),
								'status' => 'ACTIVE'
								);
	$this->db->where('email', $email);
	$this->db->update('user',$user_data);
	if($this->db->affected_rows() > 0){
	$this->db->delete('temp_user', array('temp_key' => $key));
	return true;	
	}else{
	return false;
	}
}

public function get_user_data(){
 $this->db->where('email', $this->session->userdata('email'));
 $query = $this->db->get('user');
 foreach($query->result() as $row){
 		$user_data['email']= $row->email;
 		$user_data['first']= $row->first;
 		$user_data['last']= $row->last;
 		$user_data['created']= $row->created;
 		$user_data['last_updated']= $row->last_updated; 
 		$user_data['id']= $row->id;
 }
 return $user_data;
 }
 
 public function get_user_profile($id){
 $this->db->where('user_id',$id);
 $query = $this->db->get('user_profile');
 if($query->num_rows() > 0){
 	foreach($query->result() as $row){
       $user_profile['address1'] = $row->address1;
       $user_profile['address2'] = $row->address2;
       $user_profile['city'] = $row->city;
       $user_profile['state'] = $row->state;
       $user_profile['company_name'] = $row->company_name;
       $user_profile['country'] = $row->country;
       $user_profile['profile_created'] = $row->created;
       $user_profile['profile_updated'] = $row->last_updated;
       $user_profile['email2'] = $row->email2;
       $user_profile['fax'] = $row->fax;
       $user_profile['mobile'] = $row->mobile;
		 $user_profile['tel'] = $row->tel;
		 $user_profile['website'] = $row->website; 	
	    $user_profile['zip'] = $row->zip;
 	}}else{
  		 $user_profile['address1'] =  'empty';
       $user_profile['address2'] =  'empty';
       $user_profile['city'] =  'empty';
       $user_profile['state']='empty';
       $user_profile['company_name'] = 'empty';
       $user_profile['country'] =  'empty';
       $user_profile['profile_created'] =  'User profile has not been created';
       $user_profile['profile_updated'] = 'User profile has not been updated';
       $user_profile['email2'] =  'empty';
       $user_profile['fax'] =  'empty';
       $user_profile['mobile'] =  'empty';
		 $user_profile['tel'] =  'empty';
		 $user_profile['website'] = 'empty';	
	    $user_profile['zip'] = 'empty'; 
 }
return $user_profile;
}


}
