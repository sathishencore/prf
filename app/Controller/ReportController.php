<?php
class ReportController extends AppController {
	var $uses=array("Candidate","Project","Client","Position","CandidateAssignment", "User","EncoreContacts","ProjectRole");		
	
	
	public function index() {
		$searchCriteria = $candidateDetails = $positionAssignment = array();
		$this->layout = "prf";	
		$this->set("title_for_layout","Report - Position Tracker");
		$activeClientList = $this->Client->find("list", array("fields"=>array("ID","Name"),"conditions"=>array("Client.Status"=>"Active"),"order"=>array("Client.Name")));
		$this->set("activeClientList", $activeClientList);
		$accManager = $this->User->query("SELECT GROUP_CONCAT(Id) as Id,FirstName,LastName FROM users AS `User` where StatusFlag='Active' && (RoleId='1' || RoleId='3') GROUP BY FirstName,LastName ORDER BY `FirstName` ASC ");
		foreach ($accManager as $key => $value) {
			$fullname = $value['User']['FirstName']." ".$value['User']['LastName'];
			$managerList[$value[0]['Id']] = $fullname;
		}
		$this->set("managerList", $managerList);		
		$activeUserList = $this->User->find("list", array("fields"=>array("ID","LoginName")));
		$candidateList = $this->Candidate->find("list", array("fields"=>array("ID","fullName")));
		 if(isset($this->data['ReportFrm']['ReportPeriod'])) {
			$this->set("reportPeriod", $this->data['ReportFrm']['ReportPeriod']);
			$rptModified = $this->data['ReportFrm']['ReportPeriod'];			
		}else{
			$rptModified = "1 week";	
		} 
		$accountManager = 'All';
		if (!empty($this->data['ReportFrm']['AccountManager'])) {			
			$data = $this->data['ReportFrm']['AccountManager'];	
			
			$manager = $this->User->find("first",array("conditions"=>array("User.id"=>$data)));
			if($manager){
				$accountManager = $manager['User']['FirstName'] ." ".$manager['User']['LastName'];
			}
			
			array_push($searchCriteria, array('AND' => array("Project.EncoreContact IN ($data)")));
		}
		$this->set('accountManager', $accountManager);
		$this->Session->write('accountManager', $accountManager);
		$status ='All';
		if (isset($this->data['ReportFrm']['Status']) && $this->data['ReportFrm']['Status']) {
			$status = $this->data['ReportFrm']['Status'];
			array_push($searchCriteria,  array('AND' => array('Position.status' => $this->data['ReportFrm']['Status'])));
		}
		
		$this->set('status', $status);	
		$this->Session->write('status', $status);
		$criteria = 'All';		
		if (!empty($this->data['ReportFrm']['criteria']) && $this->data['ReportFrm']['criteria']) {

			$criteria = strtolower($this->data['ReportFrm']['criteria']);
			if($criteria =='positions overdue'){
				array_push($searchCriteria,  array('AND' => array('datediff( now(),Position.StartDate) > 0 ')));		
			}
			if($criteria == 'positions overdue - upto 30 days'){
				array_push($searchCriteria,  array('AND' => array('datediff( now(),Position.StartDate) >0 and datediff( now(),Position.StartDate) <= 30')));				
			}
			if($criteria == 'positions overdue - >30 days'){		
				array_push($searchCriteria,  array('AND' => array('datediff( now(),Position.StartDate) > 30')));	
			}
			if($criteria == 'all'){
				array_push($searchCriteria,  array('AND' => array('Position.status' => 'open')));	
			}
		}
		$this->set('criteria', $criteria);	
		$this->Session->write('criteria', $criteria);		
		$frm_date = date('Y-m-d', strtotime("-" . $rptModified)); 
		$to_date = date('Y-m-d');
		
		//Add default search criteria
		array_push($searchCriteria, array('OR' => array(
								//array('Position.Status' => array('Open','Potential')),
			array('Position.modified between ? and ?' => array($frm_date, $to_date)), 
		)));
		
		$positionResult = $this->Position->find("all", array("conditions" => $searchCriteria, "order" => array("Position.ProjectId", "Position.ClientID","Position.ID")));
		
		$curPosition = ''; $confirmedPositionCnt = 0;
		
		foreach ($positionResult as $key => $position) {
			if ($curPosition != $position['Position']['ID']) {		
				$candidateDetails = array();
				$curPosition = $position['Position']['ID'];
				$confirmedPositionCnt = 0; //to calculate the open positions count
			}
			
			//candidate details for each position
			foreach($position['CandidateAssignment'] as $pos_id => $candidate) {
				$candidateDetails[$candidate['CandidateID']] = array(				
										'candidatename'		=>	!empty($candidateList[$candidate['CandidateID']]) ? $candidateList[$candidate['CandidateID']] : '',
										'assignmentstatus'	=>	$candidate['AssignmentStatus'],    
										'interviewlevel'	=>	$candidate['InterviewLevel'],
										'interviewdate'		=>	$this->formatDate($candidate['InterviewDate']),						
				);
				
				if ($candidate['AssignmentStatus'] == 'Confirmed')
					$confirmedPositionCnt++;
			}
		
			//Position Details
			$systemDate  = date("Y/m/d");
			$requiredDate = date("Y/m/d", strtotime($position['Position']['StartDate']));
			$overdueDateDiff = strtotime($systemDate)- strtotime($requiredDate);				
			$overdueDate = round($overdueDateDiff / (60 * 60 * 24));
			if($overdueDate == 0 || $overdueDate < 0){
				$overdueDate = '';
			}
	
			$createdDate = date("Y/m/d", strtotime($position['Position']['created']));
			$openDateDiff = strtotime($systemDate)- strtotime($createdDate);
			$openDate = round($openDateDiff / (60 * 60 * 24));
			
			$skillNames =  $position['Skill'];
			$position_core_skills = array();$position_essential_skills = array();$position_desirable_skills = array();
			
			if($skillNames){
				foreach($skillNames as $names){
					
					if($names['PositionSkill']['type'] == 'core_skill'){
						$position_core_skills[] = $names['Name'];
						
					}
					if($names['PositionSkill']['type'] == 'essential_skill'){
						$position_essential_skills[] = $names['Name'];
						
					}
					if($names['PositionSkill']['type'] == 'desirable_skill'){
						$position_desirable_skills[] = $names['Name'];
						
					}
				}
			}
			$core = $position_core_skills ? implode (", ", $position_core_skills) :'';
			$essential = $position_essential_skills ? implode (", ", $position_essential_skills) :'';
			$desirable = $position_desirable_skills ? implode (", ", $position_desirable_skills) :'';	

			$userRole = $position['ProjectRole']['role'];
			$role = $core . " ". $userRole;
			$positionAssignment[$position['Client']['Name']][$position['Project']['Name']][$position['Position']['ID']]	=	array(
										'accountManager'        =>  $accountManager,
										'searchStatus'        	=>  $status,
										'searchCriteria'        =>  $criteria,
										'clientname'			=>	$position['Client']['Name'],
										'projectcode'			=>	$position['Project']['Code'],
										'projectname'			=>	$position['Project']['Name'],
										'requisition'			=>	$position['Position']['RequisitionNumber'],
										'role' 					=>	$role,
										 'corekill'				=>	$core,
										'essentialskill'		=>	$essential,
										'desirableskill'		=>	$desirable, 
										//'secondaryskill'		=>	$position['Position']['OtherSkills'],										
										'location' 				=>	$position['Position']['WorkLocation'],
										'endDate' 				=>	$position['Position']['EndDate'],
										'startdate' 			=>	$this->formatDate($position['Position']['StartDate']),
										'primaryrecruiter' 		=>	isset($activeUserList[$position['Position']['RecruiterId']]) ? $activeUserList[$position['Position']['RecruiterId']] : '',
										'secondaryrecruiter'	=>	isset($activeUserList[$position['Position']['SecondaryRecruiterId']]) ? $activeUserList[$position['Position']['SecondaryRecruiterId']] : '',
										'priority' 				=>	$position['Position']['Priority'],										 
										'createddate'			=>	$this->formatDate($position['Position']['created']),
										'status'				=> 	$position['Position']['Status'],
										'JobDescription'        =>	$position['Position']['JobDescription'],
										'relocation'       		=>	$position['Position']['RelocationRequired'],
										'travel'       			=>	$position['Position']['TravelRequired'],
										'billable'        		=>	$position['Position']['Billable'],
										'worklocation'        	=>	$position['Position']['WorkLocation'],
										'currency'       	 	=>	$position['Position']['Currency'],
										'salary_annual_ft'      =>	$position['Position']['SalaryFt'],
										'salary_hourly'        	=>	$position['Position']['SalaryHourly'],
										'corp_to_corp_hourly'   =>	$position['Position']['CorpToCorp'],
										'encorescreeningmanager'=>	$position['Position']['ScreeningManager'],
										'track'        			=>	$position['Position']['Track'],
										'priority'        		=>	$position['Position']['Priority'],	
										'totalposition'			=>	$position['Position']['NoOfPosition'],										
										'openposition'			=>	$position['Position']['NoOfPosition'] - $confirmedPositionCnt,
										'candidate'				=>	$candidateDetails,
										'#overdue'				=>	$overdueDate,
										'#open'					=>	$openDate,	
																						
			);			
		}		
		ksort($positionAssignment);
		$this->Session->write('positionAssignment', $positionAssignment);
		$this->set('positionAssignment', $positionAssignment);		
	}
	
