<?php 
App::uses('AppModel', 'Model');
class Candidate extends AppModel {
    var $name = 'Candidate';
    var $useTable = "candidate";
    var $primaryKey="ID";	
	var $virtualFields=array("fullName"=>"concat(FirstName,' ', LastName)"); 
}
     
?>