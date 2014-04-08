<?

class AppFunctions {

	public function formatTime( $minutes ) {
	
		$seconds = ( $minutes * 60 );
	
		$h_i_s = gmdate("H:i:s", $seconds);
		
		$h_i_s = explode( ':', $h_i_s );
		
		if( $h_i_s[0] > 0 ) {
			
			return $h_i_s[0] . 'h' . $h_i_s[1] . 'm';
			
		}
		
		if( $h_i_s[1] > 0 ) {
			
			return $h_i_s[1] . 'm';
			
		}
		
		return 'Not Started';
		
	}
	
	public function generateRandomColor() {
	
		$white = 255;
	
	    $red 	= ( rand( 0, 256 ) + $white ) / 2;
	    $green 	= ( rand( 0, 256 ) + $white ) / 2;
	    $blue 	= ( rand( 0, 256 ) + $white ) / 2;
		
	    return $this->rgb2html( $red, $green, $blue );
	    
	}
	
	public function rgb2html($r, $g=-1, $b=-1) {
	
	    if ( is_array($r) && sizeof( $r ) == 3 ) {
		    
		    list($r, $g, $b) = $r;
		    
	    }       
	
	    $r = intval($r); 
	    $g = intval($g);
	    $b = intval($b);
	
	    $r = dechex($r<0?0:($r>255?255:$r));
	    $g = dechex($g<0?0:($g>255?255:$g));
	    $b = dechex($b<0?0:($b>255?255:$b));
	
	    $color = (strlen($r) < 2?'0':'').$r;
	    $color .= (strlen($g) < 2?'0':'').$g;
	    $color .= (strlen($b) < 2?'0':'').$b;
	    
	    return '#'.$color;
	    
	}

}

?>