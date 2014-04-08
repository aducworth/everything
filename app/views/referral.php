<h1><?=$_GET['id']?'Edit':'Add' ?> Referral</h1>

<form action='/referral' id='data-form' method='post' enctype="multipart/form-data">

<? if( $_GET['id'] ): ?>

	<input type='hidden' id='id' name='id' value='<?=$_GET['id'] ?>'/>
	
	<?=$form->select( 'referral_status', $controller->referral_statuses, array( 'label' => 'Status', 'default' => $controller->result['referral_status'], 'class' => 'required', 'empty' => ' ( Choose Status ) ' ) ) ?>
    
<? endif; ?>

<?=$form->textbox( 'patient_name', array( 'label' => 'Patient Name', 'default' => $controller->result['patient_name'], 'class' => 'required' ) ) ?>

<? if( $_SESSION['logged_in_user']['office_id'] ): ?>

	<? if( count( $controller->doctors_by_office_list ) > 1 ): ?>
	
		<?=$form->select( 'referred_by', $controller->doctors_by_office_list, array( 'label' => 'Referred by', 'default' => $controller->result['referred_by'], 'class' => 'required', 'empty' => ' ( Choose Doctor ) ' ) ) ?>
	
	<? else: ?>
	
		<? foreach( $controller->doctors_by_office_list as $id => $name ): ?>
	
			<input type='hidden' id='referred_by' name='referred_by' value='<?=$id ?>'/>
			
		<? endforeach; ?>
		
	<? endif; ?>
	
<? else: ?>

	<?=$form->select( 'referred_by', $controller->doctor_list, array( 'label' => 'Referred by', 'default' => $controller->result['referred_by'], 'class' => 'required', 'empty' => ' ( Choose Doctor ) ' ) ) ?>

<? endif; ?>

<?=$form->select( 'referred_to', $controller->doctor_list, array( 'label' => 'Referring to', 'default' => ($controller->result['referred_to']?$controller->result['referred_to']:$_GET['doctor']), 'class' => 'required', 'empty' => ' ( Choose Doctor ) ' ) ) ?>

<? if( ( $_GET['day'] && $_GET['time_slot'] ) || $controller->result['appointment'] ):
		
		$time_slot = date( 'm/d/Y', strtotime( $_GET['day'] ) ) . ' ' . AppFunctions::formatTime( $_GET['time_slot'] ); ?>

		<?=$form->textbox( 'appointment', array( 'label' => 'Appointment', 'default' => ($controller->result['appointment']?date( 'm/d/Y g:ia', strtotime( $controller->result['appointment'] ) ):$time_slot), 'class' => 'required' ) ) ?>
		
<? endif; ?>

<div class="row">

	<div class="span6">
	
		<? if( is_array( $controller->doctor_questions ) ):
		
			$counter = 0; ?>
			
			<span class="help-block"><strong>Referral Questions</strong></span>
			
			<ul id='question-list'>
			
			<? foreach( $controller->doctor_questions as $dq ): ?>
			
				
					<li>
						<a href='#' id='<?=$dq['referral_question_id'] ?>' class='question-selector'>
							<span class='selector-swatch referral-question-color-<?=$counter ?>'></span>
							<?=$controller->question_list[ $dq['referral_question_id'] ] ?>
						</a>
						<span class='selected-teeth'></span>	
					</li>				
				
				<? $counter++; ?>
			
			<? endforeach; ?>
			
			</ul>
		
		<? endif; ?>
		
	</div>
	
	<div class="span6">
	
		<span class="help-block"><strong>Tooth Chart</strong></span>
		
			<div class='tooth-chart'>
			
				<div class='deciduous-top'>
				
					<a id='A' href='#' class='tooth deciduous-tooth'>A</a>
					<a id='B' href='#' class='tooth deciduous-tooth'>B</a>
					<a id='C' href='#' class='tooth deciduous-tooth'>C</a>
					<a id='D' href='#' class='tooth deciduous-tooth'>D</a>
					<a id='E' href='#' class='tooth deciduous-tooth'>E</a>
					 		   				   			 	 
					<a id='F' href='#' class='tooth deciduous-tooth'>F</a>
					<a id='G' href='#' class='tooth deciduous-tooth'>G</a>
					<a id='H' href='#' class='tooth deciduous-tooth'>H</a>
					<a id='I' href='#' class='tooth deciduous-tooth'>I</a>
					<a id='J' href='#' class='tooth deciduous-tooth'>J</a>
				
				</div>
				
				<div class='permanent-top'>
				
					<? for( $i=1;$i<17;$i++ ): ?>
					
						<? 
							if( ( $i > 6 && $i < 11 ) || ( $i > 22 && $i < 27 ) ) {
								
								$shape = 'frisbee';
								
							} else if( $i == 6 || $i == 11 ) {
								
								$shape = 'circle';
								
							} else {
								
								$shape = 'square';
								
							}
							
						?>
					
						<a id='<?=$i ?>' href='#' class='tooth permanent-tooth <?=$shape ?>'>
							<?=$i ?>
						</a>
					
					<? endfor; ?>
				
				</div>
				
				<div class='permanent-bottom'>
				
					<? for( $i=32;$i>16;$i-- ): ?>
					
						<? 
							if( ( $i > 6 && $i < 11 ) || ( $i > 22 && $i < 27 ) ) {
								
								$shape = 'frisbee';
								
							} else if( $i == 22 || $i == 27 ) {
								
								$shape = 'circle';
								
							} else {
								
								$shape = 'square';
								
							}
							
						?>
					
						<a id='<?=$i ?>' href='#' class='tooth permanent-tooth <?=$shape ?>'><?=$i ?></a>
					
					<? endfor; ?>
				
				</div>
				
				<div class='deciduous-bottom'>
				
					<a id='T' href='#' class='tooth deciduous-tooth'>T</a>
					<a id='S' href='#' class='tooth deciduous-tooth'>S</a>
					<a id='R' href='#' class='tooth deciduous-tooth'>R</a>
					<a id='Q' href='#' class='tooth deciduous-tooth'>Q</a>
					<a id='P' href='#' class='tooth deciduous-tooth'>P</a>
											   				 
					<a id='F' href='#' class='tooth deciduous-tooth'>F</a>
					<a id='G' href='#' class='tooth deciduous-tooth'>G</a>
					<a id='H' href='#' class='tooth deciduous-tooth'>H</a>
					<a id='I' href='#' class='tooth deciduous-tooth'>I</a>
					<a id='J' href='#' class='tooth deciduous-tooth'>J</a>
				
				</div>
			
			</div>
			
			<p>Match issues with the appropriate teeth by first choosing an issue and then choosing teeth.</p>
		
	</div>

</div>

<?=$form->textarea( 'notes', array( 'label' => 'Notes', 'default' => $controller->result['notes'], 'class' => '' ) ) ?>

<p class='action-buttons'>

	<input type='submit' class="btn pull-left" value='Save'/>

	<? if( $_GET['id'] ): ?>

		<button id='delete-referral' class="btn btn-danger pull-right delete-item">Delete</button>
        
    <? else: ?>
    
    	<button id='cancel-referral' class="btn btn-danger pull-right cancel-item">Cancel</button>
        
    <? endif; ?>

</p>

</form>