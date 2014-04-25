<h1>Time Sheet</h1>

<? if( $_GET['timescope'] == 'weekly' ): ?>

	<h2>
		<a href='/timesheet?timescope=weekly&action=previous&current=<?=$_GET['current'] ?>' class='glyphicon glyphicon-chevron-left'></a>
		<?=date( ' D, F, d Y', strtotime( $controller->start_day ) ) ?> - <?=date( ' D, F, d Y', strtotime( $controller->end_day ) ) ?>
		<a href='/timesheet?timescope=weekly&action=next&current=<?=$_GET['current'] ?>' class='glyphicon glyphicon-chevron-right'></a>
	</h2>
	
	<div style='padding: 10px 0px 10px 0px; width: 80%'>
	
		<a href='/time_entry' class='btn btn-primary'>Add Entry</a>
		
		<a href='/timesheet?timescope=daily' class='btn btn-primary'>View Daily</a>
	
	</div>
	
	<? if( count( $controller->task_results ) ): ?>
	
	<table id='default-table' class="table table-striped table-condensed">
	
		<thead>
	    	<tr>
	        	<th>Project</th>
	        	<th>Task</th>
	        	
	        	<? $totals = array(); ?>
	        	
	        	<? $current_day = $controller->start_day; ?>
			
				<? for( $i=1; $i<8; $i++ ): ?>
				
					<? $current_time = strtotime( $current_day ); ?>
					
					<th><?=date( 'D', $current_time ) ?><br><?=date( 'd M', $current_time ) ?></th>
					
					<? $totals[ $current_day ] = 0; ?>
				
					<? $current_day = date( 'Y-m-d', strtotime( '+1 day', strtotime( $current_day ) ) ); ?>
				
				<? endfor; ?>

	        </tr>
	    </thead>
	    
	    <tbody>
	    
	    	<? foreach( $controller->task_results as $r ): ?>
	                
		        <tr>
		        	<td><?=$controller->project_list[ $r['project'] ]?$controller->project_list[ $r['project'] ]:'Not Specified' ?></td>
		        	<td><?=$controller->task_list[ $r['task'] ]?$controller->task_list[ $r['task'] ]:'Not Specified' ?></td>
		        	
		        	<? $current_day = $controller->start_day; ?>
			
					<? for( $i=1; $i<8; $i++ ): ?>
					
						<? $current_time = strtotime( $current_day ); ?>
						
						<td><?=$functions->formatTime( $controller->results[ $current_day ][ $r['project'] ][ $r['task'] ]?$controller->results[ $current_day ][ $r['project'] ][ $r['task'] ]:0 ) ?></td>
						
						<? $totals[ $current_day ] += ($controller->results[ $current_day ][ $r['project'] ][ $r['task'] ]?$controller->results[ $current_day ][ $r['project'] ][ $r['task'] ]:0); ?>
					
						<? $current_day = date( 'Y-m-d', strtotime( '+1 day', strtotime( $current_day ) ) ); ?>
					
					<? endfor; ?>
		        </tr>
		        
		        <? $total += $r['minutes']; ?>
	        
	        <? endforeach; ?>
	        
	        <tr>
	        	<td>Total</td>
	        	<td>&nbsp;</td>
	        	
	        	<? $current_day = $controller->start_day; ?>
			
				<? for( $i=1; $i<8; $i++ ): ?>
				
					<? $current_time = strtotime( $current_day ); ?>
					
					<td><?=$functions->formatTime( $totals[ $current_day ] ) ?></td>
					
					<? $current_day = date( 'Y-m-d', strtotime( '+1 day', strtotime( $current_day ) ) ); ?>
				
				<? endfor; ?>
	        </tr>
	        
	    </tbody>
	
	</table>
	
	<? else: ?>
	
		<p>No time entries are in the system.</p>
	    
	<? endif; ?>

<? else: ?>

	<h2>
		<a href='/timesheet?timescope=daily&action=previous&current=<?=$_GET['current'] ?>' class='glyphicon glyphicon-chevron-left'></a>
		<?=date( ' D, F, d Y', strtotime( $_GET['current'] ) ) ?>
		<a href='/timesheet?timescope=daily&action=next&current=<?=$_GET['current'] ?>' class='glyphicon glyphicon-chevron-right'></a>
	</h2>
	
	<div style='padding: 10px 0px 10px 0px; width: 80%'>
	
		<a href='/time_entry' class='btn btn-primary'>Add Entry</a>
		
		<a href='/timesheet?timescope=weekly' class='btn btn-primary'>View Weekly</a>
	
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
	
<? endif; ?>