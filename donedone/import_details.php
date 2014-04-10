<?

include( 'dd.php' );

// get all project data
//$dd_data = json_decode( $issueTracker->getProjects( true ) );

// get all user data
$db->table = 'users';
$user_ids = $db->retrieve('pair','dd_id, id');

// match project ids
$db->table = 'projects';
$project_ids = $db->retrieve('pair','id, dd_id');

// get tasks
$db->table = 'tasks';
$tasks = $db->retrieve('all','*');

// loop through all tasks
foreach( $tasks as $t ) {

	$db->table = 'tasks';

	$dd_data = json_decode( $issueTracker->getIssueDetails( $project_ids[ $t['project'] ], $t['dd_id'] ) );
	
	//print_r( $dd_data );
	
	$t['modified'] = formatDate( $dd_data->LastUpdated );
	$t['description'] = $dd_data->Description;
	
	$watchers = array();
	
	foreach( $dd_data->Watchers as $w ) {
		
		$watchers[] = $user_ids[ $w->ID ];
	}
	
	$t['watchers'] = implode( ',', $watchers );
	
	// save the task again
	//print_r( $t );
	$db->save( $t );
	
	$db->table = 'comments';
	
	// update all of the comments
	foreach( $dd_data->Histories as $h ) {
		
		$comment_data = array( 'user' => $user_ids[ $h->CreatorID ], 'task' => $t['id'], 'action' => $h->Action, 'description' => $h->Description, 'modified' => formatDate( $h->CreateDate ), 'created' => formatDate( $h->CreateDate ) );
		
		//print_r( $comment_data );
		
		$db->save( $comment_data );
	}
	
}

?>