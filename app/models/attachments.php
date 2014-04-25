<?

class Attachments extends DB {

	var $table = 'attachments';	
	
	public function upload( $files, $task = 0, $project = 0, $history = 0 ) {
	
		//print_r( $files );
		
		foreach( $files['name'] as $i => $name ) {
				
				if( is_uploaded_file( $files['tmp_name'][$i] ) ) {
				
					$data = array();
				
					if( $files['type'][$i] == 'image/jpeg' ) {
						
						$data['name'] = $name;
						$data['filename'] = time() . $this->clean_filename( $name );
						$data['task_id'] = $task;
						$data['project_id'] = $project;
						$data['history_id'] = $history;
						$data['user_id'] = $_SESSION['logged_in_user']['id'];
						
						$path = str_replace( array( 'admin', 'app' ), array( '', 'assets' ), getcwd() ) . '/assets/images/uploads/';
						
						move_uploaded_file( $files['tmp_name'][$i], $path . 'tmp/' . $data['filename'] ); 
						
						$resizeObj = new resize( $path . 'tmp/' . $data['filename'] );
						$resizeObj -> resizeImage( 300, 473, 'landscape' );
						$resizeObj -> saveImage( $path . 'resized/' . $data['filename'], 100 );
										
						$resizeObj = new resize( $path . 'tmp/' . $data['filename'] );
						$resizeObj -> resizeImage( 100, 100, 'crop' );
						$resizeObj -> saveImage( $path . 'thumbnails/' . $data['filename'], 100 );
						
						$this->save( $data );
					
					} else {
						
						$this->message = 'Invalid type of image. Please use a jpg.';
						
						echo( $this->message . '<br>' );
						
					}
				
				}
				
			}

	}
	
	public function clean_filename( $filename ) {
	
		return preg_replace( "/[^\w\.-]/", "-", strtolower( $filename ) );
		
	}
	
}