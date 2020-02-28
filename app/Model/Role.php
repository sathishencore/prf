<?php 
App::uses('AppModel', 'Model');
class Role extends AppModel {
    var $name = 'Role';
    var $primaryKey="ID";
    var $belongsTo=array("User"=>array('foreignKey'=>"AccountManagerID"));
    var $useTable="role";
}
?>