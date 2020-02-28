<?php 
App::uses('AppModel', 'Model');
class ClientContacts extends AppModel {
    var $name = 'ClientContacts';
    var $useTable = "client_contacts";
    var $primaryKey="ID";
    var $belongsTo=array(
    		"Client"=>array("foreignKey"=>"ClientID")
    );
    
}
?>