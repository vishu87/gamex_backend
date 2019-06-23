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
<form>
Start Date <input type="text" class="datepicker" name="start_date">
End Date <input type="text" class="datepicker" name="end_date">
<input class="btn blue" value="Submit" type="submit">
</form>
<div>
<h1>{{(Input::has('start_date'))?Input::get('start_date'):'' }} - {{(Input::has('end_date'))?Input::get('end_date'):'' }}</h1>
</div>
</div>
<?php $profit = 0; ?>
<div style="margin-bottom:50px">
	@foreach($distributors as $dis_id => $dis_name)
		<h3>Distributor - {{$dis_name}}</h3>
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
				@if(isset($data_dis[$dis_id]))
					@foreach($data_dis[$dis_id] as $data)
					<tr>
						<td>{{$count++}}</td>
						<td>{{$data["name"]}}</td>
						<td>{{($data["profit_loss"]*-1)}}</td>
						<td>{{($data["profit_loss"]*-1)*0.6}}</td>
					</tr>
					<?php
						$profit = $profit - $data["profit_loss"];
					?>
					@endforeach
				@endif
				<tr>
					<td></td>
					<td>Total</td>
					<td>{{$profit}}</td>
					<td>{{$profit*0.1}}</td>
				</tr>
			</tbody>
		</table>
	@endforeach
</div>

<table class="table table-bordered table-hover tablesorter" style="display:none">
	<thead>
		<tr>
			<th style="width:50px">SN</th>
			<th>Agent Name</th>
			<th>Profit</th>
		</tr></thead>
	<tbody>
		<?php $count = 1; ?>
		@foreach($p_loss as $data)
		<tr>
			<td>{{$count++}}</td>
			<td>{{$data->name}}</td>
			<td>{{($data->profit_loss*-1)}}</td>
		</tr>
		<?php
			$profit = $profit - $data->profit_loss;
		?>
		@endforeach
		<tr>
			<td></td>
			<td>Total</td>
			<td>{{$profit}}</td>
		</tr>
	</tbody>
</table>


<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					Transaction Window
				</div>
			</div>
			<div class="portlet-body form">
				<div class="form-body">
					{{Form::open(array("url"=>'admin/makepayment',"method"=>'post',"class"=>'form-group'))}}
						<!--- my form start -->
							<div class="row">
								<div class="col-md-6">
									{{Form::label('Agent')}}
									{{Form::select("agent_id",$agents,'',["id"=>"","class"=>"form-control"])}}
									<span class="error">{{$errors->first('agent_id')}}</span>									
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									{{Form::label('Amount')}}
									{{Form::text("amount",'',["class"=>"form-control"])}}
									<span class="error">{{$errors->first('amount')}}</span>									
								</div>
								<div class="col-md-6">
									{{Form::label('Remark')}}
									{{Form::text("remark",'',["class"=>"form-control"])}}
									<span class="error">{{$errors->first('remark')}}</span>									
								</div>
							</div>
						<!---my form end-->
				</div>
				<div class="form-actions">
					<button type="submit" class="btn blue">Add</button>
				</div>
					{{Form::close()}}
			</div>
		</div>


<h3>Transfer History</h3>
<?php $profit = 0; ?>
<table class="table table-bordered table-hover tablesorter">
	<thead>
		<tr>
			<th style="width:50px">SN</th>
			<th>Agent Name</th>
			<th>Amount</th>
			<th>Remark</th>
			<th>Date</th>
		</tr></thead>
	<tbody>
		<?php $count = 1; ?>
		@foreach($given as $data)
		<tr>
			<td>{{$count++}}</td>
			<td>{{$data->name}}</td>
			<td>{{$data->amount}}</td>
			<td>{{($data->remark)}}</td>
			<td>{{($data->timestamp)}}</td>
		</tr>
		<?php
			$profit = $profit + $data->amount;
		?>
		@endforeach
		<tr>
			<td></td>
			<td>Total</td>
			<td>{{$profit}}</td>
			<td></td>
			<td></td>

		</tr>
	</tbody>
</table>
