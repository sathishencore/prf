<?php
echo "<option value=''>---Select---</option>"; 
foreach($clientlocationcity as $pkey=>$pval){
	echo "<option value='$pkey'>$pval</option>";
}
die;
?>