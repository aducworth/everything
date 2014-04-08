<h1>Doctors</h1>

<div style='padding: 10px 0px 10px 0px; width: 80%'>

	<a href='/doctor'>Add Doctors</a>

</div>

<? if( count( $controller->doctors ) ): ?>

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
    
    	<? foreach( $controller->doctors as $r ): ?>
                
        <tr>
        	<td>
        		<? if( $r['image'] ): ?>
    
					<img src="<?=$controller->site_url ?>/images/uploads/thumbnails/<?=$r['image'] ?>" style='border-radius: 10px;'/>
				    
				<? endif; ?>
        	</td>
        	<td><?=$r['fname'] ?> <?=$r['lname'] ?><?=$r['credentials']?(', ' . $r['credentials']):'' ?></td>
        	<td><?=$controller->office_list[ $r['office_id'] ] ?></td>
			<td><?=$controller->referrals_by_doctor[ $r['id'] ]?$controller->referrals_by_doctor[ $r['id'] ]:0 ?></td>
            <td><a href='/doctor?id=<?=$r['id'] ?>'>edit</a> - <a href='/delete?id=<?=$r['id'] ?>&model=doctors' onclick="return confirm( 'Are you sure?' )">delete</a></td>
        </tr>
        
        <? endforeach; ?>
        
    </tbody>

</table>

<? else: ?>

	<p>No doctors are in the system.</p>
    
<? endif; ?>