	private function formatDate($strDate){
		if ($strDate)		
			$cDate	=	date(Configure::Read("Date.Format"), strtotime($strDate));
		else
			$cDate = null;
		
		return $cDate;
	}
	
	public function export_xls() {	

		$this->layout = "ajax";
		$rptToExport = ($this->request->query['rpt'] == 'candidate') ? 'unassignedCandidate' : 'positionAssignment' ; 
		$tempReport = $this->Session->read($rptToExport);
		$this->Session->read($rptToExport);
		if($rptToExport == 'positionAssignment'){
			$status = $this->Session->read('status');
			$criteria = $this->Session->read('criteria');
			$accountManager = $this->Session->read('accountManager');
			$this->set('status', $status);
			$this->set('criteria', $criteria);
			$this->set('accountManager', $accountManager);
		}
		$this->set($rptToExport, $tempReport);
		
	}
	
	//Function to show the list of unassigned candidates
	public function candidate() {
		$candidateList =  $userCondition = $tmpCandidates = array();
		$this->layout = "prf";	
		$this->set("title_for_layout","Report - Unassigned Candidates");		
						
		$assignedUsers = $this->CandidateAssignment->find("all", array('fields' => array('DISTINCT CandidateID')));
		
		foreach ($assignedUsers as $key => $val) {						
			array_push($tmpCandidates, $val['CandidateAssignment']['CandidateID']);
		}		
		if (!empty($tmpCandidates)) {
			$candidateList = $this->Candidate->find('all', array('conditions' => array("NOT"=>array('Candidate.ID' => $tmpCandidates))));
		}
		$this->Session->write('unassignedCandidate', $candidateList);	
		$this->set('unassignedCandidate', $candidateList);
	}
	public function forecast() {
		$this->layout = "prf";	
		$this->set("title_for_layout","Resource Forecast Details");	
		$searchCondition = array();$forecastResultArray = array(); $months = array();$from ='';$to='';$fromMonth='';$toMonth='';
		if($this->data && $this->data['ForecastFrm']['StartDate'] && $this->data['ForecastFrm']['EndDate'] ){
			$startDate = date('Y-m-d', strtotime(str_replace('-', '/', $this->data['ForecastFrm']['StartDate'])));
			$endDate = date('Y-m-d', strtotime(str_replace('-', '/', $this->data['ForecastFrm']['EndDate'])));
			 $conditions =  array(
			'and' => array(
				 array('Position.StartDate <= ' => $endDate,
						'Position.StartDate >= ' => $startDate
					 ),
					 'Position.Status  =' => 'open'
				)
			);
			array_push($searchCondition, $conditions); 
			if($startDate && $endDate){
				$forecastResult = $this->Position->find('all', array('conditions' => $searchCondition));  
			}
			$startYear = date('Y', strtotime($startDate));			
			$startMonth = date('F', strtotime($startDate));
			$startDay = date('d', strtotime($startDate));
			$from = $startMonth." ".$startDay;
			$fromMonth =  substr($startMonth, 0, 3)." ".$startYear;	
			$endYear = date('Y', strtotime($endDate));
			$endMonth = date('F', strtotime($endDate));
			$endDay = date('d', strtotime($endDate));
			$to = $endMonth." ".$endDay;	
			$toMonth =  substr($endMonth, 0, 3)." ".$endYear;
			$months = $this->get_months($startDate,$endDate);
			$role='';
			foreach ($forecastResult as $key => $position) {
				$coreSkill = array();
				$role_id = $position ['Position']['RoleId'];
				if($role_id){
					$role_details = $this->ProjectRole->find("first",array("conditions"=>array("ProjectRole.id"=>$role_id)));
					$role = $role_details ? $role_details['ProjectRole']['role'] : '';
				}
				$accountManager = '';
				$managerId = $position ['Project']['EncoreContact'];
				if($managerId){
					$manager = $this->User->find("first",array("conditions"=>array("User.id"=>$managerId)));
					if($manager){
						$accountManager = $manager['User']['FirstName'] ." ".$manager['User']['LastName'];
					}
				}
				if($position['Skill']){
					foreach($position['Skill'] as $skill){
						if($skill['PositionSkill']['type'] == 'core_skill'){
							$coreSkill[] = $skill['Name'];
						}
					}
				}
				$coreSkillValue = $coreSkill ?  implode (", ", $coreSkill) :'';
				$startMonthName = $position ['Position']['StartDate'];
				//$positionStartMonth =  date('F', strtotime($startMonthName)).date('Y', strtotime($startMonthName));
				$positionStartMonth = substr(date('F', strtotime($startMonthName)),0,3).'-'.substr(date('Y', strtotime($startMonthName)),-2);
				$forecastResultArray [] = array(
					'coreSkill'    	   	 	    =>   $coreSkillValue,
					'level'        			    =>   $role,
					'clientname'			    =>	 $position['Client']['Name'],
					'projectname'			    =>	 $position['Project']['Name'],
					'bde'                 	    =>   $accountManager,
					'startDate'                 =>   $position ['Position']['StartDate'],
					$positionStartMonth         =>   $position ['Position']['NoOfPosition'],
					'total'                     =>   $position ['Position']['NoOfPosition'],
				);
			}		
		
		}
		$this->set('months', $months);
		$this->set('from', $fromMonth);
		$this->set('to', $toMonth);
		$this->set('forecast_details', $forecastResultArray);
	}
	
