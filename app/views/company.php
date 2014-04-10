<form class="form-horizontal" action='/company' id='data-form' method='post' enctype="multipart/form-data">
  <fieldset>
    <legend><h1><?=$_GET['id']?'Edit':'Add' ?> Company</h1></legend>



	<? if( $_GET['id'] ): ?>
	
		<input type='hidden' id='id' name='id' value='<?=$_GET['id'] ?>'/>
	
	<? endif; ?>
	
	<? if( $controller->result['image'] ): ?>
	    
		<img src="<?=$controller->site_url ?>/assets/images/uploads/thumbnails/<?=$controller->result['image'] ?>" class="pull-right" style='border-radius: 10px;'/>
	    
	<? endif; ?>
	
	<?=$form->textbox( 'name', array( 'label' => 'Name', 'default' => $controller->result['name'], 'class' => 'required' ) ) ?>
	<?=$form->textbox( 'address', array( 'label' => 'Address', 'default' => $controller->result['address'], 'class' => 'required' ) ) ?>
	<?=$form->textbox( 'address2', array( 'label' => ' ', 'default' => $controller->result['address2'], 'class' => '' ) ) ?>
	<?=$form->textbox( 'city', array( 'label' => 'City', 'default' => $controller->result['city'], 'class' => 'required' ) ) ?>
	<?=$form->textbox( 'state', array( 'label' => 'State', 'default' => $controller->result['state'], 'class' => 'required' ) ) ?>
	<?=$form->textbox( 'zipcode', array( 'label' => 'Zipcode', 'default' => $controller->result['zipcode'], 'class' => 'required' ) ) ?>
	<?=$form->textbox( 'email', array( 'label' => 'Email', 'default' => $controller->result['email'], 'class' => 'required email' ) ) ?>
	<?=$form->textbox( 'phone', array( 'label' => 'Phone', 'default' => $controller->result['phone'], 'class' => 'required phone' ) ) ?>
	
	<?=$form->file( 'image', array( 'label' => 'Logo', 'default' => $controller->result['image'], 'class' => '', 'help' => 'Image ( Please restrict photos to jpgs. The image will automatically be resized. )' ) ) ?>
	
	<?=$form->textarea( 'description', array( 'label' => 'Description', 'default' => $controller->result['description'], 'class' => '' ) ) ?>

	<?=$form->buttons( 'company', $_GET['id'] ) ?>

	</fieldset>
</form>