<h1>Tasks</h1>

<div class="row task-filter">

	<form action='/tasks' class="navbar-form navbar-left" role="search">
	
	  <?=$form->select( 'project', $controller->active_project_list, array( 'label' => '', 'default' => $_GET['project'], 'class' => '', 'empty' => ' ( Filter By Project ) ' ) ) ?>
	  
	  <?=$form->select( 'status', $controller->statuses, array( 'label' => '', 'default' => $_GET['status'], 'class' => '', 'empty' => ' ( Filter By Status ) ' ) ) ?>
	  
	  <?=$form->select( 'user', $controller->user_list, array( 'label' => '', 'default' => $_GET['user'], 'class' => '', 'empty' => ' ( Filter By User ) ' ) ) ?>
	  
	  <?=$form->select( 'sorting', $controller->tasks->sorting_options, array( 'label' => '', 'default' => $_GET['sorting'], 'class' => '' ) ) ?>
	  
	  <div class='form-group'>
	  	<!-- <div class='col-lg-10'> -->
	  		<button type="submit" class="btn btn-default">Submit</button>
	  	<!-- </div> -->
	  </div>
	</form>
	
</div>

<? if( count( $controller->results ) ): ?>
	<?
	
		$time_estimated = 0;
		$time_tracked = 0;
		$my_time_tracked = 0;
		
	?>
	
	<? foreach( $controller->results as $r ): ?>
	
	<?
	
		$time_estimated += $r['time_estimate'];
		$time_tracked += $controller->timesheet_list[ $r['id'] ];
		$my_time_tracked += $controller->my_timesheet_list[ $r['id'] ];
		
	?>
	
		<div class="row task-list <?=$r['priority'] ?> <?=$controller->task_views->isUnread( $r )?'unread':'' ?>">
			<div class="col-md-2"><span class='task-label'><?=$controller->statuses[ $r['status'] ] ?></span></div>
			<div class="col-md-6">
				<a href='/task_review?id=<?=$r['id'] ?>'>#<?=$r['id'] ?>: <?=$r['title'] ?></a>
				<span class='due-date'><?=date( 'M d', strtotime( $r['due_date'] ) ) ?></span>
				<br><?=$controller->project_list[ $r['project'] ] ?> -  Last updated on <?=date( 'M d g:ia', strtotime( $r['modified'] ) ) ?><br>
				<span class="label label-info"><?=$functions->formatTime( $r['time_estimate'] ) ?> Est.</span>
				<span class='label label-primary'>Total Tracked <?=$functions->formatTime( $controller->timesheet_list[ $r['id'] ] ) ?></span>
				
				<? if( $controller->timesheet_list[ $r['id'] ] != $controller->my_timesheet_list[ $r['id'] ] ): ?>
				
					<span class='label label-primary'>My Tracked <?=$functions->formatTime( $controller->my_timesheet_list[ $r['id'] ] ) ?></span>
					
				<? endif; ?>
				
			</div>
			<div class="col-md-2"><strong>Fixer</strong><br><?=$controller->user_list[ $r['fixer'] ] ?></div>
			<div class="col-md-2"><strong>Tester</strong><br><?=$controller->user_list[ $r['tester'] ] ?></div>
		</div>
	
	<? endforeach; ?>
	
	<div class="row task-list">
	
		<span class="label label-success"><?=count( $controller->tasks ) ?> Tasks</span>
		<span class="label label-info"><?=$functions->formatTime( $time_estimated ) ?> Total Estimated Time</span>
		<span class='label label-primary'><?=$functions->formatTime( $time_tracked ) ?> Total Time Tracked</span>
		<span class='label label-primary'><?=$functions->formatTime( $my_time_tracked ) ?> My Time Tracked</span>
	
	</div>
	
<? else: ?>

	<div class="row task-list">
	
		No tasks match your search.
	
	</div>

<? endif; ?>