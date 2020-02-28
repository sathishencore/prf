<?php
class UsersController extends AppController {
	var $uses=array("User","Role","Position","Project");	
	
	public function beforeFilter(){
		parent::beforeFilter();		
		if(!$this->Session->read("AdminUser")){
			if($this->params['action']!='changePassword')
			$this->redirect(array("controller"=>"Client","action"=>"index"));
		}
	}
	
	public function index() {
		$this->layout="prf";
		$this->set("show","0");		
    	if(isset($this->data['User']['FirstName'])){
    		$user_data=$this->data;
    		if(isset($this->params['pass']['0'])){
    			/*if(($user_data['User']['StatusFlagOld']=='Active') && ($user_data['User']['StatusFlag']=='Inactive')){
    				$user_data['User']['StatusUpdateDate']=date("Y-m-d H:i:s");
    			} */   			
    			$user_data['User']['ID']=$this->params['pass']['0'];
    			$user_data['User']['ModifiedBy']=$this->Session->read("userId");
    			$this->User->save($user_data);
    			$this->Session->setFlash(Configure::read("User.updateSuccess"));    			
    		}else{
    			$pwd_string=$this->generateRandomString(6);
    			$user_data['User']['Password']=md5($pwd_string);
    			$user_data['User']['InsertedBy']=$this->Session->read("userId");
    			$this->User->save($user_data);
    			$insertedId=$this->User->getInsertID();
    			$this->sendMail($insertedId,$pwd_string);
    			$this->Session->setFlash(Configure::read("User.createSuccess"));
    		}    		
    		$this->redirect(array("controller"=>"Users","action"=>"index"));		   
    	}else{    		
    		$this->set("title_for_layout","CREATE NEW USER");
    	}    	
    	if(isset($this->data['UserFrm']['searchbox'])){
    		if(!empty($this->data['UserFrm']['searchbox'])){
    			$conditions=array("User.RoleId"=>$this->data['UserFrm']['searchbox']);
    		}else{
    			$conditions="";
    		}    	    		
    	}
    	if(isset($this->data['UserNamelist'])){    	
    		$this->set("show","1");	
    		$conditions=array();    		
    		if($this->data['UserNamelist'] > 0)    				    		
    			$conditions['User.ID']=$this->data['UserNamelist'];
    		if(!empty($this->data['Email'])){
    			$conditions['Email LIKE']="%".$this->data['Email']."%";
    		}
    		if(!empty($this->data['searchbox1'])){
    			$conditions['User.RoleId']=$this->data['searchbox1'];
    		}
    		if(!empty($this->data['statusbox1'])){
    			$conditions['User.StatusFlag']=$this->data['statusbox1'];
    		}
    	}    	
    	if(isset($conditions)){   		
    		$this->set("UserList",$this->User->find("all",array("conditions"=>$conditions, "order"=>array("FirstName","LastName"))));
    	}else{    	
    		$this->set("UserList",$this->User->find("all",array("conditions"=>array("User.StatusFlag"=>'Active'),"order"=>array("FirstName","LastName"))));
    	}
		if(isset($this->params['pass']['0'])){
    		$this->User->id=$this->params['pass']['0'];    		
    		$this->data=$this->User->read();
    		$this->set("title_for_layout","UPDATE USER");
    	}
    	$this->set("UserNamelist",$this->User->find("list",array("fields"=>array("ID","fullName"))));
		$this->set("timezone",Configure::read("TIMEZONE"));
		$this->set("roleList",$this->Role->find("list",array("fields"=>array("ID","Name"))));
		
	}
	
	public function delete($id) {
		$this->autoRender=false;
		if($id){
			try{
				$this->User->delete($id);
				$this->Session->setFlash(Configure::read("User.deleteSuccess"));
			}catch ( Exception $e){
				$this->Session->setFlash(Configure::read("User.deleteFailure"));
			}
			$this->redirect(array("controller"=>"Users","action"=>"index"));
		}
	}
	
	public function sendMail($userId,$pwd_string){
		$this->autoRender=false;
		$userDetails=$this->User->find("first",array("conditions"=>array("User.ID"=>$userId)));
		echo $userDetails['User']['Email'];			
		  App::uses('CakeEmail', 'Network/Email');		  
		  $desc=array();
		  $email = new CakeEmail('smtp');
		  $email->subject("Encore :: User registration PRF application");
		  $email->from(array('no-reply@encoress.com' => 'ENCORE'));
		  $email->to($userDetails['User']['Email']);
		  $email->emailFormat('text');
		  $email->viewVars(array('Name'=>$userDetails['User']['FirstName']));
		  $email->viewVars(array('title_for_layout'=>"User Registration"));	
		  $email->viewVars(array('loginName'=>$userDetails['User']['LoginName']));
		  $email->viewVars(array('Password'=>$pwd_string));	  
		  $email->template('UserRegistration');
		  $email->send();		  
	 }
	
