<?php
if(ISSET($_SERVER['HTTP_REFERER'])){
	$go_back_url = $_SERVER['HTTP_REFERER'];
}else{ 
    $go_back_url = base_url().'/User/login';
}
?>

<div id="container" class="container-fluid">
<h1><?php echo $page_header; ?></h1>
<div id="body">
<br><br>
<div class="col-md-2">
<div id="pricing_record">
<div class="panel panel-default">
<div class="panel-heading text-center "><h3>Pricing Information</h3></div>
<div class="panel-body"> 
<p>The current pricing information below is related to a specific price item.</p></div>
<table class="table-condensed">
<thead>
<tr>
<th class='text-right'></th>
<th>Pricing Data</th>
<?php

foreach ($results as $data){ 
		if($data->status == 1){
			$status = "ACTIVE";
			$status_indicator = 'success';
			}elseif($data->status == 0){
				$status = "INACTIVE";
				$status_indicator = 'warning';
				}else{
					$status = "UNDEFINED";
					$status_indicator = 'info';
					}	
		$integration_flag = ($data->integration_flag)? "YES" : "NO";
		$alf_flag = ($data->alf_flag)? "YES" : "NO";	
		$discount_flag = ($data->discount_flag)? "YES" : "NO";
    $integration = 0;
    $alf = 0;
    if ($data->fixed_integration > 0 && $data->integration_flag){ $integration = $data->fixed_integration; }elseif($data->integration_flag ){$integration = ($data->price * $integration_rate);}else{ $integration = 0; }
    if ($data->fixed_alf >0 && $data->alf_flag){$alf = $data->fixed_alf;}elseif($data->alf_flag){$alf=($data->price * $alf_rate);}else{$alf = 0;}        
    
?>
</tr></thead>
<tbody class="table-hover">
<tr><td class='text-right'>ID:</td><td>&nbsp;<?php echo $data->id; ?><td></tr>
<tr><td class='text-right'>Code:</td><td>&nbsp;<?php echo $data->code; ?><td></tr>
<tr><td class='text-right'>Description:</td><td>&nbsp;<?php echo $data->description; ?><td></tr>
<tr><td class='text-right'>Price:</td><td>&nbsp;$<?php echo number_format($data->price,2,'.',','); ?><td></tr>
<tr><td class='text-right'>ALF:</td><td>&nbsp;$<?php echo number_format($alf,2,'.',','); ?><td></tr>
<tr><td class='text-right'>Integration:</td><td>&nbsp;$<?php echo number_format($integration,2,'.',','); ?><td></tr>
<tr><td class='text-right'>Status:</td><td>&nbsp;<?php echo $status; ?><td></tr>
<tr><td class='text-right'>Category:</td><td>&nbsp;<?php echo $data->category; ?><td></tr>
<tr><td class='text-right'>Integration Flag:</td><td>&nbsp;<?php echo $integration_flag; ?><td></tr>
<tr><td class='text-right'>ALF Flag:</td><td>&nbsp;<?php echo $alf_flag; ?><td></tr>
<tr><td class='text-right'>Discoung Flag:</td><td>&nbsp;<?php echo $discount_flag; ?><td></tr>
<tr><td class='text-right'>Fixed Integration:</td><td>&nbsp;<?php echo $data->fixed_integration; ?><td></tr>
<tr><td class='text-right'>Fixed ALF:</td><td>&nbsp;<?php echo $data->fixed_alf; ?><td></tr>
<tr><td class='text-right'>Created On:</td><td>&nbsp;<?php echo $data->created; ?><td></tr>
<tr><td class='text-right'>Last Updated:</td><td>&nbsp;<?php echo $data->last_updated; ?><td></tr>
<?php } ?>
</tbody>
</table>
<p></p>
</div>
</div>
</div>
</div>
</div>


