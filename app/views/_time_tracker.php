<?=$functions->formatTime( $controller->time_entry['minutes'] ) ?> ( <a href='#' id='pause-tracker' class='glyphicon glyphicon-<?=$_SESSION['tracking']?'pause':'play' ?>'></a> )

<script>

	$(document).ready(function(){
	
		$('#pause-tracker').click(function(e) {
			
			e.preventDefault();
			
			
			
			if( $(this).hasClass('glyphicon-play') ) {
				
				$(this).removeClass('glyphicon-play');
				$(this).addClass('glyphicon-pause');
				
				$.ajax({
				  url: '/_start_tracker?ajax=true'
				}).done(function(data) {
				  //alert( data );
				});
				
			} else {
				
				$(this).removeClass('glyphicon-pause');
				$(this).addClass('glyphicon-play');
				
				$.ajax({
				  url: '/_pause_tracker?ajax=true'
				}).done(function(data) {
				  //alert( data );
				});
				
			}
			//alert( pauseTracker );
			
		});
		
		<? if( $controller->additional_time > 1 ): ?>
		
			if( confirm( 'It looks like your timer has been left open. Do you want to discard the last <?=$controller->additional_time ?> minutes?'  ) ) {
			
				$.ajax({
				  url: '/_discard_time?ajax=true'
				}).done(function(data) {
				  //alert( data );
				});
			
			} else {
				
				$.ajax({
				  url: '/_keep_time?ajax=true'
				}).done(function(data) {
				  //alert( data );
				});
				
			}
		
		<? endif; ?>
	
	});

</script>