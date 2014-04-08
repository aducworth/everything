<?

session_start();

//print_r( $_GET );

include( 'app/db.php' );
include( 'app/auth.php' );
include( 'app/controller.php' );
include( 'app/form.php' );
include( 'app/resize.php' );
include( 'app/functions.php' );

$controller = new AppController;
$functions = new AppFunctions;
$form 		= new Form;

$action = $_GET['url']?$_GET['url']:'index';

if( method_exists( $controller, $action ) ) {
	
	$controller->$action();
		
}

if( !$_GET['ajax'] ) {
	
	include( 'app/views/header.php' );
	
}

if( file_exists( 'app/views/' . $action . '.php' ) ) {
	
	include( 'app/views/' . $action . '.php' );
	
} else {
	
	include( 'app/views/404.php' );
	
}

if( !$_GET['ajax'] ) {

	include( 'app/views/footer.php' );

}

?>