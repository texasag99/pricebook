<?php 
$go_back_url = base_url().'UserAdmin';

?>

<div id="container" class="container-fluid">
<h1><?php echo $page_header; ?></h1>

<div id="body">
<div id="form_container_500">
	
<div class="form-group">
<p style="max-width:100%; border:1px solid dark-gray; background-color:silver; padding:10px;">
Please edit the user. </p>

	
<?php 
$hidden = array('id' => $id);
$selected = array_filter($selected);
if (count($selected) < 2) {
	array_push($selected,0,1,2,3);
}
echo form_open('UserAdmin/update_validation','',$hidden);
echo '<div class="warning" style="color:red;">'.validation_errors().'</div>';

echo "<label for='first'>First Name:</label>";
echo form_input('first',$first);
echo "<label for='last'>Last Name:</label>";
echo form_input('last',$last);
$email_value = array(
              'name'        => 'email',
              'id'          => 'email',
			     'class'		=> 'check-exists',
              'value'       => $email,
              'data-type'   => 'email'
            );

echo "<div id='control-group'>";
echo "<label for='email'>Email:</label> ";

echo form_input($email_value);
echo "<div class='warning' style='color:red;'><span class='check-exists-feedback' data-type='email'></span></div>";
echo "</div>";


echo "<label for='password'>Password:</label> ";
echo form_password('password',$this->input->post('password'));

echo "<label for='confirm_password'>Confirm Password:</label> ";
echo form_password('confirm_password');

echo "<label for='roles'>Roles:</label> ";
echo form_dropdown('roles[]', $active, $selected, array('class'=>'form-control multi-select'));


echo "<label for='address1'>Address:</label> ";
echo form_input('address1', $address1);

echo "<label for='address2'>Address 2:</label> ";
echo form_input('address2', $address2);

echo "<label for='address2'>City:</label> ";
echo form_input('city', $city );

echo "<label for='state'>State:</label> ";
echo form_dropdown('state', $statelist, $state);


echo "<label for='zip'>Zip:</label> ";
echo form_input('zip', $zip);

echo "<label for='country'>Country:</label> ";
echo form_dropdown('country',$countries, $country);


echo "<label for='tel'>Direct Tel:</label> ";
echo form_input('tel', $tel);


echo "<label for='mobile'>Mobile:</label> ";
echo form_input('mobile', $mobile);


echo "<label for='fax'>Fax:</label> ";
echo form_input('fax', $fax);


echo "<label for='website'>Website (URL):</label> ";
echo form_input('website', $website);


echo "<label for='email2'>Alternate Email:</label> ";
echo form_input('email2', $email2);

$statuses = array(
  	    	'ACTIVE' => 'Active', 
			'INACTIVE' => 'Inactive'
             );

echo "<label for='status'>Status:</label> ";
echo form_dropdown('status', $statuses, $status);

echo "<br><label for='created'>Created On:</label> ";
echo form_input(array('name'=>'created','value'=>$created,'readonly'=>'readonly'));
echo "<label for='created'>Last Updated:</label> ";
echo form_input(array('name'=>'last_updated','value'=>$last_updated,'readonly'=>'readonly'));

?>

	<script>
		$('.check-exists').existsChecker();
	</script>

<?php
echo '<br><button type="submit" class="btn btn-primary">Update User</button>';
echo '&nbsp;<a href="'.$go_back_url.'" class="btn btn-warning">Cancel</a>';
echo form_close();


?>
	
	
</div><!--container-->
</div><!--body-->
</div>
</div>