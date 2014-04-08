<h1>Referrals</h1>

<div style='padding: 10px 0px 10px 0px; width: 80%'>

	<a href='/referral'>Add Referral</a>

</div>

<? if( count( $controller->referrals ) ): ?>

<table id='default-table' class="table table-condensed">

	<thead>
    	<tr>
    		<th>Status</th>
            <th>Patient</th>
            <th>Referred By</th>
            <th>Referred To</th>
            <th>Appointment</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    
    <tbody>
    
    	<? foreach( $controller->referrals as $r ): ?>
                
        <tr>
        	<td class='status-<?=$r['referral_status'] ?>'><?=$controller->referral_statuses[ $r['referral_status'] ] ?></td>
            <td class='status-<?=$r['referral_status'] ?>'><?=$r['patient_name'] ?></td>
            <td class='status-<?=$r['referral_status'] ?>'><?=$controller->doctor_list[ $r['referred_by'] ] ?></td>
            <td class='status-<?=$r['referral_status'] ?>'><?=$controller->doctor_list[ $r['referred_to'] ] ?></td>
            <td class='status-<?=$r['referral_status'] ?>'><?=date( 'm/d/Y g:ia', strtotime( $r['appointment'] ) ) ?></td>
            <td class='status-<?=$r['referral_status'] ?>'><a href='/referral?id=<?=$r['id'] ?>'>edit</a> - <a href='/delete?id=<?=$r['id'] ?>&model=referrals' onclick="return confirm( 'Are you sure?' )">delete</a></td>
        </tr>
        
        <? endforeach; ?>
        
    </tbody>

</table>

<? else: ?>

	<p>No referrals are in the system.</p>
    
<? endif; ?>