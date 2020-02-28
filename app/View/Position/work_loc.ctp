<?php
echo "<option value=''>---Select---</option>"; 
echo "<option value='NEWLocation'>Create New Location</option>";
foreach($worklocationdistinctList as $pkey=>$pval){
	echo "<option value='$pkey'>$pval</option>";
}
die;
?>