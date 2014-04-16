<h1>Activity</h1>

<div class="row task-filter">

	<form class="navbar-form navbar-left" role="search">
	
	  <?=$form->select( 'project', $controller->active_project_list, array( 'label' => '', 'default' => $_GET['project'], 'class' => '', 'empty' => ' ( Filter By Project ) ' ) ) ?>
	  
	  <?=$form->select( 'user', $controller->user_list, array( 'label' => '', 'default' => $_GET['user'], 'class' => '', 'empty' => ' ( Filter By User ) ' ) ) ?>
	  
	  <?=$form->textbox( 'from', array( 'label' => '', 'default' => $_GET['from'], 'class' => 'datepicker', 'placeholder' => 'from' ) ) ?>
	  <?=$form->textbox( 'to', array( 'label' => '', 'default' => $_GET['to'], 'class' => 'datepicker', 'placeholder' => 'to' ) ) ?>
	  
	  <button type="submit" class="btn btn-default">Submit</button>
	</form>
	
</div>

<? if( count( $controller->results ) ): ?>
	<?
	
		$current_day = '';
	
////		$time_estimated = 0;
////		$time_tracked = 0;
////		$my_time_tracked = 0;
		
	?>
	
	<? foreach( $controller->results as $r ): ?>
	
	<?
	
//		$time_estimated += $r['time_estimate'];
//		$time_tracked += $controller->timesheet_list[ $r['id'] ];
//		$my_time_tracked += $controller->my_timesheet_list[ $r['id'] ];
		
	?>
	
		<div class="row task-list">
			<div class="col-md-2">
				<h2>
					<? if( $current_day != date( 'M d', strtotime( $r['created'] ) ) ): ?>
					
						<? $current_day = date( 'M d', strtotime( $r['created'] ) ); ?>
						
						<?=$current_day ?>
						
					<? endif; ?>
				</h2>
			</div>
			<div class="col-md-1"><?=date( 'g:ia', strtotime( $r['created'] ) ); ?></div>
			<div class="col-md-1"><?=$controller->users->get_avatar( $r['user'] ) ?></div>
			<div class="col-md-6">
				<a href='/task_review?id=<?=$r['task'] ?>'><?=$controller->project_list[ $controller->task_project_list[ $r['task'] ] ] ?> #<?=$r['task'] ?>: <?=$controller->task_list[ $r['task'] ] ?></a>
				
				<h4><?=$controller->histories->build_history_action( $r, $controller->user_list ) ?></h4>
				
				<?=$controller->histories->build_history_description( $r, $controller->user_list ) ?>
							
				<p><?=nl2br( $r['comment'] ) ?></p>
				
			</div>
			
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
	
		No activity matches your search.
	
	</div>

<? endif; ?>