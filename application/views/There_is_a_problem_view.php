<?php include("header.php"); 
if(ISSET($_SERVER['HTTP_REFERER'])){
	$go_back_url = $_SERVER['HTTP_REFERER'];
}else{ 
    $go_back_url = base_url().'/User/login';
}
?>
<div id="container">
<h1><?php echo $page_header; ?></h1>

	<a href="<?php echo $go_back_url; ?>"><< Go Back!</a>
<div id="body">
 <p style="max-width:800px; border:1px solid dark-gray; background-color:silver; padding:10px;">
  <?php echo $error_message ?> </p>
 <p> <a href='<?php echo base_url()."User/login"; ?>'>Please click here to login again.</a>
</p>
</div>
</div>

</body>
</html>

