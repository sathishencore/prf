<?php 
App::uses('AppModel', 'Model');
class Client extends AppModel {
    var $name = 'Client';
    var $primaryKey="ID";
//    var $belongsTo=array("User"=>array('foreignKey'=>"AccountManagerID"));
    var $belongsTo=array("timezones"=>array('foreignKey'=>"TimezoneID"));
}
?>