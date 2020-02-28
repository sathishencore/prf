<?php
class SkillController extends AppController {


	public function add_skill(){
		$this->Skill->recursive = 1;
		 $name = $this->params['data']['skill'];
		 $skillDetails = $this->Skill->find("all",array("conditions"=>array("Skill.Name ="=>$name)));
		 if(count($skillDetails) == 0) {
			$skill['Name'] = $name;
			$this->Skill->save($skill); 
			echo "true";DIE;
		 }else{
			 echo "false";DIE;
		 }
		
	}
	public function skill_list(){
		$this->layout="ajax";
		$this->set("skills",$this->Skill->find("list",array("fields"=>array("ID","Name"))));
		//$skills = $this->Skill->find("list",array("fields"=>array("id","name"),"order"=>array("name")));
		//$this->set("skills",$skills);
	}
}