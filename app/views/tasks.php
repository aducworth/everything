<h1>Tasks</h1>

<div class="row task-filter">

	<form class="navbar-form navbar-left" role="search">
	
	  <?=$form->select( 'project', $controller->project_list, array( 'label' => '', 'default' => $_GET['project'], 'class' => '', 'empty' => ' ( Filter By Project ) ' ) ) ?>
	  
	  <?=$form->select( 'status', $controller->statuses, array( 'label' => '', 'default' => $_GET['status'], 'class' => '', 'empty' => ' ( Filter By Status ) ' ) ) ?>
	  
	  <?=$form->select( 'user', $controller->user_list, array( 'label' => '', 'default' => $_GET['user'], 'class' => '', 'empty' => ' ( Filter By User ) ' ) ) ?>
	  
	  <button type="submit" class="btn btn-default">Submit</button>
	</form>
	
</div>

<? if( count( $controller->tasks ) ): ?>
	<?
	
		$time_estimated = 0;
		$time_tracked = 0;
		
	?>
	
	<? foreach( $controller->tasks as $r ): ?>
	
	<?
	
		$time_estimated += $r['time_estimate'];
		$time_tracked += $controller->timesheet_list[ $r['id'] ];
		
	?>
	
		<div class="row task-list <?=$r['priority'] ?>">
			<div class="col-md-2"><span class='task-label'><?=$controller->statuses[ $r['status'] ] ?></span></div>
			<div class="col-md-6">
				<a href='/task_review?id=<?=$r['id'] ?>'>#<?=$r['id'] ?>: <?=$r['title'] ?></a>
				<span class='due-date'><?=date( 'M d', strtotime( $r['due_date'] ) ) ?></span>
				<br><?=$r['description'] ?>
				<span class="label label-info"><?=$functions->formatTime( $r['time_estimate'] ) ?> Est.</span>
				<span class='label label-primary'><?=$functions->formatTime( $controller->timesheet_list[ $r['id'] ] ) ?></span>
			</div>
			<div class="col-md-2"><strong>Fixer</strong><br><?=$controller->user_list[ $r['fixer'] ] ?></div>
			<div class="col-md-2"><strong>Tester</strong><br><?=$controller->user_list[ $r['tester'] ] ?></div>
		</div>
	
	<? endforeach; ?>
	
	<div class="row task-list">
	
		<span class="label label-success"><?=count( $controller->tasks ) ?> Tasks</span>
		<span class="label label-info"><?=$functions->formatTime( $time_estimated ) ?> Total Estimated Time</span>
		<span class='label label-primary'><?=$functions->formatTime( $time_tracked ) ?> Total Time Tracked</span>
	
	</div>
	
<? else: ?>

	<div class="row task-list">
	
		No tasks match your search.
	
	</div>

<? endif; ?>