	 public function encore() {
	 	$this->layout="prf";
	 	//pr($this->data);
	 	$this->set("title_for_layout","Add New Encore Contacts");
	 	$this->set("Encore_Contact",$this->EncoreContacts->find('all'));
		
	 	if(isset($this->data['EncoreContacts']['ContactName'])){
			
	 		try{
	 			$encorecontact = $this->data;
				/**
				 * Modifier Name : Riyaz
				 * Modified Date : 09/27/2013
				 */
				if(isset($this->params['pass']['0']))
					$encorecontact['EncoreContacts']['ID'] = $this->params['pass']['0'];
				/**
				 * Ends Here
				 **/
	 			if(!empty($encorecontact['EncoreContacts']['ID'])){
	 				$encorecontact['EncoreContacts']['ModifiedBy']=$this->Session->read("userId");
	 				$this->EncoreContacts->save($encorecontact);
	 				$this->Session->setFlash(Configure::read("User.updateEncoreContact"));
	 				$this->redirect(array("controller"=>"Users","action"=>"encore" ));
	 			}else{
	 				$encorecontact['EncoreContacts']['InsertedBy']=$this->Session->read("userId");
	 				//pr($newclientcontact);die;
	 				$this->EncoreContacts->save($encorecontact);
	 				$this->Session->setFlash(Configure::read("User.addEncoreContact"));
	 				$this->redirect(array("controller"=>"Users","action"=>"encore"));
	 			}
	 		}catch (Exception $e){
	 			$this->Session->setFlash(Configure::read("User.addClientEncoreFailure"));
	 			$this->redirect(array("controller"=>"Users","action"=>"encore"));
	 		}
	 	}
	 	
	 	if(isset($this->params['pass']['0'])){
	 		$this->EncoreContacts->id=$this->params['pass']['0'];
	 		$this->data=$this->EncoreContacts->read();
	 		$this->set("title_for_layout","Update Encore Contacts");
	 	}
	 }
	 
	 public function deleteEncoreContact(){
	 	$this->autoRender=false;
	 	if(isset($_GET['deleteid'])){
	 		$id=$_GET['deleteid'];
	 		try{
	 			if($this->EncoreContacts->delete($id)){
	 				$this->Session->setFlash(Configure::read("User.deleteEncoreContactSuccess"));
	 			}else{
	 				$this->Session->setFlash(Configure::read("User.deleteEncoreContactFailure"));
	 			}
	 		}catch(Exception $e){
	 			$this->Session->setFlash(Configure::read("User.deleteEncoreContactFailure"));
	 		}
	 		$this->redirect(array("controller"=>"Users","action"=>"encore"));
	 	}
	 }

	public function checkName() {
		$this->autoRender=false;				
		if($this->params->query['UserLoginName']){			
			$id=$this->User->field("ID",array("LoginName"=>$this->params->query['UserLoginName']));
			if($id>0){
				echo "false";
			}else{
				echo "true";
			}
			exit;
		}
	}
	
	public function changePassword() {
		$this->layout="prf";
		$this->set("title_for_layout","Change Password");
		if(isset($this->data['User']['confirmPassword'])){
			$userData['User']['ID']=$this->Session->read("userId");
			$userData['User']['IsActive']=1;
			$userData['User']['Password']=trim(md5($this->data['User']['confirmPassword']));
			$this->User->save($userData);
			$this->Session->setFlash(Configure::read("User.passwordUpdate"));	
			$this->redirect(array("controller"=>"Client","action"=>"index"));
		}
	}
	
	public function checkEmail() {
		$this->autoRender=false;				
		if($this->params->query['UserEmail']){
			$conditions=array("Email"=>$this->params->query['UserEmail']);
			if(isset($this->params->query['UserId']) && ($this->params->query['UserId'] > 0)){
				$conditions["ID !="]=$this->params->query['UserId'];
			}			
			$id=$this->User->field("ID",$conditions);			
			if($id>0){
				echo "false";
			}else{
				echo "true";
			}
			exit;
		}
	}
	
