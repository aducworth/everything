<?

class Form {

	var $name_prefix = array( 
								'MR' => 'Mr.',
								'MRS' => 'Mrs.',
								'MS' => 'Ms.',
								'MISS' => 'Miss',
								'DR' => 'Dr.',
								'REV' => 'Rev.',
								'RET' => 'Ret.' );
								
	var $name_suffix = array( 'SR' => 'Sr.', 'JR' => 'Jr.' );
	
	var $states = array( 'AL' => 'AL', 'AK' => 'AK', 'AZ' => 'AZ', 'AR' => 'AR', 'CA' => 'CA', 'CO' => 'CO', 'CT' => 'CT', 'DE' => 'DE', 'DC' => 'DC', 'FL' => 'FL', 'GA' => 'GA', 'HI' => 'HI', 'ID' => 'ID', 'IL' => 'IL', 'IN' => 'IN', 'IA' => 'IA', 'KS' => 'KS', 'KY' => 'KY', 'LA' => 'LA', 'ME' => 'ME', 'MD' => 'MD', 'MA' => 'MA', 'MI' => 'MI', 'MN' => 'MN', 'MS' => 'MS', 'MO' => 'MO', 'MT' => 'MT', 'NE' => 'NE', 'NV' => 'NV', 'NH' => 'NH', 'NJ' => 'NJ', 'NM' => 'NM', 'NY' => 'NY', 'NC' => 'NC', 'ND' => 'ND', 'OH' => 'OH', 'OK' => 'OK', 'OR' => 'OR', 'PA' => 'PA', 'RI' => 'RI', 'SC' => 'SC', 'SD' => 'SD', 'TN' => 'TN', 'TX' => 'TX', 'UT' => 'UT', 'VT' => 'VT', 'VA' => 'VA', 'WA' => 'WA', 'WV' => 'WV', 'WI' => 'WI', 'WY' => 'WY' );
	
	var $card_types = array( 'Visa' => 'Visa', 'Mastercard' => 'Mastercard', 'Amex' => 'Amex', 'Discover' => 'Discover' );
	
	var $months = array( '01' => '01',
						'02' => '02',
						'03' => '03',
						'04' => '04',
						'05' => '05',
						'06' => '06',
						'07' => '07',
						'08' => '08',
						'09' => '09',
						'10' => '10',
						'11' => '11',
						'12' => '12' );
						
	var $days = array(  'Monday' 		=> 'Monday',
						'Tuesday' 		=> 'Tuesday',
						'Wednesday'		=> 'Wednesday',
						'Thursday'		=> 'Thursday',
						'Friday'		=> 'Friday' );
						
	function textbox( $name, $options=array() ) {
	
		$toreturn = '<div class="form-group">';
		
		if( $options['label'] ) {
		
			$toreturn .= "<label for='input-".$name."' class='col-lg-2 control-label'>".$options['label']."</label>";
		
		}
		
		$toreturn .= "<div class='col-lg-10'><input type='text' id='".$name."-id' name='".$name."' value=\"".($_POST[$name]?$_POST[$name]:$options['default'])."\" ";
		
		$options['class'] .= ' form-control ';
		
		foreach( $options as $tag => $action ) {
		
			if( $tag != 'range' && $tag != 'label' && $tag != 'empty' ) {
			
				$toreturn .= " " . $tag . "=\"" . $action . "\"";
			
			}
		
		}
		
		$toreturn .= "/></div></div>";
		
		return $toreturn;
	
	}
	
	function file( $name, $options=array() ) {
	
		$toreturn = '<div class="form-group">';
		
		if( $options['label'] ) {
		
			$toreturn .= "<label for='input-".$name."' class='col-lg-2 control-label'>".$options['label']."</label>";
		
		}
		
		$toreturn .= "<div class='col-lg-10'><input type='file' id='".$name."-id' name='".$name."' value=\"".($_POST[$name]?$_POST[$name]:$options['default'])."\" ";
		
		$options['class'] .= ' form-control ';
		
		foreach( $options as $tag => $action ) {
		
			if( $tag != 'range' && $tag != 'label' && $tag != 'empty' ) {
			
				$toreturn .= " " . $tag . "=\"" . $action . "\"";
			
			}
		
		}
		
		$toreturn .= "/>";
		
		if( $options['help'] ) {
			
			$toreturn .= "<span class='help-block'>" . $options['help'] . "</span>";
		}
		
		$toreturn .= "</div></div>";
		
		return $toreturn;
	
	}
	
	function textarea( $name, $options=array() ) {
	
		$toreturn = '<div class="form-group">';
		
		if( $options['label'] ) {
		
			$toreturn .= "<label for='input-".$name."' class='col-lg-2 control-label'>".$options['label']."</label>";
		
		}
		
		$toreturn .= "<div class='col-lg-10'><textarea id='".$name."-id' name='".$name."' ";
		
		$options['class'] .= ' form-control ';
		
		foreach( $options as $tag => $action ) {
		
			if( $tag != 'range' && $tag != 'label' && $tag != 'empty' ) {
			
				$toreturn .= " " . $tag . "=\"" . $action . "\"";
			
			}
		
		}
		
		$toreturn .= ">".($_POST[$name]?$_POST[$name]:$options['default'])."</textarea></div></div>";
		
		return $toreturn;
	
	}
	
