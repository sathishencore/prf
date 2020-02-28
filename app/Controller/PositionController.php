<?php
class PositionController extends AppController {
	var $uses=array("Client","User","Position","Project","ClientContacts","CandidateAssignment","Work_Location","DistributionList","Skill","ProjectRole","PositionSkill");


	public function index() {
		$this->layout="prf";
		$editSave = 0;
		if ($this->Session->check("PositionFrmIndexForm.EditSave"))
			$editSave = 1;
		$this->set("skills",$this->Skill->find("list",array("fields"=>array("ID","Name"))));
		$roles = $this->ProjectRole->find("list",array("fields"=>array("id","role")));
		$this->set("roles",$roles);
		$this->set('core_skill',null);
			$this->set('essential_skill',null);
			$this->set('desirable_skill',null);
		if(isset($this->data['Position']['ClientID'])){
			$positionData= $this->data;	
			$positionData['Position']['StartDate']=$positionData['Position']['StartDate1'];
			$positionData['Position']['EndDate']=$positionData['Position']['EndDate1'];			
			$positionData['Position']['SalaryFt'] = str_replace(',', '', $positionData['Position']['SalaryFt']);
			$positionData['Position']['SalaryHourly'] = str_replace(',', '', $positionData['Position']['SalaryHourly']);
			$positionData['Position']['CorpToCorp'] = str_replace(',', '', $positionData['Position']['CorpToCorp']);			
			$positionData['Position']['BackgroundCheckRequired'] = isset($positionData['Position']['BackgroundCheckRequired']) ? "Yes":"No";			
			$positionData['Position']['USBased'] = isset($positionData['Position']['USBased']) ? "Yes":"No";
			$positionData['Position']['OffShoreOffshore'] = isset($positionData['Position']['OffShoreOffshore']) ? "Yes":"No";
			$positionData['Position']['OffShoreOnsite'] = isset($positionData['Position']['OffShoreOnsite']) ? "Yes":"No";
			$positionData['Position']['NewHireFullTime'] = isset($positionData['Position']['NewHireFullTime']) ? "Yes":"No";
			$positionData['Position']['ProjectHire'] = isset($positionData['Position']['ProjectHire']) ? "Yes":"No";
			$positionData['Position']['SubContractor'] = isset($positionData['Position']['SubContractor']) ? "Yes":"No";
			$positionData['Position']['ContractToHire'] = isset($positionData['Position']['ContractToHire']) ? "Yes":"No";
			$positionData['Position']['NoPreference'] = isset($positionData['Position']['NoPreference']) ? "Yes":"No";
			$positionData['Position']['DirectHireByClient'] = isset($positionData['Position']['DirectHireByClient']) ? "Yes":"No";
			
			$skillTitle = $skillName = $desirableSkillTitle  =NULL;
			$status = $this->data['Position']['Status'];
			if(strtolower($status) == "hold"){
				$positionData['Position']['created']  =  date("Y-m-d H:i:s");
			}
		
			
			$CoreSkill =  $this->data['Position']['CoreSkills'] ? explode(" ", $this->data['Position']['CoreSkills']) :'';
			$EssentialSkills = $this->data['Position']['EssentialSkills'] ? $this->data['Position']['EssentialSkills']:'';
			$DesirableSkills = $this->data['Position']['DesirableSkills'] ? $this->data['Position']['DesirableSkills']:'';
			$positionData['CoreSkill'] = $CoreSkill;
			$positionData['EssentialSkills'] = $EssentialSkills;
		    $positionData['DesirableSkills'] = $DesirableSkills;
			
			if(isset($this->params['pass'][0])){
				
				$dataCopy = $this->Session->read("positionCopy");
				if(!empty($dataCopy)){
					$positionData['Position']['ID']="";
					$this->newPositionSave($positionData);					
				}else{
					$positionData['Position']['ID']=$this->params['pass'][0];
					$positionData['Position']['ModifiedBy']=$this->Session->read("userId");					
					$this->Session->setFlash(Configure::read("Position.updateSuccess"));
					unset($positionData['Position']['DesirableSkills']);
                    unset($positionData['Position']['EssentialSkills']);
                    $this->Position->saveAll($positionData);
						 if($CoreSkill){
							$delete_Ids = $this->PositionSkill->find("all",array('conditions' => ['PositionSkill.type' => 'core_skill','PositionSkill.position_id' => $this->params['pass'][0]] ,'fields'=>'id'));
								if($delete_Ids){
									foreach($delete_Ids as $ids){
										$id = $ids['PositionSkill']['id'];
										$this->PositionSkill->delete($id);
									}
								}
							foreach($CoreSkill as $core){
								$skill['position_id'] = $this->params['pass'][0];
								$skill['skill_id'] = 	$core;
								$skill['type'] = 'core_skill';
								$skillDetails = $this->PositionSkill->find("all",array('conditions' => ['PositionSkill.skill_id = ' => $core,	'PositionSkill.type' => 'core_skill','PositionSkill.position_id' => $this->params['pass'][0]])); 
								if(count($skillDetails) == 0){
									$this->PositionSkill->saveAll($skill);	
								}
							}
						}
						if($EssentialSkills){
							$delete_Ids = $this->PositionSkill->find("all",array('conditions' => ['PositionSkill.type' => 'essential_skill','PositionSkill.position_id' => $this->params['pass'][0]] ,'fields'=>'id'));
								if($delete_Ids){
									foreach($delete_Ids as $ids){
										$id = $ids['PositionSkill']['id'];
										$this->PositionSkill->delete($id);
									}
								}
							
							foreach($EssentialSkills as $essential_skill){
							
								$essential['position_id'] = $this->params['pass'][0];
								$essential['skill_id'] = 	$essential_skill;
								$essential['type'] = 'essential_skill';

								$skillDetails = $this->PositionSkill->find("all",array('conditions' => ['PositionSkill.skill_id = ' => $essential_skill,'PositionSkill.type' => 'essential_skill','PositionSkill.position_id' => $this->params['pass'][0]]));
								if(count($skillDetails) == 0){
									$this->PositionSkill->saveAll($essential);
								}
							}
						}
						if($DesirableSkills){
							$delete_Ids = $this->PositionSkill->find("all",array('conditions' => ['PositionSkill.type' => 'desirable_skill','PositionSkill.position_id' => $this->params['pass'][0]] ,'fields'=>'id'));
								if($delete_Ids){
									foreach($delete_Ids as $ids){
										$id = $ids['PositionSkill']['id'];
										$this->PositionSkill->delete($id);
									}
								}
							foreach($DesirableSkills as $desirable_skill){
								$desirable['position_id'] = $this->params['pass'][0];
								$desirable['skill_id'] = 	$desirable_skill;
								$desirable['type'] = 'desirable_skill';
								 $skillDetails = $this->PositionSkill->find("all",array('conditions' => ['PositionSkill.skill_id = ' => $desirable_skill,'PositionSkill.type' => 'desirable_skill','PositionSkill.position_id' => $this->params['pass'][0]])); 
										if(count($skillDetails) == 0){
												$this->PositionSkill->saveAll($desirable);
										}
							}
						} 
				}
			}else{
				$this->newPositionSave($positionData);
			}
			$this->redirect(array("controller"=>"Position","action"=>"index"));
		}
		
		if(isset($this->params['pass'][0])){
			$this->Position->id = $this->params['pass']['0'];
			$position_id = $this->params['pass']['0'];
			$position_skill = $this->PositionSkill->find('all', array(
				'conditions' => array('PositionSkill.position_id' => $this->Position->id)
			));
			$core_skill = array(); $essential_skill = array();$desirable_skill = array();
			$core_id = array();	$essential_id = array();	$desirable_id = array();
			if($position_skill){
				foreach($position_skill as $skillValues){
					if($skillValues['PositionSkill']['type'] == 'core_skill'){
							$core_skill_id = $skillValues['Skill']['ID'];
							$core_id[] = $core_skill_id;
					}
					if($skillValues['PositionSkill']['type'] == 'essential_skill'){
							$essential_skill_id = $skillValues['Skill']['ID'];
							$essential_id[] = $essential_skill_id;	
					}
					if($skillValues['PositionSkill']['type'] == 'desirable_skill'){
						$desirable_skill_id = $skillValues['Skill']['ID'];
						$desirable_id[] = $desirable_skill_id;	
					}
				}
				
				if($core_id	){
					$core_skill = $this->Skill->find('list', array('fields'=>array("ID","ID"),'conditions' => array('Skill.ID IN'  => $core_id)));
				}
				if($essential_id){
					$essential_skill = $this->Skill->find('list', array('fields'=>array("ID","ID"),'conditions' => array('Skill.ID IN'  => $essential_id)));
				}
				if($desirable_id	){
					$desirable_skill = $this->Skill->find('list', array('fields'=>array("ID","ID"),'conditions' => array('Skill.ID IN'  => $desirable_id)));
				}
			}
			$this->Session->write("PositionIndexForm.core_skill",$core_skill);
			$this->Session->write("PositionIndexForm.essential_skill",$essential_skill);
			$this->Session->write("PositionIndexForm.desirable_skill",$desirable_skill);
			$this->set('core_skill',$core_skill);
			$this->set('essential_skill',$essential_skill);
			$this->set('desirable_skill',$desirable_skill);
			//PRINT_R($essential_skill);DIE;
			$this->set("delete",$this->CandidateAssignment->find('count',array("conditions"=>array("CandidateAssignment.PositionID"=>$position_id))));//DELETE
			$position_data = $this->Position->find("first",array("conditions"=>array("Position.ID"=>$position_id)));
			$this->set("PositionData",$position_data);
			$project = $this->Project->find("first",array("conditions"=>array("Project.ID"=>$position_data['Position']['ProjectID'])));			
			$clientcontacts = $this->ClientContacts->find("list",array("fields"=>array("ID","ContactName"),"conditions" => array("ClientContacts.ClientId" => $project['Project']['ClientID'])));			
			$this->set('ClientContact',$project['ClientContact']['ContactName']);			
			$this->data=$this->Position->read();
			if(isset($this->params['pass']['1']) && !empty($this->params['pass']['1'])){
				$this->set('ClientContacts',$clientcontacts);
				$this->set("title_for_layout","Create Position");
				$this->Session->write("positionCopy","positionCopy");
				$this->set('RequisitionNumber',"");
			}else{
				$this->set("title_for_layout","Update Position");
				$this->Session->write("positionCopy","");
				$this->set('RequisitionNumber',$position_data['Position']['RequisitionNumber']);
			}			
			
			//retain the edited position details
			$this->Session->write("PositionFrmIndexForm.ClientId",$this->data['Position']['ClientID']);
			$this->Session->write("PositionFrmIndexForm.EditSave",1);
		}else{
			$this->Session->delete("PositionFrmIndexForm.EditSave");
			$this->Session->delete("PositionIndexForm.ClientID");
			$this->Session->delete("PositionIndexForm.ProjectName");
			$this->Session->delete("PositionIndexForm.StartDate");
			$this->Session->delete("PositionIndexForm.EndDate");
			if (!$editSave){
				$this->Session->delete("PositionFrmIndexForm.ClientId");
			}
			else {
				 $tmpClient = $this->Client->find("list",array("fields"=>array("Name"),"conditions"=>array("Client.Id" =>$this->Session->read("PositionFrmIndexForm.ClientId"))));				
				$editedClientName = $tmpClient[$this->Session->read("PositionFrmIndexForm.ClientId")];
				$conditions['Client.Name >='] = $editedClientName;
			}

			$this->set("title_for_layout","Create Position");
		}
		$this->set("projectList",$this->Project->find("list",array("fields"=>array("ID","Name"),"order"=>array("Name"))));
		$this->set("projectName",$this->Project->find("list",array("fields"=>array("ID","project_code_name"),"order"=>array("Name","Code"))));
		$this->set("roleList",$this->Position->find("list",array("fields"=>array("Role","Role"),"conditions"=>array("Position.Status"=>"Open"))));
		$this->set("clientList",$this->Client->find("list",array("fields"=>array("ID","Name"),"conditions"=>array("Client.Status"=>"Active"),"order"=>array("Name"))));
		$this->set("allClientList",$this->Client->find("list",array("fields"=>array("ID","Name"),"order"=>array("Name"))));
		$this->set("hiringManagerList",$this->User->find("list",array("fields"=>array("Id","fullName"),"conditions"=>array("RoleId"=>7))));
		$this->set("RecruiterList",$this->User->find("list",array("fields"=>array("Id","fullName"),"conditions"=>array("RoleId"=>array(5,11),"StatusFlag"=>'Active'),"order"=>array("fullName"))));
		$this->set("worklocationList",$this->Position->find("list",array("fields"=>array("WorkLocation","WorkLocation"),"order"=>array("WorkLocation"))));
		$this->set("worklocationdistinctList",$this->Work_Location->find("list",array("fields"=>array("Location_Name","Location_Name"),"order"=>array("Location_Name"))));

		/*if($this->Session->read("roleId")==5){ // to display the positions assigned to the recruiter			
			$conditions["Position.RecruiterId"]=$this->Session->read("userId");
		}else{*/
			
			//$conditions=array();
		//}
		//print '<pre>';print_r($this->data);print '</pre>';
		if(isset($this->data['PositionFrm']['ProjectName'])){
			if(!empty($this->data['PositionFrm']['ClientId'])){
				$conditions['Position.ClientID']=$this->data['PositionFrm']['ClientId'];
				$this->Session->write("PositionIndexForm.ClientID",$this->data['PositionFrm']['ClientId']);
				$this->set("Position.ClientID", $this->data['PositionFrm']['ClientId']);
				$this->set("projectName",$this->Project->find("list",array("fields"=>array("ID","project_code_name"),"conditions"=>array("Project.ClientID"=>$this->data['PositionFrm']['ClientId']), "order"=>array("Name","Code"))));
			}
			if(!empty($this->data['PositionFrm']['ProjectName'])){
				$conditions['Project.ID']= $this->data['PositionFrm']['ProjectName'];
				$this->Session->write("PositionIndexForm.ProjectName",$this->data['PositionFrm']['ProjectName']);
				$this->set("roleList",$this->Position->find("list",array("fields"=>array("Role","Role"),"conditions"=>array("Position.ProjectID"=>$this->data['PositionFrm']['ProjectName']))));
			}
			if(!empty($this->data['PositionFrm']['StartDate'])){
				$this->Session->write("PositionIndexForm.StartDate",$this->data['PositionFrm']['StartDate']);
			}
			if(!empty($this->data['PositionFrm']['EndDate'])){
				$this->Session->write("PositionIndexForm.EndDate",$this->data['PositionFrm']['EndDate']);			
			}
			if(!empty($this->data['PositionFrm']['Role'])){
				$conditions['Role LIKE']="%".$this->data['PositionFrm']['Role']."%";
			}
		
        	if(!empty($this->data['PositionFrm']['Status'])){
	             $conditions['Position.status']=$this->data['PositionFrm']['Status'];
			}
			else{
				$conditions['Position.status'] = "Open";		
				$this->set("openFlag",true);	    
			}	    
		}
		// Criteria search 
		if (!empty($this->data['PositionFrm']['criteria']) && $this->data['PositionFrm']['criteria']) {

			$criteria = strtolower($this->data['PositionFrm']['criteria']);
			if($criteria =='positions overdue'){
				$overdue_case1 = array(
						'datediff( now(),Position.StartDate) > 0 '
				);
				array_push($conditions, $overdue_case1);			
			}
			 if($criteria == 'positions overdue - upto 30 days'){
				 
					 $overdue_case2 = array(
					 'datediff( now(),Position.StartDate) >0 and datediff( now(),Position.StartDate) <= 30'
				);
				array_push($conditions, $overdue_case2);			
			}
			 if($criteria == 'positions overdue - >30 days'){
				 $overdue_case3 = array(
						'datediff( now(),Position.StartDate) > 30 '
				);
				array_push($conditions, $overdue_case3);			
			}
			
			 if($criteria == 'all'){
				$conditions['Position.status'] = "Open";		
				$this->set("openFlag",true);	
			}
			}

		
		//Status search
		if (isset($this->data['PositionFrm']['Status']) && $this->data['PositionFrm']['Status']) {
			$conditions['Position.status'] = $this->data['PositionFrm']['Status'];
		}
		else{
		    $conditions['Position.status'] = "Open";		
			$this->set("openFlag",true);	    
		}

		//Work Location	Search
		/* if ((!empty($this->data['PositionFrm']['WorkLocation_Country']))&&((!empty($this->data['PositionFrm']['WorkLocation_City'])))) {
			$conditions['WorkLocation LIKE']="%".$this->data['PositionFrm']['WorkLocation_City'].",".$this->data['PositionFrm']['WorkLocation_Country']."%";
		}
		if ((!empty($this->data['PositionFrm']['WorkLocation_Country']))&&((empty($this->data['PositionFrm']['WorkLocation_City'])))) {
			$conditions['WorkLocation LIKE']="%".$this->data['PositionFrm']['WorkLocation_Country'];
		} */
		if (!empty($this->data['PositionFrm']['WorkLocation'])) {
			$conditions['WorkLocation LIKE']="%".$this->data['PositionFrm']['WorkLocation'];
		}
		//Primary Recruiter Search
		if (!empty($this->data['PositionFrm']['PrimaryRecruiter'])) {
			$conditions['RecruiterId'] = $this->data['PositionFrm']['PrimaryRecruiter'];
		}

		//Account Manager Search
		if (!empty($this->data['PositionFrm']['AccountManager'])) {
			$data = $this->data['PositionFrm']['AccountManager'];			
			array_push($conditions, "Project.EncoreContact IN ($data)");
		}

		//$this->set("openFlag",true);
		//$conditions['Position.status']='Open';
		//$this->set("positionList",$this->Position->find("all",array("conditions"=>$conditions,"order"=>array("Position.created DESC"))));
		//Account Manager List
		/*$accManager = $this->EncoreContacts->query("SELECT GROUP_CONCAT(Id) as Id,ContactName FROM encore_contacts AS `EncoreContacts` where StatusFlag='Active' GROUP BY ContactName ORDER BY `ContactName` ASC");
		foreach ($accManager as $key => $value) {
			$managerList[$value[0]['Id']] = $value['EncoreContacts']['ContactName'];
		}*/
		$accManager = $this->User->query("SELECT GROUP_CONCAT(Id) as Id,FirstName,LastName FROM users AS `User` where StatusFlag='Active' && (RoleId='1' || RoleId='3') GROUP BY FirstName,LastName ORDER BY `FirstName` ASC ");
		foreach ($accManager as $key => $value) {
			$fullname = $value['User']['FirstName']." ".$value['User']['LastName'];
			$managerList[$value[0]['Id']] = $fullname;
		}
		$this->set("managerList", $managerList);

		if($editSave) {
		$this->set("positionList",$this->Position->find("all",array("conditions"=>$conditions,"order"=>array("Client.Name","Project.Name","Position.RequisitionNumber"))));
		}else{
		$this->set("positionList",$this->Position->find("all",array("conditions"=>$conditions,"order"=>array("RecruiterId","Client.Name","Project.Name","Position.RequisitionNumber"))));	
		}

	}
 	