	public function summary() {
		$this->layout = "prf";	
		$this->set("title_for_layout","Resource Forecast Summary");	
		$searchCondition = array();$forecastResultArray = array(); $months = array();$from ='';$to=''; $skillName ='';$role='';$fromMonth='';$toMonth='';
		if($this->data && $this->data['SummarytFrm']['StartDate'] && $this->data['SummarytFrm']['EndDate'] ){
			$startDate = date('Y-m-d', strtotime(str_replace('-', '/', $this->data['SummarytFrm']['StartDate'])));
			$endDate = date('Y-m-d', strtotime(str_replace('-', '/', $this->data['SummarytFrm']['EndDate'])));
			 $conditions =  array(
			'and' => array(
				 array('Position.StartDate <= ' => $endDate,
					 'Position.StartDate >= ' => $startDate
					 ),
					 'Position.Status  =' => 'open'
				)
			);
			array_push($searchCondition, $conditions); 
			if($startDate && $endDate){
				$forecastResult =$this->Position->query( "SELECT `position`.`Role`,`position_skills`.`skill_id`,`project_role`.`role`,`skill`.`Name`,GROUP_CONCAT(LEFT(MONTHNAME(`position`.`StartDate`),3) ,'-',RIGHT(YEAR(`position`.`StartDate`),2),':',`position`.`NoOfPosition`) month FROM   position LEFT JOIN position_skills on position.id = position_skills.position_id and position_skills.type ='core_skill' and `position_skills`.`skill_id` IS NOT NULL 
				 LEFT JOIN project_role on position.RoleId = project_role.id 
				  LEFT JOIN skill on skill.ID = position_skills.skill_id 
				 WHERE (`position`.`StartDate` <= '".$endDate."') AND (`position`.`StartDate` >= '".$startDate."') AND (`position`.`Status` = 'open') GROUP BY  `position_skills`.`skill_id`,`position`.`RoleId`"); 

			$startYear = date('Y', strtotime($startDate));
			$startMonth = date('F', strtotime($startDate));
			$startDay = date('d', strtotime($startDate));
			$from = $startMonth." ".$startDay;	
			$fromMonth =  substr($startMonth, 0, 3)." ".$startYear;	
			$endYear = date('Y', strtotime($endDate));
			$endMonth = date('F', strtotime($endDate));
			$endDay = date('d', strtotime($endDate));
			$to = $endMonth." ".$endDay;	
			$toMonth =  substr($endMonth, 0, 3)." ".$endYear;
			$months = $this->get_months($startDate,$endDate);
			$positionArray1 =[];
		    
			foreach ($forecastResult as $key => $position) {
				$skillName = $position['skill']['Name'];
				$role = $position['project_role']['role'];
				$value = $position[0]['month'];
				$nameArray = explode(',', $value);
				$finalArray = array();  
				foreach ($nameArray as $user) {
					$count = explode(':', $user);
					if (isset($finalArray[$count[0]]))
					{
						$finalArray[$count[0]] += $count[1];
					}
					else
					{
						$finalArray[$count[0]] = $count[1];
					}
				}
				$forecastResultArray [] = array(
					'coreSkill'    	   	 	    =>   $skillName,
					'level'        			    =>   $role,
					'date'                      =>   $finalArray,
				);
			}
		}
		}
		$this->set('months', $months);
		$this->set('from', $fromMonth);
		$this->set('to', $toMonth);
		$this->set('forecast_summary', $forecastResultArray); 
	
	}
	
	public function get_months($date1, $date2) {
		$time1  = strtotime($date1);
		$time2  = strtotime($date2);
		$dateFormat     = date('mY', $time2);
		$months = array(substr(date('F', $time1), 0, 3).'-'. substr(date('Y',$time1), -2));
		while($time1 < $time2) {
			$time1 = strtotime(date('Y-m-d', $time1).' +1 month');
			if(date('mY', $time1) != $dateFormat && ($time1 < $time2))
				//$months[] = date('F', $time1).date('Y',$time1);
				$months[] = substr(date('F', $time1), 0, 3).'-'. substr(date('Y',$time1), -2);
		}
		//$months[] = date('F', $time2).date('Y',$time2);
		$months[] =  substr(date('F', $time2), 0, 3).'-'. substr(date('Y',$time2), -2);
		return array_unique($months);
	}
  
}
?>
