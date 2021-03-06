<div id="container" class="container-fluid">
<h1><?php echo $page_header; ?></h1>

<div id="body">
<div id="form_container_500">
	
<div class="form-group">
<p style="max-width:100%; border:1px solid dark-gray; background-color:silver; padding:10px;">
Please enter the new user information. </p>

<?php 
echo form_open('UserAdmin/add_validation');
echo '<div class="warning" style="color:red;">'.validation_errors().'</div>';
echo "<label for='first'>First Name:</label>";
echo form_input('first',$this->input->post('first'));
echo "<label for='last'>Last Name:</label>";
echo form_input('last',$this->input->post('last'));
$email = array(
              'name'        => 'email',
              'id'          => 'email',
			     'class'		=> 'check-exists',
              'value'       => $this->input->post('email'),
              'data-type'   => 'email'
            );

echo "<div id='control-group'>";
echo "<label for='email'>Email:</label> ";

echo form_input($email);
echo "<div class='warning' style='color:red;'><span class='check-exists-feedback' data-type='email'></span></div>";
echo "</div>";


echo "<label for='password'>Password:</label> ";
echo form_password('password',$this->input->post('password'));

echo "<label for='confirm_password'>Confirm Password:</label> ";
echo form_password('confirm_password');

echo "<label for='address1'>Address:</label> ";
echo form_input('address1', $this->input->post('address1'));

echo "<label for='address2'>Address 2:</label> ";
echo form_input('address2', $this->input->post('address 2'));

echo "<label for='address2'>City:</label> ";
echo form_input('city', $this->input->post('city') );

echo "<label for='state'>State:</label> ";
echo form_dropdown('state', $statelist, $this->input->post('state'));


echo "<label for='zip'>Zip:</label> ";
echo form_input('zip', $this->input->post('zip'));

echo "<label for='country'>Country:</label> ";
echo form_dropdown('country',$countries, $this->input->post('country') );


echo "<label for='tel'>Direct Tel:</label> ";
echo form_input('tel', $this->input->post('tel'));


echo "<label for='mobile'>Mobile:</label> ";
echo form_input('mobile', $this->input->post('mobile'));


echo "<label for='fax'>Fax:</label> ";
echo form_input('fax', $this->input->post('fax'));


echo "<label for='website'>Website (URL):</label> ";
echo form_input('website', $this->input->post('website'));


echo "<label for='email2'>Alternate Email:</label> ";
echo form_input('email2', $this->input->post('email2'));


$status = array(
  	    	'ACTIVE' => 'Active', 
			'INACTIVE' => 'Inactive'
             );

echo "<label for='status'>Status:</label> ";
echo form_dropdown('status', $status, $this->input->post('status'));
echo '<br><button type="submit" class="btn btn-primary">Create New User</button>';
echo form_close();

?>
	<script>
		$('.check-exists').existsChecker();
	</script>
</div><!--container-->
</div><!--body-->
</div>
</div>