<?php $this->load->view('partials/header');?>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
				<h3>Query Answers</h3>
				
				<?php if(count($queries)):?>
					<table class="table table-striped">
					  <tr>
					  	<th>Sno.</th>
					  	<th>Question</th>
					  	<th>Answer</th>
					  </tr>
						<?php foreach($queries as $key =>  $query): 
										if(empty($query->answer))
											continue;
						?>	  
					  <tr>
					  	<td width="5%"><?=++$key?></td>
					  	<td width="50%"><?=$query->question?></td>
					  	<td><?=$query->answer?></td>
					  </tr>
						<?php endforeach; ?>  
					</table>
					<?php else: ?>  
							<h3 class="text-center">No Queries Found.</h3>
				<?php endif;?>

		</div>
	</div>
</div>
<?php $this->load->view('partials/footer');?>