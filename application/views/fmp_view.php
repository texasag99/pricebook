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
<a href="<?php echo $go_back_url; ?>"><< Go Back!</a>
 <h3>Forgot My Password</h3>
 <p style="max-width:800px; border:1px solid dark-gray; background-color:silver; padding:10px;">Please enter your email:</p>

<table><tbody>
<?php 
echo form_open('User/fmp_email_validation');

echo '<tr><td></td><td><div style="color:red;">'.validation_errors().'</div></td></tr>';

echo "<tr><td style='text-align:right;'>Email address:</td><td> ";
echo form_input('email',$this->input->post('email'));
echo "</td></tr>";

echo "<tr><td></td><td>";
echo form_submit('login_submit', 'Submit');
echo "</td></tr>";
		 
echo form_close();

?>
</tbody></table>
</div>
</div>

</body>
</html>


