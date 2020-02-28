<?php
echo "<option value=''>---Select---</option>"; 
foreach($projectList as $pkey=>$pval){
	echo "<option value='$pkey'>$pval</option>";
}
die;
?>