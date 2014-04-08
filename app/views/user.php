<form class="form-horizontal" action='/user' id='data-form' method='post' enctype="multipart/form-data">
  <fieldset>
    <legend><h1><?=$_GET['id']?'Edit':'Add' ?> User</h1></legend>
    
    <? if( $_GET['id'] ): ?>

		<input type='hidden' id='id' name='id' value='<?=$_GET['id'] ?>'/>
	
	<? endif; ?>
    
    <?=$form->textbox( 'first_name', array( 'label' => 'First Name', 'default' => $controller->result['first_name'], 'class' => 'required' ) ) ?>

	<?=$form->textbox( 'last_name', array( 'label' => 'Last Name', 'default' => $controller->result['last_name'], 'class' => 'required' ) ) ?>
    
    <?=$form->textbox( 'email', array( 'label' => 'Email', 'default' => $controller->result['email'], 'class' => 'email' ) ) ?>
    
    <? if( $_SESSION['logged_in_user']['user_type'] == 'admin' ): ?>

		<?=$form->select( 'user_type', $controller->auth->user_types, array( 'label' => 'Type', 'default' => $controller->result['user_type'] ) ) ?>
		
	<? else: ?>
	
		<input type='hidden' id='admin' name='user_type' value='<?=$controller->result['user_type'] ?>'/>
	
	<? endif; ?>
    
    <?=$form->password( 'password', array( 'label' => 'Password', 'class' => ($_GET['id']?'':'required') ) ) ?>
    
	<?=$form->password( 'password_confirm', array( 'label' => 'Confirm Password', 'class' => '' ) ) ?>
    
    <?=$form->buttons( 'user', $_GET['id'] ) ?>
    
  </fieldset>
</form>