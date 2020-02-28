<?php 
App::uses('AppModel', 'Model');
class Position extends AppModel {
	var $name = 'Position';
	var $useTable = "position";
	var $primaryKey="ID";
	var $belongsTo=array(
			"User"=>array('foreignKey'=>"RecruiterId"),
			"Project"=>array("foreignKey"=>"ProjectID"),
			"Client"=>array("foreignKey"=>"ClientID"),
			"ClientContacts"=>array("foreignKey"=>"HiringManagerID"),
			"ProjectRole"=>array("foreignKey"=>"RoleId"),
	);
	
	var $hasMany=array(
		"CandidateAssignment" => array("foreignKey" => "PositionID"),
	);
	 var $hasAndBelongsToMany = array(
        'Skill' => array(
            'className' => 'Skill',
            'joinTable' => 'position_skills',
            'foreignKey' => 'position_id',
            'associationForeignKey' => 'skill_id',
			'unique' => true,
        ),
    );    
	public function beforeSave($options = array()){
    foreach (array_keys($this->hasAndBelongsToMany) as $model){
      if(isset($this->data[$this->name][$model])){
        $this->data[$model][$model] = $this->data[$this->name][$model];
        unset($this->data[$this->name][$model]);
      }
    }
    return true;
  }
var $actsAs = array(
    'Containable'
);
}

?>