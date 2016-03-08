<div id="container" class="container-fluid">
<div id="body">
<h1><?php echo $page_header; ?><sup> <span title="Total Record Count" class="label label-info"><?php echo $total_records ?></span></sup></h1>
<div class='submenu' style='width:70%; float:left;'>
<?php 
if (empty($sort_by)){$sort_by=0;}
if($allow_add){ 
echo "<a href='".base_url()."Packaging/add' class='btn btn-default'>Add Packaging</a> &nbsp;&nbsp;";
}
if($controller=="show_active_packaging_paginated"){
echo "<a href='".base_url()."Packaging/show_all_packaging_paginated/0/0/".$per_page."/0' class='btn btn-primary'><span title='Show All' class='glyphicon glyphicon-eye-close'></span></a> ";
//echo "<a href='".base_url()."Packaging/".$controller."/".$sort_by."/999999/0/0' class='btn btn-primary'><span title='Export to PDF'  class='glyphicon glyphicon-print'></span></a>";
}elseif($controller=="show_all_packaging_paginated"){
echo "<a href='".base_url()."Packaging/show_active_packaging_paginated/0/0/".$per_page."/0' class='btn btn-warning'><span title='Hide Inactive' class='glyphicon glyphicon-eye-open'></span></a> ";
//echo "<a href='".base_url()."Packaging/".$controller."/".$sort_by."/999999/0/0' class='btn btn-primary'><span title='Export to PDF'  class='glyphicon glyphicon-print'></span></a>";
}else{ 
echo "<a href='".base_url()."Packaging/show_all_packaging_paginated/0/0/".$per_page."/0' class='btn btn-primary'><span  title='Show All' class='glyphicon glyphicon-eye-close'></span></a> "; 
//echo "<a href='".base_url()."Packaging/".$controller."/".$sort_by."/999999/0/0' class='btn btn-primary'><span title='Export to PDF'  class='glyphicon glyphicon-print'></span></a>";
}
echo"</div> <!--submenu-->";

?>
<?php //search by box
echo "<div class='search_by form-group' style='width:30%; float:right;'>";
echo form_open('Packaging/search_packaging');
echo '<div class="warning" style="color:red;">'.validation_errors().'</div>';
$input_options= array(
		'name'=>'search_by', 
		'id'=>'search_by',
		'class'=>'form-control',
		'maxlength'=>'250',
		'size'=>'50', 
		'style'=>'width:75%; float: left;'
		); 
