<?

include( 'models/projects.php' );
include( 'models/companies.php' );
include( 'models/tasks.php' );
include( 'models/users.php' );
include( 'models/time_entries.php' );
include( 'models/histories.php' );
include( 'models/tags.php' );
include( 'models/task_views.php' );
include( 'models/attachments.php' );

class AppController {

	public $statuses = array( 	'open' 						=> 'Open',
								'in_progress'				=> 'In Progress',
								'not_an_issue'				=> 'Not An Issue',
								'not_reproducible'			=> 'Not Reproducible',
								'missing_information'		=> 'Missing Information',
								'pushed_back'				=> 'Pushed Back',
								'ready_for_retest'			=> 'Ready for Tetest',
								'ready_for_next_release' 	=> 'Ready for Next Release',
								'fixed'						=> 'Fixed' );
	
	public $priorities = array(		'low'		=> 'Low',
									'medium'	=> 'Medium',
									'high'		=> 'High',
									'critical'	=> 'Critical',
									'on_fire'	=> 'On Fire' );							
	
	public $time_segments = array(	0		=> 'No Estimate',
									30 		=> '1/2 Hour',
									60 		=> '1 Hour',
									90 		=> '1.5 Hours',
									120 	=> '2 Hours',
									180 	=> '3 Hours',
									240 	=> '4 Hours',
									300 	=> '5 Hours',
									360 	=> '6 Hours',
									420 	=> '7 Hours',
									480		=> '8 Hours',
									720		=> '1.5 Days',
									960		=> '2 Days',
									1140	=> '3 Days',
									1920	=> '4 Days',
									2400	=> '5 Days',
									4800	=> '10 Days',
									7200	=> '15 Days' );	
														 
	function __construct() {
	
		$this->auth	= new Auth;
		$this->db = $this->auth->db;
		
		// initialize models
		$this->projects = new Projects;
		$this->companies = new Companies;
		$this->tasks = new Tasks;
		$this->users = new Users;
		$this->time_entries = new TimeEntries;
		$this->histories = new Histories;
		$this->tags = new Tags;
		$this->task_views = new TaskViews;
		$this->attachments = new Attachments;
		
		$this->filepath = getcwd();
		//$this->site_url = 'http://' . str_replace( 'admin.', '', $_SERVER['SERVER_NAME'] );
		$this->site_url = 'http://localhost:8888/';
		
		if( $this->auth->logged_in() ) {
		
			$this->company_list = $this->companies->retrieve('pair',"id,name",' order by name'); 
			
			$this->project_list = $this->projects->retrieve('pair',"id,name",' order by name'); 
			$this->active_project_list = $this->projects->retrieve('pair',"id,name",' where archived=0 order by name'); 
			
			$this->task_list = $this->tasks->retrieve('pair',"id,title",' order by title'); 
			$this->task_project_list = $this->tasks->retrieve('pair',"id,project"); 
			
			$this->user_list = $this->users->retrieve('pair',"id,concat( first_name, ' ', last_name )",' order by last_name, first_name'); 
			$this->user_thumbnail_list = $this->users->retrieve('pair',"id,image"); 
			$this->company_user_count = $this->users->retrieve('pair',"company,count(id)",' group by company'); 
			
			$this->my_timesheet_list = $this->time_entries->retrieve('pair',"task,sum( minutes )"," where user = " . $_SESSION['logged_in_user']['id'] . " group by task"); 
			$this->timesheet_list = $this->time_entries->retrieve('pair',"task,sum( minutes )"," group by task"); 
			
			$this->tag_list = $this->tags->retrieve('pair','distinct name, name',' order by name');
		
		}
					
	}
	
	public function github() {
		
		$payload = json_decode( $_POST['payload'] );
		
		$body = 'ref: ' . (string)$payload->{'ref'};
		
		$functions = new AppFunctions;
		
		
		$functions->send_mail('aducworth@gmail.com', $body, 'Push to Everything', 'no-reply@everything.com', '{e}verything app');
		exit;
		
	}
	
	public function index() {
	
		if( count( $_POST ) > 0 ) {
		
		}
		
		$this->tasks();
	
	}
		
