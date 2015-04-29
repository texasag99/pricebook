<div id="container" class="container-fluid">
<div id="body">
<h1><?php echo $page_header; ?></h1>
<?php if($allow_add){ 
echo "<a href='".base_url()."Roles/add' class='btn btn-default'>Add Role</a> &nbsp;&nbsp;";
}
?>
<?php   
if(isset($message) && !empty($message)){
echo "<p>$message</p>";
}
?>

<table class="table">
<thead>
	<tr><th class='role_column'>Role</th>
		<th class='role_description_column'>Description</th>
		<th class='role_status_column'>Status</th>
		<th class='role_created_column'>Created On</th>
		<th class='role_updated_column'>Last Updated</th>		
		<?php if($allow_edit || $allow_delete){ echo "<th class='edit_button_column'></th>"; } ?>
	</tr>
</thead>
<tbody class="table-hover">
	<?php
	$counter = 0;
	foreach ($results as $data){
		$counter++;
		echo"<tr><td class='role_column'><a href='#' class='editable' id='role' data-type='text' name='role' data-pk='".$data->id."' data-url='".base_url()."Roles/postValue/".$data->id."/role' data-title='Enter Role name'>".$data->role."</a></td>";
		echo"<td class='role_description_column'><a href='#' class='editable' id='description' data-type='text' name='description' data-pk='".$data->id."' data-url='".base_url()."Roles/postValue/".$data->id."/description' data-title='Enter Description'>".$data->description."</a></td>";
		echo"<td class='role_status_column'><a href='#' id='status' class='status_editable_".$counter."' data-type='select' name='status' data-pk='".$data->id."' data-url='".base_url()."Roles/postValue/".$data->id."/status' data-title='Select Status'>".$data->status."</a></td>";
		echo"<td class='role_created_column'>".date('m-d-Y', strtotime($data->created))."</td>";
		echo"<td class='role_updated_column'>".date('m-d-Y', strtotime($data->last_updated))."</td>";
		if($allow_edit){
		?>

<script>
 $(function(){ 
			$('.status_editable_<?php echo $counter; ?>').editable({
				value: "<?php echo $data->status; ?>", 
				source: [ 
					{value: 'ACTIVE', text: 'ACTIVE'}, 
					{value: 'INACTIVE', text: 'INACTIVE'} 
					]  
			});  
		});     
</script>
	
	<?php
		echo"<td><a href='".base_url()."Roles/update/".$data->id."' class='btn btn-default' id='edit_role".$data->id."' style='margin:1px;'><span class='glyphicon glyphicon-edit' style='font-size:16px;'></span></a>";
       }
       if($allow_delete){     
      echo"<a href='#' class='btn btn-default' id='delete_role".$data->id."' style='margin:1px;'><span class='glyphicon glyphicon-remove' style='font-size:16px;'></span></a></td></tr>";
		//below is the script for the pop-up dialog box to confirm the item delete.
		echo"<script>$('#delete_role".$data->id."').click(function(){bootbox.dialog({title:\"Confirm Deletion\", message:\"<p style='text-align:center'>Are you sure?<br><br><a class='btn btn-warning' href='".base_url()."Roles/delete/".$data->id."'>Delete</a></p>\"}); });</script>";
	}
	}
	?>
</tbody>
</table>
	<?php if(isset($links)){ 
	 echo "<div id='page_links'>".$links." </div>";
	 ?>
	 <div class="btn-group pagination_dropdown">
       <button class="btn">Per page: <strong><?php echo $per_page; ?></strong></button>
		 <button class="btn dropdown-toggle" data-toggle="dropdown">
         <span class="caret"></span>
       </button>
		 <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
<li><a tabindex="-1" href="<?php echo base_url().'Roles/show_all_roles_paginated/0/10/0'?>">10</a></li>
<li><a tabindex="-1" href="<?php echo base_url().'Roles/show_all_roles_paginated/0/20/0'?>">20</a></li>
<li><a tabindex="-1" href="<?php echo base_url().'Roles/show_all_roles_paginated/0/50/0'?>">50</a></li>
<li><a tabindex="-1" href="<?php echo base_url().'Roles/show_all_roles_paginated/0/100/0'?>">100</a></li>		
		 </ul>
		 
      </div></br></br>
     <?php } ?>

</div><!--body-->
</div><!--container-->