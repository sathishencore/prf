Hi <?php echo $manager['User']['FirstName']." ".$manager['User']['LastName']?>,

   A Candidate has been assigned to the position you created. The details are as follows :
   		
   		Client Name			:  <?php echo $position['Client']['Name']?>
   		
   		Project Name		:  <?php echo $position['Project']['Name']?>
   			
   		Position Name		:  <?php echo $position['Position']['Role']?>
   		
   		Requisition Number	:  <?php echo $position['Position']['RequisitionNumber']?>
   		
   		Candidate Name 		:  <?php echo $candidate['Candidate']['FirstName']." ".$candidate['Candidate']['LastName']?>
   
Thanks