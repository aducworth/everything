<?

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
									 
	function __construct() {
	
		$this->auth	= new Auth;
		$this->db = $this->auth->db;
		
		$this->filepath = getcwd();
		//$this->site_url = 'http://' . str_replace( 'admin.', '', $_SERVER['SERVER_NAME'] );
		$this->site_url = 'http://localhost:8888/';
		
		if( $this->auth->logged_in() ) {
		
			$this->db->table = 'companies';
			
			$this->company_list = $this->db->retrieve('pair',"id,name",' order by name'); 
			
			$this->db->table = 'projects';
			
			$this->project_list = $this->db->retrieve('pair',"id,name",' order by name'); 
			
			$this->db->table = 'tasks';
			
			$this->task_list = $this->db->retrieve('pair',"id,title",' order by title'); 
			
			$this->db->table = 'users';
			
			$this->user_list = $this->db->retrieve('pair',"id,concat( first_name, ' ', last_name )",' order by last_name, first_name'); 
			$this->user_thumbnail_list = $this->db->retrieve('pair',"id,image"); 
			$this->company_user_count = $this->db->retrieve('pair',"company,count(id)",' group by company'); 
			
			$this->db->table = 'time_entries';
			
			$this->my_timesheet_list = $this->db->retrieve('pair',"task,sum( minutes )"," where user = " . $_SESSION['logged_in_user']['id'] . " group by task"); 
			$this->timesheet_list = $this->db->retrieve('pair',"task,sum( minutes )"," group by task"); 
		
		}
					
	}
	
	public function index() {
	
		if( count( $_POST ) > 0 ) {
		
		}
		
		$this->tasks();
	
	}
	
	public function schedule() {
	
		$this->db->table = 'referrals';
		
		$where = " where 1=1";
		
		if( $_GET['search'] ) {
			
			$where .= " and patient_name like '%" . $_GET['search'] . "%'";
			
		}
		
		// do restriction for office user
		if( $_SESSION['logged_in_user']['office_id'] ) {
			
			// filter for referrals made to drs in this office
			$dr_filter = array();
			
			foreach( $this->doctors_by_office_list as $id => $name ) {
				
				$dr_filter[] = 'referred_to=' . $id;
				
			}
			
			// and referrals made to this office
			if( count( $dr_filter ) ) {
				
				$where .= " and (  " . implode( ' or ', $dr_filter ) . " ) ";
				
			} else {
				
				// or nothing
				$where .= " and 1=2 ";
				
			}
			
		}
			
		$this->referrals = $this->db->retrieve('all','*',$where . ' order by appointment'); 
	
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
	
		$this->db->table = 'users';
		
		if( $_GET['search'] ) {
			
			$where = " where first_name like '%" . $_GET['search'] . "%' or last_name like '%" . $_GET['search'] . "%' or email like '%" . $_GET['search'] . "%'";
			
		}
			
		$this->users = $this->db->retrieve('all','*',$where); 
			
	}
	
	public function time() {
	
		$this->db->table = 'time_entries';
		
		$where = " where 1=1";
		
		if( $_GET['user'] ) {
		
			$where .= " and user = " . $_GET['user'];
		
		}
		
		if( $_GET['project'] ) {
		
			$where .= " and project = " . $_GET['project'];
		
		}
		
		if( $_GET['from'] ) {
			
			$where .= " and entry_date='" . date('Y-m-d') . "'";
			
		}		
		
		
		$this->time_entries = $this->db->retrieve('all','project, task, user, entry_date, sum( minutes ) as total_minutes',$where . " group by project, task, user, entry_date order by entry_date"); 
		$this->time_entries_by_day = $this->db->retrieve('pair','entry_date, sum( minutes ) as total_minutes',$where . " group by entry_date"); 
	
	}
	
	public function timesheet() {
	
		$this->db->table = 'time_entries';
		
		$where = " where user = " . $_SESSION['logged_in_user']['id'] . " and entry_date='" . date('Y-m-d') . "'";
		
		$this->time_entries = $this->db->retrieve('all','*',$where); 
	
	}
	
	public function _time_tracker() {
	
		$url = $_GET['url'];
		
		unset( $_GET['ajax'] );
		unset( $_GET['url'] );
	
		$this->db->table = 'time_entries';
		
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
			
		$this->time_entry = $this->db->retrieve('one','*',$where); 
		
		// if we have been on this page for a litle while, just add time and save
		if( $this->time_entry['id'] && $this->time_entry['open_entry'] ) {
			
			$this->time_entry['minutes'] += round( ( time() - strtotime( $this->time_entry['open_entry_time'] ) ) / 60, 2 );
			$this->time_entry['open_entry_time'] = date('Y-m-d H:i:s');
			
			$this->db->save( $this->time_entry );
			
		} else if( $this->time_entry['id'] ) { // if we have been on this task today, but are just switching back to it, open it up
			
			// close other entries for this user
			$this->db->query( "update time_entries set open_entry=0 where user = " . $_SESSION['logged_in_user']['id'] );
			
			//echo( "update time_entries set open_entry=0 where user = " . $_SESSION['logged_in_user']['id'] );
			
			$this->time_entry['open_entry'] = 1;
			$this->time_entry['open_entry_time'] = date('Y-m-d H:i:s');
			 
			$this->db->save( $this->time_entry );
			
		} else { // this is our first entry for this page today
		
			// close other entries for this user
			$this->db->query( "update time_entries set open_entry=0 where user = " . $_SESSION['logged_in_user']['id'] );
			
			$_GET['user'] = $_SESSION['logged_in_user']['id'];
			$_GET['minutes'] = '0.00';
			$_GET['entry_date'] = date('Y-m-d');
			$_GET['open_entry_time'] = date('Y-m-d H:i:s');
			
			$this->db->save( $_GET );
			
			$this->time_entry = $_GET;
			
		}
		
		$_GET['ajax'] = 'true';
		$_GET['url'] = $url;
			
	}
	
	public function companies() {
	
		$this->db->table = 'companies';
		
		if( $_GET['search'] ) {
			
			$where = " where name like '%" . $_GET['search'] . "%' ";
			
		}
			
		$this->companies = $this->db->retrieve('all','*',$where); 
			
	}
					
	public function photos() {
	
		$this->db->table = 'photos';
		
		if( $_GET['search'] ) {
			
			$where = " where image like '%" . $_GET['search'] . "%'";
			
		}
			
		$this->photos = $this->db->retrieve('all','*',$where . ' order by id'); 
			
	}
	
	public function referrals() {
	
		$this->db->table = 'referrals';
		
		$where = " where 1=1";
		
		if( $_GET['search'] ) {
			
			$where .= " and patient_name like '%" . $_GET['search'] . "%'";
			
		}
		
		if( $_GET['referral_status'] ) {
			
			$where .= " and referral_status = '" . $_GET['referral_status'] . "'";
			
		}
		
		// do restriction for office user
		if( $_SESSION['logged_in_user']['office_id'] ) {
			
			// filter for referrals made by this office
			$dr_filter = array();
			
			foreach( $this->doctors_by_office_list as $id => $name ) {
				
				$dr_filter[] = 'referred_by=' . $id;
				$dr_filter[] = 'referred_to=' . $id;
				
			}
			
			// and referrals made to this office
			if( count( $dr_filter ) ) {
				
				$where .= " and ( " . implode( ' or ', $dr_filter ) . " ) ";
				
			}
			
		}
			
		$this->referrals = $this->db->retrieve('all','*',$where . ' order by appointment'); 
			
	}
	
	public function films() {
	
		$this->db->table = 'films';
		
		if( $_GET['search'] ) {
			
			$where = " where title like '%" . $_GET['search'] . "%'";
			
		}
			
		$this->films = $this->db->retrieve('all','*',$where . ' order by title'); 
			
	}
	
	public function banners() {
	
		$this->db->table = 'banners';
		
		if( $_GET['search'] ) {
			
			$where = " where title like '%" . $_GET['search'] . "%'";
			
		}
			
		$this->banners = $this->db->retrieve('all','*',$where . ' order by title'); 
			
	}
	
	public function tasks() {
	
		$this->db->table = 'tasks';
		
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
			
		$this->tasks = $this->db->retrieve('all','*',$where . ' order by title'); 
			
	}
	
	public function projects() {
	
		$this->db->table = 'projects';
		
		$where = " where 1=1";
		
		if( $_GET['search'] ) {
			
			$where .= " and ( name like '%" . $_GET['search'] . "%' ) ";
			
		}
			
		$this->projects = $this->db->retrieve('all','*',$where . ' order by name'); 
			
	}
	
	public function search() {
	
		$this->db->table = 'doctors';
		
		$where = " where 1=1";
		
		if( $_GET['search'] ) {
			
			$where .= " and ( fname like '%" . $_GET['search'] . "%' or lname like '%" . $_GET['search'] . "%' ) ";
			
		}
		
		// do restriction for office user
		if( $_SESSION['logged_in_user']['office_id'] ) {
			
			$where .= " and office_id != " . $_SESSION['logged_in_user']['office_id'];
			
		}
			
		$this->results = $this->db->retrieve('all','*',$where . ' order by lname, fname'); 
			
	}
	
	public function favorites() {
	
		$this->db->table = 'favorites';
		
		$where = " where 1=1";
		
		if( $_GET['search'] ) {
			
			$where .= " and ( fname like '%" . $_GET['search'] . "%' or lname like '%" . $_GET['search'] . "%' ) ";
			
		}
		
		// do restriction for office user
		if( $_SESSION['logged_in_user']['office_id'] ) {
			
			$where .= " and office_id = " . $_SESSION['logged_in_user']['office_id'];
			
		}
			
		$this->favorites = $this->db->retrieve('all','*',$where . ' order by created desc'); 
			
	}
	
	public function company() {
	
		if( count( $_POST ) > 0 ) {
								
			$this->db->table = 'companies';
			
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
						
			if( $this->db->save( $_POST ) ) {
			
				if( !$_POST['id'] ) {
				
					$_POST['id'] = mysql_insert_id();
				
				}
																						
				header( 'Location: /companies' );
				exit;
			
			}
		
		}
		
		if( $_GET['id'] ) {
		
			$this->db->table = 'companies';
			
			$this->result = $this->db->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
														
		}
		
	}
	
	public function doctor() {
	
		if( count( $_POST ) > 0 ) {
								
			$this->db->table = 'doctors';
			
			if( is_uploaded_file( $_FILES['image']['tmp_name'] ) ) {
				
				if( $_FILES['image']['type'] == 'image/jpeg' ) {
					
					$_POST['image'] = time() . $this->clean_filename( $_FILES['image']['name'] );
					
					$path = str_replace( 'admin', '', getcwd() ) . '/images/uploads/';
					
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
			
			$referral_questions = $_POST['referral_questions'];
			unset( $_POST['referral_questions'] );
						
			if( $this->db->save( $_POST ) ) {
			
				if( !$_POST['id'] ) {
				
					$_POST['id'] = mysql_insert_id();
				
				}
				
				$this->db->table = 'doctor_referral_questions';
				
				$this->db->query( 'delete from doctor_referral_questions where doctor_id = ' . $_POST['id'] );
				
				// try to save referral questions
				if( is_array( $referral_questions ) ) {
				
					foreach( $referral_questions as $question_id ) {
						
						$this->db->save( array( 'referral_question_id' => $question_id, 'doctor_id' => $_POST['id'] ) );
					}
				
				}
																						
				header( 'Location: /doctors' );
				exit;
			
			}
		
		}
		
		if( $_GET['id'] ) {
		
			$this->db->table = 'doctors';
			
			$this->result = $this->db->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
			
			$this->db->table = 'doctor_hours';
			
			$this->result['doctor_hours'] = $this->db->retrieve( 'all', '*', ' where doctor_id = ' . $_GET['id'] ); 
			
			$this->db->table = 'doctor_referral_questions';
			
			$this->result['referral_questions'] = $this->db->retrieve( 'pair', 'id, referral_question_id', ' where doctor_id = ' . $_GET['id'] ); 
														
		}
		
	}
	
	public function project() {
	
		$this->db->table = 'projects';
		
		if( count( $_POST ) ) {
			
			if( $this->db->save( $_POST ) ) {
		
				if( !$_POST['id'] ) {
				
					$_POST['id'] = mysql_insert_id();
				
				}
																				
				header( 'Location: /projects' );
				exit;
			
			}
			
		}	
		
		if( $_GET['id'] ) {
			
			$this->result = $this->db->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
															
		}
		
	}
	
	public function task() {
	
		$this->db->table = 'tasks';
		
		if( count( $_POST ) ) {
			
			if( $this->db->save( $_POST ) ) {
		
				if( !$_POST['id'] ) {
				
					$_POST['id'] = mysql_insert_id();
				
				}
																				
				header( 'Location: /tasks' );
				exit;
			
			}
			
		}	
		
		if( $_GET['id'] ) {
			
			$this->result = $this->db->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
			
			$_GET['task'] 		= $_GET['id'];
			$_GET['project'] 	= $this->result['project'];
															
		}
		
	}
	
	public function task_review() {
	
		$this->db->table = 'tasks';
		
		if( count( $_POST ) ) {
		
			$description = $_POST['description'];
			unset( $_POST['description'] );
			
			if( $this->db->save( $_POST ) ) {
		
				if( !$_POST['id'] ) {
				
					$_POST['id'] = mysql_insert_id();
				
				}
				
				// save the comment
				if( $description ) {
				
					$data = array( 'task' => $_POST['id'], 'user' => $_SESSION['logged_in_user']['id'], 'description' => $description );
					
					$this->db->table = 'comments';
					
					$this->db->save( $data );
					
				}
				
				// send notifications
																				
				header( 'Location: /task_review?id=' . $_POST['id'] );
				exit;
			
			}
			
		}	
		
		if( $_GET['id'] ) {
			
			$this->result = $this->db->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
			
			$_GET['task'] 		= $_GET['id'];
			$_GET['project'] 	= $this->result['project'];
			
			$this->db->table = 'comments';
			
			$this->comments = $this->db->retrieve( 'all', '*', ' where task = ' . $_GET['id'] ); 
			
			$this->db->table = 'time_entries';
			
			$this->task_timesheet = $this->db->retrieve('pair',"user,sum( minutes )"," where task = " . $_GET['id']  . " group by user"); 
															
		}
		
	}
	
	public function time_entry() {
	
		$this->db->table = 'time_entries';
		
		if( count( $_POST ) ) {
			
			if( $this->db->save( $_POST ) ) {
		
				if( !$_POST['id'] ) {
				
					$_POST['id'] = mysql_insert_id();
				
				}
																				
				header( 'Location: /timesheet' );
				exit;
			
			}
			
		}	
		
		if( $_GET['id'] ) {
			
			$this->result = $this->db->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
															
		}
		
	}

	
	public function schedule_appointment() {
	
		$this->db->table = 'doctor_hours';
			
		$hours = $this->db->retrieve( 'all', '*', ' where doctor_id = ' . $_GET['doctor'] ); 
		
		if( is_array( $hours ) ) {
			
			foreach( $hours as $hour ) {
				
				$this->result[ $hour['day_of_week'] ][] = $this->appointment_hours[ $hour['starting_hour'] ] . ' - ' . $this->appointment_hours[ $hour['ending_hour'] ];
				
			}
			
		}
	
	}
	
	public function _choose_appointment_day() {
	
		$this->db->table = 'doctors';
			
		$doctor_info = $this->db->retrieve( 'one', '*', ' where id = ' . $_GET['doctor'] ); 
		
		$this->db->table = 'doctor_hours';
			
		$hours = $this->db->retrieve( 'all', '*', ' where doctor_id = ' . $_GET['doctor'] . " and day_of_week='" . date( 'l', strtotime( $_GET['day'] ) ) . "' order by starting_hour asc" ); 
		
		$this->time_slots = array();
		
		if( is_array( $hours ) ) {
			
			foreach( $hours as $hour ) {
			
				//$length = $hour['ending_hour'] - $hour['starting_hour'];
				
				//$appointments = floor( ( $length * 60 ) / $doctor_info['appointment_length'] );
				
				$i = $hour['starting_hour'];
				
				while( $i < $hour['ending_hour'] ) {
				
					//echo( $i . ': ' . $i . '<br>');
					
					$this->time_slots[ "$i" ] = AppFunctions::formatTime( $i );
					
					$i += ( $doctor_info['appointment_length'] / 60 );
					
				}
				
			}
			
		}
		
	}
	
	public function doctor_hour() {
	
		if( count( $_POST ) > 0 ) {
								
			$this->db->table = 'doctor_hours';
						
			if( $this->db->save( $_POST ) ) {
			
				if( !$_POST['id'] ) {
				
					$_POST['id'] = mysql_insert_id();
				
				}
																						
				header( 'Location: /doctor?id=' . $_POST['doctor_id'] );
				exit;
			
			}
		
		}
		
		if( $_GET['id'] ) {
		
			$this->db->table = 'doctor_hours';
			
			$this->result = $this->db->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
			
			$_GET['doctor_id'] = $this->result['doctor_id'];
														
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
					$resizeObj -> resizeImage( 100, 100, 'landscape' );
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
					
			$this->db->table = 'users';
						
			if( $this->db->save( $_POST ) ) {
			
				if( !$_POST['id'] ) {
				
					$_POST['id'] = mysql_insert_id();
				
				}
																						
				header( 'Location: /users' );
				exit;
			
			}
		
		}
		
		if( $_GET['id'] ) {
		
			$this->db->table = 'users';
			
			$this->result = $this->db->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
														
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
	
	public function _update_favorites() {
	
		if( $_POST['doctor'] ) {
		
			$this->db->table = 'favorites';
			
			$favorite = $this->db->retrieve( 'one', '*', ' where doctor_id = ' . $_POST['doctor'] . ' and office_id = ' . $_SESSION['logged_in_user']['office_id'] ); 
			
			// it exists, so remove it
			if( $favorite['id'] ) {
				
				$this->db->remove( $favorite['id'] );
				
			} else { // it doesn't, so add it
				
				if( $this->db->save( array( 'doctor_id' => $_POST['doctor'], 'office_id' => $_SESSION['logged_in_user']['office_id'] ) ) ) {
					
					// do something, if necessary
					
				}
				
			}
														
		}
		
		exit;
	
	}
	
	public function referral() {
		
		if( count( $_POST ) > 0 ) {
			
			$_POST['appointment'] = date( 'Y-m-d H:i:s', strtotime( $_POST['appointment'] ) );
		
			$this->db->table = 'referrals';
			
			//print_r( $_POST );
			//exit;
			
			if( !$this->message ) {
				
				if( $this->db->save( $_POST ) ) {
				
					if( !$_POST['id'] ) {
					
						$_POST['id'] = mysql_insert_id();
					
					}
																							
					header( 'Location: /referrals' );
					exit;
								
				}
			
			}
		
		}
		
		if( $_GET['id'] ) {
		
			$this->db->table = 'referrals';
			
			$this->result = $this->db->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
														
		}
		
		if( $_GET['doctor'] ) {
		
			$this->db->table = 'doctor_referral_questions';
			
			$this->doctor_questions = $this->db->retrieve( 'all', '*', ' where doctor_id = ' . $_GET['doctor'] ); 
														
		}
		
	
	}
	
	public function banner() {
		
		if( count( $_POST ) > 0 || $_FILES['image'] ) {
			
			$this->db->table = 'banners';
			
			if( is_uploaded_file( $_FILES['image']['tmp_name'] ) ) {
				
				if( $_FILES['image']['type'] == 'image/jpeg' ) {
					
					$_POST['image'] = time() . $this->clean_filename( $_FILES['image']['name'] );
					
					$path = str_replace( 'admin', '', getcwd() ) . 'images/uploads/';
					
					move_uploaded_file( $_FILES['image']['tmp_name'], $path . 'tmp/' . $_POST['image'] ); 
					
					$size = getimagesize( $this->site_url . '/images/uploads/tmp/' . $_POST['image'] ); 
					
					if( $size[0] >= 1200 && $size[1] >= 415 ) {
					
						$resizeObj = new resize( $path . 'tmp/' . $_POST['image'] );
						$resizeObj -> resizeImage( 1200, 415, 'crop' );
						$resizeObj -> saveImage( $path . 'banners/' . $_POST['image'], 100 );
										
						$resizeObj = new resize( $path . 'tmp/' . $_POST['image'] );
						$resizeObj -> resizeImage( 150, 150, 'crop' );
						$resizeObj -> saveImage( $path . 'banners/thumbnails/' . $_POST['image'], 100 );
						
					} else {
						
						unlink( $path . 'tmp/' . $_POST['image'] );
						$this->message = 'Invalid type image dimensions. Must be at least 1200px x 415px.';
						$_GET['id'] = $_POST['id'];
						
					}
				
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
																							
					header( 'Location: /banners' );
					exit;
								
				}
			
			}
		
		}
		
		if( $_GET['id'] ) {
		
			$this->db->table = 'banners';
			
			$this->result = $this->db->retrieve( 'one', '*', ' where id = ' . $_GET['id'] ); 
														
		}
		
	
	}
		
	public function delete() {
		
		$this->db->table = $_GET['model'];
		$this->db->remove( $_GET['id'] );
	
		header( 'Location: /' . $_GET['model'] );
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