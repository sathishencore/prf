<?php 
App::uses('AppModel', 'Model');
class PositionSkill extends AppModel {
    var $name = 'position_skills';
    var $primaryKey="ID";
	var $belongsTo=array(
			"Skill"=>array('foreignKey'=>"skill_id"),
			"Position"=>array("foreignKey"=>"position_id"),
	);
}
?>