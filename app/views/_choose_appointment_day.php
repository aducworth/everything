<h3>Schedule Appointment for <?=$controller->doctor_list[ $_GET['doctor'] ] ?></h3>
		
<? if( !$_GET['day'] ): ?>

	<p>Please select a day for the appointment.</p>
	
<? else: ?>

	<p>Please select a time slot for the appointment.</p>
	
	<form action='/referral' method='get'>
	
		<ul class='time-slots'>
		
			<?=$form->radio( 'time_slot', $controller->time_slots, array( 'label' => 'Time Slot', 'default' => $controller->result['time_slot'], 'empty' => ' ( Choose Ending Hour ) ', 'class' => 'required' ) ) ?>
			
		</ul>
	
		<p><? //print_r( $controller->time_slots ) ?></p>
		
		<input type='hidden' name='doctor' value='<?=$_GET['doctor'] ?>'/>
		
		<input type='hidden' name='day' value='<?=date( 'Y-m-d', strtotime( $_GET['day'] ) ) ?>'/>
		
		<input type='submit' class="btn pull-left" value='Next'/>
		
	</form>
	
<? endif; ?>