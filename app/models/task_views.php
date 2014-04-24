<?

class TaskViews extends DB {

	var $table = 'task_views';
	
	function __construct() {
		
		parent::__construct();
		
		if( isset( $_SESSION['logged_in_user']['id'] ) ) {
			
			// go ahead and load last views
			$this->last_viewed = $this->retrieve('pair','task_id, modified',' where user_id = ' . $_SESSION['logged_in_user']['id']);
			
		}
	
	}
	
	public function updateView( $task ) {
		
		// see if there is a current timestamp
		$current = $this->retrieve('one','*',' where task_id = ' . $task . ' and user_id = ' . $_SESSION['logged_in_user']['id']);
		
		// if this isn't already set, load up the information for it
		if( !$current['id'] ) {
			
			$current = array( 'task_id' => $task, 'user_id' => $_SESSION['logged_in_user']['id'] );
			
		}
		
		// eitherway, unset this because we're updating it
		unset( $current['modified'] );
		
		$this->save( $current );
		
	}
	
	public function isUnread( $task_info ) {
	
		// if there is no record, it's obviously unread or if the last viewed timestamp is older than the last modified
		if( !isset( $this->last_viewed[ $task_info['id'] ] ) || ( strtotime( $this->last_viewed[ $task_info['id'] ] ) < strtotime( $task_info['modified'] ) ) ) {
			
			return true;
			
		} 
		
		return false;
	
	}
	
}