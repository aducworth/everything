<!-- Main hero unit for a primary marketing message or call to action -->
<div class="hero-unit">
	<h1>Hello, <?=$_SESSION['logged_in_user']['fname'] ?> <?=$_SESSION['logged_in_user']['lname'] ?>!</h1>
</div>

<!-- Example row of columns -->
<div class="row">
<div class="span6">
  <h2>Recently Added Offices</h2>
  <? if( count( $controller->recently_added_offices ) ): ?>

        <table id='default-table' class="table table-striped table-condensed">
        
            <thead>
                <tr>
                    <th>Name</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            
            <tbody>
            
                <? foreach( $controller->recently_added_offices as $p ): ?>
                        
                <tr>
                    <td>
						<a href='/office?id=<?=$p['id'] ?>'>
							<?=$p['name'] ?>
                        </a>
                    </td>
                    <td>Added <?=date( 'm/d/y g:ia', strtotime( $p['created'] ) ) ?></td>
                </td>
                
                <? endforeach; ?>
                
            </tbody>
        
        </table>
        
	<? else: ?>
    
        <p>No offices have been added.</p>
        
    <? endif; ?>
</div>
<div class="span6">
  <h2>Recently Added Referrals</h2>
  <? if( count( $controller->recently_added_referrals ) ): ?>

        <table id='default-table' class="table table-striped table-condensed">
        
            <thead>
                <tr>
                    <th>Referred to</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            
            <tbody>
            
                <? foreach( $controller->recently_added_referrals as $p ): ?>
                        
                <tr>
                    <td>
						<a href='/referral?id=<?=$p['id'] ?>'>
							<?=$controller->doctor_list[ $p['referred_to'] ] ?>
                        </a>
                    </td>
                    <td>Added <?=date( 'm/d/y g:ia', strtotime( $p['modified'] ) ) ?></td>
                </td>
                
                <? endforeach; ?>
                
            </tbody>
        
        </table>
        
	<? else: ?>
    
        <p>No referrals have been added.</p>
        
    <? endif; ?>
</div>
</div>