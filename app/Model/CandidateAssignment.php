<?php 
App::uses('AppModel', 'Model');
class CandidateAssignment extends AppModel {
    var $name = 'CandidateAssignment';
    var $useTable = "candidate_assignment";
    var $primaryKey="ID";
    var $belongsTo=array("Candidate"=>array("foreignKey"=>"CandidateID"),"Position"=>array("foreignKey"=>"PositionID"));
}
     
?>