	public function sendMailNotification($content){
		$this->autoRender=false;
		//send mail to all recruiters, super users and the user, who created the position
		$roles = array(3,5,11);
		$userData = $this->User->find("all",array("conditions"=>array("User.RoleId"=> $roles,"User.StatusFlag"=>'Active')));		
		$mailIds = array();$i=0;
		foreach ($userData as $mail){
			$mailIds[$i++] = $mail['User']['Email'];
		}

		$userData_ind = $this->User->find("all",array("conditions"=>array("User.RoleId"=> $roles,"User.StatusFlag"=>'Active',"TimezoneID"=>'79')));
			$mailIds_ind = array();$i=0;
			foreach ($userData_ind as $mail_ind){
				$mailIds_ind[$i++] = $mail_ind['User']['Email'];
			}
		
		$userData_usa = $this->User->find("all",array("conditions"=>array("User.RoleId"=> $roles,"User.StatusFlag"=>'Active','NOT' => array('TimezoneID' => '79'))));
			$mailIds_usa = array();$i=0;
			foreach ($userData_usa as $mail_usa){
				$mailIds_usa[$i++] = $mail_usa['User']['Email'];
			}
		if(strpos((strtolower($content['Position']['WorkLocation'])),'usa') !== false ) {
			$mailIds = array_unique($mailIds_usa);
			//$email->to($mailIds_usa);
		}else if(strpos((strtolower($content['Position']['WorkLocation'])),'india') !== false ) {
			$mailIds = array_unique($mailIds_ind);
			//$email->to($mailIds_ind);
		}else{
			$mailIds = array_unique($mailIds);
			//$email->to($mailIds);
		}
		$distributionList = $this->DistributionList->find('all',array('fields'=>array('email')));
        foreach($distributionList as $email){
            array_push($mailIds, $email['DistributionList']['email']);
        }
		$curUserData = $this->User->find('list',array("fields"=>array("ID","Email"),"conditions"=>array("User.ID"=> $content['Position']['InsertedBy'],"User.StatusFlag"=>'Active')));
		array_push($mailIds, $curUserData[$content['Position']['InsertedBy']]);
        $mailIds = array_unique($mailIds);
		try{
            App::uses('CakeEmail', 'Network/Email');
            $email = new CakeEmail('smtp');
            $email->subject("A new position is requested for project ".$content['Project']['Name']);
            $email->from(array('no-reply@encoress.com' => 'ENCORE'));

            $email->to($mailIds);
            $email->emailFormat('html');
            $email->viewVars(array('title_for_layout'=>"New Position Creation"));
            $email->viewVars(array('content_data'=>$content));
            $email->template('newposition');
            $email->send();
        }catch(Exception $e){
            $this->Session->setFlash("Email notification Failed. Record updated");
        }
		//$this->Session->setFlash(Configure::read("User.EmailSuccess"));
	} 

