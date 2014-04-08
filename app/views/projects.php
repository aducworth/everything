<h1>Projects</h1>

<div style='padding: 10px 0px 10px 0px; width: 80%'>

	<a href='/project'>Add Project</a>

</div>

<? if( count( $controller->projects ) ): ?>

<table id='default-table' class="table table-striped table-condensed">

	<thead>
    	<tr>
        	<th>Name</th>
        	<th>Company</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    
    <tbody>
    
    	<? foreach( $controller->projects as $r ): ?>
                
        <tr>
        	<td><?=$r['name'] ?></td>
        	<td><?=$controller->company_list[ $r['company'] ] ?></td>
            <td><a href='/project?id=<?=$r['id'] ?>'>edit</a> - <a href='/delete?id=<?=$r['id'] ?>&model=projects' onclick="return confirm( 'Are you sure?' )">delete</a></td>
        </tr>
        
        <? endforeach; ?>
        
    </tbody>

</table>

<? else: ?>

	<p>No projects are in the system.</p>
    
<? endif; ?>