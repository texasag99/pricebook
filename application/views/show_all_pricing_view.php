<script>
$(document).ready(function() {
	if ($(window).width() < 720) {
		$(".pricing_description_column").remove();
		$(".pricing_created_column").remove();
		$(".pricing_updated_column").remove();	
		}
	if ($(window).width() < 430) {
		$(".pricing_category_column").remove();
		$(".pricing_integration_column").remove();
		$(".pricing_alf_column").remove();	
		$(".pricing_discount_column").remove();	
		}
	});
</script>

<div id="container" class="container-fluid">
<div id="body">
<h1><?php echo $page_header; ?><sup> <span title="Total Record Count" class="label label-info"><?php echo $total_records ?></span></sup></h1>
<div class='submenu' style='width:70%; float:left;'>
<?php 
if (empty($sort_by)){$sort_by=0;}
if($allow_add){ 
echo "<a href='".base_url()."Pricing/add' class='btn btn-default'>Add Pricing</a> &nbsp;&nbsp;";
}
if($controller=="show_active_pricing_paginated"){
echo "<a href='".base_url()."Pricing/show_all_pricing_paginated/0/0/".$per_page."/0' class='btn btn-primary'><span title='Show All' class='glyphicon glyphicon-eye-close'></span></a> ";
//echo "<a href='".base_url()."Pricing/".$controller."/".$sort_by."/999999/0/0' class='btn btn-primary'><span title='Export to PDF'  class='glyphicon glyphicon-print'></span></a>";
}elseif($controller=="show_all_pricing_paginated"){
echo "<a href='".base_url()."Pricing/show_active_pricing_paginated/0/0/".$per_page."/0' class='btn btn-warning'><span title='Hide Inactive' class='glyphicon glyphicon-eye-open'></span></a> ";
//echo "<a href='".base_url()."Pricing/".$controller."/".$sort_by."/999999/0/0' class='btn btn-primary'><span title='Export to PDF'  class='glyphicon glyphicon-print'></span></a>";
}else{ 
echo "<a href='".base_url()."Pricing/show_all_pricing_paginated/0/0/".$per_page."/0' class='btn btn-primary'><span  title='Show All' class='glyphicon glyphicon-eye-close'></span></a> "; 
//echo "<a href='".base_url()."Pricing/".$controller."/".$sort_by."/999999/0/0' class='btn btn-primary'><span title='Export to PDF'  class='glyphicon glyphicon-print'></span></a>";
}
echo"</div> <!--submenu-->";

?>
<?php //search by box
echo "<div class='search_by form-group' style='width:30%; float:right;'>";
echo form_open('Pricing/search_pricing');
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

<?php   
if(isset($message) && !empty($message)){
echo "<p>$message</p>";
}
?>

