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
			
			setInterval(function(){update_tracker()},10000);	
			
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
						
		});
		
		
	</script>
        
  </body>
</html>