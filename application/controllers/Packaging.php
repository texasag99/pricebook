<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
FOR PRICEBOOK APPLICATION

filename: Packaging.php
Author: Bejan Nouri
Last update: 2-5-2016

Notes- 

This is the "Packaging" controller which manages everything related to pricebook packaging functionality.

*/

class Packaging extends CI_Controller {

public function __construct(){
	parent::__construct();
	$this->load->model('Packaging_model');	
	$this->load->model('Config_model');
	$this->load->model('Audit_model');
	$this->load->library('pagination');	
		
}

public function index(){
		$this->show_active_packaging_paginated(0, 0);
	}

/*************HAS PERMISSIONS*********************/
private function has_permission_to_view(){
	$all_permissions = $this->session->userdata('permissions');
	$permission = array();
	foreach ($all_permissions as $value){
			$permission[]= $value->id;				
		}
	if( in_array(8025, $permission) ||in_array(9999, $permission)){
    return true;
    	}else{
    	return false;
    	}
}

private function has_permission_to_edit(){
	$all_permissions = $this->session->userdata('permissions');
	$permission = array();
	foreach ($all_permissions as $value){
			$permission[]= $value->id;			
			}
	if( in_array(8030, $permission) ||in_array(9999, $permission)){
    return true;
    	}else{
    	return false;
    	}
}

private function has_permission_to_delete(){
	$all_permissions = $this->session->userdata('permissions');
	$permission = array();
	foreach ($all_permissions as $value){
			$permission[]= $value->id;			
			}
	if( in_array(8035, $permission) ||in_array(9999, $permission)  ){
    return true;
    	}else{
    	return false;
    	}
}

private function has_permission_to_add(){
	$all_permissions = $this->session->userdata('permissions');
	$permission = array();
	foreach ($all_permissions as $value){
			$permission[]= $value->id;			
			}
	if( in_array(8040, $permission) ||in_array(9999, $permission)  ){
    return true;
    	}else{
    	return false;
    	}
}

/********************PAGINATION SETUP*********************************/
public function pagination_setup($type){		
	$default_pagination= $this->Config_model->get_default_pagination();
	$pagination_config = array();
	$sort_by = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
	$per_page = ($this->uri->segment(5))? $this->uri->segment(5) : $default_pagination;	
	if ($type=='all_packaging'){
	$per_page = ($this->uri->segment(5))? $this->uri->segment(5) : $default_pagination;
	$pagination_config["base_url"] = base_url()."Packaging/show_all_packaging_paginated/".$sort_by."/0/".$per_page."/";
	$pagination_config["total_rows"] = $this->Packaging_model->packaging_record_count();
	$pagination_config["uri_segment"] = 6;//this is where we determine which row start we are on, also referred to as the start page or record:
	$pagination_config["per_page"] = $per_page;	
	}elseif($type=='active_packaging'){
	$per_page = ($this->uri->segment(5))? $this->uri->segment(5) : $default_pagination;
	$pagination_config["base_url"] = base_url()."Packaging/show_active_packaging_paginated/".$sort_by."/0/".$per_page."/";
	$pagination_config["total_rows"] = $this->Packaging_model->active_packaging_record_count();
	$pagination_config["uri_segment"] = 6;//this is where we determine which row start we are on, also referred to as the start page or record:
   $pagination_config["per_page"] = $per_page;	
	}else{//searched packaging
		$sort_by = ($this->uri->segment(4))? $this->uri->segment(4) : 0;	
		$per_page = ($this->uri->segment(6))? $this->uri->segment(6) : $default_pagination;	
		$pagination_config["base_url"] = base_url()."Packaging/search_packaging_paginated/".$type."/".$sort_by."/0/".$per_page."/";
		$pagination_config["total_rows"] = $this->Packaging_model->search_packaging_record_count($type);		
		$pagination_config["uri_segment"] = 7;	//this is where we determine which row start we are on, also referred to as the start page or record:	
		$pagination_config["per_page"] = $per_page;	
		}
	$pagination_config["full_tag_open"] = "<ul class='pagination'>";
	$pagination_config["full_tag_close"] = "</ul>";
	$pagination_config["first_tag_open"] = "<li>";
	$pagination_config["first_tag_close"] = "</li>";
	$pagination_config["last_tag_open"] = "<li>";
	$pagination_config["last_tag_close"] = "</li>";
	$pagination_config["next_tag_open"] = "<li>";
	$pagination_config["next_tag_close"] = "</li>";
	$pagination_config["prev_tag_open"] = "<li>";
	$pagination_config["prev_tag_close"] = "</li>";
	$pagination_config["cur_tag_open"] = "<li class='active'><a href='#'>";
	$pagination_config["cur_tag_close"] = "</a></li>";
	$pagination_config["num_tag_open"] = "<li>";
	$pagination_config["num_tag_close"] = "</li>";
	$this->pagination->initialize($pagination_config);
	return $pagination_config;	
}	

/*********************SHOW ALL PKGES************************************/

public function show_all_packaging_paginated($sort_by, $pagination_config){
	if ($this->session->userdata('is_logged_in') && $this->has_permission_to_view()){
		$this->load->helper("url");
		if (empty($pagination_config) || $pagination_config==0){
			$pagination_config = $this->pagination_setup('all_packaging');
		}
		$page =  ($this->uri->segment(6))? $this->uri->segment(6) : 0;	
		$data["results"] = $this->Packaging_model->get_all_packaging_paginated($pagination_config["per_page"], $page, $sort_by);
      // $data["categories"] = $this->Packaging_model->get_packaging_categories();
		$data ["links"] = $this->pagination->create_links();
		$data['integration_rate'] = .5;
      $data['alf_rate'] = .2;
		$default_pagination= $this->Config_model->get_default_pagination();
		$view_data['per_page'] = ($this->uri->segment(5))? $this->uri->segment(5) : $default_pagination;	
		$view_data['total_records'] = $pagination_config['total_rows'];
		$view_data['controller']="show_all_packaging_paginated";
	   $view_data['sort_by'] = $this->uri->segment(3); 
		$view_data['allow_add'] = $this->has_permission_to_add();
		$view_data['allow_delete'] = $this->has_permission_to_delete();
		$view_data['allow_edit'] = $this->has_permission_to_edit();
		$view_data['title']="PriceBook - Packaging Administration";
		$view_data['page_header']= "All Packaging";
		$data= array_merge($view_data, $data);
		$audit = array('primary' => 'PKG', 'secondary'=>'VIEW', 'status'=>true,  'controller'=>'Packaging', 'value'=>null,  'extra_1' =>null, 'extra_2'=>null, 'extra_3'=>null);
		$this->Audit_model->log_entry($audit);
		$this->load->view("header",$data);
		$this->load->view("navbar",$data);
		$this->load->view("show_all_packaging_view",$data);
		$this->load->view("footer",$data);				
			}else{
		      redirect ('User/restricted');	
			}
	} 
	
public function show_active_packaging_paginated($sort_by, $pagination_config){
	if ($this->session->userdata('is_logged_in') && $this->has_permission_to_view()){
		$this->load->helper("url");
		if (empty($pagination_config) || $pagination_config==0){
			$pagination_config = $this->pagination_setup('active_packaging');
		}
		$page =  ($this->uri->segment(6))? $this->uri->segment(6) : 0;		
		$data["results"] = $this->Packaging_model->get_active_packaging_paginated($pagination_config["per_page"], $page, $sort_by);
        //$data["categories"] = $this->Packaging_model->get_packaging_categories();
		$data ["links"] = $this->pagination->create_links();
		$data['integration_rate'] = .5;
      $data['alf_rate'] = .2;		
		$default_pagination= $this->Config_model->get_default_pagination();
		$view_data['per_page'] = ($this->uri->segment(5))? $this->uri->segment(5) : $default_pagination;	
		$view_data['total_records'] = $pagination_config['total_rows'];
		$view_data['controller']="show_active_packaging_paginated";
	    $view_data['sort_by'] = $this->uri->segment(3); 
		$view_data['allow_add'] = $this->has_permission_to_add();
		$view_data['allow_delete'] = $this->has_permission_to_delete();
		$view_data['allow_edit'] = $this->has_permission_to_edit();
		$view_data['title']="PriceBook - Packaging Administration";
		$view_data['page_header']= "Active Packaging";
		$data= array_merge($view_data, $data);
		$audit = array('primary' => 'PKG', 'secondary'=>'VIEW', 'status'=>true,  'controller'=>'Packaging', 'value'=>null,  'extra_1' =>null, 'extra_2'=>null, 'extra_3'=>null);
		$this->Audit_model->log_entry($audit);
		$this->load->view("header",$data);
		$this->load->view("navbar",$data);
		$this->load->view("show_all_packaging_view",$data);
		$this->load->view("footer",$data);				
			}else{
		      redirect ('User/restricted');	
			}
	} 	
	
public function search_packaging(){
	if ($this->session->userdata('is_logged_in') && $this->has_permission_to_view()){
	$audit_value = json_encode($this->input->post());
	$this->load->library('form_validation');
	$this->form_validation->set_rules('search_by', 'Search Field', 'required|trim');
	if ($this->form_validation->run()){
		$search_by=$this->input->post('search_by');
		$search_by=trim($search_by);
		$search_by=strip_tags($search_by,"");
		$search_by = str_replace('@', '-at-',$search_by);		
		$search_by = preg_replace('/[^A-Za-z0-9\s.\s-]/','',$search_by); 		
		redirect('Packaging/search_packaging_paginated/'.$search_by.'/0/0/0/');
	}else{ //end of section for the forms valid 
	    $audit = array('primary' => 'PKG', 'secondary'=>'SRCH', 'status'=>false,  'controller'=>'Packaging', 'value'=>$audit_value,  'extra_1' =>'invalid search entry', 'extra_2'=>null, 'extra_3'=>null);
	 	 $this->Audit_model->log_entry($audit);
	    $this->index();
	}}else{//end of section for user properly logged in
		      redirect ('User/restricted');	
			}
	
}


public function search_packaging_paginated($search_by,$sort_by, $pagination_config){
	if ($this->session->userdata('is_logged_in') && $this->has_permission_to_view()){
		$this->load->helper("url");		
		if (empty($pagination_config) || $pagination_config==0){
			$pagination_config = $this->pagination_setup($search_by);
		}
		$page = ($this->uri->segment(7))? $this->uri->segment(7) : 0;	
		$search_by = str_replace('-at-', '@',$search_by);	//this handles the @ symbol when it is passed in the url.
		$data["results"] = $this->Packaging_model->search_packaging_paginated($pagination_config["per_page"], $page, $sort_by, $search_by);
        //$data["categories"] = $this->Packaging_model->get_packaging_categories();
		$data ["links"] = $this->pagination->create_links();
		$data['integration_rate'] = .5;
      $data['alf_rate'] = .2;
		$search_by = str_replace('@', '-at-',$search_by);	 //this changes the @ symbol back to -at-
		$data['search_by']=$search_by;
		$default_pagination= $this->Config_model->get_default_pagination();
	    $view_data['per_page'] = ($this->uri->segment(6))? $this->uri->segment(6) : $default_pagination;	
	    $view_data['total_records'] = $pagination_config['total_rows'];
	    $view_data['sort_by'] = $this->uri->segment(4); 
		$view_data['title']="PriceBook - Packaging Administration";
		$view_data['allow_add'] = $this->has_permission_to_add();
		$view_data['allow_delete'] = $this->has_permission_to_delete();
		$view_data['allow_edit'] = $this->has_permission_to_edit();
		$view_data['page_header']= "Packaging Found";
		$view_data['controller']="search_packaging_paginated/".$search_by;
		$data= array_merge($view_data, $data);		
		$audit = array('primary' => 'PKG', 'secondary'=>'SRCH', 'status'=>true,  'controller'=>'Packaging', 'value'=>$search_by,  'extra_1' =>'search packaging paginated', 'extra_2'=>null, 'extra_3'=>null);
		$this->Audit_model->log_entry($audit);
		$this->load->view("header",$data);
		$this->load->view("navbar",$data);
		$this->load->view("show_all_packaging_view",$data);
		$this->load->view("footer",$data);

	}else{
		      redirect ('User/restricted');	
			}
	} 
    
    
public function getPackaging($id){ 
				if ($this->session->userdata('is_logged_in') && $this->has_permission_to_view()){
					$data['results']= $this->Packaging_model->get_packaging($id);
              $data['integration_rate'] = .5;
               $data['alf_rate'] = .2;
					$view_data['title']="Packaging Entry";
					$view_data['page_header']= "Packaging Entry ".$id;
					$data= array_merge($view_data, $data);
					$audit = array('primary' => 'PKG', 'secondary'=>'VIEW', 'status'=>true,  'controller'=>'Packaging', 'value'=>$id,  'extra_1' =>'view packaging entry', 'extra_2'=>null, 'extra_3'=>null);
					$this->Audit_model->log_entry($audit);
					$this->load->view('packaging_record_view',$data);						
			}else{
		     			http_response_code(400);
						echo "There was a problem.";
						$audit = array('primary' => 'PKGE', 'secondary'=>'VIEW', 'status'=>false,  'controller'=>'Packaging', 'value'=>$id,  'extra_1' =>'view packaging entry', 'extra_2'=>null, 'extra_3'=>null);
				   	$this->Audit_model->log_entry($audit);
			}
	}
	
/*********************ADD, DELETE & UPDATE A PKG***********************************/
public function delete($id){
	if ($this->session->userdata('is_logged_in') && $this->has_permission_to_delete()){
		if ($this->Packaging_model->delete_packaging($id)){
			$audit = array('primary' => 'PKG', 'secondary'=>'DEL', 'status'=>true,  'controller'=>'Packaging', 'value'=>null,  'extra_1' =>'Delete the packaging', 'extra_2'=>null, 'extra_3'=>null);
		   $this->Audit_model->log_entry($audit);
			$message = "<div class='alert alert-info'  packaging='alert'><p><span class='glyphicon glyphicon-exclamation-sign'></span> <strong>Deleted!</strong> The packaging was deleted from the system.</p></div>";
			$this->session->set_flashdata('message',$message);
			redirect('Packaging');	
			}else{
			$audit = array('primary' => 'PKG', 'secondary'=>'DEL', 'status'=>false,  'controller'=>'Packaging', 'value'=>null,  'extra_1' =>'Failed to delete the packaging', 'extra_2'=>null, 'extra_3'=>null);
		   $this->Audit_model->log_entry($audit);
			$error = "Unable to delete the packaging. Either it doesn't exist or there is something wrong with the database.";
			$this->error_message($error);
			}					
		}else{
		redirect ('User/restricted');	
		}
	} 
    
public function add(){
    if ($this->session->userdata('is_logged_in') && $this->has_permission_to_add()){
	$data['title']="Add Packaging";
	$data['page_header']="Add Packaging";
	$audit = array('primary' => 'PKG', 'secondary'=>'ADDV', 'status'=>true,  'controller'=>'Packaging', 'value'=>null,  'extra_1' =>null, 'extra_2'=>null, 'extra_3'=>null);
	$this->Audit_model->log_entry($audit);
	$this->load->view("header",$data);
	$this->load->view("navbar",$data);
	$this->load->view('add_packaging_view',$data);
	$this->load->view("footer",$data);		
    }else{
		redirect ('User/restricted');	
		}
}

public function add_validation(){
    if ($this->session->userdata('is_logged_in') && $this->has_permission_to_add()){
	$audit_value = json_encode($this->input->post());
	$this->load->library('form_validation');
	$this->form_validation->set_rules('code', 'Packaging Code', 'required|trim|min_length[4]|max_length[16]|is_unique[pb_packaging.code]');
	$this->form_validation->set_rules('description', 'Description', 'trim|xss_clean|max_length[200]');
	$this->form_validation->set_rules('price', 'Price', 'required|decimal');
	$this->form_validation->set_rules('fixed_alf', 'Fixed ALF Amount', 'decimal');
	$this->form_validation->set_rules('fixed_integration', 'Fixed Integration Amount', 'decimal');
	$this->form_validation->set_rules('title', 'Title', 'trim|max_length[100]|xss_clean');
	$this->form_validation->set_rules('integration_flag', 'Integration Flag', 'required|integer|trim');
	$this->form_validation->set_rules('alf_flag', 'ALF Flag', 'required|integer|trim');
	$this->form_validation->set_rules('discount_flag', 'Discount Flag', 'required|integer|trim');
	$this->form_validation->set_rules('status', 'Status', 'required|integer|trim');
	$this->form_validation->set_rules('notes', 'Packaging Notes', 'trim|xss_clean');
	$this->form_validation->set_message('is_unique',"The packaging code already exists.");	
	if ($this->form_validation->run()){		
			$data = array(
			'code'=>strtoupper($this->input->post('code')),
			'description'=>$this->input->post('description'),
			'price'=>$this->input->post('price'),
			'fixed_alf'=>$this->input->post('fixed_alf'),
			'fixed_integration'=>$this->input->post('fixed_integration'),
			'title'=>$this->input->post('title'),
			'integration_flag'=>$this->input->post('integration_flag'),
			'alf_flag'=>$this->input->post('alf_flag'),
			'discount_flag'=>$this->input->post('discount_flag'),
			'status'=>$this->input->post('status'),
			'notes'=>$this->input->post('notes')
			);
		if($this->Packaging_model->add_packaging($data)){			
			$audit = array('primary' => 'PKG', 'secondary'=>'ADD', 'status'=>true,  'controller'=>'Packaging', 'value'=>$audit_value,  'extra_1' =>null, 'extra_2'=>null, 'extra_3'=>null);
			$this->Audit_model->log_entry($audit);
			$message = "<div class='alert alert-success'  packaging='alert'><p><span class='glyphicon glyphicon-ok'></span> <strong>Success!</strong> The new packaging item was successfully added to the system.</p></div>";
			$this->session->set_flashdata('message',$message);
			 redirect('Packaging');
			}else{ 
			$audit = array('primary' => 'PKG', 'secondary'=>'ADD', 'status'=>false,  'controller'=>'Packaging', 'value'=>$audit_value,  'extra_1' =>'failed to add the new packaging item', 'extra_2'=>null, 'extra_3'=>null);
			$this->Audit_model->log_entry($audit);
			$message = "<div class='alert alert-warning'  packaging='alert'><p><span class='glyphicon glyphicon-exclamation-sign'></span> <strong>Failed!</strong>Failed to create the new packaging.</p></div>";
			$this->session->set_flashdata('message',$message);
            redirect('Packaging/add');			
			}	
	}else{
	$audit = array('primary' => 'PKG', 'secondary'=>'ADD', 'status'=>false,  'controller'=>'Packaging', 'value'=>$audit_value,  'extra_1' =>'forms validation error', 'extra_2'=>null, 'extra_3'=>null);
	$this->Audit_model->log_entry($audit);
	$this->add();
	}	 
   }else{
        redirect ('User/restricted');	
		}
}
	
public function update($id){
    if ($this->session->userdata('is_logged_in') && $this->has_permission_to_edit()){
	$data['results']= $this->Packaging_model->get_packaging($id);
	$audit_value = json_encode($data['results']);
	$audit = array('primary' => 'PKG', 'secondary'=>'UPDV', 'status'=>true,  'controller'=>'Packaging', 'value'=>$audit_value,  'extra_1' =>null, 'extra_2'=>null, 'extra_3'=>null);
	$this->Audit_model->log_entry($audit);
   $data['id'] = $id;
	$data['title']="Edit the packaging";
	$data['page_header']="Edit the packaging";
	$this->load->view("header",$data);
	$this->load->view("navbar",$data);
	$this->load->view('edit_packaging_view',$data);
	$this->load->view("footer",$data);
}else{
		redirect ('User/restricted');	
		}
}

public function update_validation(){
if ($this->session->userdata('is_logged_in') && $this->has_permission_to_edit()){
	$audit_value = json_encode($this->input->post());
   $id = $this->input->post('id');	
	$this->load->library('form_validation');
	$this->form_validation->set_rules('description', 'Description', 'trim|xss_clean|max_length[200]');
	$this->form_validation->set_rules('price', 'Price', 'required|decimal');
	$this->form_validation->set_rules('fixed_alf', 'Fixed ALF Amount', 'decimal');
	$this->form_validation->set_rules('fixed_integration', 'Fixed Integration Amount', 'decimal');
	$this->form_validation->set_rules('title', 'Category', 'trim|max_length[100]|xss_clean');
	$this->form_validation->set_rules('integration_flag', 'Integration Flag', 'required|integer|trim');
	$this->form_validation->set_rules('alf_flag', 'ALF Flag', 'required|integer|trim');
	$this->form_validation->set_rules('discount_flag', 'Discount Flag', 'required|integer|trim');
	$this->form_validation->set_rules('status', 'Status', 'required|integer|trim');
	$this->form_validation->set_rules('notes', 'Packaging Notes', 'trim|xss_clean');
	if ($this->form_validation->run()){		
		$data = array(
			'description'=>$this->input->post('description'),
			'price'=>$this->input->post('price'),
			'fixed_alf'=>$this->input->post('fixed_alf'),
			'fixed_integration'=>$this->input->post('fixed_integration'),
			'category'=>$this->input->post('category'),
			'integration_flag'=>$this->input->post('integration_flag'),
			'alf_flag'=>$this->input->post('alf_flag'),
			'discount_flag'=>$this->input->post('discount_flag'),
			'status'=>$this->input->post('status'),
			'notes'=>$this->input->post('notes')
			);		
		if($this->Packaging_model->update_packaging($data, $id)) {	
			$audit = array('primary' => 'PKG', 'secondary'=>'UPDT', 'status'=>true,  'controller'=>'Packaging', 'value'=>$audit_value,  'extra_1' =>null, 'extra_2'=>null, 'extra_3'=>null);
			$this->Audit_model->log_entry($audit);		
			$message = "<div class='alert alert-success'  packaging='alert'><p><span class='glyphicon glyphicon-ok'></span> <strong>Success!</strong> The packaging was successfully updated in the system.</p></div>";
			$this->session->set_flashdata('message',$message);
			redirect('Packaging'); //SUCCESS 
			}else{
				$audit = array('primary' => 'PKG', 'secondary'=>'UPDT', 'status'=>false,  'controller'=>'Packaging', 'value'=>$audit_value,  'extra_1' =>'failed to update the packaging', 'extra_2'=>null, 'extra_3'=>null);
				$this->Audit_model->log_entry($audit);		 
				$message = "<div id='message'><div class='alert alert-warning'  packaging='alert'><p><span class='glyphicon glyphicon-exclamation-sign'></span><strong>Notice!</strong>Failed to update the packaging.</p></div></div>";
				echo $message;
				$this->index();
			}	
	}else{
	$audit = array('primary' => 'PKG', 'secondary'=>'UPDT', 'status'=>false,  'controller'=>'Packaging', 'value'=>$audit_value,  'extra_1' =>'forms validation error', 'extra_2'=>null, 'extra_3'=>null);
	$this->Audit_model->log_entry($audit);		
	$this->update($id);
	}
}else{
		redirect ('User/restricted');	
		}
}	

public function postValue($id, $column){	//FOR INLINE EDITS 
   if($this->session->userdata('is_logged_in') && $this->has_permission_to_edit()){	
   $audit_value = json_encode($this->input->post());	
	$this->load->library('form_validation');
	if($column=='title'){$this->form_validation->set_rules('value', 'Description', 'trim|xss_clean|max_length[50]');}
	if($column=='description'){$this->form_validation->set_rules('value', 'Description', 'trim|xss_clean');}
	if($column=='price'){	$this->form_validation->set_rules('value', 'Price', 'required|decimal');}
	if($column=='fixed_alf'){	$this->form_validation->set_rules('value', 'Fixed ALF Amount', 'decimal');}
	if($column=='fixed_integration'){$this->form_validation->set_rules('value', 'Fixed Integration Amount', 'decimal');}
	 if($column=='category'){$this->form_validation->set_rules('value', 'Category', 'trim|max_length[100]|xss_clean');}
	 if($column=='integration_flag'){$this->form_validation->set_rules('value', 'Integration Flag', 'required|integer|trim');}
	 if($column=='alf_flag'){$this->form_validation->set_rules('value', 'ALF Flag', 'required|integer|trim');}
	 if($column=='discount_flag'){$this->form_validation->set_rules('value', 'Discount Flag', 'required|integer|trim');}
	 if($column=='notes'){$this->form_validation->set_rules('value', 'Packaging Notes', 'trim|xss_clean');}
	 if($column=='status'){$this->form_validation->set_rules('value', 'Status', 'required|integer|trim');}
	if ($this->form_validation->run() && $this->has_permission_to_edit()){
		if($column=='title'){$data = array('title'=>$this->input->post('value'));}
		if($column=='description'){$data = array('description'=>$this->input->post('value'));}
		if($column=='status'){$data = array('status'=>$this->input->post('value'));}
		if($column=='price'){$data = array('price'=>$this->input->post('value'));}
		if($column=='fixed_alf'){$data = array('fixed_alf'=>$this->input->post('value'));}
		if($column=='fixed_integration'){$data = array('fixed_integration'=>$this->input->post('value'));}
		if($column=='category'){$data = array('category'=>$this->input->post('value'));}
	 	if($column=='integration_flag'){$data = array('integration_flag'=>$this->input->post('value'));}
	 	if($column=='alf_flag'){$data = array('alf_flag'=>$this->input->post('value'));}
		if($column=='discount_flag'){$data = array('discount_flag'=>$this->input->post('value'));}
	 	if($column=='notes'){$data = array('notes'=>$this->input->post('value'));}
		if ($this->Packaging_model->update_packaging($data, $id)){
			$audit = array('primary' => 'PKG', 'secondary'=>'UPDT', 'status'=>true,  'controller'=>'Packaging', 'value'=>$audit_value,  'extra_1' =>$column, 'extra_2'=>null, 'extra_3'=>null);
 			$this->Audit_model->log_entry($audit);
			http_response_code(200);
		}else{
			$audit = array('primary' => 'PKG', 'secondary'=>'UPDT', 'status'=>false,  'controller'=>'Packaging', 'value'=>$audit_value,  'extra_1' =>$column, 'extra_2'=>'database did not update properly', 'extra_3'=>null);
 			$this->Audit_model->log_entry($audit);
			http_response_code(400);
			echo "Database did not update properly";
		}}else{
		$audit = array('primary' => 'PKG', 'secondary'=>'UPDT', 'status'=>false,  'controller'=>'Packaging', 'value'=>$audit_value,  'extra_1' =>$column, 'extra_2'=>'form validation error', 'extra_3'=>null);
 		$this->Audit_model->log_entry($audit);
		http_response_code(400);
		 echo strip_tags(validation_errors());
	}}else{
			$audit = array('primary' => 'PKG', 'secondary'=>'UPDT', 'status'=>false,  'controller'=>'Packaging', 'value'=>$audit_value,  'extra_1' =>$column, 'extra_2'=>'timeout error', 'extra_3'=>null);
 			$this->Audit_model->log_entry($audit);
			http_response_code(400);
	   	echo "The session timed out";
	   	}
}



}