<table class="table">
<thead>
	<tr class="active"><th class='pricing_code_column'>
	<?php if($sort_by == 1){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/2/0/".$per_page."/0'>Code <span class='glyphicon glyphicon-chevron-up'></span></a>";
		  }elseif($sort_by == 2){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/1/0/".$per_page."/0'>Code <span class='glyphicon glyphicon-chevron-down'></span></a>";
		  	}else{
		 	echo "<a href=' ".base_url()."Pricing/".$controller."/1/0/".$per_page."/0'>Code </a>";
  		}?></th>
		<th class='pricing_description_column'>
		<?php if($sort_by == 3){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/4/0/".$per_page."/0'>Description <span class='glyphicon glyphicon-chevron-up'></span></a>";
		  }elseif($sort_by == 4){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/3/0/".$per_page."/0'>Description <span class='glyphicon glyphicon-chevron-down'></span></a>";
		  	}else{
		 	echo "<a href=' ".base_url()."Pricing/".$controller."/3/0/".$per_page."/0'>Description </a>";
  		}?>			
		</th>
		<th class='pricing_price_column'>
		<?php if($sort_by == 5){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/6/0/".$per_page."/0'>Price <span class='glyphicon glyphicon-chevron-up'></span></a>";
		  }elseif($sort_by == 6){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/5/0/".$per_page."/0'>Price <span class='glyphicon glyphicon-chevron-down'></span></a>";
		  	}else{
		 	echo "<a href=' ".base_url()."Pricing/".$controller."/5/0/".$per_page."/0'>Price </a>";
  		}?>	
  		</th>
		<th class='pricing_status_column'>
		<?php if($sort_by == 7){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/8/0/".$per_page."/0'>Status <span class='glyphicon glyphicon-chevron-up'></span></a>";
		  }elseif($sort_by == 8){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/7/0/".$per_page."/0'>Status <span class='glyphicon glyphicon-chevron-down'></span></a>";
		  	}else{
		 	echo "<a href=' ".base_url()."Pricing/".$controller."/7/0/".$per_page."/0'>Status </a>";
  		}?>
  		</th>
  	<th class='pricing_category_column'>
		<?php if($sort_by == 9){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/10/0/".$per_page."/0'>Category <span class='glyphicon glyphicon-chevron-up'></span></a>";
		  }elseif($sort_by == 10){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/9/0/".$per_page."/0'>Category <span class='glyphicon glyphicon-chevron-down'></span></a>";
		  	}else{
		 	echo "<a href=' ".base_url()."Pricing/".$controller."/9/0/".$per_page."/0'>Category </a>";
  		}?>
  		</th>
		<th class='pricing_integration_column'>
		<?php if($sort_by == 11){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/12/0/".$per_page."/0'>INT <span class='glyphicon glyphicon-chevron-up'></span></a>";
		  }elseif($sort_by == 12){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/11/0/".$per_page."/0'>INT <span class='glyphicon glyphicon-chevron-down'></span></a>";
		  	}else{
		 	echo "<a href=' ".base_url()."Pricing/".$controller."/11/0/".$per_page."/0'>INT </a>";
  		}?>
  		</th>
		<th class='pricing_alf_column'>
		<?php if($sort_by == 13){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/14/0/".$per_page."/0'>ALF <span class='glyphicon glyphicon-chevron-up'></span></a>";
		  }elseif($sort_by == 14){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/13/0/".$per_page."/0'>ALF <span class='glyphicon glyphicon-chevron-down'></span></a>";
		  	}else{
		 	echo "<a href=' ".base_url()."Pricing/".$controller."/13/0/".$per_page."/0'>ALF </a>";
  		}?>			
	  </th>
	  <th class='pricing_discount_column'>
		<?php if($sort_by == 15){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/16/0/".$per_page."/0'>DISC <span class='glyphicon glyphicon-chevron-up'></span></a>";
		  }elseif($sort_by == 16){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/15/0/".$per_page."/0'>DISC <span class='glyphicon glyphicon-chevron-down'></span></a>";
		  	}else{
		 	echo "<a href=' ".base_url()."Pricing/".$controller."/15/0/".$per_page."/0'>DISC </a>";
  		}?>			
	  </th>
	  <th class='pricing_created_column'>
		<?php if($sort_by == 17){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/18/0/".$per_page."/0'>Created <span class='glyphicon glyphicon-chevron-up'></span></a>";
		  }elseif($sort_by == 18){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/17/0/".$per_page."/0'>Created <span class='glyphicon glyphicon-chevron-down'></span></a>";
		  	}else{
		 	echo "<a href=' ".base_url()."Pricing/".$controller."/17/0/".$per_page."/0'>Created </a>";
  		}?>					
		</th>
		<th class='pricing_updated_column'>
		<?php if($sort_by == 19){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/20/0/".$per_page."/0'>Last Updated <span class='glyphicon glyphicon-chevron-up'></span></a>";
		  }elseif($sort_by == 20){
		  	echo "<a href=' ".base_url()."Pricing/".$controller."/19/0/".$per_page."/0'>Last Updated <span class='glyphicon glyphicon-chevron-down'></span></a>";
		  	}else{
		 	echo "<a href=' ".base_url()."Pricing/".$controller."/19/0/".$per_page."/0'>Last Updated </a>";
  		}?>					
		</th>		
		<?php if($allow_edit || $allow_delete){ echo "<th class='edit_button_column'></th>"; } ?>
	</tr>
