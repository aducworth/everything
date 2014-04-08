<div class="row">
	<div class="span3" id='choose-day'>
	
		<? include( '_choose_appointment_day.php' ) ?>
		
	</div>
	<div class="span9">
		<div id='calendar'></div>
		
		<input type='hidden' id='doctor' value='<?=$_GET['doctor'] ?>'/>
		
	</div>
</div>