<form class="form-horizontal" action='/time_entry' id='data-form' method='post' enctype="multipart/form-data">
  <fieldset>
    <legend><h1><?=$_GET['id']?'Edit':'Add' ?> Time Entry</h1></legend>



	<? if( $_GET['id'] ): ?>
	
		<input type='hidden' id='id' name='id' value='<?=$_GET['id'] ?>'/>
	
	<? endif; ?>
	
	<?=$form->select( 'project', $controller->project_list, array( 'label' => 'Project', 'default' => $controller->result['project'], 'class' => '' ) ) ?>
	
	<?=$form->select( 'task', $controller->task_list, array( 'label' => 'Task', 'default' => $controller->result['task'], 'class' => '' ) ) ?>
	
	<?=$form->textbox( 'minutes', array( 'label' => 'Minutes', 'default' => $controller->result['minutes'], 'class' => 'required' ) ) ?>
	
	<?=$form->textarea( 'description', array( 'label' => 'Description', 'default' => $controller->result['description'], 'class' => '' ) ) ?>

	<?=$form->buttons( 'time_entries', $_GET['id'] ) ?>

	</fieldset>
</form>