</thead>
<tbody class="table-hover">
	<?php
	if(isset($results) && !empty($results)){
	$counter = 0;
	foreach ($results as $data){ 
		if($data->status == 1){
			$status = "ACTIVE";
			$status_indicator = 'success';
			}elseif($data->status == 0){
				$status = "INACTIVE";
				$status_indicator = 'warning';
				}else{
					$status = "UNDEFINED";
					$status_indicator = 'info';
					}	
		$integration_flag = ($data->integration_flag)? "YES" : "NO";	
		$alf_flag = ($data->alf_flag)? "YES" : "NO";	
		$discount_flag = ($data->discount_flag)? "YES" : "NO";	
		$counter++;
		//Pricing "code" column
		echo"<tr><td class='pricing_code_column'><a href='#' id='show_pricing_".$data->id."'><span class='glyphicon glyphicon-th-list'></span></a>&nbsp;&nbsp; <a href='#' id='code' name='code'>".$data->code."</a></td>";
		//Pricing "description" column
		echo"<td class='pricing_description_column'><a href='#' class='editable' id='description' ";
		echo"data-type='text' name='description' data-pk='".$data->id."' ";
		echo"data-url='".base_url()."Pricing/postValue/".$data->id."/description' ";
		echo"data-title='Enter Description'>".$data->description."</a></td>";
		//Price "price" column
		echo"<td class='pricing_price_column'><a title='All pricing is in US Dollars'>$</a><a href='#' class='editable' id='price' ";
		echo"data-type='text' title='All pricing is in US Dollars' name='price' data-pk='".$data->id."' ";
		echo"data-url='".base_url()."Pricing/postValue/".$data->id."/price' ";
		echo"data-title='Enter Price'>".number_format($data->price,2,".",",")."</a></td>";
		//Price "status" column 
		echo"<td class='pricing_status_column'><a href='#' id='status' ";
		echo"class='status_editable_".$counter."' data-type='select' name='status' ";
		echo"data-pk='".$data->id."' data-url='".base_url()."Pricing/postValue/".$data->id."/status' ";
		echo"data-title='Select Status'><span class='label label-$status_indicator'>".$status."</span></a></td>";
		//Price "category" column
		echo"<td class='pricing_category_column'><a href='#' id='category' class='category_editable_".$counter."' data-type='select' name='category' data-pk='".$data->id."' data-url='".base_url()."Pricing/postValue/".$data->id."/category' data-title='Enter Category'>".$data->category."</a></td>";
		//Price "integration_flag" column
		echo"<td class='pricing_integration_column'><a href='#' id='integration_flag' ";
		echo"class='integration_flag_editable_".$counter."' data-type='select' name='integration_flag' ";
		echo"data-pk='".$data->id."' data-url='".base_url()."Pricing/postValue/".$data->id."/integration_flag' ";
		echo"data-title='Turn on integration?'>".$integration_flag."</a></td>";
		//Price "alf_flag" column
		echo"<td class='pricing_alf_column'><a href='#' id='alf_flag' ";
		echo"class='alf_flag_editable_".$counter."' data-type='select' name='alf_flag' ";
		echo"data-pk='".$data->id."' data-url='".base_url()."Pricing/postValue/".$data->id."/alf_flag' ";
		echo"data-title='Turn on ALF?'>".$alf_flag."</a></td>";
		//Price "discount_flag" column
		echo"<td class='pricing_discount_column'><a href='#' id='discount_flag' ";
		echo"class='discount_flag_editable_".$counter."' data-type='select' name='discount_flag' ";
		echo"data-pk='".$data->id."' data-url='".base_url()."Pricing/postValue/".$data->id."/discount_flag' ";
		echo"data-title='Turn on discounting?'>".$discount_flag."</a></td>";
		//Price "created" column
		echo"<td class='pricing_created_column'>".date('m-d-Y', strtotime($data->created))."</td>";
		//Price "last_updated" column
		echo"<td class='pricing_updated_column'>".date('m-d-Y', strtotime($data->last_updated))."</td>";
		echo"
     <script>
				$(function() {
				$('#show_pricing_".$data->id."').click(function(event) { 
				            bootbox.dialog({
				             						title: \"Show Pricing Information\", 
				             						message:\"<div id='pricing'></div>\",
				             						buttons: {
				             							   main: {
				             							   	    label: \"Close\",
				             							   	    className: \"btn-primary\"
				             							   	}
				             							}            						
				             						});
				             						 
								$('#pricing').load('".base_url()."Pricing/getPricing/".$data->id."  #pricing_record');								
							});
						});			
				</script>";
        
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
<script>
		$(function(){ 
			$('.category_editable_<?php echo $counter; ?>').editable({
				value: "<?php echo $data->category; ?>", 
				source: [ 
				<?php  foreach($categories as $entry){echo "{value:'".$entry->category."', text:'".$entry->category."'},"; }?>
				{value:'Empty',text:'None'}
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
}
?>
	
<?php
		echo"<td><a href='".base_url()."Pricing/update/".$data->id."' class='btn btn-default' ";
		echo"id='edit_pricing".$data->id."' style='margin:1px;'><span class='glyphicon glyphicon-edit' ";
		echo"style='font-size:16px;'></span></a>";
       }
       if($allow_delete){     
         echo"<a href='#' class='btn btn-default' id='delete_pricing".$data->id."' ";
         echo"style='margin:1px;'><span class='glyphicon glyphicon-remove' ";
         echo"style='font-size:16px;'></span></a></td></tr>";
		//below is the script for the pop-up dialog box to confirm the item delete.
		echo"<script>$('#delete_pricing".$data->id."').click(function(){bootbox.dialog({title:\"Confirm Deletion\", ";
		echo"message:\"<p style='text-align:center'>Are you sure?<br><br><a class='btn btn-warning' ";
		echo"href='".base_url()."Pricing/delete/".$data->id."'>Delete</a></p>\"}); });</script>";}
	}//end of foreach
}else{//end of if($results isset)
?>
<tr><td colspan=7>
<div class='alert alert-info'  pricing='alert'><p><span class='glyphicon glyphicon-exclamation-sign'></span> <strong>Does Not Exist!</strong> There is no data returned for this table.</p></div>
</td></tr>
<?php
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


		 <ul class="dropdown-menu" pricing="menu" aria-labelledby="dropdownMenu">
 <?php
		 if($sort_by < 1){
		 	$sort_by=0;
		 	}
		 echo "<li><a tabindex='-1' href='".base_url()."Pricing/".$controller."/".$sort_by."/0/10/0'>10</a></li>";
		 echo "<li><a tabindex='-1' href='".base_url()."Pricing/".$controller."/".$sort_by."/0/20/0'>20</a></li>";
		 echo "<li><a tabindex='-1' href='".base_url()."Pricing/".$controller."/".$sort_by."/0/50/0'>50</a></li>";
		 echo "<li><a tabindex='-1' href='".base_url()."Pricing/".$controller."/".$sort_by."/0/100/0'>100</a></li>";
?>					 

	 </ul>
		 
      </div></br></br>
     <?php } ?>

</div><!--body-->
</div><!--container-->
