<!-- BEGIN PAGE HEADER-->
<div class="row">
  <div class="col-md-6">
    <h3 class="page-title">
      Change Password
    </h3>
  </div>
</div>
<!-- END PAGE HEADER-->
@if(Session::has('success'))
	<div class="alert alert-success">
    	<button type="button" class="close" data-dismiss="alert">×</button>
    	<i class="fa fa-ban-circle"></i><strong>Success!</strong> {{Session::get('success')}}
  	</div>
@endif
@if(Session::has('failure'))
	<div class="alert alert-danger">
    	<button type="button" class="close" data-dismiss="alert">×</button>
    	<i class="fa fa-ban-circle"></i><strong>Failure!</strong> {{Session::get('failure')}}
  	</div>
@endif
<div class="row">
	<div class="col-md-12">
	  <div class="portlet box blue">
	    <div class="portlet-title"><div class="caption">Change Password</div></div>
	    <div class="portlet-body form">
	    	{{ Form::open(array('url' => 'change-password', 'method' => 'POST','role' => 'form')) }}
	    	<div class="form-body">
	    		<div class="row">
			        <div class="form-group col-md-6">
			          <label>Old Password<span class="required">*</span></label>
			          {{Form::password('old_p',["class"=>"form-control"])}}
			          <span class="error"><?php echo $errors->first('old_p',"Please enter old password"); ?></span>
			        </div>
		        </div>
		        <div class="row">
			        <div class="form-group col-md-6">
			          <label>New Password</label>
			          {{Form::password('new_p',["class"=>"form-control"])}}
			          <span class="error"><?php echo $errors->first('new_p',"Please enter new password (min 8 characters)"); ?></span>
			        </div>
			    </div>
		        <div class="row">
			        <div class="form-group col-md-6">
			          <label>Re-enter New Password</label>
			          {{Form::password('re_new_p',["class"=>"form-control"])}}
			          <span class="error"><?php echo $errors->first('re_new_p',"Please enter re-new password"); ?></span>
			        </div>
		        </div>
	      	
	      	</div>
	      	<div class="form-actions" style="clear:both">
            	<button type="submit" class="btn green col-md-3 ">Confirm</button>
         	</div>
         	{{ Form::close()}}
	    </div>
	  </div>
	</div>
</div>