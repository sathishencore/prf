<div class="titlebg">
	<div class="titletxt">Unassigned Candidate List</div>	
</div>
<div class="bodyconrarea">
	<div class="content" style="min-height: 200px;">
	<div class="clear">&nbsp;</div>
		
	<!-- display results -->	
	<div class="displayResults" style="text-align: right;"><strong><?php echo $this->Html->link('Export as Excel', array('controller'=>'Report', 'action'=>'export_xls?rpt=candidate')); ?></strong></div>
	<div class="clear">&nbsp;</div>
	<div class="displayResults">
		<?php echo $this->element("unassignedCandidate"); ?>						
	</div>
	<div class="clear">&nbsp;</div>
	
	</div>
</div>