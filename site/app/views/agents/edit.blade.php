
<div class="row">
	<div class="col-md-12">
		<!--- student form start -->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					Edit User
				</div>
			</div>
			<div class="portlet-body form">
				<div class="form-body">
					{{Form::open(array("url"=>'agents/update_user/'.$users->id,"method"=>'post',"class"=>'form-group',"files"=>'true'))}}
						<!--- my form start -->
							<div class="row">
								<div class="col-md-6">
									{{Form::label('User Name')}}
									{{Form::text("name",$users->name,["class"=>"form-control"])}}
									<span class="error">{{$errors->first('name')}}</span>									
								</div>

							</div>
							<div class="row">
								<div class="col-md-6">
									{{Form::label('Email')}}
									{{Form::text("email",$users->email,["class"=>"form-control"])}}
									<span class="error">{{$errors->first('email')}}</span>	
									@if(Session::has('failure'))
										<span class="error">{{Session::get('failure')}}</span>
									@endif								
								</div>
								<div class="col-md-6">
									{{Form::label('Status')}}
									{{Form::select("status",array("0"=>"Block","1"=>"Active"),$users->status,["class"=>"form-control"])}}
									<span class="error">{{$errors->first('status')}}</span>	
																
								</div>
							</div>
						<!---my form end-->
				</div>
				<div class="form-actions">
					<button type="submit" class="btn blue">Update</button>
				</div>
					{{Form::close()}}
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<!--- student form start -->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					Edit Password
				</div>
			</div>
			<div class="portlet-body form">
				<div class="form-body">
					{{Form::open(array("url"=>'agents/update_user/password/'.$users->id,"method"=>'post',"class"=>'form-group',"files"=>'true'))}}
						<!--- my form start -->
							<div class="row">
								<div class="col-md-6">
									{{Form::label('Password')}}
									{{Form::text("password",'',["class"=>"form-control"])}}
									<span class="error">{{$errors->first('password')}}</span>									
								</div>

							</div>
						<!---my form end-->
				</div>
				<div class="form-actions">
					<button type="submit" class="btn blue">Update</button>
				</div>
					{{Form::close()}}
			</div>
		</div>
	</div>
</div>