<?php 
App::uses('AppModel', 'Model');
class Skill extends AppModel {
	var $name = 'Skill';
	var $useTable = "skill";
	var $primaryKey="id";
	
	
		  var $hasAndBelongsToMany = array(
        'Position' =>
            array(
                'className' => 'Position',
                'joinTable' => 'position_skills',
                'foreignKey' => 'skill_id',
                'associationForeignKey' => 'position_id',
				'unique' => true,
            )
    ); 
		public $actAs = array('Containable');
}

?>