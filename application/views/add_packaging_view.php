<div id="container" class="container-fluid">
<h1><?php echo $page_header; ?></h1>

<div id="body">
<div id="form_container_500">
	
<div class="form-group">
<p style="max-width:100%; border:1px solid dark-gray; background-color:silver; padding:10px;">
Please enter the new packaging. </p>

<?php 
echo form_open('Packaging/add_validation');
echo '<div class="warning" style="color:red;">'.validation_errors().'</div>';
echo "<label for='code'>Code: </label>";
echo form_input('code',$this->input->post('code'));
echo "<label for='title'>Title: </label>";
echo form_input('title',$this->input->post('title'));
echo "<label for='description'>Description:</label>";
echo form_input('description',$this->input->post('description'));
$status = array(
			' ' => 'Choose one',
  	    	'1' => 'Active', 
			'0' => 'Inactive'
             );
echo "<label for='status'>Status:</label> ";
echo form_dropdown('status', $status, $this->input->post('status'));
echo "<label for='price'>Price:</label>";
echo form_input('price',$this->input->post('price'));
$integration = array(
			' ' => 'Choose one',
  	    	'1' => 'Yes', 
			'0' => 'No'
             );
echo "<label for='integration_flag'>Charge for system integration?: </label> ";
echo form_dropdown('integration_flag', $integration, $this->input->post('integration_flag'));	
$alf= array(
			' ' => 'Choose one',
  			'1' => 'Yes', 
			'0' => 'No'
             );

echo "<label for='alf'>Charge annual license fee (ALF)?:</label> ";
echo form_dropdown('alf_flag', $alf, $this->input->post('alf_flag'));
$discount = array(
			' ' => 'Choose one',
			'1' => 'Yes', 
			'0' => 'No'
             );

echo "<label for='discount_flag'>Allow for discounting?:</label> ";
echo form_dropdown('discount_flag', $discount, $this->input->post('discount_flag'));
echo "<label for='fixed_alf'>Fixed ALF:</label>";
echo form_input('fixed_alf',$this->input->post('fixed_alf'));
echo "<label for='fixed_integration'>Fixed Integration:</label>";
echo form_input('fixed_integration',$this->input->post('fixed_integration'));
echo "<label for='notes'>Notes:</label>";
$notes = array(
  				'name'        => 'notes',
              'id'          => 'notes',
              'value'       => $this->input->post('notes'),
              'rows'   => '15',
              'cols'        => '80',
              'style'       => 'width:100% !important;'
);
echo form_textarea($notes);

echo '<br><button type="submit" class="btn btn-primary">Submit</button>';
echo form_close();

?>
</div><!--container-->
</div><!--body-->
</div>
</div>
