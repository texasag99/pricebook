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


class Main extends CI_Controller {

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
public function index()
	{
		$this->login();
	}

	public function login()
	{
		$data['title']='Login';
		$data['page_header']='Login';
		$this->load->view('login_view',$data);
	}

	public function members(){
		$data['title']="Members page";
		$data['page_header']='Members page';
		$this->load->view('members_view',$data);
	}

	public function checkLogin()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|callback_validate_credentials');		
		$this->form_validation->set_rules('password', 'Password', 'required|md5|trim');
		
		if($this->form_validation->run())	{
			$data = array(
						'email' => $this->input->post('email'),
						'is_logged_in' => 1			
				);
			$this->session->set_userdata($data);
				redirect('main/members');
		}	else{
			   $this->login();					
		}
	}

public function validate_credentials(){
	  $this->load->model('User_model');	  
	  if ($this->User_model->can_log_in()){
	          return true;	
	}else{
			    $this->form_validation->set_message('validate_credentials', 'Incorrect email/password.');
			    return false;
    }
   }
}
/* End of file main.php */
/* Location: ./application/controllers/main.php */