	public function permission() {
			
		$this->message = "Sorry, but you do not have permission to access this area.";
	
	}
	
	public function db_setup() {
		
		// do the initial check to make sure tables are set up
		$this->db->initial_setup();
		
	}
		
	public function login() {
	
		if( count( $_POST ) > 0 ) {
		
			if( $this->auth->login() ) {
			
				header( 'Location: /' );
				exit;
				
			} else {
			
				$this->message = "Error logging in.";
			
			}
		
		}
	
	}
	
	public function logout() {
	
		$this->auth->logout();
		header( 'Location: /' );
		exit;
	
	}
	
	public function users() {
	
		if( $_GET['search'] ) {
			
			$where = " where first_name like '%" . $_GET['search'] . "%' or last_name like '%" . $_GET['search'] . "%' or email like '%" . $_GET['search'] . "%'";
			
		}
			
		$this->users = $this->users->retrieve('all','*',$where); 
			
	}
	
	public function time() {
	
		$where = " where 1=1";
		
		if( $_GET['user'] ) {
		
			$where .= " and user = " . $_GET['user'];
		
		}
		
		if( $_GET['project'] ) {
		
			$where .= " and project = " . $_GET['project'];
		
		}
		
		if( $_GET['from'] ) {
			
			$where .= " and entry_date>='" . date( 'Y-m-d 00:00:00', strtotime( $_GET['from'] ) ) . "'";
			
		}
		
		if( $_GET['to'] ) {
			
			$where .= " and entry_date<='" . date( 'Y-m-d 23:59:59', strtotime( $_GET['to'] ) ) . "'";
			
		}			
		
		$this->time_entries_by_day = $this->time_entries->retrieve('pair','entry_date, sum( minutes ) as total_minutes',$where . " group by entry_date"); 

		$this->time_entries = $this->time_entries->retrieve('all','project, task, user, entry_date, sum( minutes ) as total_minutes',$where . " group by project, task, user, entry_date order by entry_date desc"); 
			
	}
	
	public function timesheet() {
	
		$where = " where user = " . $_SESSION['logged_in_user']['id'] . " and entry_date='" . date('Y-m-d') . "'";
		
		$this->time_entries = $this->time_entries->retrieve('all','*',$where); 
	
	}
	
	public function _time_tracker() {
	
		$url = $_GET['url'];
		
		unset( $_GET['ajax'] );
		unset( $_GET['url'] );
	
		$where = " where user = " . $_SESSION['logged_in_user']['id'] . " and entry_date='" . date('Y-m-d') . "'";
		
		if( $_GET['project'] ) {
			
			$where .= " and project = " . $_GET['project'];
			
		} else {
			
			$where .= " and project = 0";
			
		}
		
		if( $_GET['task'] ) {
			
			$where .= " and task = " . $_GET['task'];
			
		} else {
			
			$where .= " and task = 0";
			
		}
			
		$this->time_entry = $this->time_entries->retrieve('one','*',$where); 
		
		// if we have been on this page for a litle while, just add time and save
		if( $this->time_entry['id'] && $this->time_entry['open_entry'] ) {
			
			$this->time_entry['minutes'] += round( ( time() - strtotime( $this->time_entry['open_entry_time'] ) ) / 60, 2 );
			$this->time_entry['open_entry_time'] = date('Y-m-d H:i:s');
			
			$this->time_entries->save( $this->time_entry );
			
		} else if( $this->time_entry['id'] ) { // if we have been on this task today, but are just switching back to it, open it up
			
			// close other entries for this user
			$this->db->query( "update time_entries set open_entry=0 where user = " . $_SESSION['logged_in_user']['id'] );
			
			//echo( "update time_entries set open_entry=0 where user = " . $_SESSION['logged_in_user']['id'] );
			
			$this->time_entry['open_entry'] = 1;
			$this->time_entry['open_entry_time'] = date('Y-m-d H:i:s');
			 
			$this->time_entries->save( $this->time_entry );
			
		} else { // this is our first entry for this page today
		
			// close other entries for this user
			$this->db->query( "update time_entries set open_entry=0 where user = " . $_SESSION['logged_in_user']['id'] );
			
			$_GET['user'] = $_SESSION['logged_in_user']['id'];
			$_GET['minutes'] = '0.00';
			$_GET['entry_date'] = date('Y-m-d');
			$_GET['open_entry_time'] = date('Y-m-d H:i:s');
			
			$this->time_entries->save( $_GET );
			
			$this->time_entry = $_GET;
			
		}
		
		$_GET['ajax'] = 'true';
		$_GET['url'] = $url;
			
	}
	
