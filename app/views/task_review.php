<div class="row <?=$controller->result['priority'] ?>">
		<div class="col-md-8 task-review-mainbar">
		
			<span class='label'>#<?=$controller->result['id'] ?></span>		
			<span class='label'><?=$controller->priorities[ $controller->result['priority'] ] ?></span>	
			<span class='label'><?=$controller->statuses[ $controller->result['status'] ] ?></span>	
			<span class='label'><?=date( 'M d', strtotime( $controller->result['due_date'] ) ) ?></span>	
			
			<h1><?=$controller->result['title'] ?></h1>
			
			<p><?=nl2br( $controller->result['description'] ) ?></p>
			
			<? if( count( $controller->comments ) ): ?>
			
			<div class="row task-comments">
			
				<? $i = 1; ?>
			
				<? foreach( $controller->comments as $c ): ?>
				
					<div class="row">
					
						<div class="col-md-2">&nbsp;</div>
						<div class="col-md-7">
							#<?=$i ?> <?=date( 'M d g:ia', strtotime( $c['created'] ) ) ?>
							<h2><?=$controller->user_list[ $c['user'] ] ?> added a comment.</h2>
							
							<p><?=nl2br( $c['description'] ) ?></p>
							
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
				
				<? endif; ?>
					
				<?=$form->select( 'status', $controller->statuses, array( 'label' => 'Status', 'default' => $controller->result['status'], 'class' => 'required' ) ) ?>
				<?=$form->select( 'fixer', $controller->user_list, array( 'label' => 'Fixer', 'default' => $controller->result['fixer'], 'class' => 'required', 'empty' => ' ( Choose ) ' ) ) ?>
				
				<?=$form->textarea( 'description', array( 'label' => 'Description', 'default' => '', 'class' => '' ) ) ?>
			
				<?=$form->buttons( 'comment', 0 ) ?>
			
				</fieldset>
			</form>
			
			
		</div>
		<div class="col-md-4 task-review-sidebar">
			
			<strong>Fixer</strong><br><?=$controller->user_list[ $controller->result['fixer'] ] ?><br><br>
			
			<strong>Tester</strong><br><?=$controller->user_list[ $controller->result['tester'] ] ?>
			
		</div>
</div>