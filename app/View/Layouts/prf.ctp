<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php echo $this->Html->charset(); ?>
	<title>		
		:: PRF :: <?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('styles',"chosen","jquery-ui-1.10.3.custom.min.css","style","jquery-ui-timepicker-addon"));
		echo $this->Html->script(array("jquery.min.js","jquery-ui-1.10.3.custom.js",'jquery.validate',"additional-methods.js","chosen.jquery","jquery.tablesorter.min","jquery-ui-timepicker-addon","jquery.maskedinput"));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
<script type="text/javascript">
		function MM_swapImgRestore() { //v3.0
		  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
		}
		function MM_preloadImages() { //v3.0
		  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
		    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
		    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
		}
		
		function MM_findObj(n, d) { //v4.01
		  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
		    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
		  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
		  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
		  if(!x && d.getElementById) x=d.getElementById(n); return x;
		}
		
		function MM_swapImage() { //v3.0
		  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
		   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
		}
	</script>
</head>
<body  onload="MM_preloadImages('<?php echo $this->Html->url("/")?>img/signout-hover.png')">
	<div class="outer">
    	<div class="header-bg">
        	<div class="headerconarea">
            	<div class="logo"><a href="<?php echo $this->Html->url("/");?>"><?php echo $this->Html->image("encore-logo.png",array("vspace"=>"5","alt"=>"Encore logo"))?></a></div>
                <div class="rightcon">
                	<div class="dateBg"><span class="orange"><?php echo date('l');?>,</span> <span class="blktxt"><?php echo date("M d, Y")?></span></div>
                    <div class="user blktxt"> 
                    	Hi <span class="usertxt"><?php echo $this->Session->read('userName');?> (<?php echo $this->Session->read("roleInfo")?>)</span>
                    	&nbsp;|&nbsp; 
                    	<?php echo $this->Html->link(
									    $this->Html->image("change-password.png", array("alt" => "Login","id"=>"Image4","align"=>"absmiddle")),
									    "/Users/changePassword",
									    array('escape' => false,"title"=>"Change Password","onmouseout"=>"MM_swapImgRestore()","onmouseover"=>"MM_swapImage('Image4','','".$this->Html->url("/")."img/change-password-hover.png',1)")
						);?>
                    	&nbsp;|&nbsp;                    	
                    	<?php echo $this->Html->link(
									    $this->Html->image("signout.png", array("alt" => "Login","id"=>"Image2","align"=>"absmiddle")),
									    "/logout",
									    array('escape' => false,"title"=>"Signout","onmouseout"=>"MM_swapImgRestore()","onmouseover"=>"MM_swapImage('Image2','','".$this->Html->url("/")."img/signout-hover.png',1)")
						);?>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu">
        	<ul>
        	<?php if($this->Session->read("ProjectLead")){ ?>
        	<li><a style="background-image: none;" href="<?php echo $this->Html->url("/Report")?>" <?php if($this->params['controller']=='Report') echo "class='current'"?>>Reports</a></li>
        	<?php } else {?>
                <li><a href="<?php echo $this->Html->url("/Client")?>" <?php if($this->params['controller']=='Client') echo "class='current'"?>>Client  Details</a></li>
                
                <li><a href="<?php echo $this->Html->url("/Project")?>" <?php if($this->params['controller']=='Project') echo "class='current'"?>>Project Details</a></li>
                <li><a href="<?php echo $this->Html->url("/Position")?>" <?php if($this->params['controller']=='Position') echo "class='current'"?>>Position Details</a></li>
                <?php if($this->Session->read("AdminUser") || ($this->Session->read("ManagerRecruiter"))) {?>
                <li><a href="<?php echo $this->Html->url("/AssignRecruiter")?>" <?php if($this->params['controller']=='AssignRecruiter') echo "class='current'"?>>Assign Recruiter</a></li>
                <?php } ?>
                <li><a href="<?php echo $this->Html->url("/Candidate")?>" <?php if($this->params['controller']=='Candidate') echo "class='current'"?>>Candidate Details</a></li>
                <li><a href="<?php echo $this->Html->url("/CandidateAssignment")?>" <?php if($this->params['controller']=='CandidateAssignment') echo "class='current'"?>>Candidate Assignment</a></li>
                <?php if($this->Session->read("AdminUser")){?>
                <li class="admin"><a href="<?php echo $this->Html->url("/Users/")?>" <?php if($this->params['controller']=='Users') echo "class='current'"?>>Administration</a></li>
                <?php }?>
                <li><a style="background-image: none;" href="<?php echo $this->Html->url("/Report")?>" <?php if($this->params['controller']=='Report') echo "class='current'"?>>Reports</a></li>
                <?php } ?>
            </ul>
        </div>
        <?php if($this->params['controller']=='Users') {?>
     <!--  <div class="submenu"><div style="margin-left: 84%;font-size: 125%;">
        	<a style="color:#D96609;text-decoration: none;" href="<?php echo $this->Html->url("/Users")?>">USER</a> </div></div>--> 
         <?php } ?>      
      <!--  | <a style="color:#D96609;text-decoration: none;"	 href="<?php //echo $this->Html->url("/Users/encore")?>">Encore Contacts</a> -->   
         <?php if($this->params['controller']=='Report') {?>
      	<div class="submenu"><div style="margin-left: 50%;font-size: 110%;">
        	<a style="color:#D96609;text-decoration: none;" href="<?php echo $this->Html->url("/Report")?>">Position Tracker</a> | <a style="color:#D96609;text-decoration: none;"	 href="<?php echo $this->Html->url("/Report/candidate")?>">Unassigned Candidates</a>|
			<a style="color:#D96609;text-decoration: none;"	 href="<?php echo $this->Html->url("/Report/forecast")?>">Forecast Report</a>|
			<a style="color:#D96609;text-decoration: none;"	 href="<?php echo $this->Html->url("/Report/summary")?>">Forecast Summary Report</a></div></div>   
		<?php } ?> 
		
			<?php echo $this->Session->flash(); ?>
	
			<?php echo $this->fetch('content'); ?>		
		<div class="clear">&nbsp;</div>
		<div class="footer">
          	<div class="footertxt">&copy; <?php date('Y');?> Encore Software Services. All rights reserved. Terms of Use | Designed by Encore User Experience Practice </div>
        </div>
        
	</div>
	<?php  echo $this->element('sql_dump'); ?>
</body>

</html>
