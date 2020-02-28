<?php
echo "<option value=''>---Select---</option>"; 
echo "<option value='NEWRole'>Create New Role</option>";
foreach($roles as $pkey=>$pval){
	echo "<option value='$pkey'>$pval</option>";
}
die;
?>