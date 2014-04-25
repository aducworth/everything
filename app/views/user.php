<form class="form-horizontal" action='/user' id='data-form' method='post' enctype="multipart/form-data">
  <fieldset>
    <legend><h1><?=$_GET['id']?'Edit':'Add' ?> User</h1></legend>
    
    <? if( $_GET['id'] ): ?>

		<input type='hidden' id='id' name='id' value='<?=$_GET['id'] ?>'/>
	
	<? endif; ?>
	
	<? if( $controller->result['image'] ): ?>
	
		<div class='form-group'>
		
			<label for='input-' class='col-lg-2 control-label'>Profile Pic</label>
			
			<?=$controller->users->get_avatar( $controller->result['id'] ) ?>
	    
		</div>
	    
	<? endif; ?>
    
    <?=$form->select( 'company', $controller->company_list, array( 'label' => 'Company', 'default' => $controller->result['company'], 'class' => 'required' ) ) ?>
    
    <?=$form->textbox( 'first_name', array( 'label' => 'First Name', 'default' => $controller->result['first_name'], 'class' => 'required' ) ) ?>

	<?=$form->textbox( 'last_name', array( 'label' => 'Last Name', 'default' => $controller->result['last_name'], 'class' => 'required' ) ) ?>
    
    <?=$form->textbox( 'email', array( 'label' => 'Email', 'default' => $controller->result['email'], 'class' => 'email' ) ) ?>
    
    <?=$form->textbox( 'hourly_rate', array( 'label' => 'Hourly Rate', 'default' => $controller->result['hourly_rate'], 'class' => 'required number' ) ) ?>
    
    <?=$form->textbox( 'billable_rate', array( 'label' => 'Billable Rate', 'default' => $controller->result['billable_rate'], 'class' => 'required number' ) ) ?>
    
    <? if( $_SESSION['logged_in_user']['user_type'] == 'admin' ): ?>

		<?=$form->select( 'user_type', $controller->auth->user_types, array( 'label' => 'Type', 'default' => $controller->result['user_type'] ) ) ?>
		
	<? else: ?>
	
		<input type='hidden' id='admin' name='user_type' value='<?=$controller->result['user_type'] ?>'/>
	
	<? endif; ?>
	
	<?=$form->file( 'image', array( 'label' => 'Logo', 'default' => $controller->result['image'], 'class' => '', 'help' => 'Image ( Please restrict photos to jpgs. The image will automatically be resized. )' ) ) ?>
    
    <?=$form->password( 'password', array( 'label' => 'Password', 'class' => ($_GET['id']?'':'required') ) ) ?>
    
	<?=$form->password( 'password_confirm', array( 'label' => 'Confirm Password', 'class' => '' ) ) ?>
    
    <?=$form->buttons( 'user', $_GET['id'] ) ?>
    
  </fieldset>
</form>