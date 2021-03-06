<?php

if(ISSET($_SERVER['HTTP_REFERER'])){
	$go_back_url = $_SERVER['HTTP_REFERER'];
}else{ 
    $go_back_url = base_url().'/User/login';
}
if(!isset($profile_pic) && empty($profile_pic)) { 
$profile_pic = "<img src='".base_url()."uploads/generic_user.jpg' class='profile_pic'/>"; 
}else{
	$profile_pic = "<img src='".base_url()."uploads/profile_pics/".$profile_pic."' class='profile_pic'/>";  
}
?>

<div id="container" class="container-fluid">
<h1><?php echo $page_header; ?></h1>
<a class="btn btn-default" id="edit_profile"  href="<?php echo base_url().'Profile/edit_profile'  ?>">Edit Profile</a> 
<div id="body">
<br><br>
<div class="col-md-4">
<div id="user-profile">
<div class="panel panel-default">
<div class="panel-heading text-center "><h3>User Information</h3></div>
<div class="panel-body"> 
<p>The current profile information related to the account on the system. Please ensure the profile data is updated to reflect the most recent information</p></div>
<table class="table-condensed">
<thead>
<tr>
<th class='text-right'></th>
<th>Profile Data</th>
</tr></thead>
<tbody class="table-hover">
<tr><td></td><td><?php echo $profile_pic; ?></td></tr>
<tr><td class='text-right'>Email:</td><td>&nbsp;<?php echo $email; ?><td></tr>
<tr><td class='text-right'>Name:</td><td>&nbsp;<?php echo $first." ".$last; ?><td></tr>
<tr><td class='text-right'>Address:</td><td>&nbsp;<?php echo $address1; ?><td></tr>
<tr><td class='text-right'>Address 2:</td><td>&nbsp;<?php echo $address2; ?><td></tr>
<tr><td class='text-right'>City:</td><td>&nbsp;<?php echo $city; ?><td></tr>
<tr><td class='text-right'>State:</td><td>&nbsp;<?php echo $state; ?><td></tr>
<tr><td class='text-right'>Zip:</td><td>&nbsp;<?php echo $zip; ?><td></tr>
<tr><td class='text-right'>Country:</td><td>&nbsp;<?php echo $country; ?><td></tr>
<tr><td class='text-right'>Direct Tel:</td><td>&nbsp;<?php echo $tel; ?><td></tr>
<tr><td class='text-right'>Mobile:</td><td>&nbsp;<?php echo $mobile; ?><td></tr>
<tr><td class='text-right'>Fax:</td><td>&nbsp;<?php echo $fax; ?><td></tr>
<tr><td class='text-right'>Website (URL):</td><td>&nbsp;<a href="<?php echo $website; ?>"><?php echo $website; ?></a><td></tr>
<tr><td class='text-right'>Alternate Email:</td><td>&nbsp;<?php echo $email2; ?><td></tr>
<tr><td class='text-right'>Created On:</td><td>&nbsp;<?php echo $created; ?><td></tr>
<tr><td class='text-right'>Last Updated:</td><td>&nbsp;<?php echo $profile_updated; ?><td></tr>
<tr><td class='text-right'>Last Activity:</td><td>&nbsp;<?php echo $last_activity; ?><td></tr>
</tbody>
</table>
<p></p>
</div>
</div></div>

<div class="col-md-3">
<div id="user-permissions">
<div class="panel panel-default">
<div class="panel-heading text-center "><h3>User Permissions</h3></div>
<div class="panel-body"> 
<p>The below list indicates all the permissions granted for this user. Permissions are designated with a permission code and permission name.</p></div>
<table class="table table-condensed">
<thead>
<tr>
<th class='text-right'>Code</th>
<th>Permission</th>
</tr></thead>
<tbody class='table-hover'>
<?php
if(isset($permission)&&!empty($permission)){
foreach($permission as $row){
foreach($row as $value){
echo "<tr><td class='text-right'><a href='#' title='".$value->description."'><strong>".$value->id."</strong></a></td><td>".$value->permission."</td></tr>";	
}}
}else{
echo "<tr><td colspan=2 class='alert alert-warning'><strong>None defined!</strong>   There are no permissions defined for this user.</td></tr>";	
}
?>
</tbody>
</table>
</div>
</div>
</div>
</div></div>



