<?php
class CandidateAssignmentController extends AppController {
	var $uses=array("Candidate","Project","Client","Position","User","CandidateAssignment","CandidateAssignmentLogs","ClientContacts");

	public function index() {
		$this->layout="prf";
		$this->set("title_for_layout","Candidate Assignment entry");
		//$this->set("candidateList",$this->Candidate->find("all",array("conditions"=>array("Candidate.Status"=>"Available"))));
		$activePositions = $this->Position->find("all",array("fields"=>array("DISTINCT	Position.ClientID"),"conditions"=>array("Position.Status"=>array("Open","Potential"))));
		$data = array();$i=0;
		foreach ($activePositions as $activePosition){
			$data['ID'][$i] =	$activePosition['Position']['ClientID'];
			$i++;
		}
		$this->set("clientList",$this->Client->find("list",array("fields"=>array("ID","Name"),"conditions"=>$data,"order"=>array("Name"))));
		$this->set("projectList","");
		//Recruiter Unassigned Position List
		$candidateAssignmentPosition = $this->CandidateAssignment->find("list",array("fields"=>array("CandidateAssignment.PositionID","CandidateAssignment.PositionID")));
		$unassignedPositions = $this->Position->find("all",array("conditions"=>array("Position.Status"=>array("Open","Potential"),"NOT"=>array("Position.ID"=>$candidateAssignmentPosition)),"order"=>array("Position.RequisitionNumber DESC")));
		$this->set("unassignedPositionList",$unassignedPositions);
		
		$this->set("positionList","");
		$this->set("roleList",$this->Candidate->find("list",array("fields"=>array("Role","Role"))));

		if(isset($_GET['positionid'])){
			$positionid = $_GET['positionid'];
			$this->set("positionId",$positionid);
				
			$this->set("clientContactList",$this->ClientContacts->find("list",array("fields"=>array("Id","ContactName"))));
			$candidateAssignment = $this->CandidateAssignment->find("all",array("conditions"=>array("CandidateAssignment.PositionID"=>$positionid)));
			$candidates=array();			
			foreach($candidateAssignment as $candidateVal){
				$candidates[]=$candidateVal['CandidateAssignment']['CandidateID'];
			}
			$this->search($candidates);
			$this->set("candidateAssignmentList",$candidateAssignment);
				
			$position_data = $this->Position->find('first',array('conditions'=>array('Position.ID'=>$positionid)));
			$this->set("positionData",$position_data);
			//projectList
			$activePosition = $this->Position->find("all",array("fields"=>array("DISTINCT	Position.ProjectID"),"conditions"=>array("Position.Status"=>array("Open","Potential"))));
			$data = array();$i=0;
			$data["ClientID"] = $position_data['Position']['ClientID'];
			foreach ($activePosition as $Position){
				$data['ID'][$i] =	$Position['Position']['ProjectID'];
				$i++;
			}
			$this->set("projectList",$this->Project->find("list",array("fields"=>array("id","project_code_name"),"conditions"=>$data)));
			
			$PositionConditions=array();
								
				$PositionConditions['Position.ProjectID']=$position_data['Position']['ProjectID'];
				$PositionConditions["Position.Status"]=array("Open","Potential");
			
			$positionList = $this->Position->find("list",array("fields"=>array("id","RequisitionNumber"),"conditions"=>$PositionConditions));
			$position_ReqNo = array();
			foreach ($positionList as $key=>$val){
				$position_ReqNo[$key] = substr_replace($val, "-", -3,0);
			}
			$this->set("positionList",$position_ReqNo);
			
			
			$this->set("ConfirmedStatus",$this->CandidateAssignment->find('all',array('conditions'=>array('CandidateAssignment.PositionID'=>$positionid,"CandidateAssignment.AssignmentStatus"=>"Confirmed"))));
			$this->set("AssignedStatus",$this->CandidateAssignment->find('all',array('conditions'=>array('CandidateAssignment.PositionID'=>$positionid,"CandidateAssignment.AssignmentStatus"=>"Assigned"))));
			$this->set("SubmittedStatus",$this->CandidateAssignment->find('all',array('conditions'=>array('CandidateAssignment.PositionID'=>$positionid,"CandidateAssignment.AssignmentStatus"=>"Submitted"))));
			$this->set("InterviewScheduledStatus",$this->CandidateAssignment->find('all',array('conditions'=>array('CandidateAssignment.PositionID'=>$positionid,"CandidateAssignment.AssignmentStatus"=>"Interview Scheduled"))));
			$this->set("InterviewDoneStatus",$this->CandidateAssignment->find('all',array('conditions'=>array('CandidateAssignment.PositionID'=>$positionid,"CandidateAssignment.AssignmentStatus"=>"Interview Done"))));
			$this->set("SelectedStatus",$this->CandidateAssignment->find('all',array('conditions'=>array('CandidateAssignment.PositionID'=>$positionid,"CandidateAssignment.AssignmentStatus"=>"Selected"))));
			$this->set("RejectedStatus",$this->CandidateAssignment->find('all',array('conditions'=>array('CandidateAssignment.PositionID'=>$positionid,"CandidateAssignment.AssignmentStatus"=>"Rejected"))));
				
			//ViewCandidateAssignment Status
			if(isset($_GET['candidateid'])){
				$candidateid = $_GET['candidateid'];
				$candidateAssign = $this->CandidateAssignment->find('first',array('conditions'=>array("CandidateAssignment.CandidateID"=>$candidateid,"CandidateAssignment.PositionID"=>$positionid)));
				if(!empty($candidateAssign['CandidateAssignment']['InterviewDate'])){
				$dateformat = explode(" ", $candidateAssign['CandidateAssignment']['InterviewDate']);
				$candidateAssign['CandidateAssignment']['Date'] = $dateformat[0];
				$temptime = DateTime::createFromFormat( 'H:i:s', $dateformat[1]);
				$formatted = $temptime->format( 'h:i A');
				$timeformat = explode(" ", $formatted);
				$candidateAssign['CandidateAssignment']['Time'] = $timeformat[0];
				$candidateAssign['CandidateAssignment']['Session'] = $timeformat[1];
				}else{
					$candidateAssign['CandidateAssignment']['Date'] = '';
					$candidateAssign['CandidateAssignment']['Time'] = '';
					$candidateAssign['CandidateAssignment']['Session'] = '';
				}
				
				$json_data = json_encode($candidateAssign);
				echo $json_data;die;
			}
			//ViewCandidateAssignment Status
				
			//CandidateAssignment Status
			if(isset($this->data['CandidateAssignmentFrm']['AssignmentStatus'])){
				$status = $this->data['CandidateAssignmentFrm']['AssignmentStatus'];
				$in_date = $this->data['CandidateAssignmentFrm']['InterviewDate'];
				$date= null;
				$formatted =null;
				if(!empty($in_date)){
					$in_time = $this->data['CandidateAssignmentFrm']['InterviewTime']." ".$this->data['CandidateAssignmentFrm']['InterviewSession'];
					$temp = DateTime::createFromFormat( 'H:i A', $in_time);
					$formatted = $temp->format( 'H:i:s');
					$date =  "'$in_date $formatted'";
				}
				if(!empty($this->data['CandidateAssignmentFrm']['InterviewLevel']))
					$interviewLevel ="'". $this->data['CandidateAssignmentFrm']['InterviewLevel']."'";
				else 
					$interviewLevel = null;
				
				$notes = $this->data['CandidateAssignmentFrm']['Notes'];
				$candidate_Id =  $this->data['CandidateAssignmentFrm']['CandidateID'];
				
				//Logs START
				$can_ass_Data = $this->CandidateAssignment->find("first",array("conditions"=>array("CandidateAssignment.PositionID"=>$positionid,"CandidateAssignment.CandidateID"=>$candidate_Id)));
				$logs = array();
				try{
				$logs['CandidateAssignmentID']=$can_ass_Data['CandidateAssignment']['ID'];;
				$logs['ExistingStatus']=$can_ass_Data['CandidateAssignment']['AssignmentStatus'];
				$logs['UpdatedStatus']=$status;
				if(!empty($formatted))
					$logs['InterviewDate']=$this->data['CandidateAssignmentFrm']['InterviewDate']." ".$formatted;
				$logs['InterviewLevel']=$this->data['CandidateAssignmentFrm']['InterviewLevel'];
				$logs['ModifiedBy']=$this->Session->read("userId");
				$this->CandidateAssignmentLogs->save($logs);
				//Logs END
				
				$updatedBy = $this->Session->read("userId");
				$this->CandidateAssignment->updateAll(array('CandidateAssignment.AssignmentStatus'=>"'$status'","CandidateAssignment.InterviewLevel"=>$interviewLevel,"CandidateAssignment.ModifiedBy"=>$updatedBy,"CandidateAssignment.InterviewDate"=>$date,"CandidateAssignment.Notes"=>"'$notes'"),array("CandidateAssignment.CandidateID"=>$candidate_Id,"CandidateAssignment.PositionID"=>$positionid));
				$this->Session->setFlash("Candidate status changed successfully");
				}catch(Exception $e){
					$this->Session->setFlash("Some error occured",'failure');
				}
				$this->redirect(array("controller"=>"CandidateAssignment","action"=>"index?positionid=".$positionid));
			}
			//CandidateAssignment Status
				
			//NewAssignCandidate
			if(isset($_GET['assignCandidateID'])){
				$candidateAssignedData['CandidateAssignment']['PositionID'] = $positionid;
				$candidateAssignedData['CandidateAssignment']['CandidateID'] = $_GET['assignCandidateID'];
				$candidateAssignedData['CandidateAssignment']['AssignmentStatus'] = "Assigned";
				$candidateAssignedData['CandidateAssignment']['InsertedBy'] = $this->Session->read("userId");
				$candidate = $this->Candidate->find('first',array("conditions"=>array("Candidate.ID"=>$_GET['assignCandidateID'])));
				$position = $this->Position->find('first',array("conditions"=>array("Position.ID"=>$positionid)));
				$this->CandidateAssignment->save($candidateAssignedData);
				
				$lastId = $this->CandidateAssignment->getLastInsertId();
				$content = $this->CandidateAssignment->find('first',array('conditions'=>array("CandidateAssignment.ID"=>$lastId)));
				$this->sendMailNotification($content);
				$this->Session->setFlash($candidate['Candidate']['FirstName']." ".$candidate['Candidate']['LastName']." assigned to the Requisition number ".substr_replace($position['Position']['RequisitionNumber'], "-", -3,0));
				$this->redirect(array("controller"=>"CandidateAssignment","action"=>"index?positionid=".$positionid));
			}
			//NewAssignCandidate
		}else{
			$this->search("");
		}
		
	}
	
