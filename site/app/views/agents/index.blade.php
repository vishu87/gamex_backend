<div class="row">
	<div class="col-md-12">
		<!--- student form start -->
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				{{Session::get('success')}}
			</div>
		@endif
		
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					Add User
				</div>
			</div>
			<div class="portlet-body form">
				<div class="form-body">
					{{Form::open(array("url"=>'agents/addUser',"method"=>'post',"class"=>'form-group',"files"=>'true'))}}
						<!--- my form start -->
							<div class="row">
								<div class="col-md-6">
									{{Form::label('Name')}}
									{{Form::text("name",'',["class"=>"form-control"])}}
									<span class="error">{{$errors->first('name')}}</span>									
								</div>
								<div class="col-md-6">
									{{Form::label('UserName')}}
									{{Form::text("username",'',["class"=>"form-control"])}}
									<span class="error">{{$errors->first('username')}}</span>									
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									{{Form::label('Agent')}}
									{{Form::select("agent",$agents,'',["class"=>"form-control"])}}
									<span class="error">{{$errors->first('agent')}}</span>									
								</div>
								<div class="col-md-3">
									{{Form::label('Email')}}
									{{Form::text("email",'',["class"=>"form-control"])}}
									<span class="error">{{$errors->first('email')}}</span>									
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
		
	</div>
</div>
<div style="overflow-x: auto">
	<table class="table table-bordered table-hover tablesorter">
		<thead>
			<tr>
				<th>SN</th>
				<th>User Name</th>
				<th>Balance</th>
				<th>#</th>
				

			</tr></thead>
		<tbody>
			<?php $count = 1; ?>
			@foreach($users as $data)
			<tr>
				<td>{{$count++}}</td>
				<td>{{$data->user_name}}</td>
				<td>{{$data->balance}}</td>
				<td>	
					<a type="button" href="{{url('admin/transferhistoryuser/'.$data->id)}}" class="btn btn-block yellow" target="_blank">Transfer History</a>
					
					<a type="button" href="{{url('admin/bettinghistoryuser/'.$data->id)}}" class="btn btn-block blue" target="_blank">Gaming</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
