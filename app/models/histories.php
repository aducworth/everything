<?

class Histories extends DB {

	var $table = 'histories';	
	
	public $tocheck = array( 'time_estimate', 'fixer', 'tester', 'due_date', 'status' );
	
	public function build_history_action( $history, $users ) {
	
		$functions = new AppFunctions;
	
		$toreturn = $users[ $history['user'] ];
		
		// this comes from done done, otherwise, it's dynamic
		if( $history['action'] != '' ) {
			
			return $history['action'];
			
		}
		
		$total = 0;
		$changes = array();
		
		foreach( $this->tocheck as $field ) {
			
			$total += $history[ $field ];
			
			if( $history[ $field ] == 1 ) {
				
				if( $field == 'fixer' ) {
					
					$changes[] = 'changed the fixer from ' . $users[ $history['prev_fixer'] ] . ' to ' . $users[ $history['new_fixer'] ];
					
				} elseif( $field == 'tester' ) {
					
					$changes[] = 'changed the tester from ' . $users[ $history['prev_tester'] ] . ' to ' . $users[ $history['new_tester'] ];
					
				} elseif( $field == 'time_estimate' ) {
					
					$changes[] = 'changed the estimate from ' . $functions->formatTime( $history['prev_time_estimate'] ) . ' to ' . $functions->formatTime( $history['new_time_estimate'] );
					
				} elseif( $field == 'due_date' ) {
					
					$changes[] = 'changed the due date from ' . $history['prev_due_date'] . ' to ' . $history['new_due_date'];
					
				} elseif( $field == 'status' ) {
					
					$changes[] = 'changed the status from ' . $history['prev_status'] . ' to ' . $history['new_status'];
					
				}
			}
			
		}
		
		// update it if this is when the item was created
		if( $history['creation'] ) {
			
			return $toreturn . ' created the task.';
			
		}
		
		if( $total == 0 ) {
			
			return $toreturn . ' added a comment.';
			
		}
		
		if( $total > 1 ) {
			
			return $toreturn . ' edited the task.';
			
		}
		
		return $toreturn . ' ' . implode( ', ', $changes ) . '.';
		
	}
	
	public function build_history_description( $history, $users ) {
	
		$functions = new AppFunctions;
	
		$toreturn = '';
		
		// this comes from done done, otherwise, it's dynamic
		if( $history['action'] != '' ) {
			
			return $history['action'];
			
		}
		
		$total = 0;
		$changes = array();
		
		foreach( $this->tocheck as $field ) {
			
			$total += $history[ $field ];
			
			if( $history[ $field ] == 1 ) {
				
				if( $field == 'fixer' ) {
					
					$changes[] = 'Changed the fixer from ' . $users[ $history['prev_fixer'] ] . ' to ' . $users[ $history['new_fixer'] ];
					
				} elseif( $field == 'tester' ) {
					
					$changes[] = 'Changed the tester from ' . $users[ $history['prev_tester'] ] . ' to ' . $users[ $history['new_tester'] ];
					
				} elseif( $field == 'time_estimate' ) {
					
					$changes[] = 'Changed the estimate from ' . $functions->formatTime( $history['prev_time_estimate'] ) . ' to ' . $functions->formatTime( $history['new_time_estimate'] );
					
				} elseif( $field == 'due_date' ) {
					
					$changes[] = 'Changed the due date from ' . $history['prev_due_date'] . ' to ' . $history['new_due_date'];
					
				} elseif( $field == 'status' ) {
					
					$changes[] = 'Changed the status from ' . $history['prev_status'] . ' to ' . $history['new_status'];
					
				}
			}
			
		}
		
		// update it if this is when the item was created
		if( $history['creation'] ) {
			
			return 'Assigned the fixer to ' . $users[ $history['new_fixer'] ] . ', assigned the tester to ' . $users[ $history['new_tester'] ] . '. The task is marked as ' . $history['new_status'] . '.';
			
		}
		
		if( $total < 2 ) {
			
			return '';
			
		}
		
		return $toreturn . ' ' . implode( '<br>', $changes );
		
	}

	
}