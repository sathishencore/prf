<?php
class ClientController extends AppController {
	var $uses=array("User","Client","Project","ClientContacts","Position");

	public function index(){

		$this->layout="prf";
		$this->set("accountManagerList",$this->User->find("list",array("fields"=>array("Id","fullName"),"conditions"=>array("RoleId"=>1))));
		$this->set("clientlocation",$this->Client->find("list",array("fields"=>array("Client.City","Client.State","Client.Country"),"order"=>array("City"))));
		if(isset($this->data['Client']['Name'])){
			if(isset($this->params['pass']['0'])){
				$userId=$this->Session->read("userId");
				$client_data=$this->data;
				$client_data['Client']['ID']=$this->params['pass']['0'];
				$client_data['Client']['ModifiedBy']=$userId;
				$this->Client->save($client_data);
				$this->Session->setFlash(Configure::read("Client.updateSuccess"));
				//created to retain the client id to display in the search form when edit action is performed
				$this->Session->write("Client.ID",$client_data['Client']['ID']); 
				$this->redirect(array("controller"=>"Client","action"=>"index"));
			}else{
				$userId=$this->Session->read("userId");
				$client_data=$this->data;
				$client_data['Client']['InsertedBy']=$userId;
				$this->Client->save($client_data);
				$id = $this->Client->getLastInsertId();
				$this->Session->setFlash(Configure::read("Client.createSuccess")."<br/>  Do you want to add contact? <a href='javascript:' class='client_contact' data-val=$id id='yesAddClient'>Yes</a> / <a href='javascript:' onclick='clientIndex()' class=''>No</a>");
				$this->redirect(array("controller"=>"Client","action"=>"index/".$id));
			}

		}
		if(isset($this->data['ClientFrm']['searchbox'])){
			$conditions=array();
			if(!empty($this->data['ClientFrm']['searchbox'])){
				$conditions["Client.ID"]=$this->data['ClientFrm']['searchbox'];
			}
			if((!empty($this->data['ClientFrm']['searchboxcountry']))&&(!empty($this->data['ClientFrm']['searchboxcity'])) ){
				$split = explode(',',$this->data['ClientFrm']['searchboxcity']);
				$conditions["Client.Country"]=$this->data['ClientFrm']['searchboxcountry'];
				$conditions["Client.City"]=$split[0];
				$conditions["Client.State"]=$split[1];
			}
			if((!empty($this->data['ClientFrm']['searchboxcountry']))&&(empty($this->data['ClientFrm']['searchboxcity'])) ){
				$split = explode(',',$this->data['ClientFrm']['searchboxcity']);
				$conditions["Client.Country"]=$this->data['ClientFrm']['searchboxcountry'];
			}
			if(!empty($this->data['ClientFrm']['Status']))
				$conditions["Client.Status"]=$this->data['ClientFrm']['Status'];

			$this->set("Clcountry",$this->data['ClientFrm']['searchboxcountry']);
			$this->set("Clcity",$this->data['ClientFrm']['searchboxcity']);
			$this->set("clientList",$this->Client->find("all",array("conditions"=>$conditions, "order"=>array("Name"))));
		}else{
			$conditions=array();
			if((!empty($this->data['ClientFrm']['searchboxcountry']))&&(!empty($this->data['ClientFrm']['searchboxcity'])) ){
				$split = explode(',',$this->data['ClientFrm']['searchboxcity']);
				$conditions["Client.Country"]=$this->data['ClientFrm']['searchboxcountry'];
				$conditions["Client.City"]=$split[0];
				$conditions["Client.State"]=$split[1];
			}
			if((!empty($this->data['ClientFrm']['searchboxcountry']))&&(empty($this->data['ClientFrm']['searchboxcity'])) ){
				$split = explode(',',$this->data['ClientFrm']['searchboxcity']);
				$conditions["Client.Country"]=$this->data['ClientFrm']['searchboxcountry'];
				$conditions["Client.City"]=$split[0];
				$conditions["Client.State"]=$split[1];
			}
			$this->set("Clcountry",isset($this->data['ClientFrm']['ClientCountry'])?$this->data['ClientFrm']['ClientCountry']:'');
			$this->set("Clcity",isset($this->data['ClientFrm']['ClientCity'])?$this->data['ClientFrm']['ClientCity']:'');
			$this->set("clientList",$this->Client->find("all",array("conditions"=>$conditions, "order"=>array("Name"))));
		}
		if(isset($this->params['pass']['0'])){
			$this->Client->id=$this->params['pass']['0'];
			
			$client_contactsD = $this->ClientContacts->find('count',array("conditions"=>array("ClientContacts.ClientID"=>$this->params['pass'][0])));//DELETE
			$projectD = $this->Project->find('count',array("conditions"=>array("Project.ClientID"=>$this->params['pass'][0])));//DELETE
			if($client_contactsD == 0 && $projectD == 0){
				$this->set("delete",0);
			}else{
				$this->set("delete",1);
			}
			
			$this->set("ClientID",$this->params['pass']['0']);
 			$this->set("Client_Contact",$this->ClientContacts->find('all',array('conditions'=>array("ClientContacts.ClientID"=>$this->Client->id))));
			$this->data=$this->Client->read();
			$this->set("title_for_layout","Update Client");
		}else{
			//$this->Session->write("Client.ID","");
			$this->set("title_for_layout","Add New Client");
		}

		$this->set("clientNamelist",$this->Client->find("list",array("fields"=>array("ID","Name"),"order"=>array("Name"))));
			
	}

