	</div><!--content--> 
				
	<script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/validate.js"></script>
    <script src="/assets/fullcalendar/fullcalendar.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
    
    <script type="text/javascript">
    
    	function update_tracker() {
	    	
	    	var timeData = 'project=<?=$_GET['project'] ?>&task=<?=$_GET['task'] ?>';
			
			$.ajax({
			  url: "/_time_tracker",
			  data: timeData,
			  type: "GET"
			}).done(function(data) {
			  $('#hour-update').html( data );
			});

	    	
    	}
		$(document).ready(function(){	
		
			update_tracker();		
			
			$("#data-form").validate({
			  rules: {
				password_confirm: {
				  equalTo: "#password-id"
				},
				checkbox: { 
					required: 'input[type="checkbox"]:checked'
				}
			  }
			});
			
			$('.action-search').change(function() {
			
				$(this).parent('form').submit();
				
			});
			
			$('#title-id').change(function() {
				
		      var name = $(this).val();
			  
			  var formatted_name = name.replace(/\./g,'').replace(/,/g,'').replace(/,/g,'-').replace(/"/g,'').replace(/'/g,'').replace(/ /g,'-').replace(/&/g,'and').replace(/!/g,'').replace(/\$/g,'').replace(/\*/g,'').replace(/\//g,'').replace(/@/g,'').replace(/\(/g,'').replace(/\)/g,'').replace(/\[/g,'').replace(/\]/g,'').replace(/%/g,'').replace(/#/g,'');
			  			  
			  if( $('#url-id').val() == '' ) {
				  
				  $('#url-id').val( formatted_name.toLowerCase() );
				  
			  }
			  
			});
			
			$('#doctor_type_id-id').change(function(){
			
				$('.questions-by-doctor-type').hide();
				
				if( $(this).val() ) {
					
					$('#doctor-type-'+$(this).val()).show();
					
				}
				
			});
			
			$('.update-favorites').click(function(e){
			
				e.preventDefault();
				
				var this_link = $(this);
				var postData = 'doctor=' + $(this).attr('data-attr');
				
				$.ajax({
				  url: '/_update_favorites?ajax=true',
				  data: postData,
				  type: "POST"
				}).done(function(data) {
				  
				  	if( this_link.html().trim() == 'Add to Favorites' ) {
					  	
					  	this_link.html( 'Remove From Favorites' );
					  	
				  	} else {
					  	
					  	this_link.html( 'Add to Favorites' );
					  	
				  	}
				});
			
			});
			
			$('.update-tag').change(function() {
				
			  if( $('#fname-id').val() == '' || $('#lname-id').val() == '' ) {
				  
				  return;
			  }
			  
		      var name = $('#fname-id').val() + '-' + $('#lname-id').val();
			  
			  var formatted_name = name.replace(/\./g,'').replace(/,/g,'').replace(/,/g,'-').replace(/"/g,'').replace(/'/g,'').replace(/ /g,'-').replace(/&/g,'and').replace(/!/g,'').replace(/\$/g,'').replace(/\*/g,'').replace(/\//g,'').replace(/@/g,'').replace(/\(/g,'').replace(/\)/g,'').replace(/\[/g,'').replace(/\]/g,'').replace(/%/g,'').replace(/#/g,'');
			  
			  if( $('#url-id').val() == '' ) {
				  
				  $('#url-id').val( formatted_name.toLowerCase() );
				  
			  }
			  
			});
			
			$('.update-display-order').change(function() {
				
				$.ajax({
					url: '/update_display_order?update_id=' + $(this).attr('id') + '&order=' + $(this).val(),
					context: document.body
				}).done(function() {
					$('.alert').remove();
					$('#main-content').prepend('<div class="alert alert-success">Order Updated</div> ');
				});
			  			  
			});
			
			$('.photo-selector').click(function() {
				
				$('.photo-selector').removeClass('selected-photo');
				$(this).addClass('selected-photo');
				
				$('#photo').val( $(this).attr('id') );
			  			  
			});
			
			$('.add-to-list').click(function(e) {
				
				e.preventDefault();
				
				$( '#' + $(this).attr('data-item') ).toggle('slow');
							  			  
			});
			
			$('.add-list-item').click(function(e) {
				
				e.preventDefault();
				
				var list_area = $(this).parent().parent().attr('id');
				var select_item = list_area.replace('add-list','id');
				
				var url = 'ajax=true'
				
				$( '#' + list_area + ' input' ).each(function( index ) {
				  url += '&' + $(this).attr('id') + '=' + $(this).val();
				});
				
				$.ajax({
					url: '/add_to_list',
					data: url,
					method: 'GET',
					success: function(data) { 
						var result = $.parseJSON(data);
						
						if( result.error ) {
							
							$( '#' + list_area ).prepend( "<div class='alert alert-error'>" + result.error + "</div>" );
							
						} else {
							
							$( '#' + select_item ).html( result.data );
							$( '#' + list_area + ' .alert' ).hide();
							$( '#' + list_area ).hide('slow');
							
						}
					}
				});
				
				//$( '#' + $(this).attr('data-item') ).toggle();
							  			  
			});
			
			$('.delete-item').click(function(e) {
				
				e.preventDefault();
				
				var to_delete = $(this).attr('id').replace('delete-','');
				
				if( confirm( 'Are you sure you want to delete this ' + to_delete + '?' ) ) {
					
					location.href = '/delete?id=' + $('#id').val() + '&model=' + to_delete + 's';
					
				}
			  			  
			});
			
			$('.cancel-item').click(function(e) {
				
				e.preventDefault();
				
				var to_cancel = $(this).attr('id').replace('cancel-','');
				
				location.href = '/' + to_cancel + 's';
			  			  
			});
			
			$('.booking-list-link').click(function(e) {
				
				e.preventDefault();
							  			  
			});
			
			$(function() {
				
				$( "#release_date-id" ).datepicker();
			
			});
			
			// if location changes, re-center map
			$('#get-coordinates').click( function(e) {
			
				e.preventDefault();
			
				geocoder = new google.maps.Geocoder();
				
				var address = $('#address-id').val() + ' ' + $('#address2-id').val() + ', ' + $('#city-id').val() + ', ' + $('#state-id').val() + ' ' + $('#zipcode-id').val();
				
				geocoder.geocode({ 'address': address }, function (results, status) {
					
					if (status == google.maps.GeocoderStatus.OK) {
					
						$('#latitude-id').val( results[0].geometry.location.lat() );
						
						$('#longitude-id').val( results[0].geometry.location.lng() );
						//map.setCenter( results[0].geometry.location );
						
					} else {
						
						alert('Geocode was not successful for the following reason: ' + status);
						
					}
				
				});
			  
		  	});
		  	
		  	$('.question-selector').click(function(e){
		  	
		  		e.preventDefault();
		  		
		  		$('.question-selector').removeClass('selected');
		  		$('.question-selector').parent().css('border','3px #fff solid');
		  		
		  		var swatch_click = $(this).find('span.selector-swatch');
		  		var selected_teeth = $(this).parent().find('span.selected-teeth');		  		
		  		var color = swatch_click.css("background-color");
		  		
		  		if( swatch_click.hasClass('checked-swatch') ) {
			  		
			  		swatch_click.removeClass('checked-swatch');
			  		selected_teeth.html('');			  		
			  		$('a.tooth').removeClass( swatch_click.attr('class').replace('selector-swatch','') );
			  		
		  		} else {
			  		
			  		swatch_click.addClass('checked-swatch');
			  		selected_teeth.html('( All Teeth )');
			  		$(this).addClass('selected');
			  		$(this).parent().css('border','3px ' + color + ' solid');
			  		
		  		}
		  		
		  	});
		  	
		  	$('.tooth').click(function(e){
		  	
		  		e.preventDefault();
		  		
		  		//alert( $(this).attr('id') );
		  		
		  		//var select_question = $('#question-list .selected');
		  		
		  		if( $('#question-list .selected').attr('id') ) {
			  		
			  		var color_class = $('#question-list .selected span').attr('class');
			  		color_class = color_class.replace('checked-swatch','').replace('selector-swatch','');
			  		
			  		if( $(this).hasClass( color_class ) ) {
				  		
				  		$(this).removeClass( color_class );
				  		
			  		} else {
				  		
				  		$(this).addClass( color_class );
				  		
			  		}
		  		
		  		} else {
			  		
			  		alert( 'Please select an issue to the left and then select teeth to match with the issue.' );
			  		
		  		}
		  		
		  		
//		  		$('.question-selector').removeClass('selected');
//		  		$('.question-selector').parent().css('border','3px #fff solid');
//		  		
//		  		var color = $(this).find('span').css("background-color");
//		  		
//		  		$(this).parent().css('border','3px ' + color + ' solid');
		  		//alert( color );
		  		
		  	});
						
		});
		
		
	</script>
	
	<? if( $action == 'schedule' || ( $action == 'index' && $_SESSION['logged_in_user']['homepage'] == 'schedule' ) ): ?>
	
	<script>

		$(document).ready(function() {
		
			$('#calendar').fullCalendar({
				editable: true,
				events: [
					<? foreach( $controller->referrals as $r ): ?>
					{
						<? $appt_time = strtotime( $r['appointment'] ); ?>
						
						id: <?=$r['id'] ?>,
						title: '<?=$r['patient_name'] ?>',
						start: new Date(<?=date( 'Y', $appt_time ) ?>, <?=( date( 'm', $appt_time ) - 1 ) ?>, <?=date( 'd', $appt_time ) ?>, <?=date( 'H', $appt_time ) ?>, <?=date( 'i', $appt_time ) ?>),
						url: '/referral?id=<?=$r['id'] ?>',
						allDay: false
					},
					<? endforeach; ?>
				]
			});
			
		});
	
	</script>

	<? endif; ?>
	
	<? if( $action == 'schedule_appointment' ): ?>
	
		<?
		
			$current = time();
			$three_months = strtotime( '+3 months' );
			
		?>
	
	<script>

		$(document).ready(function() {
		
			$('#calendar').fullCalendar({
				editable: false,
				events: [
					<? while( $current < $three_months ): ?>
					
						<? if( $controller->result[ date( 'l', $current ) ] ): ?>
						
						{
							id: <?=$current ?>,
							title: '<?=date( 'l', $current ) . ': ' . implode( ', ', $controller->result[ date( 'l', $current ) ] ) ?>',
							start: new Date(<?=date( 'Y', $current ) ?>, <?=( date( 'm', $current ) - 1 ) ?>, <?=date( 'd', $current ) ?>, <?=date( 'H', $current ) ?>, <?=date( 'i', $current ) ?>),
							allDay: true
						},
						
						<? endif; ?>
					
						<? $current = strtotime( '+1 day', $current ) ?>
						
					<? endwhile; ?>
				],
				eventClick: function(calEvent, jsEvent, view) {
				
					var postData = 'ajax=true&doctor=' + $('#doctor').val() + '&day=' + calEvent.start;
				
					$.ajax({
					  url: '/_choose_appointment_day',
					  data: postData,
					  type: "GET"
					}).done(function(data) {
					  //alert( data );
					  	
					  	$('#choose-day').html( data );
					  	
					  	// change the border color just for fun
					  	$(this).css('border-color', 'red');
					});

			        //alert('Event: ' + calEvent.start);
			        //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
			        //alert('Dr: ' + $('#doctor').val());
			
			        
			
			    }
			});
			
		});
	
	</script>

	<? endif; ?>
        
  </body>
</html>