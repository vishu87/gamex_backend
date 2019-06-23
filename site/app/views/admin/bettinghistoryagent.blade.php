<div class="row">
	<div class="col-md-12">
		<!--- student form start -->
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				{{Session::get('success')}}
			</div>
		@endif
		
	</div>
</div>
<div style="text-align:center">
	<h1>Agent: {{$agent->name}}</h1>
</div>
<h3>Betting History</h3>
<?php $bet_amount=0; $final_amount = 0; $profit_loss = 0; ?>

<table class="table table-bordered table-hover tablesorter">
	<thead>
		<tr>
			<th style="width:50px">SN</th>
			<th>User Name</th>
			<th>Time</th>
			<th>Game ID</th>
			<th>Bet Amount</th>
			<th>Final Amount</th>
			<th>Profit/Loss</th>
		</tr></thead>
	<tbody>
		<?php $count = 1; ?>
		@foreach($betting as $data)
		<tr>
			<td>{{$count++}}</td>
			<td>{{$data->name}}</td>
			<td>{{date('H:i:s d-M-Y', strtotime($data->created_timestamp))}}</td>
			<td>{{$data->game_id}}</td>
			<td>{{$data->bet_amount}}</td>
			<td>{{$data->final_amount}}</td>
			<td>{{$data->profit_loss}}</td>
		</tr>
		<?php $profit_loss += $data->profit_loss; $bet_amount += $data->bet_amount; $final_amount += $data->final_amount  ?>

		@endforeach
		<tr>
			<td>Total</td>
			<td></td>
			<td></td>
			<td></td>
			<td>{{$bet_amount}}</td>
			<td>{{$final_amount}}</td>
			<td>{{$profit_loss}}</td>
		</tr>
	</tbody>
</table>
