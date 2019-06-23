<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>DevShree</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
{{HTML::style("http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all")}}
{{HTML::style("assets/global/plugins/font-awesome/css/font-awesome.min.css")}}
{{HTML::style("assets/global/plugins/bootstrap/css/bootstrap.min.css")}}
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN THEME STYLES -->
{{HTML::style("assets/global/css/components.css")}}
{{HTML::style("assets/admin/css/login-soft.css?v=1.0.2")}}
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->

<body class="login">
  <div class="logo">
    <img src="{{url('assets/admin/img/logo_dev.png')}}" style="width: 300px; height: auto">
    <br><br>
    <a style="display: inline-block; background: rgba(0,0,0,0.5); padding: 10px 100px; color: #fff" href="http://devshree.live:3000">Login</a>
  </div>

  <div class="container draw" >
    <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <h1 style="color: #FFF; text-align: center;">Draw Results</h1>
        <table class="table table-bordered">
          @foreach($dates as $date => $numbers)
          <tr>
            <td>
              <div style="font-weight: bold; color: #FFF; font-size: 24px; margin-top: 10px; text-align: center;">
                {{date("d-m-y",strtotime($date))}}
              </div>
              <ul class="game-numbers">
                @foreach($numbers as $number)
                <li>
                    <div>
                      <span class="meta">{{ date("h:i A",strtotime($number->game_time))}}</span>
                      <span class="number">{{$number->number1}}{{$number->number2}}</span>
                    </div>
                </li>
                @endforeach
              </ul>
            </td>
          </tr>
          @endforeach
        </table>
        <div>
          <div class="row">
            <div class="col-md-6">
              @if($next_date)
              <a style="display: inline-block; background: rgba(0,0,0,0.5); padding: 15px; font-size: :28px; color: #fff" href="{{url('/')}}?date={{$next_date}}">{{date("d-m-Y",strtotime($next_date))}}</a>
              @endif
            </div>
            <div class="col-md-6 text-right">
              @if($prev_date)
              <a style="display: inline-block; background: rgba(0,0,0,0.5); padding: 15px; font-size: :28px; color: #fff" href="{{url('/')}}?date={{$prev_date}}">{{date("d-m-Y",strtotime($prev_date))}}</a>
              @endif
            </div>
          </div>
        </div>
    </div>
    </div>
  </div>
</body>
<!-- END BODY -->
</html>