<?

class Tasks extends DB {

	var $table = 'tasks';	
	
	function __construct() {
	
		$this->histories = new Histories;
	
		parent::__construct();
	
	}
	
	public function save( $fields ) {
	
		// build any history
		$history = $this->build_history( $fields );
		
		unset( $fields['comment'] );
		
		// format watchers
		$fields['watchers'] = is_array( $fields['watchers'] )?implode( ',', $fields['watchers'] ):$fields['watchers'];
		
		// go ahead and save it
		$toreturn = parent::save( $fields );
		
		if( !$fields['id'] ) {
			
			$fields['id'] = mysql_insert_id();
			
			$history['creation'] = 1;
			$history['new_time_estimate'] = $fields['time_estimate'];
			$history['new_fixer'] = $fields['fixer'];
			$history['new_tester'] = $fields['tester'];
			$history['new_due_date'] = $fields['due_date'];
			$history['new_status'] = $fields['status'];
			
		}
		
		
		// if there is some history here, go ahead and save it
		if( count( $history ) || $fields['comment'] ) {
		
			$history['task'] = $fields['id'];
			$history['user'] = $_SESSION['logged_in_user']['id'];
			$history['comment'] = $fields['comment'];
			
			$this->histories->save( $history );			
			
		}
		
		// send notifications
		$this->send_notifications( $fields['id'], $history );
		
		return $toreturn;
		
	}
	
	public function build_history( $fields ) {
	
		$toreturn = array();
	
		// we're only saving info if this is one that has already been created
		if( $fields['id'] ) {
			
			$current_info = $this->retrieve('one','*',' where id = ' . $fields['id'] );
			
			foreach( $this->histories->tocheck as $change_field ) {
				
				if( $fields[ $change_field ] != $current_info[ $change_field ] ) { 
				
					$toreturn[ $change_field ] = 1;
					$toreturn[ 'prev_' . $change_field ] = $current_info[ $change_field ];
					$toreturn[ 'new_' . $change_field ] = $fields[ $change_field ];
				
				}
				
			}			
			
		}
		
		return $toreturn;
		
	}
	
	public function send_notifications( $task_id, $history = array() ) {
	
		$task_info = $this->retrieve('one','*',' where id = ' . $task_id);
		
		$projects = new Projects;
		
		$project_info = $projects->retrieve('one','*',' where id = ' . $task_info['project']);
		
		$users = new Users;
		
		$user_list = $users->retrieve('pair',"id,concat( first_name, ' ', last_name )",' order by last_name, first_name'); 
		$user_emails = $users->retrieve('pair',"id,email"); 
		
		$watchers = explode( ',', $task_info['watchers'] );
		
		$functions = new AppFunctions;
		
		$fromname = $_SESSION['logged_in_user']['first_name'] . ' ' . $_SESSION['logged_in_user']['last_name'] . ' via {e}verything';
		$fromaddress = $_SESSION['logged_in_user']['email'];
		
		$body = '<h1>' . $task_info['name'] . '</h1>';
		$body .= '<p><strong>Due Date</strong>' . $task_info['due_date'] . '</p>';
		$body .= '<p><strong>Fixer</strong>' . $user_list[ $task_info['fixer'] ] . '</p>';
		$body .= '<p><strong>Tester</strong>' . $user_list[ $task_info['tester'] ] . '</p>';
		
		// if history has been included, and send appropriate emails
		if( count( $history ) ) {
			
			// send creation email
			if( $history['creation'] ) {

				$body .= '<p><strong>Creator</strong>' . $user_list[ $_SESSION['logged_in_user']['id'] ] . '</p>';
				
				// send to fixer
				$subject = '[Assigned as Fixer] ' . $project_info['name'];
				$functions->send_mail( $user_emails[ $task_info['fixer'] ], $body, $subject, $fromaddress, $fromname);
				
				// send to tester
				$subject = '[Assigned as Tester] ' . $project_info['name'];
				$functions->send_mail( $user_emails[ $task_info['tester'] ], $body, $subject, $fromaddress, $fromname);
				
				// send to watchers
				
				$subject = '[New] ' . $project_info['name'];
				
				foreach( $watchers as $w ) {
					
					$functions->send_mail( $user_emails[ $w ], $body, $subject, $fromaddress, $fromname);
					
				}
				
				
			} else { // we've updated some of the tracked information here
			
				// send to fixer
				if( $history['fixer'] )  {
					
					$subject = '[Assigned as Fixer] ' . $project_info['name'];
					$functions->send_mail( $user_emails[ $history['new_fixer'] ], $body, $subject, $fromaddress, $fromname);
					
				}
				
				// send to fixer
				if( $history['tester'] )  {
				
					// send to tester
					$subject = '[Assigned as Tester] ' . $project_info['name'];
					$functions->send_mail( $user_emails[ $history['new_tester'] ], $body, $subject, $fromaddress, $fromname);
					
				}
				
				// send to watchers
				
				$subject = '[Edit] ' . $project_info['name'];
				
				foreach( $watchers as $w ) {
					
					$functions->send_mail( $user_emails[ $w ], $body, $subject, $fromaddress, $fromname);
					
				}
				
				
			}
			
		}
	
		
	}
	
}