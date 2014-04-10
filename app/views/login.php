<form class="form-horizontal" action='/login' id='data-form' method='post'>
  <fieldset>
    <legend><h1>Login</h1></legend>

<form action='/login' method='post'>

<?=$form->textbox( 'email', array( 'label' => 'Email' ) ) ?>
<?=$form->password( 'password', array( 'label' => 'Password' ) ) ?>

	<p><input type='submit' value='Login' class='btn'/></p>

	</fieldset>
</form>