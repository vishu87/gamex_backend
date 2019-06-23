
<div class="row">
	<div class="col-md-12">
		<!--- student form start -->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					Edit Agent
				</div>
			</div>
			<div class="portlet-body form">
				<div class="form-body">
					{{Form::open(array("url"=>'admin/agent/update/'.$agent->id,"method"=>'post',"class"=>'form-group',"files"=>'true'))}}
						<!--- my form start -->
							<div class="row">
								<div class="col-md-6">
									{{Form::label('Agent Name')}}
									{{Form::text("name",$agent->name,["class"=>"form-control"])}}
									<span class="error">{{$errors->first('name')}}</span>									
								</div>

							</div>
							<div class="row">
								<div class="col-md-6">
									{{Form::label('Email')}}
									{{Form::text("email",$agent->email,["class"=>"form-control"])}}
									<span class="error">{{$errors->first('email')}}</span>	
									@if(Session::has('failure'))
										<span class="error">{{Session::get('failure')}}</span>
									@endif								
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
