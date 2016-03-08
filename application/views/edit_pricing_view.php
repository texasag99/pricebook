<?php 
$go_back_url = base_url().'Pricing';

/* 
FOR PRICEBOOK APPLICATION

filename: edit_pricing_view.php
Author: Bejan Nouri
Last update: 2-3-2015

Notes- 

This is the update "Pricing" view used to modify the unique values of each price item.

*/
?>

<div id="container" class="container-fluid">
<h1><?php echo $page_header; ?></h1>

<div id="body">
<div id="form_container_500">
	
<div class="form-group">
<p style="max-width:100%; border:1px solid dark-gray; background-color:silver; padding:10px;">
Please edit the pricing. </p>

	
<?php 
$hidden = array('id' => $id);
echo form_open('Pricing/update_validation','',$hidden);
echo '<div class="warning" style="color:red;">'.validation_errors().'</div>';
foreach ($results as $data){
echo "<label for='code'>Code:</label>";
echo form_input(array('name'=>'code','value'=>$data->code,'readonly'=>'readonly'));
echo "<label for='description'>Description:</label>";
echo form_input('description',$data->description);
echo "<label for='price'>Price:</label>";
echo form_input('price',number_format($data->price,2, '.', ''));
echo "<label for='category'>Category:</label>";
echo form_input('category',$data->category);
$status = array(
			' ' => 'Choose one',
  	    	'1' => 'Active', 
			'0' => 'Inactive'
             );

echo "<label for='status'>Status:</label> ";
echo form_dropdown('status', $status, $data->status);
$integration = array(
			' ' => 'Choose one',
  	    	'1' => 'Yes', 
			'0' => 'No'
             );

echo "<label for='integration_flag'>Charge for System Integration: </label> ";
echo form_dropdown('integration_flag', $integration, $data->integration_flag);	
$alf= array(
			' ' => 'Choose one',
  			'1' => 'Yes', 
			'0' => 'No'
             );

echo "<label for='alf'>Charge Annual License Fee (ALF):</label> ";
echo form_dropdown('alf_flag', $alf, $data->alf_flag);
$discount = array(
			' ' => 'Choose one',
			'1' => 'Yes', 
			'0' => 'No'
             );

echo "<label for='discount_flag'>Discounting Allowed:</label> ";
echo form_dropdown('discount_flag', $discount, $data->discount_flag);
echo "<label for='fixed_alf'>Fixed ALF:</label>";
echo form_input('fixed_alf',number_format($data->fixed_alf,2, '.', ''));
echo "<label for='fixed_integration'>Fixed Integration:</label>";
echo form_input('fixed_integration',number_format($data->fixed_integration,2, '.', ''));
echo "<label for='notes'>Notes:</label>";
echo form_textarea(array('name'=>'notes','value'=>$data->notes, 'rows'=> '10', 'id'=>'comment', 'class'=>'form-control'));
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