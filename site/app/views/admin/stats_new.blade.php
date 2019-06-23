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
</div>
<h3>Profit Loss History</h3>
<div style="margin:20px 0">
<form autocomplete="off">
Start Date <input type="text" class="datepicker" name="start_date" autocomplete="off">
End Date <input type="text" class="datepicker" name="end_date" autocomplete="off">
<input class="btn blue" value="Submit" type="submit">
</form>
<div>
<h1>{{(Input::has('start_date'))?Input::get('start_date'):'' }} to {{(Input::has('end_date'))?Input::get('end_date'):'' }}</h1>
</div>
</div>
<?php $t_amount = 0; $f_amount = 0; ?>
<div style="margin-bottom:50px">
	<table class="table table-bordered table-hover tablesorter">
			<thead>
				<tr>
					<th style="width:50px">SN</th>
					<th>Agent Name</th>
					<th>Profit</th>
					<th>Commission</th>
				</tr></thead>
			<tbody>
				<?php $count = 1; $profit = 0; ?>
					@foreach($p_loss as $data)
					<tr>
						<td>{{$count++}}</td>
						<td>{{$data->user_name}}</td>
						<td>{{$data->total_amount*10}}</td>
						<td>{{$data->final_amount*10}}</td>
					</tr>
					<?php
						$t_amount += $data->total_amount*10;
						$f_amount += $data->final_amount*10;
					?>
					@endforeach
				<tr>
					<td></td>
					<td>Total</td>
					<td>{{$t_amount}}</td>
					<td>{{$f_amount}}</td>
				</tr>
			</tbody>
		</table>
</div>
