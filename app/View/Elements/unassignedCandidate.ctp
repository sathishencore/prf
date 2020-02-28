<table id="candidateList" width=100% cellpadding="0" cellspacing="0" border=0>
<thead>
<tr>	
	<th>Name</th>
	<th>Contact Phone</th>
	<th>Email</th>
	<th>City</th>
	<th>State</th>
	<th>Willing to Travel</th>
	<th>Willing to Relocate</th>
	<th>Role</th>
	<th>Years of Experience</th>
	<th>Education</th>
	<th>Field of Study</th>
	<th>Primary Skills</th>
	<th>Secondary Skills</th>
	<th>Currency</th>	
	<th>Amount</th>
	<th class="headerRight">Compensation Type</th>
</tr>
</thead>
<tbody>
<?php 
if (!empty($unassignedCandidate)) {	
	foreach ($unassignedCandidate as $key => $candidate) {
		print '<tr>';
		print '<td>' . $candidate['Candidate']['FirstName'] . ' ' . $candidate['Candidate']['LastName'] . '</td>';			
		print '<td>' . $candidate['Candidate']['ContactPhone'] . '</td>';
		print '<td>' . $candidate['Candidate']['Email'] . '</td>';
		print '<td>' . $candidate['Candidate']['City'] . '</td>';
		print '<td>' . $candidate['Candidate']['State'] .  '</td>';
		print '<td>' . $candidate['Candidate']['WillingToTravel'] . '</td>';
		print '<td>' . $candidate['Candidate']['WillingToTravel'] . '</td>';
		print '<td>' . $candidate['Candidate']['Role'] . '</td>';							
		print '<td>' . $candidate['Candidate']['YearsOfExperience'] . '</td>';
		print '<td>' . $candidate['Candidate']['HighestEducationLevel'] . '</td>';															
		print '<td>' . $candidate['Candidate']['FieldOfStudy'] . '</td>';
		print '<td>' . $candidate['Candidate']['PrimarySkills'] . '</td>';
		print '<td>' . $candidate['Candidate']['SecondarySkills'] . '</td>';
		print '<td>' . $candidate['Candidate']['Currency'] . '</td>';
		print '<td>' . number_format($candidate['Candidate']['Amount'], 2, '.', ','). '</td>';
		print '<td class="headerRight">' . $candidate['Candidate']['CompensationPeriod'] . '</td>';
		print '</tr>';
	}	
} else {
	print '<tr><td class="headerRight" colspan=16>No Records found!!!</td></tr>';
}?>
</tbody>
</table>