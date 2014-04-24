<h1>Tasks: Multi-Edit</h1>

<div class="row task-filter">

	<form action='/multiple' class="navbar-form navbar-left" role="search">
	
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

<? if( $_GET['project'] ): ?>

	<form action='/multiple' id='data-form' method='post'>

	<? if( count( $controller->results ) ): ?>
		<?
		
			$time_estimated = 0;
			$time_tracked = 0;
			$my_time_tracked = 0;
			
		?>
		
		<div id='sortable'>
		
		<? foreach( $controller->results as $r ): ?>
		
		<?
		
			$time_estimated += $r['time_estimate'];
			$time_tracked += $controller->timesheet_list[ $r['id'] ];
			$my_time_tracked += $controller->my_timesheet_list[ $r['id'] ];
			
		?>
		
			<div class="row task-list <?=$r['priority'] ?>">
				<div class="col-md-2">
					<a href='/task_review?id=<?=$r['id'] ?>'>#<?=$r['id'] ?>: <?=$r['title'] ?></a><br>
					<span class='due-date'><?=date( 'M d', strtotime( $r['due_date'] ) ) ?></span>
					<br><?=$controller->project_list[ $r['project'] ] ?> -  Last updated on <?=date( 'M d g:ia', strtotime( $r['modified'] ) ) ?><br>
					<span class="label label-info"><?=$functions->formatTime( $r['time_estimate'] ) ?> Est.</span>
					<span class='label label-primary'>Total Tracked <?=$functions->formatTime( $controller->timesheet_list[ $r['id'] ] ) ?></span>
					
					<? if( $controller->timesheet_list[ $r['id'] ] != $controller->my_timesheet_list[ $r['id'] ] ): ?>
					
						<span class='label label-primary'>My Tracked <?=$functions->formatTime( $controller->my_timesheet_list[ $r['id'] ] ) ?></span>
						
					<? endif; ?>
					
					<input type='hidden' id='id' name='multiple[<?=$r['id'] ?>][id]' value='<?=$r['id'] ?>'/>
					
					<input type='hidden' name='multiple[<?=$r['id'] ?>][watchers]' value='<?=$r['watchers'] ?>'/>
					
				</div>
				<div class="col-md-2"><strong>Status</strong><br><?=$form->select( 'multiple['.$r['id'].'][status]', $controller->statuses, array( 'label' => '', 'default' => $r['status'], 'class' => 'required' ) ) ?></div>
				<div class="col-md-2"><strong>Estimate</strong><br><?=$form->select( 'multiple['.$r['id'].'][time_estimate]', $controller->time_segments, array( 'label' => '', 'default' => $r['time_estimate'], 'class' => '' ) ) ?></div>
				<div class="col-md-2"><strong>Due Date</strong><br><?=$form->textbox( 'multiple['.$r['id'].'][due_date]', array( 'label' => '', 'default' => $r['due_date'], 'class' => 'required datepicker' ) ) ?></div>
				<div class="col-md-2"><strong>Fixer</strong><br><?=$form->select( 'multiple['.$r['id'].'][fixer]', $controller->user_list, array( 'label' => '', 'default' => $r['fixer'], 'class' => 'required' ) ) ?></div>
				<div class="col-md-2"><strong>Tester</strong><br><?=$form->select( 'multiple['.$r['id'].'][tester]', $controller->user_list, array( 'label' => '', 'default' => $r['tester'], 'class' => 'required' ) ) ?></div>
			</div>
		
		<? endforeach; ?>
		
		</div>
		
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
	
		<div class="row task-list">
		
			<div class='form-group pull-right'>
		  	<!-- <div class='col-lg-10'> -->
		  		<button type="submit" class="btn btn-default">Save Changes</button>
		  	<!-- </div> -->
		  </div>
		
		</div>
	
	</form>
	
<? else: ?>

	<div class="row task-list">
		
		Please select a project to begin editing tasks.
	
	</div>

<? endif; ?>