	public function companies() {
	
		if( $_GET['search'] ) {
			
			$where = " where name like '%" . $_GET['search'] . "%' ";
			
		}
			
		$this->companies = $this->companies->retrieve('all','*',$where); 
			
	}
					
	public function photos() {
	
		$this->db->table = 'photos';
		
		if( $_GET['search'] ) {
			
			$where = " where image like '%" . $_GET['search'] . "%'";
			
		}
			
		$this->photos = $this->db->retrieve('all','*',$where . ' order by id'); 
			
	}
			
	public function tasks() {
	
		// set up search caching
		$_GET['project'] = isset( $_GET['project'] )?$_GET['project']:$_SESSION['project'];
		$_SESSION['project'] = $_GET['project']?$_GET['project']:'';
		
		$_GET['status'] = isset( $_GET['status'] )?$_GET['status']:$_SESSION['status'];
		$_SESSION['status'] = $_GET['status']?$_GET['status']:'';
		
		$_GET['user'] = isset( $_GET['user'] )?$_GET['user']:$_SESSION['user'];
		$_SESSION['user'] = $_GET['user']?$_GET['user']:'';
		
		$_GET['sorting'] = isset( $_GET['sorting'] )?$_GET['sorting']:$_SESSION['sorting'];
		$_SESSION['sorting'] = $_GET['sorting']?$_GET['sorting']:'completion_order asc';
	
		$where = " where 1=1";
		
		if( $_GET['search'] ) {
			
			$where .= " and ( title like '%" . $_GET['search'] . "%' ) ";
			
		}
		
		if( $_GET['project'] ) {
			
			$where .= " and ( project = " . $_GET['project'] . " ) ";
			
		}
		
		if( $_GET['status'] ) {
			
			$where .= " and ( status = '" . $_GET['status'] . "' ) ";
			
		}
		
		if( $_GET['user'] ) {
			
			$where .= " and ( fixer = '" . $_GET['user'] . "' ) ";
			
		}
			
		$this->results = $this->tasks->retrieve('all','*',$where . ' order by ' . $_GET['sorting']); 
			
	}
	
	public function multiple() {
	
		if( count( $_POST ) ) {
			
			$this->tasks->saveMultiple( $_POST['multiple'] );
			
			header( 'Location: /' );
			exit;
			
		}
	
		// set up search caching
		$_GET['project'] = isset( $_GET['project'] )?$_GET['project']:$_SESSION['project'];
		$_SESSION['project'] = $_GET['project']?$_GET['project']:'';
		
		$_GET['status'] = isset( $_GET['status'] )?$_GET['status']:$_SESSION['status'];
		$_SESSION['status'] = $_GET['status']?$_GET['status']:'';
		
		$_GET['user'] = isset( $_GET['user'] )?$_GET['user']:$_SESSION['user'];
		$_SESSION['user'] = $_GET['user']?$_GET['user']:'';
		
		$_GET['sorting'] = isset( $_GET['sorting'] )?$_GET['sorting']:$_SESSION['sorting'];
		$_SESSION['sorting'] = $_GET['sorting']?$_GET['sorting']:'completion_order asc';
	
		$where = " where 1=1";
		
		if( $_GET['search'] ) {
			
			$where .= " and ( title like '%" . $_GET['search'] . "%' ) ";
			
		}
		
		if( $_GET['project'] ) {
			
			$where .= " and ( project = " . $_GET['project'] . " ) ";
			
		}
		
		if( $_GET['status'] ) {
			
			$where .= " and ( status = '" . $_GET['status'] . "' ) ";
			
		}
		
		if( $_GET['user'] ) {
			
			$where .= " and ( fixer = '" . $_GET['user'] . "' ) ";
			
		}
			
		$this->results = $this->tasks->retrieve('all','*',$where . ' order by ' . $_GET['sorting']); 
			
	}
	