	public function assignmentStatus(){
		if(isset($_GET['assignmentStatus']) && isset($_GET['positionid'])){
			$positionId = $_GET['positionid'];
			$assignmentStatus = $_GET['assignmentStatus'];
			$candidateList = $this->CandidateAssignment->find('all',array("conditions"=>array("CandidateAssignment.PositionID"=>$positionId,"CandidateAssignment.AssignmentStatus"=>$assignmentStatus)));
			$json = json_encode($candidateList);
			echo $json;die;
			echo $assignmentStatus;die;
		}
	}
	
	public function sendMailNotification($content){
		$this->autoRender=false;
		App::uses('CakeEmail', 'Network/Email');
		$positionDetails =  $this->Position->find('first',array('conditions'=>array("Position.ID"=>$content['CandidateAssignment']['PositionID'])));
		$encoreBD = $userEmail = $this->User->find("first",array("conditions"=>array("User.ID"=>$positionDetails['Project']['EncoreContact'],"User.StatusFlag"=>'Active')));
		$candidateDetails =  $this->Candidate->find('first',array('conditions'=>array("Candidate.ID"=>$content['CandidateAssignment']['CandidateID'])));
		$manager = $this->User->find('first',array("conditions"=>array("User.ID"=>$positionDetails['Position']['InsertedBy'],"User.StatusFlag"=>'Active')));
		$toMail = array($manager['User']['Email'],$encoreBD['User']['Email']) ;
		$candidateName = $candidateDetails['Candidate']['FirstName']." ".$candidateDetails['Candidate']['LastName'];
		$fileName = $candidateDetails['Candidate']['ResumeName'];
		$filePath = WWW_ROOT . 'files'."/". $fileName;
		try{
			$email = new CakeEmail('smtp');
			$email->subject("Candidate $candidateName assigned to the position ".substr_replace($positionDetails['Position']['RequisitionNumber'], "-", -3,0));
			$email->from(array('no-reply@encoress.com' => 'ENCORE'));
			$email->to($toMail);
			$email->emailFormat('html');
			if(!empty($fileName) && file_exists($filePath))
				$email->attachments(array($fileName => $filePath));
			$email->viewVars(array('title_for_layout'=>"New Position Creation"));
			$email->viewVars(array('manager'=>$manager));
			$email->viewVars(array('candidate'=>$candidateDetails));
			$email->viewVars(array('position'=>$positionDetails));
			$email->template('candidateassignment');
			$email->send();
        }catch(Exception $e){

		}
		//$this->Session->setFlash(Configure::read("User.EmailSuccess"));
	}
	
