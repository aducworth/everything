<form class="form-horizontal" action='/project' id='data-form' method='post' enctype="multipart/form-data">
  <fieldset>
    <legend><h1><?=$_GET['id']?'Edit':'Add' ?> Project</h1></legend>



	<? if( $_GET['id'] ): ?>
	
		<input type='hidden' id='id' name='id' value='<?=$_GET['id'] ?>'/>
	
	<? endif; ?>
	
	<? if( $controller->result['image'] ): ?>
	    
		<img src="<?=$controller->site_url ?>/assets/images/uploads/thumbnails/<?=$controller->result['image'] ?>" class="pull-right" style='border-radius: 10px;'/>
	    
	<? endif; ?>
	
	<?=$form->checkbox( 'archived', array( 1 => 'Archived' ), array( 'label' => ' ', 'default' => array( $controller->result['archived'] ), 'class' => '' ) ) ?>
	
	<?=$form->textbox( 'name', array( 'label' => 'Name', 'default' => $controller->result['name'], 'class' => 'required' ) ) ?>
	
	<?=$form->select( 'company', $controller->company_list, array( 'label' => 'Company', 'default' => $controller->result['company'], 'class' => 'required', 'empty' => ' ( Choose ) ' ) ) ?>
	
	<?=$form->textarea( 'description', array( 'label' => 'Description', 'default' => $controller->result['description'], 'class' => '' ) ) ?>

	<?=$form->buttons( 'project', $_GET['id'] ) ?>

	</fieldset>
</form>