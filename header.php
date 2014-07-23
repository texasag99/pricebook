<!DOCTYPE html>
<html lang="en">


<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<link rel="shortcut icon" href="<?php echo base_url().'favicon.ico';?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'style.css';?>">
</head>
<body>
<div id="header">
<p id="title"><?php echo APPLICATION_TITLE; ?> <span class="version_number">Version <?php  echo APPLICATION_VERSION; ?></span></p>
</div>
<div class="navbar">
<ul class="navbar_ul">
<?php if ($this->session->userdata('is_logged_in')){ ?> <li class="navbar_li"><a class="navbar_a" href="<?php echo base_url().'User/logout'; ?>">Logout</a></li><?php }else{ echo "  ";}?>

</ul>
<?php if ($this->session->userdata('is_logged_in')){  
		echo "<p class='login_name'><a  href='".base_url()."Profile'>".$this->session->userdata('name')."</a> is logged in.</p>";
		}else{
		 echo " ";
		 }
?>
</div>



