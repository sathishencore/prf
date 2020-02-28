<?php
echo "<option value=''>---Select---</option>"; 
echo "<option value='NEWSkill'>Create New Skill</option>";
foreach($skills as $pkey=>$pval){
	echo "<option value='$pkey'>$pval</option>";
}
die;
?>