<h1>Your Favorite Doctors</h1>

<? if( count( $controller->favorites ) ): ?>

<p>Click <a href='/search'>here</a> to search for more doctors.</p>

<table id='default-table' class="table table-striped table-condensed">

	<thead>
    	<tr>
    		<th>&nbsp;</th>
        	<th>Name</th>
        	<th>Office</th>
        	<th>Referrals</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    
    <tbody>
    
    	<? foreach( $controller->favorites as $r ): ?>
                
        <tr>
        	<td>
        		<? if( $controller->doctor_image_list[ $r['doctor_id'] ] ): ?>
    
					<img src="<?=$controller->site_url ?>/images/uploads/thumbnails/<?=$controller->doctor_image_list[ $r['doctor_id'] ] ?>" style='border-radius: 10px;'/>
				    
				<? endif; ?>
        	</td>
        	<td><?=$controller->doctor_list[ $r['doctor_id'] ] ?></td>
        	<td><?=$controller->office_list[ $controller->offices_by_doctor[ $r['doctor_id'] ] ] ?></td>
			<td><?=$controller->office_referrals_by_doctor[ $r['doctor_id'] ]?$controller->office_referrals_by_doctor[ $r['doctor_id'] ]:0 ?></td>
            <td>
            	<a href='#' class='update-favorites' data-attr='<?=$r['doctor_id'] ?>'>
	            	
	            	<? if( $controller->my_favorites[ $r['doctor_id'] ] ): ?>
	            	
	            		Remove from Favorites
	            		
	            	<? else: ?>
	            	
	            		Add to Favorites
	            		
	            	<? endif; ?>
	            	
            	</a><br>
            	<a href='/schedule_appointment?doctor=<?=$r['doctor_id'] ?>'>Schedule Appointment</a><br>
            	<a href='/referral?doctor=<?=$r['doctor_id'] ?>'>Refer Patient</a>
            </td>
        </tr>
        
        <? endforeach; ?>
        
    </tbody>

</table>

<? else: ?>

	<p>No favorites are in the system. Click <a href='/search'>here</a> to search for doctors.</p>
    
<? endif; ?>