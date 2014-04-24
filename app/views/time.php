<h1>Time</h1>

<div class="row task-filter">

	<form class="navbar-form navbar-left" role="search">
	
	  <?=$form->select( 'project', $controller->project_list, array( 'label' => '', 'default' => $_GET['project'], 'class' => '', 'empty' => ' ( Filter By Project ) ' ) ) ?>
	  
	  <?=$form->select( 'user', $controller->user_list, array( 'label' => '', 'default' => $_GET['user'], 'class' => '', 'empty' => ' ( Filter By User ) ' ) ) ?>
	  
	  <?=$form->textbox( 'from', array( 'label' => '', 'default' => $_GET['from'], 'class' => 'datepicker', 'placeholder' => 'from' ) ) ?>
	  
	  <?=$form->textbox( 'to', array( 'label' => '', 'default' => $_GET['to'], 'class' => 'datepicker', 'placeholder' => 'to' ) ) ?>
	  
	  <button type="submit" class="btn btn-default">Submit</button>
	</form>
	
</div>

<? if( count( $controller->time_entries ) ): ?>
	<?
	
		$current_date = '';
		$total_minutes = 0;
		
		$project_summary = array();
		$task_summary = array();
			
	?>
	
	<? foreach( $controller->time_entries as $r ): ?>
	
	<?
	
		$project_summary[ $r['project'] ] += $r['total_minutes'];
		$task_summary[ $r['project'] ][ $r['task'] ] += $r['total_minutes'];
		
		$total_minutes += $r['total_minutes'];
		
	?>
	
	<? if( $r['entry_date'] != $current_date ): ?>
	
		<? if( $current_date != '' ): ?>
		
			<div class="row task-list"><h3 class='pull-right'><?=$functions->formatTime( $controller->time_entries_by_day[ $current_date ] ) ?></h3></div>
			
		<? endif; ?>
	
		<div class="row task-list"><h3><?=date( 'M d, Y', strtotime( $r['entry_date'] ) ) ?></h3></div>
		
		<? $current_date = $r['entry_date']; ?>
	
	<? endif; ?>
	
		<div class="row task-list">
			<div class="col-md-4"><?=$controller->project_list[ $r['project'] ]?$controller->project_list[ $r['project'] ]:'Not Specified' ?></div>
			<div class="col-md-4"><?=$controller->task_list[ $r['task'] ]?$controller->task_list[ $r['task'] ]:'Not Specified' ?></div>
			<div class="col-md-2"><?=$controller->user_list[ $r['user'] ]?$controller->user_list[ $r['user'] ]:'Not Specified' ?></div>
			<div class="col-md-2"><?=$functions->formatTime( $r['total_minutes'] ) ?></div>
		</div>
	
	<? endforeach; ?>
	
	<div class="row task-list"><h3 class='pull-right'><?=$functions->formatTime( $controller->time_entries_by_day[ $current_date ] ) ?></h3></div>
	
	<div class="row task-list"><h3 class='pull-right'>Total Time<?=$functions->formatTime( $total_minutes ) ?></h3></div>
	
	<? foreach( $project_summary as $project => $minutes ): ?>
	
		<div class="row task-list"><h3><?=$controller->project_list[ $project ]?$controller->project_list[ $project ]:'Not Specified' ?> ( <?=$functions->formatTime( $minutes ) ?> ) </h3></div>
		
		<? foreach( $task_summary[ $project ] as $task => $task_minutes ): ?>
		
			<div class="row task-list">
				<div class="col-md-4"><?=$controller->task_list[ $task ]?$controller->task_list[ $task ]:'Not Specified' ?></div>
				<div class="col-md-2">&nbsp;</div>
				<div class="col-md-2"><?=$functions->formatTime( $task_minutes ) ?></div>
			</div>
		
		<? endforeach; ?>
	
	<? endforeach; ?>
	
	<div class="row task-list">
	
		<span class="label label-success"><?=count( $controller->tasks ) ?> Tasks</span>
		<span class="label label-info"><?=$functions->formatTime( $time_estimated ) ?> Total Estimated Time</span>
		<span class='label label-primary'><?=$functions->formatTime( $time_tracked ) ?> Total Time Tracked</span>
		<span class='label label-primary'><?=$functions->formatTime( $my_time_tracked ) ?> My Time Tracked</span>
	
	</div>
	
<? else: ?>

	<div class="row task-list">
	
		No time entries match your search.
	
	</div>

<? endif; ?>