	public function delete($id) {
		$this->autoRender=false;
		try{
			$this->Position->delete($id);
			$this->Session->setFlash(Configure::read("Position.deleteSuccess"));
		}catch(Exception $e){
			$this->Session->setFlash(Configure::read("Position.deleteFailure"),'failure');
		}
		$this->redirect(array("controller"=>"Position","action"=>"index"));
	}
	
	public function Copy() {
		if(isset($this->params['pass'][0])){
			$this->Session->setFlash("Position Copied");
			$this->redirect(array("controller"=>"Position","action"=>"index/".$this->params['pass'][0]."/positionCopy"));
		}
	}

	public function getRequest(){
		$this->layout="ajax";
		if(isset($this->data['ProjectId'])){
				$conditions=array();
			if(isset($this->data['ClientId']) && (!empty($this->data['ClientId'])))
				$conditions["ClientID"]=$this->data['ClientId'];			
			if(isset($this->data['ProjectId'])  && (!empty($this->data['ProjectId'])))
				$conditions["ProjectID"]=$this->data['ProjectId'];			
			if($this->Session->read("roleId")==5) // to display the positions assigned to the recruiter					
				$conditions["RecruiterId"]=$this->Session->read("userId");
			pr($conditions);
			$requestList=$this->Position->find("list",array("conditions"=>$conditions,"fields"=>array("ID","RequisitionNumber")));
			$this->set("requestList",$requestList);			
		}
		
		if(isset($this->data['CandidateAssignmentProjectId'])){
			if($this->data['CandidateAssignmentProjectId']){
				$condition = array();
				$condition['ClientID'] = $this->data['CandidateAssignmentClientId'];
				$condition['ProjectID'] = $this->data['CandidateAssignmentProjectId'];
				$condition['Status'] = array("Open","Potential");
				
				$requestList=$this->Position->find("list",array("conditions"=>$condition,"fields"=>array("ID","RequisitionNumber")));
				$position_ReqNo = array();
				foreach ($requestList as $key=>$val){
					$position_ReqNo[$key] = substr_replace($val, "-", -3,0);
				}
				$this->set("requestList",$position_ReqNo);
			}
		}
	}