	public function activity() {
	
		// set up search caching
		$_GET['project'] = isset( $_GET['project'] )?$_GET['project']:$_SESSION['project'];
		$_SESSION['project'] = $_GET['project']?$_GET['project']:'';
		
		$_GET['from'] = isset( $_GET['from'] )?$_GET['from']:$_SESSION['from'];
		$_SESSION['from'] = $_GET['from']?$_GET['from']:'';
		
		$_GET['to'] = isset( $_GET['to'] )?$_GET['to']:$_SESSION['to'];
		$_SESSION['to'] = $_GET['to']?$_GET['to']:'';
		
		$_GET['user'] = isset( $_GET['user'] )?$_GET['user']:$_SESSION['user'];
		$_SESSION['user'] = $_GET['user']?$_GET['user']:'';
	
		$where = " where 1=1";
		
		if( $_GET['search'] ) {
			
			$where .= " and ( title like '%" . $_GET['search'] . "%' ) ";
			
		}
		
		if( $_GET['project'] ) {
		
			$tofilter = array();
		
			$project_tasks = $this->tasks->retrieve('all','*',' where project = ' . $_GET['project']);
			
			foreach( $project_tasks as $pt ) {
				
				$tofilter[] = 'task=' . $pt['id'];
				
			}
			
			if( count( $tofilter ) ) {
				
				$where .= " and ( " . implode( ' or ', $tofilter ) . " ) ";
				
			}
			
		}
		
		if( $_GET['from'] ) {
			
			$where .= " and ( created >= '" . $_GET['from'] . "' ) ";
			
		}
		
		if( $_GET['to'] ) {
			
			$where .= " and ( created <= '" . $_GET['to'] . "' ) ";
			
		}

		
		if( $_GET['user'] ) {
			
			$where .= " and ( user = '" . $_GET['user'] . "' ) ";
			
		}
			
		$this->results = $this->histories->retrieve('all','*',$where . ' order by created desc'); 
			
	}
	
	public function projects() {
	
		$where = " where 1=1";
		
		if( $_GET['search'] ) {
			
			$where .= " and ( name like '%" . $_GET['search'] . "%' ) ";
			
		}
			
		$this->projects = $this->projects->retrieve('all','*',$where . ' order by name'); 
			
	}
			
	public function company() {
	
		if( count( $_POST ) > 0 ) {
								
			if( is_uploaded_file( $_FILES['image']['tmp_name'] ) ) {
				
				if( $_FILES['image']['type'] == 'image/jpeg' ) {
					
					$_POST['image'] = time() . $this->clean_filename( $_FILES['image']['name'] );
					
					$path = str_replace( 'app', '', getcwd() ) . '/assets/images/uploads/';
					
					//echo( $path );
					
					move_uploaded_file( $_FILES['image']['tmp_name'], $path . 'tmp/' . $_POST['image'] ); 
					
					$resizeObj = new resize( $path . 'tmp/' . $_POST['image'] );
					$resizeObj -> resizeImage( 300, 473, 'landscape' );
					$resizeObj -> saveImage( $path . 'resized/' . $_POST['image'], 100 );
									
					$resizeObj = new resize( $path . 'tmp/' . $_POST['image'] );
					$resizeObj -> resizeImage( 100, 100, 'landscape' );
					$resizeObj -> saveImage( $path . 'thumbnails/' . $_POST['image'], 100 );
				
				} else {
					
					$this->message = 'Invalid type of image. Please use a jpg.';
					$_GET['id'] = $_POST['id'];
					
					echo( $this->message );
					
				}
			
			}
						
			if( $this->companies->save( $_POST ) ) {
			
				if( !$_POST['id'] ) {
				
					$_POST['id'] = mysql_insert_id();
				
				}
																						
				header( 'Location: /companies' );
				exit;
			
			}
		
		}
		
		if( $_GET['id'] ) {
		
			$this->result = $this->companies->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
														
		}
		
	}
		
