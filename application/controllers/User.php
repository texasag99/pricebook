<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
filename: User.php
Author: Bejan Nouri
Last update: 7-12-2014

Notes- 

This is the "User" controller which manages everything related to user functionality including:
- login/logout
- change password
- set user session data
- initial user registration and setup
- forgot my password [TBD]

Functions include:
1. index()
2. login()
3. logout()
3. login_validation() - for validating the login credentials
4. registration() - call the initial registration/user setup page
5. registration_validation() - validate the registration values
6. confirm_registration($key) - confirms the user after they have selected the link in the email they receive
7. validate_credentials () - used during the login validation as a callback procedure...this confirms the user password is correct, the user isn't locked_out, the user is "ACTIVE"
8. change_password() - loads the page for changing the user password
9. password_validation() - validates the values passed in the change password form
10.  verify_password() - Used during the password validation  as a callback procedure to verify s the current password
11. confirm_password($key) - confirms the new password after the user has selected the link in the email.
12. error_message($error) - loads the standard error page, when an error is called by another function.
13. restricted() - loads the standard restricted access page, when someone tries to access something that is restricted.

*/

class User extends CI_Controller {

public function index(){
		$this->login();
	}

public function login(){
		$data['title']='Login';
		$data['page_header']='Login';
		$this->load->view('login_view',$data);
	}

public function logout(){
	$this->session->sess_destroy();
	redirect('User/login');
}

public function login_validation(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|callback_validate_credentials');		
		$this->form_validation->set_rules('password', 'Password', 'required|md5|trim');
		if($this->form_validation->run())	{
				$data = array(
						'email' => $this->input->post('email'),
						'is_logged_in' => 1			
				);
			$this->session->set_userdata($data);
			redirect('Profile');
		   }else{
			   $this->login();					
		   }
	}

public function registration(){
	$data['title']="Site Registration";
	$data['page_header']="Site Registration";
	$this->load->view('registration_view',$data);
}

public function registration_validation(){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('first', 'First Name', 'required|trim');
			$this->form_validation->set_rules('last', 'Last Name', 'required|trim');			
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]|is_unique[temp_user.email]');
			$this->form_validation->set_rules('password', 'Password', 'required|trim');
			$this->form_validation->set_rules('confirm_password','Confirm Password', 'required|trim|matches[password]');
			$this->form_validation->set_message('is_unique',"The user email already exists.");
			if ($this->form_validation->run()){
					    //generate a random key
						$key = md5(uniqid());
						   //add the user info to the db, build the email and send and email to the new user
						$this->load->library('email');
						$this->load->model('Config_model');
						$from_email = $this->Config_model->get_from_email();
						$from_name = $this->Config_model->get_from_name();
						$this->email->from($from_email, $from_name);
						$this->email->to($this->input->post('email'))	;
						$this->email->subject('Confirm your account!');
						$message = "<p>Thank you for signing up</p>";
						$message .= "<p><a href='".base_url()."User/confirm_registration/$key'>Click Here</a> to confirm your account.</p>";		    
						$this->email->message($message);						
						$this->load->model('User_model');
						$data = array(
								'email'=>$this->input->post('email'),
								'temp_key'=>$key
						);
						if($this->User_model->register_new_user($data)){
							if ($this->email->send()){
									echo "The user has been successfully entered and an email has been sent!";
								}else{ 
									echo "The email failed to send. Please notify the system administrator.";
								}	
						}else{
							echo "There is a problem inserting the new user information in the database";
						}	 
			   }else{ //Else if the form is not valid...they didn't enter a field properly or user already exists. Then reload the registration page with the errors.
						
						$this->registration();
			}
}

public function confirm_registration($key){
	$this->load->model('User_model');
	if ($this->User_model->confirm_key($key)){
		if ($this->User_model->activate_new_user($key)){
			$data['title']="User Activated!";
			$data['page_header']="You have successfully activated your account!"	;		
			$this->load->view('user_activated_view',$data);		
		}else {
			   $error = "<p><span id='error'>There is a problem with activating the new user. </span> Please contact the system administrator</p>";
				$this->error_message($error);
		}
	} else{
	         $error = "<p><span id='error'>The activation key is not valid!</span> <br><br> Did you already activate the account?<br><br>
	         You are receiving this error because the registration key is no longer valid and may be because you already activated the account or 
	         the URL link has been altered in some way. Please contact a system administrator for further assistance.</p>";
				$this->error_message($error);
			} 
}

public function validate_credentials(){
		  $this->load->model('User_model');	  
		  if ($this->User_model->can_log_in()){
		      if($this->User_model->is_active()){
		      	if($this->User_model->is_unlocked()){
		      		return true;
		      	}else{
		      		$this->form_validation->set_message('validate_credentials','User is locked.');
		      		return false;
		      	}
		      }else{
		      	$this->form_validation->set_message('validate_credentials','User has not been activated.');
		      	return false;
		      }
	     }else{
		     $this->form_validation->set_message('validate_credentials', 'Invalid email/password.');
			  return false;
	     }
 }
 
public function forgot_my_password(){
	$data['title']="Forgot My Password";
	$data['page_header']="Forgot My Password";
	$this->load->view('fmp_view',$data);
}