	public function ProjectDetailsView(){
		$role = '';
		if(isset($_GET['id'])){
			$id= $_GET['id'];
			$Req_No = $_GET['reqno'];
			$project_view = $this->Position->find("first",array("conditions"=>array("Position.RequisitionNumber"=>$Req_No)));
			$role_id =  $project_view['Position']['RoleId'];
			$positionId = $project_view['Position']['ID'];
			if($role_id){
				$role_details = $this->ProjectRole->find("first",array("conditions"=>array("ProjectRole.id"=>$role_id)));
				$role = $role_details ? $role_details['ProjectRole']['role'] : '';
			}
			$position_skill = $this->PositionSkill->find('all', array(
				'conditions' => array('PositionSkill.position_id' => $positionId)
			));
			
			$core_skill = array(); $essential_skill = array();$desirable_skill = array();
			$core_id = array();	$essential_id = array();	$desirable_id = array(); 
			if($position_skill){
				foreach($position_skill as $skillValues){
				
					if($skillValues['PositionSkill']['type'] == 'core_skill'){
							$core_skill_id = $skillValues['PositionSkill']['skill_id'];
							if($core_skill_id){
								$core_skills = $this->Skill->find('all', array('fields'=>array("Name"),'conditions' => array('Skill.ID ='  => $core_skill_id)));
									if($core_skills){
										$core_skill[] = $core_skills[0]['Skill']['Name'] ;
									}
							}
					}
					if($skillValues['PositionSkill']['type'] == 'essential_skill'){
							$essential_skill_id = $skillValues['PositionSkill']['skill_id'];
							if($essential_skill_id){
								$essential_skills = $this->Skill->find('all', array('fields'=>array("Name"),'conditions' => array('Skill.ID ='  => $essential_skill_id)));
									if($essential_skills){
										$essential_skill[] = $essential_skills[0]['Skill']['Name'] ;
									}
							}
							
					}
					if($skillValues['PositionSkill']['type'] == 'desirable_skill'){

						$desirable_skill_id = $skillValues['PositionSkill']['skill_id'];
						if($desirable_skill_id){
								$desirable_skills = $this->Skill->find('all', array('fields'=>array("Name"),'conditions' => array('Skill.ID ='  => $desirable_skill_id)));
									if($desirable_skills){
										$desirable_skill[] = $desirable_skills[0]['Skill']['Name'] ;
									}
							}
					}
				}
			}
			$project_view['Position']['Role']=  $role; 
			$project_view['Position']['CoreSkills']=  $core_skill ? implode(', ', $core_skill) :''; 
			$project_view['Position']['EssentialSkills']=  $essential_skill ? implode(', ', $essential_skill) :''; 
			$project_view['Position']['DesirableSkills']=  $desirable_skill ? implode(', ', $desirable_skill) :''; 
			$project_view['Project']['StartDate']=date(Configure::Read("Date.Format"),strtotime($project_view['Project']['StartDate']));
			if(!empty($project_view['Project']['EndDate']))
				$project_view['Project']['EndDate']=date(Configure::Read("Date.Format"),strtotime($project_view['Project']['EndDate']));
			else
				$project_view['Project']['EndDate']='';
			
			if(empty($project_view['Position']['RecruiterId'])){
				$project_view['User']['FirstName'] = "";
				$project_view['User']['LastName'] = "";
			}
			
			if(empty($project_view['Position']['Priority']))
				$project_view['Position']['Priority'] = "";
			
			if(!empty($project_view['Position']['BillingRate'])) 
					$project_view['Position']['BillingRate'] = number_format($project_view['Position']['BillingRate'], 2, '.', ',');
			 else 
			 	 $project_view['Position']['BillingRate'] =  "";
			 
			 $project_view['Position']['RequisitionNumber'] = substr_replace($project_view['Position']['RequisitionNumber'], "-", -3,0);

			$project_data = json_encode($project_view);
			echo $project_data;
			die;
		}
	}
	
