<?

include( 'dd.php' );

// get all project data
$dd_data = json_decode( $issueTracker->getProjects( true ) );

// get all user data
$db->table = 'users';
$user_ids = $db->retrieve('pair','dd_id, id');

// loop through all dd data
foreach( $dd_data as $project ) {
	
	$project_data = array( 'dd_id' => $project->ID, 'name' => $project->Name, 'company' => 1 );
	
	print_r( $project );
	//print_r( $project_data );
	
	echo( '<br><br>' );
	
	$db->table = 'projects';
	$db->save( $project_data );
	
	$project_id = mysql_insert_id();
	
	$db->table = 'tasks';
	
	foreach( $project->Issues as $issue ) {
	
//		if( !$user_ids[ $issue->TesterID ] ) {
//			
//			echo( $issue->TesterName . ': ' . $issue->TesterID );
//		}
//		
//		if( !$user_ids[ $issue->CreatorID ] ) {
//			
//			echo( $issue->CreatorName . ': ' . $issue->CreatorID );
//		}
//		
//		if( !$user_ids[ $issue->ResolverID ] ) {
//			
//			echo( $issue->ResolverName . ': ' . $issue->ResolverID );
//		}
		
		$issue_data = array( 'dd_id' => $issue->OrderNumber, 'project' => $project_id, 'title' => $issue->Title, 'priority' => strtolower( $issue->PriorityLevel ), 'status' => str_replace( ' ', '_', strtolower( $issue->State ) ), 'fixer' => $user_ids[ $issue->ResolverID ], 'tester' => $user_ids[ $issue->TesterID ] );
		
		if( $issue->DueDate ) {
			
			$issue_data['due_date'] = formatDate( $issue->DueDate );
			
		}
		
		$issue_data['modified'] = formatDate( $issue->LastUpdatedDate );
		$issue_data['created'] = formatDate( $issue->CreateDate );
		
		$db->save( $issue_data );
		//print_r( $issue_data );
		
	}
	
	echo( '<br><br>' );
}

?>