	public function delete($id){
		$this->autoRender=false;
		if($id > 0){
			try{
				if($this->Client->delete($id)){
					$this->Session->setFlash(Configure::read("Client.deleteSuccess"));
				}else{
					$this->Session->setFlash(Configure::read("Client.deleteFailure"));
				}
			}catch(Exception $e){
				$this->Session->setFlash(Configure::read("Client.deleteFailure"),'failure');
			}
			$this->redirect(array("controller"=>"Client","action"=>"index"));
		}
	}

	public function addclientcontact(){
		$this->autoRender=false;
		if(isset($this->data['ClientContacts']['ContactName'])){
			try{
				$newclientcontact = $this->data;
				$clientId = $newclientcontact['ClientContacts']['ClientID'];
				if(!empty($newclientcontact['ClientContacts']['ID'])){
					$newclientcontact['ClientContacts']['ModifiedBy']=$this->Session->read("userId");
					$this->ClientContacts->save($newclientcontact);
					$this->Session->setFlash(Configure::read("Client.updateClientContact"));
					$this->redirect(array("controller"=>"Client","action"=>"index/".$clientId ));
				}else{
					$newclientcontact['ClientContacts']['InsertedBy']=$this->Session->read("userId");
					//pr($newclientcontact);die;
					$this->ClientContacts->save($newclientcontact);
					$this->Session->setFlash(Configure::read("Client.addClientContact"));
					$this->redirect(array("controller"=>"Client","action"=>"index/".$clientId));
				}
			}catch (Exception $e){
				$this->Session->setFlash(Configure::read("Client.addClientContactFailure"),'failure');
				$this->redirect(array("controller"=>"Client","action"=>"index/".$clientId ));
			}
		}
	}

	public function checkcode() {
		$this->autoRender=false;
		if($this->params->query['ClientCode']){
			$id=$this->Client->field("ID",array("ClientCode"=>$this->params->query['ClientCode']));
			if($id > 0){
				return "false";
			}else{
				return "true";
			}
			exit;
		}
	}