	function password( $name, $options=array() ) {
	
		$toreturn = '<div class="form-group">';
		
		if( $options['label'] ) {
		
			$toreturn .= "<label for='input-".$name."' class='col-lg-2 control-label'>".$options['label']."</label>";
		
		}
		
		$toreturn .= "<div class='col-lg-10'><input type='password' id='".$name."-id' name='".$name."' value=\"".($_POST[$name]?$_POST[$name]:$options['default'])."\" ";
		
		$options['class'] .= ' form-control ';
		
		foreach( $options as $tag => $action ) {
		
			if( $tag != 'range' && $tag != 'label' && $tag != 'empty' ) {
			
				$toreturn .= " " . $tag . "=\"" . $action . "\"";
			
			}
		
		}
		
		$toreturn .= "></div></div>";
		
		return $toreturn;
	
	}
	
	function select( $name, $inputs, $options=array() ) {
	
		$toreturn = '<div class="form-group">';
		
		// adds in ability to add to a list on the fly
		if( is_array( $options['add_to_list'] ) ) {
			
			$list_form .= "<div id='" . $name . "-add-list' class='add-list-container'>";
			
			$list_form .= "<h2>Add " . $options['label'] . "</h2>";
			
			foreach( $options['add_to_list']['fields'] as $field => $label ) {
				
				$list_form .= "<label for='input_".$field."'>".$label.":</label>";
				$list_form .= "<input type='text' id='".$field."' value=''/>";
				
			}
			
			$list_form .= "<input type='hidden' id='model' value='" . $options['add_to_list']['model'] . "'/>";
			$list_form .= "<input type='hidden' id='pair' value='" . $options['add_to_list']['pair'] . "'/>";
			
			$list_form .= "<p><button class='btn add-list-item'>Add Item</button></p>";
			
			$list_form .= "</div>";
			
			// update the label
			$options['label'] .= " ( <a href='#' class='add-to-list' data-item='" . $name . "-add-list'>Add Item</a> )";
			
		}
		
		if( $options['label'] ) {
		
			$toreturn .= "<label for='input_".$name."' class='col-lg-2 control-label'>".$options['label']."</label>";
		
		}
		
		if( isset( $options['range']['lower'] ) && isset( $options['range']['upper'] ) ) {
		
			for( $i=$options['range']['lower'];$i<$options['range']['upper'];$i++ ) {
			
				$inputs[$i] = $i;
			
			}
		
		}
		
		$toreturn .= "<div class='col-lg-10'><select id='".$name."-id' name='".$name."' ";
		
		$options['class'] .= ' form-control ';
		
		foreach( $options as $tag => $action ) {
		
			if( $tag != 'range' && $tag != 'label' && $tag != 'empty' ) {
			
				$toreturn .= " " . $tag . "=\"" . $action . "\"";
			
			}
		
		}
		
		$toreturn .= ">";
		
		if( $options['empty'] ) {
			
			$selected = ($_POST[$name]=='')?'selected':'';
		
			$toreturn .= "<option value='' ".$selected.">".$options['empty']."</option>";
		
		}
		
			foreach( $inputs as $value => $display ) {
			
				$selected = ($_POST[$name] == $value || $options['default'] == $value)?'selected':'';
				
				$toreturn .= "<option value='".$value."' ".$selected.">".$display."</option>";
			
			}
		
		$toreturn .= "</select>";
		
		if( $list_form ) {
			
			$toreturn .= $list_form;
			
		}
		
		$toreturn .= "</div></div>";
		
		return $toreturn;
	
	}
	
	function buttons( $model, $id ) {
		
		$toreturn = '<div class="form-group">
				      <div class="col-lg-10 col-lg-offset-2">';
				      
		if( $id ) {
			
			$toreturn .= '<button id="delete-' . $model . '" class="btn btn-danger pull-right delete-item">Delete</button>';
			
		}
				      
		$toreturn .= '<button id="cancel-' . $model . '"  class="btn btn-default cancel-item">Cancel</button>
				        
				        <button type="submit" class="btn btn-primary">Submit</button>
				      </div>
				    </div>';
				    
		return $toreturn;
		
	}
	
	function radio( $name, $inputs, $options = array( ) ) {
	
		$toreturn = '';
		
		$toreturn .= "<input type='hidden' id='".$name."-id' name='".$name."' value=''/>";
		
		foreach( $inputs as $value => $label ) {
		
			$checked = ($_POST[$name]==$value)?'checked':'';
		
			$toreturn .= "<li><label for='input_".$name."'>";
			$toreturn .= "<input type='radio' id='".$name."-id' class='radio_input' name='".$name."' value=\"".$value."\" ".$checked."> ";
			$toreturn .= $label."</label></li>";
			
		}
		
		return $toreturn;
	
	}
	
	
	function checkbox( $name, $inputs=array(), $options=array() ) {
	
		$toreturn = '<div class="form-group">';
		
		if( $options['label'] ) {
		
			$toreturn .= "<label for='input_".$name."' class='col-lg-2 control-label'>".$options['label']."</label>";
		
		}
		
		$toreturn .= '<div class="col-lg-10 col-lg-offset-2">';
		
		foreach( $inputs as $value => $label ) {
			
			$toreturn .= "<div class='checkbox'><label>
							  <input type='checkbox' id='".$name.((count($inputs)>1)?$value:'')."-id' value='" . $value. "' name='".$name.((count($inputs)>1)?'[]':'')."' " . (in_array( $value, $options['default'] )?'checked':'') . "/>" . $label .
						  "</label></div>";
			
		}
		
		$toreturn .= '</div></div>';
				
		return $toreturn;
	
	}
	

}

?>