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
	
	<?=$form->textbox( 'time_estimate', array( 'label' => 'Estimate', 'default' => $controller->result['time_estimate'], 'class' => '' ) ) ?>
	
	<?=$form->textbox( 'due_date', array( 'label' => 'Due Date', 'default' => $controller->result['due_date'], 'class' => 'required' ) ) ?>
	
	<?=$form->select( 'fixer', $controller->user_list, array( 'label' => 'Fixer', 'default' => $controller->result['fixer'], 'class' => 'required', 'empty' => ' ( Choose ) ' ) ) ?>
	
	<?=$form->select( 'tester', $controller->user_list, array( 'label' => 'Tester', 'default' => $controller->result['tester'], 'class' => 'required', 'empty' => ' ( Choose ) ' ) ) ?>
	
	<?=$form->checkbox( 'watchers', $controller->user_list, array( 'label' => 'Watchers', 'default' => explode( ',', $controller->result['watchers'] ), 'class' => '' ) ) ?>
	
	<?=$form->textarea( 'description', array( 'label' => 'Description', 'default' => $controller->result['description'], 'class' => '' ) ) ?>

	<?=$form->buttons( 'task', $_GET['id'] ) ?>

	</fieldset>
</form>