	public function getProject(){
		$this->layout="ajax";
		if(isset($this->data['PositionId'])){
			if($this->data['PositionId']){
				$projectList=$this->Project->find("list",array("conditions"=>array("ClientID"=>$this->data['PositionId']),"fields"=>array("ID","project_code_name"),"order"=>array("Name","Code")));
				$this->set("projectList",$projectList);
			}
		}
		
		if(isset($this->data['getRoleId'])){
			if($this->data['getRoleId']){
				$roleList=$this->Position->find("list",array("conditions"=>array("ProjectID"=>$this->data['getRoleId']),"fields"=>array("Role","Role")));
				//pr($roleList);die;
				$this->set("projectList",$roleList);				
			}
		}
			
		if(isset($this->data['CandidateAssignmentClientId'])){
			if($this->data['CandidateAssignmentClientId']){
				$activePositions = $this->Position->find("all",array("fields"=>array("DISTINCT	Position.ProjectID"),"conditions"=>array("Position.Status"=>array("Open","Potential"))));
				$data = array();$i=0;
				$data["ClientID"] = $this->data['CandidateAssignmentClientId'];
				foreach ($activePositions as $activePosition){
					$data['ID'][$i] =	$activePosition['Position']['ProjectID'];
					$i++;
				}
				
				$projectList=$this->Project->find("list",array("conditions"=>$data,"fields"=>array("ID","project_code_name")));
				$this->set("projectList",$projectList);
			}
		}	
	}

	public function ClientView(){
		if(isset($_GET['id'])){
			$id= $_GET['id'];
			$client_view = $this->Client->find('first',array('conditions'=>array('Client.ID'=>$id)));
			$client_data = json_encode($client_view);
			print_r($client_data);
			die;
		}
	}

	public function ClientContactDetails(){
		if(isset($_GET['id'])){
			$id= $_GET['id'];
			$clientContact = $this->ClientContacts->find('all',array('conditions'=>array("ClientContacts.ClientID"=>$id)));
			$clientContactData = json_encode($clientContact);
			echo $clientContactData;die;
		}

		if(isset($_GET['editid'])){
			$id= $_GET['editid'];
			$clientContact = $this->ClientContacts->find('first',array('conditions'=>array("ClientContacts.ID"=>$id)));
			$clientContactData = json_encode($clientContact);
			echo $clientContactData;die;
		}
	}

	public function deleteClientContact(){
		$this->autoRender=false;
		if(isset($_GET['deleteid'])){
			$id=$_GET['deleteid'];
			$clientContact = $this->ClientContacts->find('first',array('conditions'=>array("ClientContacts.ID"=>$id)));
			$ClientID = $clientContact['ClientContacts']['ClientID'];
			try{
				if($this->ClientContacts->delete($id)){
					$this->Session->setFlash(Configure::read("Client.deleteClientContactSuccess"));
				}else{
					$this->Session->setFlash(Configure::read("Client.deleteClientContactFailure"));
				}
			}catch(Exception $e){
				$this->Session->setFlash(Configure::read("Client.deleteClientContactFailure"),'failure');
			}
			$this->redirect(array("controller"=>"Client","action"=>"index/".$ClientID));
		}
	}
	public function loadCityclient(){
		$this->layout="ajax";
		$country = $this->params['data']['Country'];
		//echo $country;die;
		echo "<pre>";
		//print_r($worklocationList);
		$query = $this->Client->find("list",array("fields"=>array("Client.City","Client.State","Client.Country"),'conditions'=>array("Client.Country"=>$country),"order"=>array("City")));
		//$this->set("clientlocation",$this->Client->find("list",array("fields"=>array("Client.City","Client.State","Client.Country"),"order"=>array("City"))));
		//print_r($query);die;
		
		$cl = array();
		foreach($query as $key=>$value) {
			$cl_country[$key] = $key; 
			foreach($value as $k=>$v){
				$com = $k.",".$v; 
				$cl_city[$com] = $com; 
			}
		}
		$country = array_keys($cl_country);
		foreach($country as $k=>$v) {
			$country_only[$v] = $v; 
		}
		echo "<pre>";
		print_r($cl_city);
		$this->set("clientlocationcity",$cl_city);
		//$this->autoRender = false;
	}
}
?>
