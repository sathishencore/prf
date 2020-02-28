<?php
class CandidateController extends AppController {
	var $uses=array("Candidate","Project","Client","Position","User","CandidateAssignment");

	public function index() {
		
		 $user = $this->User->find('first',array("conditions"=>$this->Session->read("userId")));
		$timezone = $user['timezone']['Timezone'];
		$test = explode("-", $timezone);
	//	pr(date("M d, Y H:i:s"));
		
		$this->layout="prf";		
		if(isset($this->data['Candidate']['FirstName'])){			
			$candidateData=$this->data;
			
			$candidateData['Candidate']['Amount'] = str_replace(',', '', $candidateData['Candidate']['Amount1']);
			
			if(!empty($this->data['Candidate']['ResumeNames']['name'])){
				$filename=$this->data['Candidate']['ResumeNames']['name'];
				$fileDetails=explode(".",$filename);
				$extension=isset($fileDetails[1])?$fileDetails[1]:"";
				$filename=(isset($fileDetails[0])?$fileDetails[0]:"")."_".time();
				$filename=$filename.".".$extension;
				if($this->data['Candidate']['ResumeNames']['error']==0){
					if(move_uploaded_file($this->data['Candidate']['ResumeNames']['tmp_name'],WWW_ROOT . 'files' . DS . "$filename")){
						$candidateData['Candidate']['ResumeName']=$filename;
						@chmod(WWW_ROOT . 'files' . DS . "$filename",0777);
						if(isset($this->params['pass'][0])){
							$fileToBeRemoved=$this->Candidate->field("ResumeName",array("ID"=>$this->params['pass'][0]));
							@unlink(WWW_ROOT . 'files' . DS .$fileToBeRemoved);
						}
					}
				}
			}
			try{				
				if(isset($this->params['pass'][0])){
					$candidateData['Candidate']['ID']=$this->params['pass'][0];
					$candidateData['Candidate']['ModifiedBy']=$this->Session->read("userId");
					$this->Session->setFlash(Configure::read("Candidate.updateSuccess"));
					$this->Candidate->save($candidateData);
				}else{
					$candidateData['Candidate']['InsertedBy']=$this->Session->read("userId");
					$this->Candidate->save($candidateData);				
					$this->Session->setFlash(Configure::read("Candidate.createSuccess"));
				}
				$this->redirect(array("controller"=>"Candidate","action"=>"index"));
			}catch(Exception $e){				
				$this->Session->setFlash(Configure::read("Candidate.updateFailure"),'failure');
			}
		}
		if(isset($this->params['pass'][0])){
			$this->set("title_for_layout","Update Candidate entry");
			$this->Candidate->id=$this->params['pass']['0'];
			$this->set("delete",$this->CandidateAssignment->find('count',array("conditions"=>array("CandidateAssignment.CandidateID"=>$this->params['pass'][0]))));//DELETE
			$this->data=$this->Candidate->read();
			
		}else{
			$this->set("title_for_layout","Create Candidate entry");
		}
		$this->set("clientList",$this->Client->find("list",array("fields"=>array("id","Name"))));
		$this->set("positionList",$this->Position->find("list",array("fields"=>array("id","RequisitionNumber"))));
		$this->set("projectList",$this->Project->find("list",array("fields"=>array("id","Name"))));
		$conditions=array();
		if(isset($this->data['CandidateFrm']['YOE'])){
			if(!empty($this->data['CandidateFrm']['YOE'])){
				$params=explode("-",$this->data['CandidateFrm']['YOE']);
				$conditions['YearsOfExperience >='] =$params[0];
				$conditions['YearsOfExperience <='] =$params[1];
			}
			if(!empty($this->data['CandidateFrm']['PrimarySkills'])){
				$conditions['PrimarySkills LIKE']="%".$this->data['CandidateFrm']['PrimarySkills']."%";
			}
			if(!empty($this->data['CandidateFrm']['Role'])){
				$conditions['Role LIKE']="%".$this->data['CandidateFrm']['Role']."%";
			}
			if(!empty($this->data['CandidateFrm']['ResourceType'])){
				$conditions['CompensationPeriod']=$this->data['CandidateFrm']['ResourceType'];
				
			}
		}
		//pr($conditions);die;
		$this->set("candidateList",$this->Candidate->find("all",array("conditions"=>$conditions,"order"=>array("FirstName","LastName"))));
	}
	
	public function sendMailNotification($content,$manager){
		$this->autoRender=false;
		App::uses('CakeEmail', 'Network/Email');
		$email = new CakeEmail('smtp');
		$email->subject("A new candidate created for the project ".$content['Project']['Name'] ." with Requisition Number ".$content['Position']['RequisitionNumber']);
		$email->from(array('no-reply@encoress.com' => 'ENCORE'));
		$email->to($manager['User']['Email']);
		$email->emailFormat('text');
		$email->viewVars(array('title_for_layout'=>"New Candidate Entry"));
		$email->viewVars(array('manager'=>$manager));
		$email->viewVars(array('content_data'=>$content));
		$email->template('newcandidate');
		$email->send();
	}

	public function delete($id) {
		$this->autoRender=false;
		try{
			$this->Candidate->delete($id);
			$fileToBeRemoved=$this->Candidate->field("ResumeName",array("ID"=>$id));
			@unlink(WWW_ROOT . 'files' . DS .$fileToBeRemoved);
			$this->Session->setFlash(Configure::read("Candidate.deleteSuccess"));
		}catch(Exception $e){
			$this->Session->setFlash(Configure::read("Candidate.deleteFailure"),'failure');
		}
		$this->redirect(array("controller"=>"Candidate","action"=>"index"));
	}

	public function CandidateView(){
		if(isset($_GET['id'])){
			$id= $_GET['id'];
			$candidate_view = $this->Candidate->find('first',array('conditions'=>array('Candidate.ID'=>$id)));
				if(!empty($candidate_view['Candidate']['SalaryWithBenefits'])) 
					$candidate_view['Candidate']['SalaryWithBenefits'] = number_format($candidate_view['Candidate']['SalaryWithBenefits'], 2, '.', ','); 
				else 
					 $candidate_view['Candidate']['SalaryWithBenefits']=  "";
				
				if(!empty($candidate_view['Candidate']['SalaryWithoutBenefits']))
					$candidate_view['Candidate']['SalaryWithoutBenefits'] = number_format($candidate_view['Candidate']['SalaryWithoutBenefits'], 2, '.', ',');
				else
					$candidate_view['Candidate']['SalaryWithoutBenefits']=  "";
				
				if(!empty($candidate_view['Candidate']['CorpToCorp']))
					$candidate_view['Candidate']['CorpToCorp'] = number_format($candidate_view['Candidate']['CorpToCorp'], 2, '.', ',');
				else
					$candidate_view['Candidate']['CorpToCorp']=  "";
				
			$candidate_data = json_encode($candidate_view);
			print_r($candidate_data);
			die;
		}
	}
}
?>
