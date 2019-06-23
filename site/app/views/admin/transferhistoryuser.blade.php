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
	<h1>User: {{$user->name}}</h1>
</div>
<h3>Transaction History</h3>
<?php $debit=0;$credit = 0; ?>
<table class="table table-bordered table-hover tablesorter">
	<thead>
		<tr>
			<th style="width:50px">SN</th>
			<th>Time</th>
			<th>Agent Name</th>
			<th>Amount Given</th>
			<th>Amount Received</th>
			<th>Remark</th>
		</tr></thead>
	<tbody>
		<?php $count = 1; ?>
		@foreach($transactions as $data)
		<tr>
			<td>{{$count++}}</td>
			@if($data->credit_debit == 1 )
			<td>{{date('H:i:s d-M-Y', (strtotime($data->updated_at)+5.5*60*60))}}</td>
			@else
			<td>{{date('H:i:s d-M-Y', strtotime($data->updated_at))}}</td>
			@endif
			<td>{{$data->name}}</td>
			<td>@if($data->credit_debit == 0){{$data->amount}}@endif</td>
			<td>@if($data->credit_debit == 1){{$data->amount}}@endif</td>
			<td>{{$data->remark}}</td>
		</tr>
		<?php
			if($data->credit_debit == 0) $debit += $data->amount;
			else if($data->credit_debit == 1) $credit += $data->amount;
		?>
		@endforeach
		<tr>
			<td>Total</td>
			<td></td>
			<td></td>
			<td>{{$debit}}</td>
			<td>{{$credit}}</td>
			<td></td>
		</tr>
	</tbody>
</table>
