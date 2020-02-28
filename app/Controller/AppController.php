<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	var $uses=array("Timezone");
	
	public function beforeFilter(){
		Configure::load("config");
		$userId=$this->Session->read('userId');

        $this->forceSSL();

		if($userId > 0){
			Configure::write("TIMEZONE",$this->Timezone->find("list",array("fields"=>array("id","Timezone"))));
			if($this->params['controller']=='login' && $this->params['action']!='logout'){
				$this->redirect(array('controller'=>'client','action'=>'index'));
			}
			$this->checkAccessLevel();
		}else{
			if($this->params['controller']!='login'){
				$this->redirect(array('controller'=>'login','action'=>'index'));
			}
		}
	}

	public function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	public function checkAccessLevel(){ // to restrict access to the users based on their access level
		$roleId=$this->Session->read("roleId");		
		if($this->params['controller']!='Candidate'){
			$validRoles=array(1,3,4,9); // restricting admin, project manager and account manager to edit / delete  
			if(!in_array($roleId,$validRoles)){
				if((($this->params['action']=='index') || (($this->params['action']=='delete'))) && isset($this->params['pass']['0'])){
					$this->Session->setFlash(Configure::read("User.accessRestrict"));
					$this->redirect("/".$this->params['controller']."/index");
				}
				$this->set("editAction",false);
			}else{
				$this->set("editAction",true);
			}
		}else{ // to allow recruiter and admin to edit / delete the candidate details
			$validRoles=array(3,5,9);
			if(!in_array($roleId,$validRoles)){
				if((($this->params['action']=='index') || (($this->params['action']=='delete'))) && isset($this->params['pass']['0'])){
					$this->Session->setFlash(Configure::read("User.accessRestrict"));
					$this->redirect("/".$this->params['controller']."/index");
				}
				$this->set("editAction",false);
			}else{
				$this->set("editAction",true);
			}
			
		}
	}

	public function forceSSL() {
        if(($_SERVER['SERVER_PORT']=='80') && $_SERVER['SERVER_ADDR']!='127.0.0.1' && $_SERVER['SERVER_ADDR']!='192.168.1.42') {
            return $this->redirect('https://' . env('SERVER_NAME') . $this->here);
        }
	}
}
