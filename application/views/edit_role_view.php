<?php 
$go_back_url = base_url().'Roles';

?>

<div id="container" class="container-fluid">
<h1><?php echo $page_header; ?></h1>

<div id="body">
<div id="form_container_500">
	
<div class="form-group">
<p style="max-width:100%; border:1px solid dark-gray; background-color:silver; padding:10px;">
Please edit the role. </p>

	
<?php 
$hidden = array('id' => $id);
$selected = array_filter($selected);
if (count($selected) < 2) {
	array_push($selected,0,1,2,3);
}
echo form_open('Roles/update_validation','',$hidden);
echo '<div class="warning" style="color:red;">'.validation_errors().'</div>';
foreach ($results as $data){
echo "<label for='role'>Role Name:</label>";
echo form_input('role',$data->role);
echo "<label for='description'>Description:</label>";
echo form_textarea(array('name'=>'description','value'=>$data->description, 'rows'=> '10', 'id'=>'comment', 'class'=>'form-control'));
$status = array(
  	    	'ACTIVE' => 'Active', 
			'INACTIVE' => 'Inactive'
             );
echo "<label for='status'>Status:</label> ";
echo form_dropdown('status', $status, $data->status);
echo "<label for='permissions'>Permissions:</label> ";
echo form_dropdown('permissions[]', $active, $selected, array('class'=>'form-control multi-select'));
echo "<br><label for='created'>Created On:</label> ";
echo form_input(array('name'=>'created','value'=>$data->created,'readonly'=>'readonly'));
echo "<label for='created'>Last Updated:</label> ";
echo form_input(array('name'=>'last_updated','value'=>$data->last_updated,'readonly'=>'readonly'));
}
?>


<?php
echo '<br><button type="submit" class="btn btn-primary">Submit</button>';
echo '&nbsp;<a href="'.$go_back_url.'" class="btn btn-warning">Cancel</a>';
echo form_close();


?>
	
	
</div><!--container-->
</div><!--body-->
</div>
</div>