	public function project() {
	
		if( count( $_POST ) ) {
			
			if( $this->projects->save( $_POST ) ) {
		
				if( !$_POST['id'] ) {
				
					$_POST['id'] = mysql_insert_id();
				
				}
																				
				header( 'Location: /projects' );
				exit;
			
			}
			
		}	
		
		if( $_GET['id'] ) {
			
			$this->result = $this->projects->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
															
		}
		
	}
	
	public function task() {
	
		if( count( $_POST ) ) {
			
			if( $this->tasks->save( $_POST ) ) {
		
				if( !$_POST['id'] ) {
				
					$_POST['id'] = mysql_insert_id();
				
				}
																				
				header( 'Location: /tasks' );
				exit;
			
			}
			
		}	
		
		if( $_GET['id'] ) {
			
			$this->result = $this->tasks->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
			
			$this->result['tags'] = implode( ', ', $this->tags->retrieve( 'pair','id,name',' where task_id = ' . $_GET['id'] ) );
			
			$_GET['task'] 		= $_GET['id'];
			$_GET['project'] 	= $this->result['project'];
															
		}
		
	}
	
	public function task_review() {
	
		if( count( $_POST ) ) {
		
			if( $this->tasks->save( $_POST ) ) {
		
				if( !$_POST['id'] ) {
				
					$_POST['id'] = mysql_insert_id();
				
				}
											
				header( 'Location: /task_review?id=' . $_POST['id'] );
				exit;
			
			}
			
		}	
		
		if( $_GET['id'] ) {
			
			$this->result = $this->tasks->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
			
			$_GET['task'] 		= $_GET['id'];
			$_GET['project'] 	= $this->result['project'];
			
			$this->result['histories'] = $this->histories->retrieve( 'all', '*', ' where task = ' . $_GET['id'] ); 
			
			$this->result['attachments'] = $this->attachments->retrieve( 'all', '*', ' where task_id = ' . $_GET['id'] ); 
			
			$this->result['task_timesheet'] = $this->time_entries->retrieve('pair',"user,sum( minutes )"," where task = " . $_GET['id']  . " group by user"); 
															
		}
		
	}
	
	public function time_entry() {
	
		if( count( $_POST ) ) {
			
			if( $this->time_entries->save( $_POST ) ) {
		
				if( !$_POST['id'] ) {
				
					$_POST['id'] = mysql_insert_id();
				
				}
																				
				header( 'Location: /timesheet' );
				exit;
			
			}
			
		}	
		
		if( $_GET['id'] ) {
			
			$this->result = $this->time_entries->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
															
		}
		
	}
					
	public function user() {
		
		if( count( $_POST ) > 0 ) {
		
			if( is_uploaded_file( $_FILES['image']['tmp_name'] ) ) {
				
				if( $_FILES['image']['type'] == 'image/jpeg' ) {
					
					$_POST['image'] = time() . $this->clean_filename( $_FILES['image']['name'] );
					
					$path = str_replace( 'app', '', getcwd() ) . '/assets/images/uploads/';
					
					//echo( $path );
					
					move_uploaded_file( $_FILES['image']['tmp_name'], $path . 'tmp/' . $_POST['image'] ); 
					
					$resizeObj = new resize( $path . 'tmp/' . $_POST['image'] );
					$resizeObj -> resizeImage( 300, 473, 'landscape' );
					$resizeObj -> saveImage( $path . 'resized/' . $_POST['image'], 100 );
									
					$resizeObj = new resize( $path . 'tmp/' . $_POST['image'] );
					$resizeObj -> resizeImage( 100, 100, 'crop' );
					$resizeObj -> saveImage( $path . 'thumbnails/' . $_POST['image'], 100 );
				
				} else {
					
					$this->message = 'Invalid type of image. Please use a jpg.';
					$_GET['id'] = $_POST['id'];
					
					echo( $this->message );
					
				}
			
			}
			
			unset( $_POST['password_confirm'] );
			
			if( $_POST['password'] ) {
				
				$_POST['password'] = md5( $_POST['password'] );
				
			} else {
				
				unset( $_POST['password'] );
				
			}
					
			if( $this->users->save( $_POST ) ) {
			
				if( !$_POST['id'] ) {
				
					$_POST['id'] = mysql_insert_id();
				
				}
																						
				header( 'Location: /users' );
				exit;
			
			}
		
		}
		
		if( $_GET['id'] ) {
		
			$this->result = $this->users->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
														
		}
		
	}
			