	public function newPositionSave($positionData){
		$RequisitionNumber = '';
		$rows = $this->Position->find("all",array("conditions"=>array("Position.ProjectID"=>$positionData['Position']['ProjectID'])));
			$CoreSkill = $positionData['Position']['CoreSkills'] ? explode(" ", $positionData['Position']['CoreSkills']) :'';
			$EssentialSkills = $positionData['Position']['EssentialSkills'] ;
		     $DesirableSkills = $positionData['Position']['DesirableSkills'] ;

		if(count($rows) > 0 || !empty($rows)){
			$row = $this->Position->find("first",array("conditions"=>array("Position.ProjectID"=>$positionData['Position']['ProjectID']),"order"=>array("Position.RequisitionNumber DESC")));
			$CODE = str_replace($row['Project']['Code'], "", $row['Position']['RequisitionNumber']);
			$RequisitionNumber = $CODE+1;
			if($RequisitionNumber >= 100)
				$RequisitionNumber = $RequisitionNumber;
			else if($RequisitionNumber >= 10)
				$RequisitionNumber = "0".$RequisitionNumber;
			else
				$RequisitionNumber = "00".$RequisitionNumber;
		
			$positionData['Position']['RequisitionNumber']  = $row['Project']['Code'].$RequisitionNumber;
		}else{
			$projectCode = $this->Project->find("first",array("conditions"=>array("Project.ID"=>$positionData['Position']['ProjectID'])));
			$RequisitionNumber = $projectCode['Project']['Code']."001";
			$positionData['Position']['RequisitionNumber'] = $RequisitionNumber;
		}
		//$RequisitionNumber = substr_replace($RequisitionNumber, "-", 6,0);
		$positionData['Position']['InsertedBy']=$this->Session->read("userId");
		unset($positionData['Position']['EssentialSkills']);
		unset( $positionData['Position']['DesirableSkills']);
		$this->Position->save($positionData);
		if($this->Position->save($positionData)){
			$lastId = $this->Position->getLastInsertId();
			$content = $this->Position->find('first',array('conditions'=>array("Position.ID"=>$lastId)));
			//$skill = array();$essential = array();$desirable = array();
				if($lastId){
							if($CoreSkill){
								foreach($CoreSkill as $core){
										$skill['position_id'] = $lastId;
										$skill['skill_id'] = 	$core;
										$skill['type'] = 'core_skill';
										$this->PositionSkill->saveAll($skill);												
								}
								
							}if($EssentialSkills){
								
								foreach($EssentialSkills as $essential_skill){
									$essential['position_id'] = $lastId;
									$essential['skill_id'] = 	$essential_skill;
									$essential['type'] = 'essential_skill';
									$this->PositionSkill->saveAll($essential);
								
								}
							}
							if($DesirableSkills){
								foreach($DesirableSkills as $desirable_skill){
									$desirable['position_id'] = $lastId;
									$desirable['skill_id'] = 	$desirable_skill;
									$desirable['type'] = 'desirable_skill';
									$this->PositionSkill->saveAll($desirable);
								}
							}
				}
				$this->sendMailNotification($content);
				$this->Session->setFlash(Configure::read("Position.createSuccess") ." with the requisition number :".substr_replace( $positionData['Position']['RequisitionNumber'], "-", -3,0));
				$this->Session->delete("positionCopy");
		}
			
	}
	
