<?

class Auth {

	var $user_types = array( 'admin' => 'Administrator', 'pm' => 'Project Manager', 'developer' => 'Developer', 'designer' => 'Designer' );
	
	var $menu = array( 
						'people' => array( 'companies' => 'List Companies', 'users' => 'List Users' ),
						/* 'doctors' => array( 'doctors' => 'List Doctors', 'doctor' => 'Add Doctor' ), */
						/* 'referrals' => array( 'referrals' => 'List Referrals', 'referral' => 'Add Referral', 'schedule' => 'View Schedule' ), */
						/* 'reports' => array( 'report_by_location' => 'By Location', 'report_by_specialty' => 'By Specialty', 'report_by_doctor' => 'By Doctor' ), */
						'projects' => array( 'projects' => 'List Projects', 'tasks' => 'List Tasks', 'activity' => 'List Activity', 'task' => 'Add Task' ),
						'reports' => array( 'time' => 'Time' ) );
						
	var $office_menu = array( 
						'profile' => array( 'office' => 'Office Profile', 'user' => 'User Profile' ),
						'doctors' => array( 'doctors' => 'My Doctors', 'doctor' => 'Add Doctor', 'search' => 'Search for Doctors' ),
						'referrals' => array( 'referrals' => 'List Referrals', 'referral' => 'Add Referral', 'schedule' => 'View Schedule' ) );
						
	var $always_allow = array( 'login', 'logout', 'permission', 'github' );
	
	var $admin_access = array( 'users', 'offices' );
	
	var $show_search = array( 'companies', 'users' );
	
	var $allow = array( 'login', 'db_setup', 'github' );
	
	var $homepage_views = array( 'schedule' 	=> 'Appointment Schedule',
								 'favorites'	=> 'Favorite Doctors' );

	function __construct() {
	
		$action = $_GET['url']?$_GET['url']:'index';
	
		if( !$this->logged_in() && !in_array( $action, $this->allow ) ) {
		
			header( 'Location: /login' );
			exit;
		
		}
		
		$this->db = new DB;
		
		// check the database connection
		if( !$this->db->connection && $action != 'db_setup' ) {
			
			header( 'Location: /db_setup' );
			exit;
			
		}
		
		if( !$this->hasPermission( $action ) ) {
			
			header( 'Location: /' );
			exit;
			
		}
		
	}
	
	public function hasPermission( $url ) {
		
//		if( in_array( $url, $this->admin_access ) && $_SESSION['logged_in_user']['admin'] == 0 ) {
//			
//			return false;
//			
//		}
		
		return true;
		
	}
	
	public function navigation() {
		
		$toreturn = '';
		
//		if( $_SESSION['logged_in_user']['admin'] ) {
//			
//			$nav_menu = $this->menu;
//			
//		} else {
//			
//			$nav_menu = $this->office_menu;
//			
//		}
		
		$nav_menu = $this->menu;
		
		foreach( $nav_menu as $name => $items ) {
			
			// if this has a submenu
			if( is_array( $items ) ) {
				
				// build the submenu first to make sure permissions allow for the top level
				$submenu = '';
				
				foreach( $items as $url => $value ) {
						
					if( $this->hasPermission( $url ) ) {
						
						$submenu .= '<li><a href="/' . $url . '">' . $value . '</a></li>';
						
					}
					
				}
				
				// include top menu if there is a submenu
				if( $submenu ) {
					
					$toreturn .= '<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . ucwords( str_replace( '_', ' ', $name ) ) . ' <b class="caret"></b></a>
									<ul class="dropdown-menu">'
										
										. $submenu .
										
									'</ul>
								  </li>';
							  
				}
				
			// if this is a single item
			} else {
				
				if( $this->hasPermission( $name ) ) {
					
					$toreturn .= '<li><a href="/' . $name . '">' . $item . '</a></li>';
					
				}
				
			}
			
		}
		
		return $toreturn;
		
	}
	
	public function logged_in( ) {
	
		if( $_SESSION['logged_in_user'] ) {
		
			return true;
			
		}
		
		return false;
	
	}
	
	public function login() {
	
		$this->db->table = 'users';
		
		$user = $this->db->retrieve( 'one', '*', "where email='" . $_POST['email'] . "' and password='" . md5( $_POST['password'] ) . "'" );
		
		if( $user['id'] ) {
		
			$_SESSION['logged_in_user'] = $user;
			return true;
			
		} else {
		
			unset( $_SESSION['logged_in_user'] );
			return false;
		
		}
	
	}
	
	public function logout() {
	
		unset( $_SESSION['logged_in_user'] );
		
		return true;
	
	}

}

?>