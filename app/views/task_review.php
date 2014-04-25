<div class="row <?=$controller->result['priority'] ?>">
		<div class="col-md-8 task-review-mainbar">
		
			<span class='label'>#<?=$controller->result['id'] ?></span>		
			<span class='label'><?=$controller->priorities[ $controller->result['priority'] ] ?></span>	
			<span class='label'><?=$controller->statuses[ $controller->result['status'] ] ?></span>	
			<span class='label'><?=date( 'M d', strtotime( $controller->result['due_date'] ) ) ?></span><br><br>
			
			<a href='/task?id=<?=$controller->result['id'] ?>'>edit</a>	
			
			<h1><?=$controller->result['title'] ?></h1>
			
			<p><?=$functions->convertText( $controller->result['description'] ) ?></p>
			
			<? if( count( $controller->result['histories'] ) ): ?>
			
			<div class="row task-comments">
			
				<? $i = 1; ?>
			
				<? foreach( $controller->result['histories'] as $c ): ?>
				
					<div class="row">
					
						<div class="col-md-2">
							<?=$controller->users->get_avatar( $c['user'] ) ?>
						</div>
						<div class="col-md-7">
							#<?=$i ?> <?=date( 'M d g:ia', strtotime( $c['created'] ) ) ?>
							<h3><?=$controller->histories->build_history_action( $c, $controller->user_list ) ?></h3>
							
							<?=$controller->histories->build_history_description( $c, $controller->user_list ) ?>
							
							<p><?=$functions->convertText( $c['comment'] ) ?></p>
							
						</div>
					
					</div>
					
					<? $i++; ?>
					
				<? endforeach; ?>
			
			</div>
			
			<? endif; ?>
						
			<form class="form-horizontal" action='/task_review' id='data-form' method='post' enctype="multipart/form-data">
			  <fieldset>
			    <legend><h1>Comment</h1></legend>
			
			
			
				<? if( $_GET['id'] ): ?>
				
					<input type='hidden' id='id' name='id' value='<?=$_GET['id'] ?>'/>
					
					<input type='hidden' name='watchers' value='<?=$controller->result['watchers'] ?>'/>
				
				<? endif; ?>
				
				<?=$form->select( 'time_estimate', $controller->time_segments, array( 'label' => 'Estimate', 'default' => $controller->result['time_estimate'], 'class' => '' ) ) ?>
				
				<?=$form->textbox( 'due_date', array( 'label' => 'Due Date', 'default' => $controller->result['due_date'], 'class' => 'required datepicker' ) ) ?>
					
				<?=$form->select( 'status', $controller->statuses, array( 'label' => 'Status', 'default' => $controller->result['status'], 'class' => 'required' ) ) ?>
				<?=$form->select( 'fixer', $controller->user_list, array( 'label' => 'Fixer', 'default' => $controller->result['fixer'], 'class' => 'required', 'empty' => ' ( Choose ) ' ) ) ?>
				
				<?=$form->select( 'tester', $controller->user_list, array( 'label' => 'Tester', 'default' => $controller->result['tester'], 'class' => 'required', 'empty' => ' ( Choose ) ' ) ) ?>
				
				<?=$form->textarea( 'comment', array( 'label' => 'Comment', 'default' => '', 'class' => '' ) ) ?>
			
				<?=$form->buttons( 'comment', 0 ) ?>
			
				</fieldset>
			</form>
			
			
		</div>
		<div class="col-lg-4 task-review-sidebar">
		
			<h3>People</h3>
			
			<strong>Fixer</strong><br><?=$controller->user_list[ $controller->result['fixer'] ] ?><br><br>
			
			<strong>Tester</strong><br><?=$controller->user_list[ $controller->result['tester'] ] ?>
			
			<? if( count( $controller->result['task_timesheet'] ) ): ?>
			
				<h3>Task Timesheet</h3>
			
				<? foreach( $controller->result['task_timesheet'] as $user => $minutes ): ?>
				
					<strong><?=$controller->user_list[ $user ] ?></strong> <?=$functions->formatTime( $minutes ) ?></br>
				
				<? endforeach; ?>
			
			<? endif; ?>
			
			<? $watchers = explode( ',', $controller->result['watchers'] ); ?>
			
			<? if( count( $watchers ) ): ?>
			
				<h3>CC'd</h3>
			
				<? foreach( $watchers as $w ): ?>
				
					<?=$controller->user_list[ $w ] ?><br>
					
				<? endforeach; ?>
			
			<? endif; ?>
			
		</div>
</div>