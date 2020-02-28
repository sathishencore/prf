<?php 
App::uses('AppModel', 'Model');
class Project extends AppModel {
    var $name = 'Project';
    var $useTable = "project";
    var $primaryKey="ID";
	var $belongsTo=array(
		"Users"=>array("foreignKey"=>"EncoreContact"),
			
		'ClientContact' => array(
			'className' => 'ClientContacts',
			'foreignKey' => "ClientContactID",			
			'fields' => '',
			'order' => ''
		),

		'ProjectManager' => array(
			'className' => 'ClientContacts',
			'foreignKey' => "ProjectManagerID",
			'fields' => '',
			'order' => ''
		));
	public $actAs = array('Containable');
    public $virtualFields = array(
    		'project_code_name' => 'CONCAT(Project.Code, ", ", Project.Name)'
    );
}
     
?>