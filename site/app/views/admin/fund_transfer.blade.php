<div class="row">
	<div class="col-md-12">
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				{{Session::get('success')}}
			</div>
		@endif
		@if(Session::has('failure'))
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				{{Session::get('failure')}}
			</div>
		@endif
		<!--- student form start -->
		@if(Auth::user()->priv == 1)
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					Fund Transfer @if(Auth::user()->priv==1) Distributors @endif
				</div>
			</div>
			<div class="portlet-body form">
				<div class="form-body">
					{{Form::open(array("url"=>'transferMoney',"method"=>'post',"class"=>'form-group',"files"=>'true'))}}
						<!--- my form start -->
							<div class="row">
								
								<div class="col-md-3">
									{{Form::label('Select Payee')}}
									{{Form::select("payee",$pay_to,'',["class"=>"form-control","required"=>""])}}
									<span class="error">{{$errors->first('payee')}}</span>									
								</div>
								
								<div class="col-md-3">
									{{Form::label('Amount')}}
									{{Form::text("amount",'',["class"=>"form-control","required"=>""])}}
									<span class="error">{{$errors->first('amount2')}}</span>									
								</div>
								<div class="col-md-6">
									{{Form::label('Remark')}}
									{{Form::text("remark",'',["class"=>"form-control"])}}
									<span class="error">{{$errors->first('remark2')}}</span>									
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
		@endif

		@if(Auth::user()->priv != 1)
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					Fund Transfer Current Balance Point. {{Auth::user()->balance}}
				</div>
			</div>
			<div class="portlet-body form">
				<div class="form-body">
					{{Form::open(array("url"=>'transferMoney',"method"=>'post',"class"=>'form-group',"files"=>'true'))}}
						<!--- my form start -->
							<div class="row">
								<div class="col-md-6">
									{{Form::label('Select Payee')}}
									{{Form::select("payee",$pay_to,'',["id"=>"payee","class"=>"form-control"])}}
									<span class="error">{{$errors->first('payee')}}</span>									
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
		@endif

		@if(Auth::user()->priv != 1)
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					Withdraw Money: Current Balance Point. {{Auth::user()->balance}}
				</div>
			</div>
			<div class="portlet-body form">
				<div class="form-body">
					{{Form::open(array("url"=>'withdrawMoney',"method"=>'post',"class"=>'form-group',"files"=>'true'))}}
						<!--- my form start -->
							<div class="row">
								<div class="col-md-6">
									{{Form::label('Amount')}}
									{{Form::text("amount",'',["class"=>"form-control"])}}
									<span class="error">{{$errors->first('amount2')}}</span>									
								</div>
								<div class="col-md-6">
									{{Form::label('Remark')}}
									{{Form::text("remark",'',["class"=>"form-control"])}}
									<span class="error">{{$errors->first('remark2')}}</span>									
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
		@endif

		@if(Auth::user()->priv == 1)
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						Fund Transfer Current Balance Point. {{Auth::user()->balance}}
					</div>
				</div>
				<div class="portlet-body form">
					<div class="form-body">
						{{Form::open(array("url"=>'transferMoneyAgent',"method"=>'post',"class"=>'form-group',"files"=>'true'))}}
							<!--- my form start -->
								<div class="row">
									<div class="col-md-6">
										{{Form::label('Select Payee')}}
										{{Form::select("payee",$pay_to_agent,'',["id"=>"payee","class"=>"form-control"])}}
										<span class="error">{{$errors->first('payee')}}</span>									
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
		@endif

	</div>
</div>