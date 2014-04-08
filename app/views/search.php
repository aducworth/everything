<div class="hero-unit">

	<h1>Search for Doctors</h1>
	
</div>

<? if( count( $controller->results ) ): ?>

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
    
    	<? foreach( $controller->results as $r ): ?>
                
        <tr>
        	<td>
        		<? if( $controller->doctor_image_list[ $r['id'] ] ): ?>
    
					<img src="<?=$controller->site_url ?>/images/uploads/thumbnails/<?=$controller->doctor_image_list[ $r['id'] ] ?>" style='border-radius: 10px;'/>
				    
				<? endif; ?>
        	</td>
        	<td><?=$r['fname'] ?> <?=$r['lname'] ?><?=$r['credentials']?(', ' . $r['credentials']):'' ?></td>
        	<td><?=$controller->office_list[ $r['office_id'] ] ?></td>
			<td><?=$controller->office_referrals_by_doctor[ $r['id'] ]?$controller->office_referrals_by_doctor[ $r['id'] ]:0 ?></td>
            <td>
            	<a href='#' class='update-favorites' data-attr='<?=$r['id'] ?>'>
	            	
	            	<? if( $controller->my_favorites[ $r['id'] ] ): ?>
	            	
	            		Remove from Favorites
	            		
	            	<? else: ?>
	            	
	            		Add to Favorites
	            		
	            	<? endif; ?>
	            	
            	</a><br>
            	<a href='/schedule_appointment?doctor=<?=$r['id'] ?>'>Schedule Appointment</a><br>
            	<a href='/referral?doctor=<?=$r['id'] ?>'>Refer Patient</a>
            </td>
        </tr>
        
        <? endforeach; ?>
        
    </tbody>

</table>

<? else: ?>

	<p>No doctors match your search.</p>
    
<? endif; ?>