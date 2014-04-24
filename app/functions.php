<?

class AppFunctions {

	public function formatTime( $minutes ) {
	
		$seconds = ( $minutes * 60 );
	
		$h_i_s = gmdate("j:G:i:s", $seconds);
		
		$h_i_s = explode( ':', $h_i_s );
		
		if( $h_i_s[0] > 1 ) {
			
			return $h_i_s[0] . 'd' . $h_i_s[1] . 'h' . $h_i_s[2] . 'm';
			
		}
		
		if( $h_i_s[1] > 0 ) {
			
			return $h_i_s[1] . 'h' . $h_i_s[2] . 'm';
			
		}
		
		if( $h_i_s[2] > 0 ) {
			
			return $h_i_s[2] . 'm';
			
		}
		
		return '0m';
		
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
	
	public function convertText( $text ) {
	
		$text = nl2br( $text );
		
		return ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\" target=\"_blank\">\\0</a>", $text);
				
	}
	
	public function send_mail($to, $body, $subject, $fromaddress, $fromname, $attachments=false) {

	  $eol="\r\n";

	  $mime_boundary=md5(time());

	

	  # Common Headers

	  $headers .= "From: ".$fromname."<".$fromaddress.">".$eol;
	  
	  //if( !strstr( $subject, 'configured' ) ) {
	  
	  	$headers .= 'Bcc: aducworth@gmail.com'.$eol;
		
	  //}

	  $headers .= "Reply-To: ".$fromname."<".$fromaddress.">".$eol;

	  $headers .= "Return-Path: ".$fromname."<".$fromaddress.">".$eol;    // these two to set reply address

	  $headers .= "Message-ID: <".time()."-".$fromaddress.">".$eol;

	  $headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters

	

	  # Boundry for marking the split & Multitype Headers

	  $headers .= "MIME-Version: 1.0".$eol;

	  $headers .= "Content-Type: multipart/mixed; boundary=\"".$mime_boundary."\"".$eol.$eol;

	

	  # Open the first part of the mail

	  $msg = "--".$mime_boundary.$eol;

	  

	  $htmlalt_mime_boundary = $mime_boundary."_htmlalt"; //we must define a different MIME boundary for this section

	  # Setup for text OR html -

	  $msg .= "Content-Type: multipart/alternative; boundary=\"".$htmlalt_mime_boundary."\"".$eol.$eol;

	

	  # Text Version

	  $msg .= "--".$htmlalt_mime_boundary.$eol;

	  $msg .= "Content-Type: text/plain; charset=iso-8859-1".$eol;

	  $msg .= "Content-Transfer-Encoding: 8bit".$eol.$eol;

	  $msg .= strip_tags(str_replace("<br>", "\n", substr($body, (strpos($body, "<body>")+6)))).$eol.$eol;

	

	  # HTML Version

	  $msg .= "--".$htmlalt_mime_boundary.$eol;

	  $msg .= "Content-Type: text/html; charset=iso-8859-1".$eol;

	  $msg .= "Content-Transfer-Encoding: 8bit".$eol.$eol;

	  $msg .= $body.$eol.$eol;

	

	  //close the html/plain text alternate portion

	  $msg .= "--".$htmlalt_mime_boundary."--".$eol.$eol;

	

	  if ($attachments !== false)

	  {

		for($i=0; $i < count($attachments); $i++)

		{



			$f_contents = chunk_split(base64_encode($attachments[$i]["file"]));

			

			# Attachment

			$msg .= "--".$mime_boundary.$eol;

			$msg .= "Content-Type: ".$attachments[$i]["content_type"]."; name=\"".$attachments[$i]["name"]."\"".$eol;  // sometimes i have to send MS Word, use 'msword' instead of 'pdf'

			$msg .= "Content-Transfer-Encoding: base64".$eol;

			$msg .= "Content-Description: ".$attachments[$i]["name"].$eol;

			$msg .= "Content-Disposition: attachment; filename=\"".$attachments[$i]["name"]."\"".$eol.$eol; // !! This line needs TWO end of lines !! IMPORTANT !!

			$msg .= $f_contents.$eol.$eol;

		  //}

		}

	  }

	  # Finished
	  $msg .= "--".$mime_boundary."--".$eol.$eol;  // finish with two eol's for better security. see Injection.

	  # SEND THE EMAIL
	  
	  ini_set(sendmail_from,$fromaddress);  // the INI lines are to force the From Address to be used !

	  //$mail_sent = mail($to, $subject, $msg, $headers);	  
	  $mail_sent = mail($to, $subject, $msg, $headers,"-f$to");	  

	  ini_restore(sendmail_from);

	  return $mail_sent;

	} // send_mail

}

?>