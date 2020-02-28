<?php
class AssignRecruiterController extends AppController {
	var $uses=array("Candidate","Project","Client","Position","User","CandidateAssignment","Work_Location");
	
	public function beforeFilter(){
		parent::beforeFilter();
		if(!$this->Session->read("AdminUser") && !($this->Session->read('ManagerRecruiter'))) { // to check for super admin user
			$this->redirect("/");
		}
	}

	public function index() {
		$this->layout="prf";
		$this->set("title_for_layout","Assign Recruiter entry");
		$this->set("activeClientList",$this->Client->find("list",array("fields"=>array("ID","Name"),"conditions"=>array("Client.Status"=>"Active"), "order"=>array("Name"))));
		$this->set("clientList",$this->Client->find("list",array("fields"=>array("ID","Name"))));
		$this->set("projectList",$this->Project->find("list",array("fields"=>array("id","project_code_name"),"order"=>array("Name","Code"))));
		$positionList = $this->Position->find("list",array("fields"=>array("id","RequisitionNumber")));
		$position_ReqNo = array();
		foreach ($positionList as $key=>$val){
			$position_ReqNo[$key] = substr_replace($val, "-", -3,0);
		}
		$this->set("positionList",$position_ReqNo);
		$this->set("recruiterList",$this->User->find("list",array("fields"=>array("Id","fullName"),"conditions"=>array("RoleId"=>array(5,11),"StatusFlag"=>'Active'), "order" => array("fullName"))));
		$this->set("roleList",$this->Position->find("list",array("fields"=>array("Role","Role"),"conditions"=>array("Position.Status"=>array("Open","Potential")),"order"=>array("Role"))));
		$this->set("worklocationList",$this->Position->find("list",array("fields"=>array("WorkLocation","WorkLocation"),"order"=>array("WorkLocation"))));
		$this->set("worklocationdistinctList",$this->Work_Location->find("list",array("fields"=>array("Location_Name","Location_Name"),"order"=>array("Location_Name"))));
		//ADD NEW
		if(isset($this->data['AssignRecruiter']['RecruiterId'])){
			//pr($this->data);die;
			$id = $this->data['AssignRecruiter']['PositionID'];
			$recruiterId = $this->data['AssignRecruiter']['RecruiterId'];
			$updates = array();
			try{
				$updatedBy = $this->Session->read("userId");
				$updated = date('Y-m-d H:i:s');
				$updates["RecruiterId"] = $recruiterId;
				$updates["ModifiedBy"] = $updatedBy;
				if(!empty($this->data['AssignRecruiter']['SecondaryRecruiterId']))
					$updates["SecondaryRecruiterId"] = $this->data['AssignRecruiter']['SecondaryRecruiterId'];
				else
					$updates["SecondaryRecruiterId"] = null;

				$this->Position->updateAll($updates,array('Position.ID'=>$id));
				//send mail to all recruiters, super users and the user, who created the position
				$content = $this->Position->find('first',array('conditions'=>array("Position.ID"=>$id)));
				$this->Session->setFlash("Recruiter Assigned Successfully");
                $this->sendMailNotification($content);
			}catch(Exception $e){
				$this->Session->setFlash("Email Notification could not be sent. Recruiter Assigned Successfully.",'failure');
			}
			$this->Session->write('assignedcountry', $this->data['AssignRecruiter']['AssignedCountry']);
			$this->redirect(array("controller"=>"AssignRecruiter","action"=>"index"));
		}
		//EDIT
		if(isset($_GET['positionid'])){
			$positionid = $_GET['positionid'];
			$this->set("positionData",$this->Position->find('first',array('conditions'=>array('Position.ID'=>$positionid))));
			$this->set("ConfirmedStatus",$this->CandidateAssignment->find('all',array('conditions'=>array('CandidateAssignment.PositionID'=>$positionid,"CandidateAssignment.AssignmentStatus"=>"Confirmed"))));
			//print_r($positionid);
			$positionInfo = $this->Position->find('first',array('conditions'=>array('Position.ID'=>$positionid)));
			$this->set("positionInformation",$positionInfo);
			//pr($positionInfo);
				
		}
		$conditions = array();
		if(isset($this->data['AssignRecruiterFrm']['Recruiter'])){
			$this->Session->delete('assignedcountry');
			if(!empty($this->data['AssignRecruiterFrm']['Client'])){
				$conditions['Position.ClientID']=$this->data['AssignRecruiterFrm']['Client'];
			}
			if(!empty($this->data['AssignRecruiterFrm']['Project'])){
				$conditions['Position.ProjectID']=$this->data['AssignRecruiterFrm']['Project'];
			}
			if(!empty($this->data['AssignRecruiterFrm']['Role'])){
				$conditions['Role LIKE']="%".$this->data['AssignRecruiterFrm']['Role']."%";
			}
			if(!empty($this->data['AssignRecruiterFrm']['Recruiter'])){
				$conditions["OR"]['Position.RecruiterID']=$this->data['AssignRecruiterFrm']['Recruiter'];
				$conditions["OR"]['Position.SecondaryRecruiterID']=$this->data['AssignRecruiterFrm']['Recruiter'];
			}
			
			if ((!empty($this->data['AssignRecruiterFrm']['WorkLocation_Country']))&&((!empty($this->data['AssignRecruiterFrm']['WorkLocation_City'])))) {
				$conditions['Position.WorkLocation LIKE']="%".$this->data['AssignRecruiterFrm']['WorkLocation_City'].",".$this->data['AssignRecruiterFrm']['WorkLocation_Country'];
			}
			if ((!empty($this->data['AssignRecruiterFrm']['WorkLocation_Country']))&&((empty($this->data['AssignRecruiterFrm']['WorkLocation_City'])))) {
				$conditions['Position.WorkLocation LIKE']="%".$this->data['AssignRecruiterFrm']['WorkLocation_Country'];
			}
		}
		$conditions['Position.Status']=array("Open","Potential");
		//pr($conditions);die;
		$this->set("assignRecruiterList",$this->Position->find("all",array("conditions"=>$conditions,"order"=>array("Client.Name","Project.Name","Project.Code","Position.RequisitionNumber"))));
	}

