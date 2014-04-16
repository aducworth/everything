<h1>Time Sheet</h1>

<div style='padding: 10px 0px 10px 0px; width: 80%'>

	<a href='/time_entry'>Add Entry</a>

</div>

<? if( count( $controller->time_entries ) ): ?>

<table id='default-table' class="table table-striped table-condensed">

	<thead>
    	<tr>
        	<th>Project</th>
        	<th>Task</th>
        	<th>Hours</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    
    <tbody>
    
    	<? $total = 0; ?>
    
    	<? foreach( $controller->time_entries as $r ): ?>
                
	        <tr>
	        	<td><?=$controller->project_list[ $r['project'] ]?$controller->project_list[ $r['project'] ]:'Not Specified' ?></td>
	        	<td><?=$controller->task_list[ $r['task'] ]?$controller->task_list[ $r['task'] ]:'Not Specified' ?></td>
	        	<td><?=$functions->formatTime( $r['minutes'] ) ?></td>
	            <td><a href='/time_entry?id=<?=$r['id'] ?>'>edit</a> - <a href='/delete?id=<?=$r['id'] ?>&model=time_entries' onclick="return confirm( 'Are you sure?' )">delete</a></td>
	        </tr>
	        
	        <? $total += $r['minutes']; ?>
        
        <? endforeach; ?>
        
        <tr>
        	<td>Total</td>
        	<td>&nbsp;</td>
        	<td><?=$functions->formatTime( $total ) ?></td>
            <td>&nbsp;</td>
        </tr>
        
    </tbody>

</table>

<? else: ?>

	<p>No time entries are in the system.</p>
    
<? endif; ?>