	public function add_location(){
		$nn = $this->params;
		$city = $this->params['data']['City'];
		$state = $this->params['data']['State'];
		$country = $this->params['data']['Country'];
		
		$work_loc['Work_Location']['Location_Name'] = $city.",".$state.",".$country;
		$this->Work_Location->save($work_loc);
		echo "success";
		die;
		//$this->Session->setFlash("Created a New Location");
		//$this->redirect(array("controller"=>"Position","action"=>"index"));
	}
	public function workLoc(){
		
		$this->layout="ajax";
		$worklocationdistinctList = $this->Work_Location->find("list",array("fields"=>array("Location_Name","Location_Name"),"order"=>array("Location_Name")));
		$this->set("worklocationdistinctList",$worklocationdistinctList);
		
		//echo "<pre>";
		//print_r($worklocationdistinctList);
		//die;
		//echo json_encode($wl);
		//die;
		//$this->autoRender=false;
	}
	public function loadCity(){
		$this->layout="ajax";
		$country = $this->params['data']['Country'];
		//echo $country;die;
		echo "<pre>";
		//print_r($worklocationList);
		$query = $this->Position->find("list",array("fields"=>array("WorkLocation","WorkLocation"),'conditions'=>array("Position.WorkLocation LIKE"=>"%".$country),"order"=>array("WorkLocation")));
	//print_r($query);die;
		foreach($query as $id=>$val){
			$split = explode(',',$val);
			//print_r($split);
			//echo $split[0].'/'.$split[1].'/'.$split[2]."<br>";
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
			//$country[]=$ss;
			$country_city[$cc] = $cc;
		}
		$country = array_keys($country_city);
		foreach($country as $k=>$v) {
			$country_only[$v] = $v;
		}
		//print_r($country_city);
		$this->set("worklocationcity",$country_city);
		//$this->autoRender = false;
	}
}
?>
