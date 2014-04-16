<?

class Users extends DB {

	var $table = 'users';	
	
	
	public function get_avatar( $user_id ) {
	
		$user_info = $this->retrieve('one','*',' where id = ' . $user_id);
	
		if( $user_info['image'] ) {
			
			return '<img src="/assets/images/uploads/thumbnails/' . $user_info['image'] . '" class="img-thumbnail">';
			
		}
		
		return '<div class="issue-member-avatar"><span>' . substr( $user_info['first_name'], 0, 1 ) . ' ' .  substr( $user_info['last_name'], 0, 1 ) . '</span></div>';
		
	}
	
}