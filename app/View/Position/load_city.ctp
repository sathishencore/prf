<?php
echo "<option value=''>---Select---</option>"; 
foreach($worklocationcity as $pkey=>$pval){
	echo "<option value='$pkey'>$pval</option>";
}
die;
?>