echo form_input($input_options);
$submit_options= array(
	'name'=>'submit',
	'id'=>'search_submit',
	'value'=>'Search',
	'class'=>'form-control btn btn-primary',
	'maxlength'=>'75',
	'size'=>'50',
	'style'=>'width:22%; margin-left:3%;'	
);
echo form_submit($submit_options);
$string = "</div> <!--search_by-->";
echo form_close($string);
?>
<br><br>
<div class="row">
<?php   
if(isset($message) && !empty($message)){ //Is there some type of alert message...I am not sure if this is still being used.
echo "<p>$message</p>";
}
if(isset($results) && !empty($results)){ // Checks to see if there are data results 
	$counter = 0;
 foreach ($results as $data){ //A repeat for each row of data returned.
 if($counter % 3 == 0){echo "</div><div class='row'>";} 
 $counter++;
 $status = ($data->status)? "Active" : "Inactive";
 $status_indicator = ($data->status)? "success" : "warning";						
 $integration_flag = ($data->integration_flag)? "YES" : "NO";
 $integration_indicator = ($data->integration_flag)? "info" : "warning";		
 $alf_flag = ($data->alf_flag)? "YES" : "NO";	
 $alf_indicator = ($data->alf_flag)? "info" : "warning";	
 $discount_flag = ($data->discount_flag)? "YES" : "NO";	
 $discount_indicator = ($data->discount_flag)? "info" : "warning";	
//Packaging div tag set below...
		?>
<div id="packaging-item" class="col-md-3">
<div class="panel panel-default">
<div class="panel-heading text-center "><h3><?php echo $data->code; ?></h3></div>
<div class="panel-body"> 
<?php 
$price = money_format('%i', $data->price);
$fixed_integration = money_format('%i',$data->fixed_integration);
$fixed_alf = money_format('%i',$data->fixed_alf);
 $integration = 0;
 $alf = 0;
 if ($data->fixed_integration > 0 && $data->integration_flag){ $integration = $data->fixed_integration; }elseif($data->integration_flag ){$integration = ($data->price * $integration_rate);}else{ $integration = 0; }
 if ($data->fixed_alf >0 && $data->alf_flag){$alf = $data->fixed_alf;}elseif($data->alf_flag){$alf=($data->price * $alf_rate);}else{$alf = 0;}        
    
//Package title field
echo "<p><a href='#' class='editable' id='package_title' ";
echo "data-type='text' name='title' data-pk='".$data->id."' ";
echo "data-url='".base_url()."Packaging/postValue/".$data->id."/title' ";
echo "data-title='Enter Title'><strong>".$data->title."</strong></a></p>";
//Description field
echo "<p><a href='#' class='editable' id='description' ";
echo "data-type='text' name='description' data-pk='".$data->id."' ";
echo "data-url='".base_url()."Packaging/postValue/".$data->id."/description' ";
echo "data-title='Enter Description'>".$data->description."</a></p>";
//Status field
echo"<p><a href='#' id='status' class='status_editable_".$counter."' data-type='select' name='status' ";
echo"data-pk='".$data->id."' data-url='".base_url()."Packaging/postValue/".$data->id."/status' ";
echo"data-title='Select Status'><span style='font-size:1.15em;' class='label label-$status_indicator'>".$status."</span></a><br><br>";
//Price field
echo"<span style='font-size:1.5em;'><a title='All pricing is in US Dollars'>$</a><a href='#' class='editable' id='price' ";
echo"data-type='text' title='All pricing is in US Dollars' name='price' data-pk='".$data->id."' ";
echo"data-url='".base_url()."Packaging/postValue/".$data->id."/price' ";
echo"data-title='Enter Price'>".number_format($data->price,2,'.',',')."</a></span></br>";
echo "<span style='font-size:1em;'>Annual License Fee: <strong>$".number_format($alf,2,'.',',')."</strong><br>";
echo "System Integration: <strong>$".number_format($integration,2,'.',',')." </strong></span><br>";
//Price "integration_flag" column
echo"Integration Flag: <strong><a href='#' id='integration_flag' class='integration_flag_editable_".$counter."' data-type='select' name='integration_flag' ";
echo"data-pk='".$data->id."' data-url='".base_url()."Packaging/postValue/".$data->id."/integration_flag' ";
echo"data-title='Turn on integration?'><span class='label label-$integration_indicator'>".$integration_flag."</span></a></strong><br>";
//Price "alf_flag" column
echo"ALF Flag: <strong><a href='#' id='alf_flag' class='alf_flag_editable_".$counter."' data-type='select' name='alf_flag' ";
echo"data-pk='".$data->id."' data-url='".base_url()."Packaging/postValue/".$data->id."/alf_flag' ";
echo"data-title='Turn on ALF?'><span class='label label-$alf_indicator'>".$alf_flag."</span></a></strong><br>";
//Price "discount_flag" column
echo"Discount Flag: <strong><a href='#' id='discount_flag' class='discount_flag_editable_".$counter."' data-type='select' name='discount_flag' ";
echo"data-pk='".$data->id."' data-url='".base_url()."Packaging/postValue/".$data->id."/discount_flag' ";
echo"data-title='Turn on discounting?'><span class='label label-$discount_indicator'>".$discount_flag."</span></a></strong><br><br>";


echo"Created On: ".$data->created."</br>";
echo"Last Updated: ".$data->last_updated." </p>";
		
if($allow_edit){
?>
<script>
 $(function(){ 
			$('.status_editable_<?php echo $counter; ?>').editable({
				value: "<?php echo $data->status; ?>", 
				source: [ 
					{value: '1', text: 'ACTIVE'}, 
					{value: '0', text: 'INACTIVE'} 
					]  
			});  
		});     
</script>

<?php  
$repeat_counter = 1;
while($repeat_counter <= 3){
switch ($repeat_counter){
	case 1 : 
		$value = "integration_flag";
		break;
	case 2 : 
		$value = "alf_flag";
		break;
	case 3 : 
		$value = "discount_flag";
		break;
}
?>
<script>
	$(function(){ 
			$('.<?php echo $value; ?>_editable_<?php echo $counter; ?>').editable({
				value: "<?php echo $data->$value; ?>", 
				source: [ 
					{value: '1', text: 'YES'}, 
					{value: '0', text: 'NO'} 
					]  
			});  
		});     
</script>

<?php
$repeat_counter++; 
}//The end of the repeat to call the javascript to setup the flag editables

		echo"<p><a href='".base_url()."Packaging/update/".$data->id."' class='btn btn-default'";
		echo"id='edit_packaging".$data->id."' style='margin:1px;'><span class='glyphicon glyphicon-edit' ";
		echo"style='font-size:16px;'></span></a>";
       }
       if($allow_delete){     
         echo"<a href='#' class='btn btn-default' id='delete_packaging".$data->id."' ";
         echo"style='margin:1px;'><span class='glyphicon glyphicon-remove' ";
         echo"style='font-size:16px;'></span></a></p>";
		//below is the script for the pop-up dialog box to confirm the item delete.
		echo"<script>$('#delete_packaging".$data->id."').click(function(){bootbox.dialog({title:\"Confirm Deletion\", ";
		echo"message:\"<p style='text-align:center'>Are you sure?<br><br><a class='btn btn-warning' ";
		echo"href='".base_url()."Packaging/delete/".$data->id."'>Delete</a></p>\"}); });</script>";}
		echo"</div><!-- End of the panel-body div -->";
		echo"</div><!-- End of the panel panel-default div -->";
		echo"</div><!-- End of the packaging-item  col-md-3 div -->";
	}//end of foreach

}else{//end of if($results isset)
?>

<div class='alert alert-info'  packaging='alert'><p><span class='glyphicon glyphicon-exclamation-sign'></span> <strong>Does Not Exist!</strong> There is no data returned for this table.</p></div>
</div> <!--The final "Row" div-->
<?php
}
?>
<div class="row"></div>
<?php

if(isset($links)){ 
	 echo "<div id='page_links'>".$links." </div>";
	 ?><br><br>
	 <div class="btn-group pagination_dropdown">
       <button class="btn">Per page: <strong><?php echo $per_page; ?></strong></button>
		 <button class="btn dropdown-toggle" data-toggle="dropdown">
         <span class="caret"></span>
       </button>


		 <ul class="dropdown-menu" packaging="menu" aria-labelledby="dropdownMenu">
 <?php
		 if($sort_by < 1){
		 	$sort_by=0;
		 	}
		 echo "<li><a tabindex='-1' href='".base_url()."Packaging/".$controller."/".$sort_by."/0/10/0'>10</a></li>";
		 echo "<li><a tabindex='-1' href='".base_url()."Packaging/".$controller."/".$sort_by."/0/20/0'>20</a></li>";
		 echo "<li><a tabindex='-1' href='".base_url()."Packaging/".$controller."/".$sort_by."/0/50/0'>50</a></li>";
		 echo "<li><a tabindex='-1' href='".base_url()."Packaging/".$controller."/".$sort_by."/0/100/0'>100</a></li>";
	
?>					 

	 </ul>
		</div> 
      </div></br></br>
     <?php } ?>

</div><!--body-->
</div><!--container-->
