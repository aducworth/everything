<?=$functions->formatTime( $controller->time_entry['minutes'] ) ?>
<script>

	$(document).ready(function(){
	
		setInterval(function(){update_tracker()},10000);
	
	});

</script>