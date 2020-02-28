<?php
App::uses('AppModel', 'Model');
class DistributionList extends AppModel {
    var $name = 'DistributionList';
    var $useTable = "distribution_lists";
    var $primaryKey="id";
}
?>