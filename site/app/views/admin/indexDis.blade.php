<div class="row">
	<div class="col-md-12">
		<!--- agent form start -->
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				{{Session::get('success')}}
			</div>
		@endif
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					Add Distributor
				</div>
			</div>
			<div class="portlet-body form">
				<div class="form-body">
					{{Form::open(array("url"=>'admin/postDis',"method"=>'post',"class"=>'form-group',"files"=>'true'))}}
						<!--- my form start -->
							<div class="row">
								<div class="col-md-6">
									{{Form::label('Distributor Name')}}
									{{Form::text("name",'',["class"=>"form-control"])}}
									<span class="error">{{$errors->first('name')}}</span>									
								</div>
								<div class="col-md-6">
									{{Form::label('Distributor UserName')}}
									{{Form::text("agent_uname",'',["class"=>"form-control"])}}
									<span class="error">{{$errors->first('agent_uname')}}</span>									
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
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
<table class="table table-bordered table-hover tablesorter">
	<thead>
		<tr>
			<th>SN</th>
			<th>Name</th>
			<th>User Name</th>
			<th>Email</th>
			<th>Balance</th>
			<!-- <th>#</th> -->
			<th>History</th>
		</tr></thead>
	<tbody>
		<?php $count = 1; ?>
		@foreach($agents as $data)
		<tr>
			<td>{{$count++}}</td>
			<td>{{$data->name}}</td>
			<td>{{$data->username}}</td>
			<td>{{$data->email}}</td>
			<td>{{$data->balance}}</td>
			<!-- <td><a type="button" href="{{url('admin/agent/edit/'.$data->id)}}" class="btn yellow"><i class="fa fa-edit"></i></a><a type="button" href="{{url('admin/agent/delete/'.$data->id)}}" class="btn red"><i class="fa fa-remove"></i></a></td> -->
			<td><a type="button" href="{{url('admin/transferhistorydis/'.$data->id)}}" class="btn btn-block yellow" target="_blank">Transfer</a></td>
		</tr>
		@endforeach
	</tbody>
</table>