	public function search($candidates){
		$conditions = array();
		if(isset($this->data['CandidateAssignmentFrm']['Role'])){
			if(!empty($this->data['CandidateAssignmentFrm']['YOE'])){
				$params=explode("-",$this->data['CandidateAssignmentFrm']['YOE']);
				$conditions['YearsOfExperience >='] =$params[0];
				$conditions['YearsOfExperience <='] =$params[1];
			}
			if(!empty($this->data['CandidateAssignmentFrm']['Role'])){
				$conditions['Role LIKE']="%".$this->data['CandidateAssignmentFrm']['Role']."%";
			}
			if(!empty($this->data['CandidateAssignmentFrm']['Skills'])){
				$conditions["OR"]['PrimarySkills LIKE']="%".$this->data['CandidateAssignmentFrm']['Skills']."%";
				$conditions["OR"]['SecondarySkills LIKE']="%".$this->data['CandidateAssignmentFrm']['Skills']."%";
			}
			if(!empty($this->data['CandidateAssignmentFrm']['ResourceType'])){
				$conditions['CompensationPeriod']=$this->data['CandidateAssignmentFrm']['ResourceType'];
			}
		}
		$conditions['Candidate.Status']="Available";
		if(!empty($candidates))
			$conditions["NOT"]['Candidate.ID'] = $candidates;
		$this->set("candidateList",$this->Candidate->find("all",array("conditions"=>$conditions)));
	}
	