public function fmp_validation(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|callback_verify_email');
		$this->form_validation->set_message('verify_email', 'This is not a valid email');		
		if($this->form_validation->run()){
				//generate a random key
						$key = md5(uniqid());
						   //add the user info to the db, build the email and send and email to the new user
						$this->load->library('email');
						$this->load->model('Config_model');
						$from_email = $this->Config_model->get_from_email();
						$from_name = $this->Config_model->get_from_name();
						$this->email->from($from_email, $from_name);
						$this->email->to($this->input->post('email'))	;
						$this->email->subject('Forgot My Password');
						$message = "<p>This email has been sent to reset your password</p>";
						$message .= "<p><a href='".base_url()."User/fmp_confirm/$key'>Click Here</a> to create a new password.</p>";		    
						$this->email->message($message);						
						$this->load->model('User_model');
						$data = array(
								'email'=>$this->input->post('email'),
								'temp_key'=>$key
						);
						if($this->User_model->register_new_password($data) && $this->email->send()){
									echo "A request to change your password has been sent to your email address!";
								}else{ 
									echo "The email failed to send. Please notify the system administrator.";
								}	 
		   }else{
			   $this->forgot_my_password();					
		   }
}

public function verify_email(){
	$this->load->model('User_model');
	$email= $this->input->post('email');
	if ($this->User_model->verify_email($email)){
				return true; 
				}else{
				return false;
				}

}

public function fmp_confirm($key){
  $this->load->model('User_model');
	if ($this->User_model->confirm_key($key)){
//need to put the information to remove the $key and then call the fmp_create_new_password view...
echo "this will be where we show the create new password screen";		
		
		
	} else{
	$this->session->sess_destroy();
   $error = "<p><span id='error'>The activation key is not valid!</span> <br><br> Did you already activate the password?<br><br>
   You are receiving this error because the registration key is no longer valid and may be because you already activated the new password or 
   the URL link has been altered in some way. Please contact a system administrator for further assistance.</p>";
	$this->error_message($error);
	} 
}
 
public function change_password(){
				if ($this->session->userdata('is_logged_in')){
					$this->load->model('User_model');
					$email = $this->session->userdata('email');
					$user_data = $this->User_model->get_user_data($email);
					$view_data['title']="Change My Password";
					$view_data['page_header']= "Change password for: <strong>".$user_data['first']." ".$user_data['last']."</strong>";
					$data= array_merge($view_data, $user_data);
					$this->load->view('password_change_view',$data);	
			}else{
		      redirect ('User/restricted');	
			}
	}

public function password_validation(){
	$this->load->library('form_validation');
	$this->form_validation->set_rules('current_password','Current Password','required|trim|callback_verify_password');
	$this->form_validation->set_message('verify_password',"You must enter your current password correctly.");
	$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]');
	$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|matches[password]');
		if($this->form_validation->run()){
		    //generate a random key
				$key = md5(uniqid());
				//add the user info to the db, build the email and send and email to the new user
				$this->load->library('email');
				$this->load->model('Config_model');
				$from_email = $this->Config_model->get_from_email();
				$from_name = $this->Config_model->get_from_name();
				$this->email->from($from_email, $from_name);
				$email = $this->session->userdata('email');
				$this->email->to($email);
				$this->email->subject('Confirm your new password!');
				$message = "<p>Thank you for changing your password.</p>";
				$message .= "<p><a href='".base_url()."User/confirm_password/$key'>Click Here</a> to confirm your new password.</p>";		    
				$this->email->message($message);						
				$this->load->model('User_model');
				$data = array(
								'email'=>$this->session->userdata('email'),
								'password'=>md5($this->input->post('password')),
								'temp_key'=>$key
						);
				if($this->User_model->register_new_password($data) && $this->email->send()){
					   echo "The user's password is pending update. An email has been sent to ".$email." in order to confirm this change!";
					}else{
						$this->error_message('<p><span id="error">There was a problem updating your password. </span> Please contact the system administrator.</p>');
					}
		}else{
		   $this->change_password();
		}
} 
public function verify_password(){
	$this->load->model('User_model');
	$password = md5($this->input->post('current_password'));
	$email = $this->session->userdata('email');
	if ($this->User_model->verify_password($password, $email)){
				return true; 
				}else{
				return false;
				}
}

public function confirm_password($key){
	$this->load->model('User_model');
	if ($this->User_model->confirm_key($key)){
		if ($this->User_model->activate_new_password($key)){
			$this->session->sess_destroy();
			echo "You have successfully updated your password. Please <a href='".base_url()."/User/login'>click here</a> to login again.";			
		}else {
			$this->session->sess_destroy();
			$error = "<p><span id='error'>There is a problem with activating the new password. </span> Please contact the system administrator.</p>";
			$this->error_message($error);
		}
	} else{
	$this->session->sess_destroy();
   $error = "<p><span id='error'>The activation key is not valid!</span> <br><br> Did you already activate the password?<br><br>
   You are receiving this error because the registration key is no longer valid and may be because you already activated the new password or 
   the URL link has been altered in some way. Please contact a system administrator for further assistance.</p>";
	$this->error_message($error);
	} 
}
	
 public function error_message($error){
         $data['title']="There is a problem with the User controller!";
	      $data['page_header']="<span id='error'>There is a problem!</span>";
	      $data['error_message']= $error;
			$this->load->view('There_is_a_problem_view',$data); 
 }
 
 public function restricted(){
			$this->session->sess_destroy();//if the user attempts to access a restricted area...destroy the session
	      $data['title']="There is a problem!";
	      $data['page_header']="There is a problem!";
	      $data['error_message']="<span style='color:red; font-size:2em; font-weight:bold;'>Restricted Access!</span><br><br>You have attempted to access an area that is restricted.";
			$this->load->view('There_is_a_problem_view',$data);
	}



}
/* End of file user.php */
/* Location: ./application/controllers/user.php */
