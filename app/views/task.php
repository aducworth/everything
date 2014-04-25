<form class="form-horizontal" action='/task' id='data-form' method='post' enctype="multipart/form-data">
  <fieldset>
    <legend><h1><?=$_GET['id']?'Edit':'Add' ?> Task</h1></legend>



	<? if( $_GET['id'] ): ?>
	
		<input type='hidden' id='id' name='id' value='<?=$_GET['id'] ?>'/>
	
	<? endif; ?>
		
	<?=$form->textbox( 'title', array( 'label' => 'Title', 'default' => $controller->result['title'], 'class' => 'required' ) ) ?>
	
	<?=$form->select( 'project', $controller->active_project_list, array( 'label' => 'Project', 'default' => $controller->result['project'], 'class' => 'required', 'empty' => ' ( Choose ) ' ) ) ?>
	
	<?=$form->select( 'status', $controller->statuses, array( 'label' => 'Status', 'default' => $controller->result['status'], 'class' => 'required' ) ) ?>
	
	<?=$form->select( 'priority', $controller->priorities, array( 'label' => 'Priority', 'default' => $controller->result['priority'], 'class' => 'required' ) ) ?>
	
	<?=$form->select( 'time_estimate', $controller->time_segments, array( 'label' => 'Estimate', 'default' => $controller->result['time_estimate'], 'class' => '', 'empty' => ' ( Choose Estimate ) ' ) ) ?>
	
	<?=$form->textbox( 'due_date', array( 'label' => 'Due Date', 'default' => $controller->result['due_date'], 'class' => 'required datepicker' ) ) ?>
	
	<?=$form->select( 'fixer', $controller->user_list, array( 'label' => 'Fixer', 'default' => $controller->result['fixer'], 'class' => 'required', 'empty' => ' ( Choose ) ' ) ) ?>
	
	<?=$form->select( 'tester', $controller->user_list, array( 'label' => 'Tester', 'default' => $controller->result['tester'], 'class' => 'required', 'empty' => ' ( Choose ) ' ) ) ?>
	
	<?=$form->select( 'bucket', array( 0 => 'Not Billable', 1 => 'Billable' ), array( 'label' => 'Bucket', 'default' => $controller->result['bucket'], 'class' => '' ) ) ?>
	
	<?=$form->select( 'completion_order', array(), array( 'label' => 'Completion Order', 'default' => $controller->result['completion_order'], 'class' => '', 'range' => array( 'lower' => 1, 'upper' => 100 ) ) ) ?>
	
	<?=$form->checkbox( 'watchers', $controller->user_list, array( 'label' => 'Watchers', 'default' => explode( ',', $controller->result['watchers'] ), 'class' => '' ) ) ?>
	
	<?=$form->textarea( 'description', array( 'label' => 'Description', 'default' => $controller->result['description'], 'class' => '' ) ) ?>
	
	<?=$form->textbox( 'tags', array( 'label' => 'Tags', 'default' => $controller->result['tags'], 'class' => '' ) ) ?>
	
	<?=$form->file( 'attachments[1]', array( 'label' => 'Attachment', 'class' => '' ) ) ?>

	<?=$form->buttons( 'task', $_GET['id'] ) ?>

	</fieldset>
</form>