<h1>Companies</h1>

<div style='padding: 10px 0px 10px 0px; width: 80%'>

	<a href='/company'>Add Company</a>

</div>

<? if( count( $controller->companies ) ): ?>

<table id='default-table' class="table table-striped table-condensed">

	<thead>
    	<tr>
        	<th>Name</th>
        	<th>City / State</th>
        	<th>Users</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    
    <tbody>
    
    	<? foreach( $controller->companies as $r ): ?>
                
        <tr>
        	<td><?=$r['name'] ?></td>
        	<td><?=$r['city'] ?>, <?=$r['state'] ?></td>
        	<td><?=$controller->company_user_count[ $r['id'] ]?$controller->company_user_count[ $r['id'] ]:0 ?></td>
            <td><a href='/company?id=<?=$r['id'] ?>'>edit</a> - <a href='/delete?id=<?=$r['id'] ?>&model=companies' onclick="return confirm( 'Are you sure?' )">delete</a></td>
        </tr>
        
        <? endforeach; ?>
        
    </tbody>

</table>

<? else: ?>

	<p>No companies are in the system.</p>
    
<? endif; ?>