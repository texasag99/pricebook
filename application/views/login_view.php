<?php include("header.php"); ?>

<div id="container">
	<h1><?php echo $page_header; ?></h1>

	<div id="body">
	<a href='<?php echo base_url()."User/registration"; ?>'>Register</a> | 
	<a href='<?php echo base_url()."User/forgot_my_password"; ?>'>Forgot My Password</a>
	 <h3>Please enter your email and password!</h3>
	 <p style="max-width:800px; border:1px solid dark-gray; background-color:silver; padding:10px;">
     Please login here. </p>
<table><tbody>
<?php 
echo form_open('User/login_validation');

echo '<tr><td></td><td><div style="color:red;">'.validation_errors().'</div></td></tr>';

echo "<tr><td style='text-align:right;'>Email:</td><td> ";
echo form_input('email',$this->input->post('email'));
echo "</td></tr>";

echo "<tr><td style='text-align:right;'>Password:</td><td> ";
echo form_password('password');
echo "</td></tr>";

echo "<tr><td></td><td>";
echo form_submit('login_submit', 'Login');
echo "</td></tr>";
		 
echo form_close();

?>
</tbody></table>


</div>
</div>

</body>
</html>


