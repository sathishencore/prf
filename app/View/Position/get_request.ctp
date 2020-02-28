<?php
echo "<option value=''>---Select---</option>"; 
foreach($requestList as $rkey=>$rval){
	echo "<option value='$rkey'>$rval</option>";
}
die;
?>