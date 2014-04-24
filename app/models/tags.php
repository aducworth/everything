<?

class Tags extends DB {

	var $table = 'tags';
	
	public function saveTags( $task, $project, $tags ) {
		
		$this->query( "delete from " . $this->table . " where task_id = " . $task );
		
		if( count( $tags ) ) {
			
			foreach( $tags as $tag ) {
			
				$tag = trim( $tag );
				
				if( $tag ) {
					
					$data = array( 'task_id' => $task, 'project_id' => $project, 'name' => trim( $tag ) );
				
					$this->save( $data );
					
				}				
				
			}
			
		}
		
	}	
	
}