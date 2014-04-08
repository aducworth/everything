<h1><?=$_GET['id']?'Edit':'Add' ?> Hours for <?=$controller->doctor_list[ $_GET['doctor_id'] ] ?></h1>

<form action='/doctor_hour' id='data-form' method='post'>

<? if( $_GET['id'] ): ?>

	<input type='hidden' id='id' name='id' value='<?=$_GET['id'] ?>'/>

<? endif; ?>

<input type='hidden' name='doctor_id' value='<?=$_GET['doctor_id'] ?>'/>

<?=$form->select( 'day_of_week', $form->days, array( 'label' => 'Day of Week', 'default' => $controller->result['day_of_week'], 'empty' => ' ( Choose Day of Week ) ', 'class' => 'required' ) ) ?>

<?=$form->select( 'starting_hour', $controller->appointment_hours, array( 'label' => 'Starting Hour', 'default' => $controller->result['starting_hour'], 'empty' => ' ( Choose Starting Hour ) ', 'class' => 'required' ) ) ?>

<?=$form->select( 'ending_hour', $controller->appointment_hours, array( 'label' => 'Ending Hour', 'default' => $controller->result['ending_hour'], 'empty' => ' ( Choose Ending Hour ) ', 'class' => 'required' ) ) ?>

<p class='action-buttons'>

	<input type='submit' class="btn pull-left" value='Save'/>

	<? if( $_GET['id'] ): ?>

		<button id='delete-doctor_hour' class="btn btn-danger pull-right delete-item">Delete</button>
        
    <? else: ?>
    
    	<button id='cancel-doctor_hour' class="btn btn-danger pull-right cancel-item">Cancel</button>
        
    <? endif; ?>

</p>

</form>