	public function mailTemplate(){
		$this->autoRender=false;
		if(isset($_GET['resumeName'])){
			$resumeName = $_GET['resumeName'];
			$cost = "";
			$CADetails['Candidate'] = $this->Candidate->find("first",array("conditions"=>array("Candidate.ResumeName"=>$resumeName)));
			$CADetails['Position'] = $this->Position->find("first",array("conditions"=>array("Position.ID"=>$_GET['positionId'])));
            $userID = $CADetails['Position']['Project']['EncoreContact'];
            $userEmail = $this->User->find("first",array("conditions"=>array("User.ID"=>$userID)));
			if(empty($CADetails['Candidate']['Candidate']['LeadTimeForInterview']))
				$CADetails['Candidate']['Candidate']['LeadTimeForInterview'] = "";
			
			if(empty($CADetails['Candidate']['Candidate']['LeadTime']))
				$CADetails['Candidate']['Candidate']['LeadTime'] = "";
			
			if(!empty($CADetails['Candidate']['Candidate']['Amount'])){
				if($CADetails['Candidate']['Candidate']['CompensationPeriod'] == "W2 - Salary")
					$cost = (($CADetails['Candidate']['Candidate']['Amount']) * Configure::read("SalaryCalculation.MF")) /Configure::read("SalaryCalculation.HY");
				else if($CADetails['Candidate']['Candidate']['CompensationPeriod'] == "W2 - Hourly")
					$cost = (($CADetails['Candidate']['Candidate']['Amount']) * Configure::read("SalaryCalculation.MF"));
				else
					$cost = $CADetails['Candidate']['Candidate']['Amount'];
			}
			$CADetails['Candidate']['Candidate']['Cost'] = number_format($cost, 2, '.', ',');
			$CADetails['Candidate']['Candidate']['Amount'] = number_format($CADetails['Candidate']['Candidate']['Amount'], 2, '.', ',');
			$CADetails['Candidate']['Candidate']['encoremail'] = $userEmail['User']['Email'];
			echo json_encode($CADetails);die;
		}
	}
	
	public function candidateResumeMail(){
		$this->layout="prf";
		
		if(isset($this->data['MailTemplate']['ToAddress'])){
			$this->autoRender=false;
			$fileName = $this->data['MailTemplate']['resName'];
			$filePath = WWW_ROOT . 'files'."/". $fileName;
			App::uses('CakeEmail', 'Network/Email');
			try{
                $email = new CakeEmail('smtp');
                $email->subject($this->data['MailTemplate']['Subject']);
                $email->from(array('no-reply@encoress.com' => 'ENCORE'));
                $email->to($this->data['MailTemplate']['ToAddress']);
                $email->emailFormat('text');
                $email->attachments(array($fileName => $filePath));
                $email->send($this->data['MailTemplate']['Body']);
                $this->Session->setFlash("Mail sent successfully with resume.");
			}catch(Exception $e){
				$this->Session->setFlash("Mail cannot be sent. SMTP error",'failure');
			}
			$this->redirect(array("controller"=>"CandidateAssignment","action"=>"index?positionid=".$this->data['MailTemplate']['PositionID']));
		}
	}
}
?>
