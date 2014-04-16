<?

class Projects extends DB {

	var $table = 'projects';	
	
	public function save( $fields ) {
	
		$fields['archived'] = $fields['archived']?$fields['archived']:0;
	
		return parent::save( $fields );
	
	}
	
}