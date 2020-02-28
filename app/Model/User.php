<?php 
App::uses('AppModel', 'Model');
class User extends AppModel {
    var $name = 'User';
    var $primaryKey="ID";
    var $belongsTo=array("Role"=>array('foreignKey'=>"RoleId"),"timezone"=>array('foreignKey'=>"TimezoneID"));   
    var $virtualFields=array("fullName"=>"concat(FirstName,' ', LastName)");    
}
     
?>