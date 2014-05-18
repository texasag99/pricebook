<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Academic Free License version 3.0
 *
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');


class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
public function index(){
		$this->login();
	}

	public function login(){
		$data['title']='Login';
		$data['page_header']='Login';
		$this->load->view('login_view',$data);
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
			redirect('User/members');
		   }else{
			   $this->login();					
		   }
	}

	public function members(){
				if ($this->session->userdata('is_logged_in')){
				$data['title']="Members page";
				$data['page_header']='Members page';
				$this->load->view('members_view',$data);
			}else{
		      redirect ('User/restricted');	
			}
	}

public function restricted(){
			$this->load->view('restricted_view');
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
			$this->form_validation->set_message('is_unique',"The user already exists.");
			if ($this->form_validation->run()){
					    //generate a random key
						$key = md5(uniqid());
						   //send and email to the user
						$this->load->library('email');
						$this->email->from('bejan.nouri@gmail.com',"Bejan Nouri");
						$this->email->to($this->input->post('email'))	;
						$this->email->subject('Confirm your account!');
						$message = "<p>Thank you for signing up</p>";
						$message .= "<p><a href='".base_url()."User/confirm_registration/$key'>Click Here</a> to confirm 
						your account.</p>";		    
						$this->email->message($message);
						if ($this->email->send()){
									echo "The email has been sent!";
								}else{ 
									 echo "The email failed to send. Please notify the system administrator.";
								}	
						$this->load->model('User_model');
						$data = array(
								'email'=>$this->input->post('email'),
								'temp_key'=>$key
						);
						if($this->User_model->register_new_user($data)){
							echo "New user data was inserted correctly";
						}else{
							echo "There is a problem inserting the new user information in the database";
						}	 
			 	      
			}else{
						$this->registration();
			}
}

public function confirm_registration($key){
	echo "You are confirmed";

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

public function logout(){
	$this->session->sess_destroy();
	redirect('User/login');


}


}
/* End of file user.php */
/* Location: ./application/controllers/user.php */
