<div class="titlebg">
	<div class="titletxt">Forecast Report</div>	
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="bodyconrarea">
	<div id="searchForecast" class="content" style="min-height: 200px;">
	<!-- search form -->
	<div id="basicSearch" class="content-mid">
	<?php echo $this->Form->create("ForecastFrm",array("url"=>array("controller"=>"Report", "action"=>"forecast")));?>
	<table cellpadding="0" cellspacing="2" border="0"  align="left">
					<tr>
                        <td><b>Start Date: &nbsp;</b></td>
                        <td>&nbsp; &nbsp;
						     <td>
                             <?php echo $this->Form->input("StartDate",array("type"=>"text",'id'=>'start_date',"autocomplete" =>"off","style"=>"width:250px;height:25px;",'label'=>false));?>
                        </td>
                        </td>
						<td><b>&nbsp; &nbsp;End Date:&nbsp;</b></td>
						<td>
						   <?php echo $this->Form->input("EndDate",array("type"=>"text",'id'=>'end_date',"autocomplete" =>"off","style"=>"width:250px;height:25px;",'label'=>false));?>
						</td>
						&nbsp; &nbsp;
						<td></td><td></td><td><?php echo $this->Form->submit("Search");?></td>
					 </tr>
	</table>
	<?php echo $this->Form->end();?>				
	</div>
	<div class="clear">&nbsp;</div>
	<div class="clear">&nbsp;</div>
	<div class="displayResults">
		<?php echo $this->element("forecast_details"); ?>						
	</div>
	<div class="clear">&nbsp;</div>
	
	</div>
</div>
<script>
 $( function() {
    $( "#start_date" ).datepicker({
		changeMonth: true,
		changeYear: true
    });
	 $( "#end_date" ).datepicker({
		changeMonth: true,
		changeYear: true
    });
  } );
</script>