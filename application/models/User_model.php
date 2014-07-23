<?php
/*
 * Filename : User_model.php
 * Author : BEJAN NOURI
 * Date : 7-2-2014
 * Summary: Access data related to the User controller and the Profile controller
 * */

class User_model extends CI_Model {

public function can_log_in()	{
		$email = $this->input->post('email');
		$password = md5($this->input->post('password'));		
		if($this->verify_password($password, $email)){
			return true;
			}else{
			return false;
			}		
}		

public function is_active()	{
		$this->db->where('email', $this->input->post('email'));
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
		$this->db->where('locked',0);
		$query = $this->db->get('user');		
		if($query->num_rows() == 1){
			return true;
			}else{
			return false;
			}		
	}	
public function verify_password($password, $email)	{
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		$query = $this->db->get('user');		
		if($query->num_rows() == 1){
			$this->reset_retry_counter($email);			
			return true;			
			}else{
			if ($this->verify_email($email)){
				$this->increase_retry_counter($email);
				}else{
				return false;
				}
		   }		
	}	
	
public function increase_retry_counter($email){ //increments the password retries
	$this->db->where('email',$email);
	$query = $this->db->get('user');
	foreach($query->result() as $row){
 		$user_data['retry_counter']= $row->retry_counter;
 	    }
  $retry_limit = $this->get_retry_limit();
  if ($retry_limit == NULL || $retry_limit == 0){ 
  		$retry_limit = 3; //default is 3 tries and your out
  		}else{ 
  		$retry_limit = $retry_limit; 
  		}
  $counter = $user_data['retry_counter'];
  if ($counter >= $retry_limit) {
  	$user_data= array('locked'=>1);
  	$this->db->where('email',$email);
  	$this->db->update('user',$user_data);
  	if($this->db->affected_rows() > 0){ 
  		return true; 
  		}else{ 
  		return false; 
  		}  
  }else{
   ++$counter;
   $user_data= array( 'retry_counter'=>$counter);
   $this->db->where('email',$email);
   $this->db->update('user',$user_data);
   if($this->db->affected_rows() > 0){
   	return true;
   	}else{
   	return false;
   	}
    }
}

public function reset_retry_counter($email){
	$user_data= array( 'retry_counter'=>0);
   $this->db->where('email',$email);
   $this->db->update('user',$user_data); 
}

public function get_retry_limit() {
	$query = $this->db->get('config');
 	foreach($query->result() as $row){
 		$retry_limit= $row->retry_limit;
 	    }
 	return $retry_limit;
	}	


public function verify_email($email){
		$this->db->where('email', $email);
		$query = $this->db->get('user');		
		if($query->num_rows() == 1){
			return true;
			}else{
			return false;
			}		
	}	
public function update_password($password, $email){
$user_data = array (
		'password' => $password,
		'last_updated'=>date("Y-m-d H:i:s")
);
$this->db->where('email',$email);
$this->db->update('user',$user_data);
if($this->db->affected_rows() >0){
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

public function confirm_key($key, $return_values){
		$this->db->where('temp_key', $key);
		$query = $this->db->get('temp_user');		
		if($query->num_rows() == 1){
					if($return_values == true) {
						foreach($query->result() as $row){
						$temp_data{'email'}= $row->email;
						}
					   return $temp_data;
					}else{
						return true;
					}
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
	$user_data = $this->get_user_data($email);
	$id = $user_data['id'];
	$profile_data = array('user_id'=>$id);
	$this->db->insert('user_profile',$profile_data);
	return true;	
	}else{
	return false;
	}
}

public function get_user_data($email){
 $this->db->where('email', $email);
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
       $profile_data['address1'] = $row->address1;
       $profile_data['address2'] = $row->address2;
       $profile_data['city'] = $row->city;
       $profile_data['state'] = $row->state;
       $profile_data['company_name'] = $row->company_name;
       $profile_data['country'] = $row->country;
       $profile_data['profile_updated'] = $row->last_updated;
       $profile_data['email2'] = $row->email2;
       $profile_data['fax'] = $row->fax;
       $profile_data['mobile'] = $row->mobile;
		 $profile_data['tel'] = $row->tel;
		 $profile_data['website'] = $row->website; 	
	    $profile_data['zip'] = $row->zip;
 	}}else{
  		 return false;
 }
return $profile_data;
}

public function update_user_data(){
			$user_update = array(
								'first'=>$this->input->post('first'),
								'last'=>$this->input->post('last'),
								'last_updated'=>date("Y-m-d H:i:s")
			);
			$user_data = $this->get_user_data($this->session->userdata('email'));
			$id = $user_data['id'];
			$this->db->where('id', $id);
         $this->db->update('user', $user_update);
         if($this->db->affected_rows() > 0){
	         return true;
	         }else{
				return false;         
	         }
	}
	
public function update_user_profile(){
			$profile_data = array(
								'address1'=>$this->input->post('address1'),
								'address2'=>$this->input->post('address2'),
								'city'=>$this->input->post('city'),
								'state'=>$this->input->post('state'),
								'zip'=>$this->input->post('zip'),
								'country'=>$this->input->post('country'),
								'email2'=>$this->input->post('email2'),
								'tel'=>$this->input->post('tel'),
								'mobile'=>$this->input->post('mobile'),
								'fax'=>$this->input->post('fax'),
								'company_name'=>$this->input->post('company_name'),
								'website'=>$this->input->post('website'),						
								'last_updated'=>date("Y-m-d H:i:s")
			);
			$user_data = $this->get_user_data($this->session->userdata('email'));
			$id = $user_data['id'];
			$this->db->where('user_id', $id);
         $this->db->update('user_profile', $profile_data);
         if($this->db->affected_rows() > 0){
	         return true;
	         }else{
				return false;         
	         }
	}
	
public function register_new_password($data){
         $this->db->insert('temp_user', $data);
         if($this->db->affected_rows() > 0){
	         return true;
	         }else{
				return false;         
	         }
	
	}
	
public function activate_new_password($key){
		$this->db->where('temp_key', $key);
	   $query = $this->db->get('temp_user');
		 foreach($query->result() as $row){
		 		$user_data['email']= $row->email;
		 		$user_data['password'] = $row->password;
		 }
		 if (empty($user_data['password'])){
					 $password = md5($this->input->post('password'));		 
					 }else{ 
					 $password = $user_data['password'];
					 }
		 $email = $user_data['email'];
		 if($this->update_password($password,$email)){
		 		$this->db->delete('temp_user', array('temp_key' => $key));
		 		return true;
		 }else{
				return false;		 
		 }	
	}
	

}