	public function resetpassword(){
		if(isset($this->params['pass']['0'])){
			$this->autoRender=false;
			App::uses('CakeEmail', 'Network/Email');
			$pwd_string=$this->generateRandomString(6);
			$userDetails = $this->User->find('first',array('conditions'=>array("User.ID"=>$this->params['pass']['0'])));
			$this->User->id=$userDetails['User']['ID'];
			$userData['User']['IsActive']=0;
			$userData['User']['Password']=md5($pwd_string);
			$this->User->save($userData);
			$email = new CakeEmail('smtp');
			$email->subject("Encore - PRF :: Reset Password Request");
			$email->from(array('no-reply@encoress.com' => 'ENCORE'));
			$email->to($userDetails['User']['Email']);
			$email->emailFormat('text');
			$email->viewVars(array('Name'=>$userDetails['User']['FirstName']));
			$email->viewVars(array('title_for_layout'=>"Reset Password Information"));
			$email->viewVars(array('loginName'=>$userDetails['User']['LoginName']));
			$email->viewVars(array('Password'=>$pwd_string));
			$email->template('forgotPassword');
			$email->send();
			$this->Session->setFlash("New password generated and mailed to ".$userDetails['User']['LoginName']);
			$this->redirect(array('controller'=>'Users','action'=>'index'));
			#print_r($pwd_string);die;
		}
		
	}
	
	public function checkRecruiter(){
		$this->autoRender=false;
		if($this->params['data']['userId']){
			$recruiterid=$this->params['data']['userId'];
		}
		$get_val=$this->Position->find("all",array("conditions"=>array("Position.RecruiterId"=>$recruiterid,"Position.Status"=>array("Open","Potential")),"order"=>array("ProjectID")));
		
		$count = $this->Position->find("count",array("conditions"=>array("Position.RecruiterId"=>$recruiterid,"Position.Status"=>array("Open","Potential")),"order"=>array("ProjectID")));
		//echo $count; ,"order by"=>'ProjectID asc'
		if($count>0){
			//echo "<pre>";
			//print_r($get_val);
			//die;
		echo json_encode($get_val);
			//echo $recruiterid.",".$get_val;
		}else{
			$userData['User']['ID']=$recruiterid;
			$userData['User']['StatusFlag']='Inactive';
			$userData['User']['StatusUpdateDate']=date("Y-m-d H:m:s");
			$this->User->save($userData);
			echo json_encode($recruiterid);
		}
		exit;
	}
	
	public function activateRecruiter(){
		$this->autoRender=false;
		if($this->params['data']['userId']){
			$recruiterid=$this->params['data']['userId'];
			$userData['User']['ID']=$recruiterid;
			$userData['User']['StatusFlag']='Active';
			$userData['User']['StatusUpdateDate']=date("Y-m-d H:m:s");
			$this->User->save($userData);
			echo "success";
		}
		//$count=$this->Position->find("update",array("conditions"=>array("User.ID"=>$recruiterid,"Position.status"=>array("Open","Potential"))));
		exit;
	}
	public function activateProjectlead(){
		$this->autoRender=false;
		if($this->params['data']['userId']){
			$recruiterid=$this->params['data']['userId'];
			$userData['User']['ID']=$recruiterid;
			$userData['User']['StatusFlag']='Active';
			$userData['User']['StatusUpdateDate']=date("Y-m-d H:m:s");
			$this->User->save($userData);
			echo "success";
		}
		//$count=$this->Position->find("update",array("conditions"=>array("User.ID"=>$recruiterid,"Position.status"=>array("Open","Potential"))));
		exit;
	}
	public function inactivateProjectlead(){
		$this->autoRender=false;
		if($this->params['data']['userId']){
			$recruiterid=$this->params['data']['userId'];
			$userData['User']['ID']=$recruiterid;
			$userData['User']['StatusFlag']='Inactive';
			$userData['User']['StatusUpdateDate']=date("Y-m-d H:m:s");
			$this->User->save($userData);
			echo "success";
		}
		//$count=$this->Position->find("update",array("conditions"=>array("User.ID"=>$recruiterid,"Position.status"=>array("Open","Potential"))));
		exit;
	}
	public function getRecruiters(){
		$this->autoRender=false;
		if($this->params['data']['userId']){
			$recruiterid=$this->params['data']['userId'];
		}
		$get_val1=$this->User->find("list",array("fields"=>array("ID","fullName"),"conditions"=>array("User.RoleId"=>'5',"User.StatusFlag"=>'Active')));
		
		echo json_encode($get_val1);
	
	}
	public function assignrec(){
	//	$this->autoRender=false;
			$nos=$this->params;
			echo "<pre>";
			print_r($this->params['query']);
			$count = $this->params->query['hh'];
			//echo $nos;
			for($a=0;$a<$count;$a++) {
				$reqn="req_name".$a;
				//echo $reqn;
					echo $this->params->query[$reqn];
					$seln="sel_rec".$a;
					echo $this->params->query[$seln];
					$pos_id="pos_id".$a;
					
					$posData['Position']['ID']=$this->params->query[$pos_id];
				$posData['Position']['RecruiterId']=$this->params->query[$seln];	
				$userData['User']['ID']=$this->params->query['user_id'];
				$userData['User']['StatusFlag']='Inactive';
				$userData['User']['StatusUpdateDate']=date("Y-m-d H:m:s");
				$this->Position->save($posData);
				$this->User->save($userData);	
			}
			
		$this->Session->setFlash("Successfully Deactivated");
		$this->redirect(array("controller"=>"Users","action"=>"index"));
		
			die;
		}
		
		
	 
