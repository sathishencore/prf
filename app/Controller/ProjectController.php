<?php
class ProjectController extends AppController {
	var $uses=array("Project","Client","User","ClientContacts","Position");
	public $helpers=array("Time");
	
	public function index() {
		$this->layout="prf";
		$this->set("projectName",$this->Project->find("list",array("fields"=>array("ID","project_code_name"),"order"=>array("Project.Name","Project.Code"))));
		$this->set("clientlocation",$this->Client->find("list",array("fields"=>array("Client.City","Client.State","Client.Country"),"order"=>array("City"))));
		if(isset($this->data['Project']['Name'])){
			$projectData=$this->data;
			$projectData['Project']['StartDate']=$projectData['Project']['StartDate1'];
			$projectData['Project']['EndDate']=$projectData['Project']['EndDate1'];
			if(isset($this->params['pass'][0])){				
				$projectData['Project']['ID']=$this->params['pass'][0];
				$projectData['Project']['ModifiedBy']=$this->Session->read("userId");
				try{
					$this->Project->save($projectData);
					$this->Session->setFlash(Configure::read("Project.updateSuccess"));
				}catch(Exception $e){
					$this->Session->setFlash(Configure::read("Project.updateFailure"),'failure');
				}				
			}else{
				if($this->Project->find("count",array("conditions"=>array("Code"=>$projectData['Project']['Code'])))){
					$clientCode=$this->Client->field("ClientCode",array("Client.ID"=>$projectData['Project']['ClientID']));
					$projectData['Project']['Code']=$this->getCode($projectData['Project']['ClientID'],$clientCode,true);
				}
				$projectData['Project']['InsertedBy']=$this->Session->read("userId");
				try{
					$this->Project->save($projectData);
					$this->Session->setFlash(Configure::read("Project.createSuccess"));
				}catch(Exception $e){
					$this->Session->setFlash(Configure::read("Project.updateFailure"),'failure');
				}				
			}			
			$this->redirect(array("controller"=>"Project","action"=>"index"));
		}
		if(isset($this->params['pass'][0])){			
			$this->Project->id=$this->params['pass']['0'];
			$this->set("delete",$this->Position->find('count',array("conditions"=>array("Position.ProjectID"=>$this->params['pass']['0']))));//DELETE
			$projectData = $this->Project->find('first',array("conditions"=>array("Project.ID"=>$this->params['pass']['0'])));
			$this->set("clientContactList",$this->ClientContacts->find("list",array("fields"=>array("Id","ContactName"),"conditions"=>array("ClientContacts.ClientID"=>$projectData['Project']['ClientID']))));
			$this->data=$this->Project->read();
			$this->set("title_for_layout","Update Project");
		}else{			
			$this->set("title_for_layout","Create New Project");
			$this->set("clientContactList",$this->ClientContacts->find("list",array("fields"=>array("Id","ContactName"))));
		} 
		
		$this->set("clientList",$this->Client->find("list",array("fields"=>array("ID","Name"),"conditions"=>array("Status"=>"Active"),"order"=>array("Name"))));
		$this->set("allClientList",$this->Client->find("list",array("fields"=>array("ID","Name"),"order"=>array("Name"))));
		$this->set("encoreContactList",$this->User->find("list",array("fields"=>array("ID","fullName"),"conditions"=>array("StatusFlag"=>'Active',"RoleId"=>array('1','3')))));
		//$this->set("clientContactList",$this->ClientContacts->find("list",array("fields"=>array("Id","ContactName"))));
		$this->set("projectManagerList",$this->User->find("list",array("fields"=>array("Id","fullName"),"conditions"=>array("RoleId"=>4))));
		
		//SEARCH
		$conditions=array();
		//pr($this->data);die;
		if(isset($this->data['ProjectFrm']['ClientId'])&&($this->data['ProjectFrm']['ClientId']!="")){
			
			
			if(!empty($this->data['ProjectFrm']['ClientId'])){
				$conditions['Project.ClientID']=$this->data['ProjectFrm']['ClientId'];
				$this->set("projectName",$this->Project->find("list",array("fields"=>array("ID","project_code_name"),"conditions"=>array("Project.ClientID"=>$this->data['ProjectFrm']['ClientId']), "order"=>array("Project.Name","Project.Code"))));
			}
			if((!empty($this->data['ProjectFrm']['ClientCountry']))&&(empty($this->data['ProjectFrm']['ClientCity']))){
				$clients = $this->Client->find("list",array("fields"=>array("ID","Country"),"conditions"=>array("ID"=>$this->data['ProjectFrm']['ClientId'],"Country"=>$this->data['ProjectFrm']['ClientCountry']),"order"=>array("Name")));
				$c = array_keys($clients);
				$conditions['Project.ClientID']=$c;
			}
			if((!empty($this->data['ProjectFrm']['ClientCountry']))&&(!empty($this->data['ProjectFrm']['ClientCity']))){
				$cs = explode(",",$this->data['ProjectFrm']['ClientCity']);
				$clients = $this->Client->find("list",array("fields"=>array("ID","Country"),"conditions"=>array("ID"=>$this->data['ProjectFrm']['ClientId'],"Country"=>$this->data['ProjectFrm']['ClientCountry'],"City"=>$cs[0],"State"=>$cs[1]),"order"=>array("Name")));
				$c = array_keys($clients);
				$conditions['Project.ClientID']=$c;
			}
			if(!empty($this->data['ProjectFrm']['ProjectName'])){
				$conditions['Project.ID']=$this->data['ProjectFrm']['ProjectName'];		
			}			
			$this->set("Clcountry",$this->data['ProjectFrm']['ClientCountry']);
			$this->set("Clcity",$this->data['ProjectFrm']['ClientCity']);
			$this->set("projectList",$this->Project->find("all",array("conditions"=>$conditions, "order"=>array("project_code_name"))));
		}
		else{
			
			if((!empty($this->data['ProjectFrm']['ClientCountry']))&&(empty($this->data['ProjectFrm']['ClientCity']))){
				$clients = $this->Client->find("list",array("fields"=>array("ID","Country"),"conditions"=>array("Country"=>$this->data['ProjectFrm']['ClientCountry']),"order"=>array("Name")));
				$c = array_keys($clients);
				$conditions['Project.ClientID']=$c;
			}
			if((!empty($this->data['ProjectFrm']['ClientCountry']))&&(!empty($this->data['ProjectFrm']['ClientCity']))){
				$cs = explode(",",$this->data['ProjectFrm']['ClientCity']);
				$clients = $this->Client->find("list",array("fields"=>array("ID","Country"),"conditions"=>array("Country"=>$this->data['ProjectFrm']['ClientCountry'],"City"=>$cs[0],"State"=>$cs[1]),"order"=>array("Name")));
				$c = array_keys($clients);
				$conditions['Project.ClientID']=$c;
			}
			$this->set("Clcountry",isset($this->data['ProjectFrm']['ClientCountry'])?$this->data['ProjectFrm']['ClientCountry']:'');
			$this->set("Clcity",isset($this->data['ProjectFrm']['ClientCity'])?$this->data['ProjectFrm']['ClientCity']:'');
			$this->set("projectList",$this->Project->find("all",array("conditions"=>$conditions, "order"=>array("project_code_name"))));
		}			
	}
	
