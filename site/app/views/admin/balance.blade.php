<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Admin</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
{{HTML::style("assets/global/plugins/font-awesome/css/font-awesome.min.css")}}
{{HTML::style("assets/global/plugins/bootstrap/css/bootstrap.min.css")}}
{{HTML::style("assets/global/plugins/bootstrap-datepicker/css/datepicker3.css")}}
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN THEME STYLES -->
{{HTML::style("assets/global/css/components.css")}}
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->

<body>
  <div class="logo text-center" style="background: #000; text-align: center; padding: 10px">
    <img src="{{url('assets/admin/img/logo_dev.png')}}" style="width: 200px; height: auto">
  </div>

	<div class="content">
	 <div style="padding: 10px;">
	 	<div class="container">
	 		<div class="col-md-6 col-md-offset-3">
	 			<div class="row">
	 				{{Form::open(array("url"=>"/check-balance-main","method"=>"get"))}}
	 				<input type="hidden" name="uid" value="{{$user_id}}">
	 				<div class="col-md-4">
	 					<input type="text" class="form-control datepicker" name="start_date" placeholder="Start Date" value="{{$start_date}}" autocomplete="off" required />
	 				</div>
	 				<div class="col-md-4">
	 					<input type="text" class="form-control datepicker" name="end_date" placeholder="End Date" value="{{$end_date}}" autocomplete="off"  />
	 				</div>
	 				<div class="col-md-4">
	 					<input type="submit" class="btn btn-block blue" value="Submit" />
	 				</div>
	 				{{Form::close()}}
	 			</div>
	 		</div>
	 	</div>
	 </div>
	</div>
	<div style="padding: 10px;">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>SN</th>
					<th>Number</th>
					<th>Game Number</th>
					<th>Bet</th>
					<th>Number</th>
					<th>Total Amount</th>
					<th>Final Amount</th>
					<th>Scanned</th>
					<th>Cancelled</th>
					<th>Date</th>
				</tr>
			</thead>
			<?php $count = 1; ?>
			<?php $total_amount = 0;?>
			<?php $final_amount = 0;?>
			<?php $scanned_total = 0;?>
			<?php $scanned_final = 0;?>
			<tbody>
				@foreach($transactions as $transaction)
					<tr>
						<td>{{$count++}}</td>
						<td>{{$transaction->id}}</td>
						<td>{{$transaction->game_id}}</td>
						<td>{{str_replace("|","| ",$transaction->bet_string)}}</td>
						<td>{{$transaction->number1.$transaction->number2}}</td>
						<td>{{$transaction->total_amount*10}}</td>
						<td>{{$transaction->final_amount*10}}</td>
						<td>{{($transaction->scanned == 1)?"Yes":"No"}}</td>
						<td>{{($transaction->cancelled == 1)?"Yes":""}}</td>
						<td>{{date("d-m-Y h:i A",strtotime($transaction->created_timestamp)+5.5*3600)}}</td>
					</tr>
					@if($transaction->cancelled == 0)
						<?php 
							$total_amount += $transaction->total_amount;
							$final_amount += $transaction->final_amount;
						?>
						@if($transaction->scanned == 1)
							<?php 
								$scanned_total += $transaction->total_amount;
								$scanned_final += $transaction->final_amount;
							?>
						@endif
					@endif
				@endforeach
				<tr>
					<td colspan="5" style="text-align: right;">Total</td>
					<td>{{$total_amount*10}}</td>
					<td>{{$final_amount*10}}</td>
					<td colspan="2"></td>
				</tr>
				
				<tr>
					<td colspan="5" style="text-align: right;">Total Profit Loss</td>
					<td colspan="2" style="text-align: center;"><b>{{ ($total_amount - $final_amount)*10 }}</b></td>
					<td colspan="2"></td>
				</tr>

				<tr>
					<td colspan="5" style="text-align: right;">Scanned</td>
					<td>{{$scanned_total*10}}</td>
					<td>{{$scanned_final*10}}</td>
					<td colspan="2"></td>
				</tr>

				<tr>
					<td colspan="5" style="text-align: right;">Scanned Profit Loss</td>
					<td colspan="2" style="text-align: center;"><b>{{ ($scanned_total - $scanned_final)*10 }}</b></td>
					<td colspan="2"></td>
				</tr>
			</tbody>
			
		</table>
	</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../assets/global/plugins/respond.min.js"></script>
<script src="../../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
{{HTML::script("assets/global/plugins/jquery.min.js")}}
{{HTML::script("assets/global/plugins/jquery-migrate.min.js")}}
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
{{HTML::script("assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js")}}
{{HTML::script("assets/global/plugins/bootstrap/js/bootstrap.min.js")}}
{{HTML::script("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js")}}
{{HTML::script("assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js")}}
<!-- END CORE PLUGINS -->
{{HTML::script("assets/global/scripts/metronic.js")}}
{{HTML::script("assets/admin/scripts/jquery.tablesorter.js")}}
{{HTML::script("assets/admin/scripts/jquery.tablesorter.pager.js")}}
{{HTML::script("assets/admin/scripts/jquery.tablesorter.widgets.js")}}
{{HTML::script("assets/admin/scripts/custom.js")}}
<script>
jQuery(document).ready(function() {   
   // initiate layout and plugins
  Metronic.init(); // init metronic core components
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>