	public function inactivateEncoreContact(){
	 	$this->autoRender=false;
	 	if(isset($_GET['inactiveid'])){
	 		$id=$_GET['inactiveid'];
	 		$contactData['User']['ID']=$id;
			$contactData['User']['StatusFlag']='Inactive';
			$contactData['User']['StatusUpdateDate']=date("Y-m-d H:m:s");
			$this->User->save($contactData);
			$this->Session->setFlash("Successfully Deactived");
	 		$this->redirect(array("controller"=>"Users","action"=>"index"));
	 	}
	 }
	public function activateEncoreContact(){
	 	$this->autoRender=false;
	 	if($this->params['data']['userId']){
	 		$id=$this->params['data']['userId'];
	 		$acc_mail=$this->params['data']['userMail'];
	 		
	 		$contactData['User']['ID']=$id;
			$contactData['User']['StatusFlag']='Active';
			$contactData['User']['StatusUpdateDate']=date("Y-m-d H:m:s");
			$this->User->save($contactData);
			
			
			//$this->Session->setFlash("Successfully Activated");
	 		//$this->redirect(array("controller"=>"Users","action"=>"encore"));
	 	}
	 }
	 
		public function checkAccmanager(){
		$this->autoRender=false;
		if($this->params['data']['userId']){
			 $accid=$this->params['data']['userId'];
		}
		if($this->params['data']['userName']){
			 $accname=$this->params['data']['userName'];
		}
		if($this->params['data']['userMail']){
			 $accmail=$this->params['data']['userMail'];
		}
		//echo $accid;
		//die;
		$get_val=$this->Project->find("all",array("conditions"=>array("Project.EncoreContact"=>$accid),"order"=>"Project.ID"));
		
		$count = $this->Project->find("count",array("conditions"=>array("Project.EncoreContact"=>$accid),"order"=>"Project.ID"));
		//echo $count; //,"order by"=>'ProjectID asc'
		
		if($count>0){
			//echo "<pre>";
			//print_r($get_val);
			//die;
		echo json_encode($get_val);
			//echo $recruiterid.",".$get_val;
		}else{
			$accid=$this->params['data']['userId'];
			$userData['User']['ID']=$accid;
			$userData['User']['StatusFlag']='Inactive';
			$userData['User']['StatusUpdateDate']=date("Y-m-d H:m:s");
			$this->User->save($userData);
			echo json_encode($accid);
			
		} 
		exit;
	}
	
	public function getAccmanager(){
		$this->autoRender=false;
		$managerList = array();
	 $accManager = $this->User->query("SELECT GROUP_CONCAT(Id) as Id,FirstName,LastName FROM users AS `User` where StatusFlag='Active' && RoleId='1' GROUP BY FirstName ORDER BY `FirstName` ASC ");
		foreach ($accManager as $key => $value) {
			$fullname = $value['User']['FirstName']." ".$value['User']['LastName'];
			$managerList[$value[0]['Id']] = $fullname;
		}
		//echo "<pre>";
		//print_r($managerList);
		echo json_encode($managerList);
	}
	
	public function assignAcc(){
	//	$this->autoRender=false;
			$nos=$this->params;
			//echo "<pre>";
		//	print_r($this->params['query']);
			$count = $this->params->query['hh'];
			//echo $count;
			for($a=0;$a<$count;$a++) {
				$reqn="pro_name".$a;
				//echo $reqn;
					//echo $this->params->query[$reqn];
					$seln="sel_acc".$a;
					//echo $this->params->query[$seln];
					$pro_id="pro_id".$a;
					//echo $seln;
					$posData['Project']['ID']=$this->params->query[$pro_id];
					$posData['Project']['EncoreContact']=$this->params->query[$seln];
					$userData['User']['ID']=$this->params->query['enc_id'];
					$userData['User']['StatusFlag']='Inactive';
					$userData['User']['StatusUpdateDate']=date("Y-m-d H:m:s");
			
				$this->Project->save($posData);
				$this->User->save($userData);
			}
			
		$this->Session->setFlash("Successfully Deactivated");
		$this->redirect(array("controller"=>"Users","action"=>"index"));
		
			die;
		}
		
}		
	


?>