	public function delete($id) {
		$this->autoRender=false;
		try{
			$this->Project->delete($id);
			$this->Session->setFlash(Configure::read("Project.deleteSuccess"));
		}catch(Exception $e){
			$this->Session->setFlash(Configure::read("Project.deleteFailure"),'failure');
		}
		$this->redirect(array("controller"=>"Project","action"=>"index"));
	}
	
	public function checkCode() {
		$this->autoRender=false;
		if($this->params->data['ClientId']){
			$clientCode=$this->Client->field("ClientCode",array("Client.ID"=>$this->params->data['ClientId']));
			echo $this->getCode($this->params->data['ClientId'],$clientCode);
		}
	}

	public function getCode($clientID,$clientCode,$return = false){
		$this->autoRender=false;
		$project=array();
		$project["contactList"] = $this->ClientContacts->find("list",array("fields"=>array("ID","ContactName"),"conditions"=>array("ClientContacts.ClientID"=>$clientID)));
		$projectExiCode= $this->Project->find("first",array("conditions"=>array("Project.ClientID"=>$clientID),"order"=>array("Project.Code DESC")));
		if(!empty($projectExiCode)){
		$codeNo = str_replace($clientCode, '', $projectExiCode['Project']['Code']);
		$codeNo = $codeNo+1;
			if($codeNo >= 100){
				$project["Code"] = $clientCode.$codeNo;
			}elseif($codeNo >= 10){
				$project["Code"] = $clientCode."0".$codeNo;
			}else{
				$project["Code"] = $clientCode."00".$codeNo;
			}
		}else{
			$project["Code"] = $clientCode."001";
		}
		$jsonEncode = json_encode($project);
		if($return){
			return $project["Code"];
		}
		echo $jsonEncode;
		die;
	}
	
	public function ProjectDetailsView(){
		if(isset($_GET['id'])){
			$id= $_GET['id'];
			$project_view = $this->Project->find('first',array('conditions'=>array('Project.ID'=>$id)));
			$client_name = $this->Client->find('first',array('conditions'=>array('Client.ID'=>$project_view['Project']['ClientID'])));
			
			$project_view['Project']['ClientName']=$client_name['Client']['Name'];
			$project_view['Project']['StartDate']=date(Configure::Read("Date.Format"),strtotime($project_view['Project']['StartDate']));
			if(!empty($project_view['Project']['EndDate']))
				$project_view['Project']['EndDate']=date(Configure::Read("Date.Format"),strtotime($project_view['Project']['EndDate']));
			else 
				$project_view['Project']['EndDate']='';
			
			$project_data = json_encode($project_view);
			print_r($project_data);
			die;
		}
	}
	
	public function getHiringManager(){
		$this->layout="ajax";
		if(isset($this->data['ProjectId'])){
			if($this->data['ProjectId']){
				$project = $this->Project->find("first",array("conditions"=>array("Project.ID"=>$this->data['ProjectId'])));
				$project_data['name'] = $project['ClientContact']['ContactName'];
				$project_data['id'] = $project['ClientContact']['ID'];
				$project_data['startdate'] = $project['Project']['StartDate'];
				$project_data['enddate'] = $project['Project']['EndDate'];
				$data = json_encode($project_data);
				echo $data;die;
			}
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
