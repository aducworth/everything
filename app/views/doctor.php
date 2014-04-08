<h1><?=$_GET['id']?'Edit':'Add' ?> Doctor for <?=$controller->office_list[ $_SESSION['logged_in_user']['office_id'] ] ?></h1>

<form action='/doctor' id='data-form' method='post' enctype="multipart/form-data">

<? if( $_GET['id'] ): ?>

	<input type='hidden' id='id' name='id' value='<?=$_GET['id'] ?>'/>

<? endif; ?>

<? if( $_SESSION['logged_in_user']['office_id'] ): ?>

	<input type='hidden' id='office_id' name='office_id' value='<?=$_SESSION['logged_in_user']['office_id'] ?>'/>
	
<? else: ?>

	<?=$form->select( 'office_id', $controller->office_list, array( 'label' => 'Office', 'default' => $controller->result['office_id'], 'empty' => ' ( Choose Office ) ', 'class' => 'required' ) ) ?>
	
<? endif; ?>

<? if( $controller->result['image'] ): ?>
    
	<img src="<?=$controller->site_url ?>/images/uploads/thumbnails/<?=$controller->result['image'] ?>" class="pull-right" style='border-radius: 10px;'/>
    
<? endif; ?>


<?=$form->textbox( 'fname', array( 'label' => 'First Name', 'default' => $controller->result['fname'], 'class' => 'required' ) ) ?>
<?=$form->textbox( 'lname', array( 'label' => 'Last Name', 'default' => $controller->result['lname'], 'class' => 'required' ) ) ?>

<p><label>Image ( Please restrict photos to jpgs. The image will automatically be resized. ):</label><input type='file' name='image' class='<?=$controller->result['image']?'':'required' ?>'/></p>

<?=$form->textbox( 'credentials', array( 'label' => 'Credentials', 'default' => $controller->result['credentials'], 'class' => '' ) ) ?>
<?=$form->select( 'appointment_length', $controller->appointment_lengths, array( 'label' => 'Appointment Length', 'default' => $controller->result['appointment_length'], 'empty' => ' ( Choose Appointment Length ) ', 'class' => 'required' ) ) ?>
<?=$form->select( 'concurrent_appointments', array(), array( 'label' => 'Concurrent Appointments', 'default' => $controller->result['concurrent_appointments'], 'empty' => ' ( Choose Concurrent Appointments ) ', 'class' => 'required', 'range' => array( 'lower' => 1, 'upper' => 6 ) ) ) ?>
<?=$form->select( 'doctor_type_id', $controller->doctor_type_list, array( 'label' => 'Doctor Type', 'default' => $controller->result['doctor_type_id'], 'empty' => ' ( Choose Doctor Type ) ', 'class' => 'required' ) ) ?>

<? foreach( $controller->referral_question_list as $doctor_type => $questions ): ?>

	<div id='doctor-type-<?=$doctor_type ?>' class='questions-by-doctor-type' <?=( $controller->result['doctor_type_id'] != $doctor_type )?"style='display: none';":"" ?>>	
	
		<?=$form->checkbox( 'referral_questions', $questions, array( 'label' => ( $controller->doctor_type_list[ $doctor_type ] . ' Referral Questions' ), 'default' => ($controller->result['referral_questions']?$controller->result['referral_questions']:array()), 'class' => '' ) ) ?>
		
	</div>

<? endforeach; ?>

<? if( $_GET['id'] ): ?> 

	<h2>Hours Available for Appointment</h2>
	
	<div style='padding: 10px 0px 10px 0px; width: 80%'>
	
		<a href="/doctor_hour?doctor_id=<?=$controller->result['id'] ?>">Add Hours</a>
	
	</div>
	
	<? if( count( $controller->result['doctor_hours'] ) ): ?>
	
		<table id='default-table' class="table table-striped table-condensed">
		
			<thead>
		    	<tr>
		        	<th>Day of Week</th>
		        	<th>Starting Hour</th>
		        	<th>Ending Hour</th>
		            <th>&nbsp;</th>
		        </tr>
		    </thead>
		    
		    <tbody>
		    
		    	<? foreach( $controller->result['doctor_hours'] as $r ): ?>
		                
		        <tr>
		        	<td><?=$r['day_of_week'] ?></td>
		        	<td><?=$controller->appointment_hours[ $r['starting_hour'] ] ?></td>
					<td><?=$controller->appointment_hours[ $r['ending_hour'] ] ?></td>
		            <td><a href='/doctor_hour?id=<?=$r['id'] ?>'>edit</a> - <a href='/delete?id=<?=$r['id'] ?>&model=doctor_hours' onclick="return confirm( 'Are you sure?' )">delete</a></td>
		        </tr>
		        
		        <? endforeach; ?>
		        
		    </tbody>
		
		</table>
	
	<? else: ?>
	
		<p>No hours have been set up for this doctor.</p>
	    
	<? endif; ?>

<? endif; ?>

<p class='action-buttons'>

	<input type='submit' class="btn pull-left" value='Save'/>

	<? if( $_GET['id'] ): ?>

		<button id='delete-doctor' class="btn btn-danger pull-right delete-item">Delete</button>
        
    <? else: ?>
    
    	<button id='cancel-doctor' class="btn btn-danger pull-right cancel-item">Cancel</button>
        
    <? endif; ?>

</p>

</form>