	public function photo() {
		
		if( count( $_POST ) > 0 || $_FILES['image'] ) {
		
			$this->db->table = 'photos';
			
			if( is_uploaded_file( $_FILES['image']['tmp_name'] ) ) {
				
				if( $_FILES['image']['type'] == 'image/jpeg' ) {
					
					$_POST['image'] = time() . $this->clean_filename( $_FILES['image']['name'] );
					
					$path = str_replace( 'admin', '', getcwd() ) . 'images/uploads/';
					
					move_uploaded_file( $_FILES['image']['tmp_name'], $path . 'tmp/' . $_POST['image'] ); 
					
					$resizeObj = new resize( $path . 'tmp/' . $_POST['image'] );
					$resizeObj -> resizeImage( 1120, 473, 'crop' );
					$resizeObj -> saveImage( $path . 'banners/' . $_POST['image'], 100 );
									
					$resizeObj = new resize( $path . 'tmp/' . $_POST['image'] );
					$resizeObj -> resizeImage( 200, 84, 'crop' );
					$resizeObj -> saveImage( $path . 'banners/thumbnails/' . $_POST['image'], 100 );
				
				} else {
					
					$this->message = 'Invalid type of image. Please use a jpg.';
					$_GET['id'] = $_POST['id'];
					
				}
			
			}
			
			if( !$this->message ) {
				
				if( $this->db->save( $_POST ) ) {
				
					if( !$_POST['id'] ) {
					
						$_POST['id'] = mysql_insert_id();
					
					}
																							
					header( 'Location: /photos' );
					exit;
								
				}
			
			}
		
		}
		
		if( $_GET['id'] ) {
		
			$this->db->table = 'photos';
			
			$this->result = $this->db->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
														
		}
		
	
	}
		
		
	public function delete() {
		
		$model = $_GET['model'];
		$this->$model->remove( $_GET['id'] );
	
		header( 'Location: /' . $model );
		exit;		
	
	}
	
	public function update_display_order() {
		
		$update_parts = explode( '-order-', $_GET['update_id'] );
		
		$this->db->table = $update_parts[0];
		
		$this->db->save( array( 'id' => str_replace( '-id', '', $update_parts[1] ), 'display_order' => $_GET['order'] ) );
	
		exit;		
	
	}
	
	public function add_to_list() {
		
		$model = $_GET['model'];
		$pair = $_GET['pair'];
		
		unset( $_GET['model'] );
		unset( $_GET['pair'] );
		unset( $_GET['url'] );
		unset( $_GET['ajax'] );
		
		// set the model
		$this->db->table = $model;
		
		$tocheck = array();
		
		// check to see if this one is already in the system
		foreach( $_GET as $field => $value ) {
			
			$tocheck[] = $field . "='" . addslashes( $value ) . "'";
			
			// also check to make sure there is a value for each option
			if( !$value ) {
				
				echo( json_encode( array( 'error' => $field . ' is required.' ) ) );
				exit;
				
			}
			
		}
		
		$already_there = $this->db->retrieve('one','*'," where 1=1 and ( " . implode( ' and ', $tocheck ) . " )");
		
		if( $already_there['id'] ) {
			
			echo( json_encode( array( 'error' => 'The item is already in the database.' ) ) );
			
		} else {
			
			$this->db->save( $_GET );
			
			$new_id = mysql_insert_id();
			
			$new_info = $this->db->retrieve('pair',$pair);
			
			$toreturn = '';
			
			foreach( $new_info as $id => $label ) {
				
				$selected = ( $new_id == $id )?'selected':'';
				
				$toreturn .= "<option value='" . $id . "' " . $selected . ">" . $label . "</option>";
				
			}
			
			echo( json_encode( array( 'data' => $toreturn ) ) );
			
		}
		
		exit;		
	
	}
	
	public function clean_filename( $filename ) {
	
		return preg_replace( "/[^\w\.-]/", "-", strtolower( $filename ) );
		
	}
			
}

?>