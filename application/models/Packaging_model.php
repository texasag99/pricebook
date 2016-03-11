<?php
/*
 * Filename : Packaging_model.php
 * Author : BEJAN NOURI
 * Date :  2-5-2016
 * Summary: Access data related to the Packaging controller 
 * */

class Packaging_model extends CI_Model { 
 
	public function __construct(){
		parent::__construct();
	}
//MODEL FUNCTIONS FOR THE PACKAGING TABLE
	
public function packaging_record_count() {
		return $this->db->count_all("pb_packaging");
	}
	

public function active_packaging_record_count() {
	  $this->db->where('status','1');
		return $this->db->count_all_results("pb_packaging");
	}
	
public function search_packaging_record_count($search_by){
	$search_by = trim($search_by);
	$this->db->or_like('code', $search_by);
	$this->db->or_like('title', $search_by);
	$this->db->or_like('description', $search_by);
	return $this->db->count_all_results("pb_packaging");			
	}

public function roles_sort_by($sort_by){
		switch($sort_by){
					case 1: return $this->db->order_by("code","asc");
					case 2: return $this->db->order_by("code","desc");
					case 3: return $this->db->order_by("title","asc");
					case 4: return $this->db->order_by("title","desc");
					case 5: return $this->db->order_by("description","asc");
					case 6: return $this->db->order_by("description","desc");
					case 7: return $this->db->order_by("price", "asc");
					case 8: return $this->db->order_by("price", "desc");
					case 9: return $this->db->order_by("status","asc");
					case 10: return $this->db->order_by("status","desc");
					case 11: return $this->db->order_by("integration_flag","asc");
					case 12: return $this->db->order_by("integration_flag","desc");
					case 13: return $this->db->order_by("alf_flag","asc");
					case 14: return $this->db->order_by("alf_flag","desc");
					case 15: return $this->db->order_by("discount_flag","asc");
					case 15: return $this->db->order_by("discount_flag","desc");
					case 16: return $this->db->order_by("created","asc");
					case 17: return $this->db->order_by("created","desc");
					case 18: return $this->db->order_by("last_updated","asc");
					case 19: return $this->db->order_by("last_updated","desc");
					default : return NULL;			
			}		
		}


public function get_all_packaging(){
		$query = $this->db->get("pb_packaging");
		if ($query->num_rows() > 0) {
				foreach($query->result() as $row){
					$data[] = $row;
			}
			return $data;
		}
		return false;	
	}
	
public function get_all_packaging_paginated($limit, $start,$sort_by){
		$this->roles_sort_by($sort_by);
		$this->db->limit($limit,$start);
		$query = $this->db->get("pb_packaging");
		if ($query->num_rows() > 0) {
				foreach($query->result() as $row){
					$data[] = $row;
			}
			return $data;
		}
		return false;	
	}
	
public function get_active_packaging_paginated($limit, $start,$sort_by){
		$this->roles_sort_by($sort_by);
		$this->db->limit($limit,$start);
		$this->db->where('status','1');
		$query = $this->db->get("pb_packaging");
		if ($query->num_rows() > 0) {
				foreach($query->result() as $row){
					$data[] = $row;
			}
			return $data;
		}
	return false;	
	}
	
public function  search_packaging_paginated($limit, $start, $sort_by, $search_by){
		$this->roles_sort_by($sort_by);		
		$this->db->limit($limit,$start);
		$search_by = trim($search_by);
	   $this->db->or_like('code', $search_by);
	   $this->db->or_like('title', $search_by);
	   $this->db->or_like('description', $search_by);
      $query = $this->db->get("pb_packaging");
		if ($query->num_rows() > 0) {
				foreach($query->result() as $row){
					$data[] = $row;
			}
			return $data;
		}
		return false;	
	}
    
/*public function get_packaging_categories(){
		$this->db->select('DISTINCT(category)');
		$query = $this->db->get('pb_packaging');
		if ($query->num_rows() > 0){
				foreach($query->result() as $row){
					$data[] = $row;
					}		
					return $data;				
			}else{
			return false;				
				}	
	}*/

public function get_packaging($id){
		$this->db->where('id', $id);
		$query = $this->db->get("pb_packaging");
		if ($query->num_rows() > 0) {
				foreach($query->result() as $row){
					$data[] = $row;
			}
			return $data;
		}
		return false;	
		
	}
	
/*	public function list_active_packaging(){
		$this->db->where('status', '1');
		$query = $this->db->get("pb_packaging");
		if ($query->num_rows() > 0) {
				foreach($query->result() as $row){
					$data[] = $row;
			}
			return $data;
		}
		return false;	
		
	}*/
	
public function delete_packaging($id){
		$this->db->where('id',$id);
		if($this->db->delete('pb_packaging')){
 		   return true;
		}else{
			return false;
		}
	}
	
public function add_packaging($data){
		$data['created'] = date("Y-m-d H:i:s");
		$data['last_updated']= date("Y-m-d H:i:s");
		$this->db->insert("pb_packaging", $data);
		if($this->db->affected_rows() > 0){
	         return true;
	         }else{
			 return false;         
	         }
	}
	
public function update_packaging($data, $id){
		$data['last_updated'] = date("Y-m-d H:i:s");		
		$this->db->where('id', $id);
		$this->db->update("pb_packaging", $data);
		if($this->db->affected_rows() > 0){
	         return true;
	         }else{
			 return false;         
	         }
	}
}
	

