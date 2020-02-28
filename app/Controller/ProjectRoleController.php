<?php
class ProjectRoleController extends AppController {


	public function add_role(){
		 $name = $this->params['data']['role'];
		 $role['role'] = $name;
		 $roleDetails = $this->ProjectRole->find("all",array("conditions"=>array("ProjectRole.role"=>$name)));
		 if(count($roleDetails) == 0) {
			$this->ProjectRole->save($role); 
			echo "true";DIE;
		 }else{
			 echo "false";DIE;
		 }
		
	}
	public function role_list(){
		$this->layout="ajax";
		$roles = $this->ProjectRole->find("list",array("fields"=>array("id","role")));
		$this->set("roles",$roles);
	}
}