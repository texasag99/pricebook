<?php include("header.php"); 
if(ISSET($_SERVER['HTTP_REFERER'])){
	$go_back_url = $_SERVER['HTTP_REFERER'];
}else{ 
    $go_back_url = base_url().'/User/login';
}
?>
<div id="container">
<h1><?php echo $page_header; ?></h1>

<div id="body">
<a href="<?php echo $go_back_url; ?>"><< Go Back!</a>  |  
<a href="<?php echo base_url().'Profile'  ?>">View Profile</a>  |
<a href="<?php echo base_url().'User/change_password'  ?>">Change My Password</a>
<table class="form_table">
<tbody>
<?php 
echo form_open('Profile/profile_validation');

echo '<tr><td></td><td><div style="color:red;">'.validation_errors().'</div></td></tr>';

echo "<tr><td style='text-align:right;'>First Name:</td><td> ";
echo form_input('first',$first);
echo "</td></tr>";

echo "<tr><td style='text-align:right;'>Last Name:</td><td> ";
echo form_input('last',$last);
echo "</td></tr>";

echo'<tr><td class="align_right field_header">Email: </td><td class="field_value">&nbsp;'.$email.'<td></tr>';

echo "<tr><td style='text-align:right;'>Address:</td><td> ";
echo form_input('address1',$address1);
echo "</td></tr>";

echo "<tr><td style='text-align:right;'>Address 2:</td><td> ";
echo form_input('address2',$address2);
echo "</td></tr>";

echo "<tr><td style='text-align:right;'>City:</td><td> ";
echo form_input('city',$city);
echo "</td></tr>";

echo "<tr><td style='text-align:right;'>State:</td><td> ";
echo form_dropdown('state', $statelist, $state);
echo "</td></tr>";

echo "<tr><td style='text-align:right;'>Zip:</td><td> ";
echo form_input('zip',$zip);
echo "</td></tr>";

echo "<tr><td style='text-align:right;'>Country:</td><td> ";
echo form_dropdown('country',$countries,$country);
echo "</td></tr>";

echo "<tr><td style='text-align:right;'>Direct Tel:</td><td> ";
echo form_input('tel',$tel);
echo "</td></tr>";

echo "<tr><td style='text-align:right;'>Mobile:</td><td> ";
echo form_input('mobile',$mobile);
echo "</td></tr>";

echo "<tr><td style='text-align:right;'>Fax:</td><td> ";
echo form_input('fax',$fax);
echo "</td></tr>";

echo "<tr><td style='text-align:right;'>Website (URL):</td><td> ";
echo form_input('website',$website);
echo "</td></tr>";

echo "<tr><td style='text-align:right;'>Alternate Email:</td><td> ";
echo form_input('email2',$email2);
echo "</td></tr>";

echo'<tr><td class="align_right field_header">Created On:</td><td class="field_value">&nbsp;'.$created.'<td></tr>';
echo'<tr><td class="align_right field_header">Last Updated:</td><td class="field_value">&nbsp;'.$profile_updated.'<td></tr>';

echo "<tr><td></td><td>";
echo form_submit('login_submit', 'Submit');
echo "</td></tr>";
		 
echo form_close();

?>
</tbody>
</table>
<p></p>

</div></div>

</body>
</html>

