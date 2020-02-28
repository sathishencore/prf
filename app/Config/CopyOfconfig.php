<?php
$config['User']['loginFail'] = 'Username / Password is invalid';
$config['User']['EmailFail'] = 'The given email address is not present in the system';
$config['User']['EmailSuccess'] = 'Your password has been sent to your email address';

$config['Client']['createSuccess'] = 'Client created successfully.';
$config['Client']['updateSuccess'] = 'Client details updated successfully';
$config['Client']['deleteSuccess'] = 'Client details deleted successfully';
$config['Client']['deleteFailure'] = 'The client has one or more associated projects and cannot be deleted';
$config['Client']['addClientContact'] = 'Client Contact added successfully';
$config['Client']['updateClientContact'] = 'Client Contact updated successfully';
$config['Client']['addClientContactFailure'] = 'Cannot save new contact';
$config['Client']['deleteClientContactSuccess'] = 'Client Contact details deleted successfully';
$config['Client']['deleteClientContactFailure'] = 'The client contact has one or more associated projects and cannot be deleted';

$config['User']['createSuccess'] = 'User created successfully';
$config['User']['updateSuccess'] = 'User details updated successfully';
$config['User']['deleteSuccess'] = 'User details deleted successfully';
$config['User']['deleteFailure'] = 'User details cannot be deleted';
$config['User']['passwordUpdate'] = 'Your password has been changed successfully';
$config['User']['changePassword'] = 'Please change your password';

$config['Project']['createSuccess'] = 'Project created successfully';
$config['Project']['updateFailure'] = 'Please fill all the mandatory fields';
$config['Project']['updateSuccess'] = 'Project details updated successfully';
$config['Project']['deleteSuccess'] = 'Project details deleted successfully';
$config['Project']['deleteFailure'] = 'The project has one or more associated positions and cannot be deleted';

$config['Position']['createSuccess'] = 'Position details created successfully';
$config['Position']['updateFailure'] = 'Please fill all the mandatory fields';
$config['Position']['updateSuccess'] = 'Position details updated successfully';
$config['Position']['deleteSuccess'] = 'Position details deleted successfully';
$config['Position']['deleteFailure'] = 'Position details cannot be deleted';

$config['AssignRecruiter']['createSuccess'] = 'Candidate details created successfully';
$config['AssignRecruiter']['updateFailure'] = 'Please fill all the mandatory fields';
$config['AssignRecruiter']['updateSuccess'] = 'Candidate details updated successfully';
$config['AssignRecruiter']['deleteSuccess'] = 'Candidate details deleted successfully';
$config['AssignRecruiter']['deleteFailure'] = 'Candidate details cannot be deleted';

$config['Candidate']['createSuccess'] = 'Candidate details created successfully';
$config['Candidate']['updateFailure'] = 'Please fill all the mandatory fields';
$config['Candidate']['updateSuccess'] = 'Candidate details updated successfully';
$config['Candidate']['deleteSuccess'] = 'Candidate details deleted successfully';
$config['Candidate']['deleteFailure'] = 'Candidate details cannot be deleted';


$config['User']['accessRestrict'] = " You do not have sufficient privilege to edit/delete.";

$config['Project']['SaleStatus']=array("Request Received"=>"Request Received",
										"Proposal Submitted"=>"Proposal Submitted",
										"Deal Won"=>"Deal Won",
										"Deal Lost"=>"Deal Lost",
										"Delivery Completed"=>"Delivery Completed",
										"On Hold"=>"On Hold",
										"Closed" => "Closed"
										);
$config['Project']['BillingFrequency']=array("Weekly"=>"Weekly",
										"Bi-weekly"=>"Bi-weekly",
										"Monthly"=>"Monthly",
										"Milestone based"=>"Milestone based",
										);

$config['Project']['BillingType']=array("T&M"=>"T & M",
										"T&M with Cap"=>"T&M with Cap",
										"Fixed Price"=>"Fixed Price"
										);										
$config['Position']['PreferredSource']=array("US-Based Employee"=>"US-Based Employee",
											  "OffShore Employee-Offshore"=>"OffShore Employee-Offshore",
											  "OffShore Employee-Onsite"=>"OffShore Employee-Onsite",
											  "New-hire full time"=>"New-hire full time",
											  "Project Hire"=>"Project Hire",
											  "Sub contractor"=>"Sub contractor",
											  "Contract to Hire"=>"Contract to Hire",
											  "No preference"=>"No preference"
											 );
$config['Position']['TravelPercent']=array("0"=>"0",
											  "25"=>"25",
											  "50"=>"50",
											  "75"=>"75",
											  "100"=>"100"
											 );
$config['Position']['UnitOfMeasure']=array("Hourly"=>"Hourly",
											"Daily"=>"Daily",
											"Weekly"=>"Weekly",
											"Monthly"=>"Monthly",
											"Milestone based"=>"Hourly for Milestone based",
											"Fixed fee"=>"Hourly for Fixed fee"
											);

$config['Position']['Status']=array("Potential"=>"Potential",
									"Open"=>"Open",
									"Lost"=>"Lost",
									"Hold"=>"Hold",
									"Filled"=>"Filled"
									);				
$config['Position']['Priority']=array("High"=>"High",
									"Medium"=>"Medium",
									"Low"=>"Low"
									);						 
$config['Candidate']['Status']=array("Available"=>"Available",
										"Not Available"=>"Not Available",
										"Rejected"=>"Rejected"
										);
										
$config['Candidate']['YearsOfExperience']=array("0-2" => "Less than 2 years",
												"2-4"=>" 2-4 years ",
												"4-6"=>" 4-6 years ",
												"6-8"=>" 6-8 years ",
												"8-10"=>" 8-10 years ",
												"10-100"=>" greater than 10 years "
												);								
$config['Candidate']['ResourceType']=array("Salary FT" => "Salary FT",
												"Salary Hourly"=>"Salary Hourly",
												"Corp-to-Corp"=>"Corp-to-Corp",
										);		
$config['CandidateAssignment']['Status']=array(
		"Assigned"=>"Assigned",
		"Submitted"=>"Submitted",
		"Interview Scheduled"=>"Interview Scheduled",
		"Interview Done"=>" Interview Done",
		"Selected"=>"Selected",
		"Confirmed"=>"Confirmed",
		"Rejected"=>"Rejected",
		"Background Check"=>"Background Check",
		"Started"=>"Started",
		"Background Check Failed"=>"Background Check Failed"
);

$config['CandidateAssignment']['InterviewLevel']=array(
		"Internal 1"=>"Internal 1",
		"Internal 2"=>"Internal 2",
		"Internal 3"=>"Internal 3",
		"Internal 4"=>"Internal 4",
		"Internal 5"=>"Internal 5",
		"Client 1"=>"Client 1",
		"Client 2"=>"Client 2",
		"Client 3"=>"Client 3",
		"Client 4"=>"Client 4",
		"Client 5"=>"Client 5"
);



$config['Time']['Session'] = array("AM"=>"AM","PM"=>"PM");

$config['SalaryCalculation']['HY']=1920 ;// hours in a year
$config['SalaryCalculation']['MF']=1.175 ;// Multiplication Factor

$config['Date']['Format']="m/d/Y";
											 
?>