	public function getPositionDetails(){
		$this->layout="ajax";
		$this->autoRender=false;
		if(isset($_POST['PositionId'])){
			$position_data = $this->Position->find('first',array('conditions'=>array('Position.ID'=>$_POST['PositionId'])));
			$position = json_encode($position_data);
			echo $position;die;
		}
	}

	public function sendMailNotification($content){
		$this->autoRender=false;		
		$roles = array(3,5,11);
		$userData = $this->User->find("all",array("conditions"=>array("User.RoleId"=> $roles,"User.StatusFlag"=>'Active')));		
		$mailIds = array();$i=0;
		foreach ($userData as $mail){
			$mailIds[$i++] = $mail['User']['Email'];
		}
		$curUserData = $this->User->find('list',array("fields"=>array("ID","Email"),"conditions"=>array("User.ID"=> $content['Position']['InsertedBy'],"User.StatusFlag"=>'Active')));
		array_push($mailIds, $curUserData[$content['Position']['InsertedBy']]);
		$mailIds = array_unique($mailIds);
		$primaryRecruiterId = $content['Position']['RecruiterId'];
		$secondaryRecruiterId = $content['Position']['SecondaryRecruiterId'];
		$primaryRecruiter = $this->User->find('list',array("fields"=>array("ID","fullName",),"conditions"=>array("User.ID"=> $primaryRecruiterId,"User.StatusFlag"=>'Active')));		
		if ($secondaryRecruiterId) {
			$secondaryRecruiter = $this->User->find('list',array("fields"=>array("ID","fullName",),"conditions"=>array("User.ID"=>$secondaryRecruiterId,"User.StatusFlag"=>'Active')));
		}

		$content_data = array();
		$content_data['client'] = $content['Client']['Name'];
		$content_data['project'] = $content['Project']['Name'];
		$content_data['role'] = $content['Position']['Role'];
		$content_data['requistion_no'] = $content['Position']['RequisitionNumber'];
		$content_data['primary_recruiter'] = $primaryRecruiter[$primaryRecruiterId];
		$content_data['secondary_recruiter'] = !empty($secondaryRecruiter) ? $secondaryRecruiter[$secondaryRecruiterId] : '';
		try{
			App::uses('CakeEmail', 'Network/Email');
			$email = new CakeEmail('smtp');
			$email->subject("A new recruiter has been assigned for the Position.");
			$email->from(array('no-reply@encoress.com' => 'ENCORE'));
			$email->to($mailIds);
			$email->emailFormat('html');
			$email->viewVars(array('title_for_layout'=>"New Position Creation"));
			$email->viewVars(array('content_data'=>$content_data));
			$email->template('assignrecruiter');
			$email->send();
			$this->Session->setFlash("Recruiter assigned successfully");
        }catch(Exception $e){

		}
	}
	
	public function loadCity(){
		$this->layout="ajax";
		$country = $this->params['data']['Country'];
		$query = $this->Position->find("list",array("fields"=>array("WorkLocation","WorkLocation"),'conditions'=>array("Position.WorkLocation LIKE"=>"%".$country),"order"=>array("WorkLocation")));
		foreach($query as $id=>$val){
			$split = explode(',',$val);
			if(($split[2]=="")&&($split[1]!="")) {
				$ss = $split[1];
				$cc = $split[0];
			}
			else if(($split[2]=="")&&($split[1]=="")) {
				$ss = $split[0];
	
			}
			else {
				$ss = $split[2];
				$cc = $split[0].','.$split[1];
			}
			$country_city[$cc] = $cc;
		}
		$country = array_keys($country_city);
		foreach($country as $k=>$v) {
			$country_only[$v] = $v;
		}
		$this->set("worklocationcity",$country_city);
	}

}
?>
