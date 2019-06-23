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
	<h1>Your Balance {{$balance}}</h1>
</div>
<?php $adebit = 0; $acredit = 0; $udebit = 0; $ucredit = 0; ?>
<h3>Transaction History</h3>
<div style="overflow-x:auto">
<table class="table table-bordered table-hover tablesorter">
	<thead>
		<tr>
			<th style="width:50px">SN</th>
			<th>Time</th>
			<th>Given By</th>
			<th>Given</th>
			<th>Withdrawal</th>
			<th>User Name</th>
			<th>User Given</th>
			<th>User Withdrawal</th>
			<th>Remark</th>
		</tr>
	</thead>
	<tbody>
		<?php $count = 1; ?>
		@foreach($transactions as $data)
		<tr>
			<td>{{$count++}}</td>
			@if($data->admin_id == 0 && $data->distributor_id == 0 && $data->credit_debit == 1 )
			<td>{{date('H:i:s d-M-Y', (strtotime($data->updated_at)+5.5*60*60))}}</td>
			@else
			<td>{{date('H:i:s d-M-Y', strtotime($data->updated_at))}}</td>
			@endif
			<td>
				@if($data->user_id == 0)
					@if($data->distributor_id == 0)
						Admin
					@else
						{{(isset($data->distributor_id))?$distributors[$data->distributor_id]:''}}
					@endif
				@endif
			</td>
			<td>@if(($data->admin_id != 0 || $data->distributor_id != 0) && $data->credit_debit == 0 ){{$data->amount}} <?php $adebit += $data->amount; ?>  @endif</td>
			<td>@if(($data->admin_id != 0 || $data->distributor_id != 0) && $data->credit_debit == 1 ){{$data->amount}} <?php $acredit += $data->amount; ?> @endif</td>
			<td>@if($data->user_id != 0){{$data->name}}@endif</td>
			<td>@if(($data->admin_id == 0 && $data->distributor_id == 0) && $data->credit_debit == 0 ){{$data->amount}} <?php $udebit += $data->amount; ?>@endif</td>
			<td>@if(($data->admin_id == 0 && $data->distributor_id == 0) && $data->credit_debit == 1 ){{$data->amount}} <?php $ucredit += $data->amount; ?>@endif</td>
			<td>{{$data->remark}}</td>
		</tr>
		@endforeach
		<tr>
			<td>Total</td>
			<td></td>
			<td></td>
			<td>{{$adebit}}</td>
			<td>{{$acredit}}</td>
			<td></td>
			<td>{{$udebit}}</td>
			<td>{{$ucredit}}</td>
			<td></td>
		</tr>
	</tbody>
</table>
</div>