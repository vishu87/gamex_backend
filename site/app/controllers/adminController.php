<?php

class adminController extends BaseController {
	protected $layout = 'layout';
	function indexpage(){
		return View::make('login');
	}

	function home(){
		$game_number_max = DB::table("game_numbers")->orderBy("updated_at","DESC")->first();

		if(Input::has("date")){
			$date = date("Y-m-d",strtotime(Input::get("date")));
			$prev_date = date("Y-m-d",strtotime(Input::get("date")) - 86400);
		} else {	
			$date = date("Y-m-d",strtotime($game_number_max->updated_at));
			$prev_date = date("Y-m-d",strtotime($date) - 86400);
		}

		if($date != date("Y-m-d",strtotime($game_number_max->updated_at))){
			$next_date = date("Y-m-d",strtotime(Input::get("date")) + 86400);
		} else {
			$next_date = "";
		}

		$times = [
			"08:00","08:15","08:30","08:45",
			"09:00","09:15","09:30","09:45",
			"10:00","10:15","10:30","10:45",
			"11:00","11:15","11:30","11:45",
			"12:00","12:15","12:30","12:45",
			"13:00","13:15","13:30","13:45",
			"14:00","14:15","14:30","14:45",
			"15:00","15:15","15:30","15:45",
			"16:00","16:15","16:30","16:45",
			"17:00","17:15","17:30","17:45",
			"18:00","18:15","18:30","18:45",
			"19:00","19:15","19:30","19:45",
			"20:00","20:15","20:30","20:45",
			"21:00","21:15","21:30","21:45"
		];

		$dates = [];
		$game_numbers = DB::table("game_numbers")->where("updated_at","LIKE","%".$date."%")->orderBy("game_time","DESC")->get();
		foreach ($game_numbers as $game_number) {
			if($game_number->number1 == 50) $game_number->number1 = 0;
			if($game_number->number2 == 50) $game_number->number2 = 0;

			$date = date("Y-m-d",strtotime($game_number->updated_at));
			if(!isset($dates[$date])) $dates[$date] = [];

			$dates[$date][] = $game_number;
		}
		return View::make('home',["dates" => $dates, "times" => $times, "prev_date" => $prev_date, "next_date" => $next_date]);
	}

	function autoGenerateNumber(){
		$start_date = strtotime("01-01-2019");
		$times = [
			"08:00","08:15","08:30","08:45",
			"09:00","09:15","09:30","09:45",
			"10:00","10:15","10:30","10:45",
			"11:00","11:15","11:30","11:45",
			"12:00","12:15","12:30","12:45",
			"13:00","13:15","13:30","13:45",
			"14:00","14:15","14:30","14:45",
			"15:00","15:15","15:30","15:45",
			"16:00","16:15","16:30","16:45",
			"17:00","17:15","17:30","17:45",
			"18:00","18:15","18:30","18:45",
			"19:00","19:15","19:30","19:45",
			"20:00","20:15","20:30","20:45",
			"21:00","21:15","21:30","21:45"
		];

		$count = 0;

		for ($date=$start_date; $date < strtotime("today"); $date = $date+86400) { 
			
			$date_ymd = date("Y-m-d",$date);
			$date_ymd_hour = $date_ymd." 00:00:00";

			foreach ($times as $time) {

				$check = DB::table("game_numbers")->where("updated_at",$date_ymd_hour)->where("game_time",$time)->first();
				if(!$check){
					DB::table("game_numbers")->insert(array(
						"game_number" => "-1",
						"game_time" => $time,
						"game_type" => 1,
						"number1" => rand(0,10),
						"number2" => rand(0,10),
						"updated_at" => $date_ymd_hour
					));
					$count++;
				}
			}

		}

		return $count." entries has been done";
	}

	function login(){
		$cre=["username"=>Input::get('username'),"password"=>Input::get('password')];
		$rules=['username'=>'required','password'=>'required'];
		$validator=Validator::make($cre,$rules);
		if($validator->passes()){
            if(Auth::attempt($cre)){
            	// if(Auth::id() == 28){
	            	if(Auth::user()->priv==1){
	            		return Redirect::to('/agents');
	            	}
	                else if(Auth::user()->priv == 2) return Redirect::to('/fundtransfer');
	                else if(Auth::user()->priv == 3) return Redirect::to('/fundtransfer');
	                else return  Redirect::Back()->withErrors($validator)->withInput()->with('failure','Username and password does not match');
	            // } else {
	            // 	return 'Not allowed';
	            // }


            } else {
                return  Redirect::Back()->withErrors($validator)->withInput()->with('failure','Username and password does not match');
            }
            
        } else {
            return Redirect::Back()->withErrors($validator)->withInput();
        }
	}

	function loginagent(){
		$this->layout->main =  View::make('agents/welcome');
		$this->layout->page_id = 0;
	}
	function logout(){
		Auth::logout();
		return Redirect::to('/');
	}
	function adminPage(){
		$agents=User::where('priv',2)->where('admin_id',Auth::id())->get();
		$distributors=User::where('priv',3)->where('admin_id',Auth::id())->lists("name","id");
		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>1]);
		$this->layout->main = View::make('admin.index',["agents"=>$agents, "distributors" => $distributors]);
	}
	function addDis(){
		$agents=User::where('priv',3)->where('admin_id',Auth::id())->get();
		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>9]);
		$this->layout->main = View::make('admin.indexDis',["agents"=>$agents]);
	}
	function addAgent(){
		if(Auth::user()->priv==1){
			$cre = [
				"name"=>Input::get('name'),
				"agent_uname"=>Input::get('agent_uname')
			];
			$rules=[
				"name"=>'required',
				"agent_uname"=>'required|unique:members,username'
			];
			$password = "tgr123";
			$validation=Validator::make($cre,$rules);
			if($validation->passes()){
				$user = new User;
				$user->username = Input::get('agent_uname');
				$user->name = Input::get('name');
				$user->email = Input::get('email');
				$user->password = Hash::make($password);
				$user->distributor_id = Input::get('dis_id');
				$user->admin_id = Auth::id();

				$user->priv = 2;
				$user->save();
				return Redirect::Back()->with('success','Agent Added');
			}
			else{
				return Redirect::Back()->withErrors($validation)->withInput();
			}
		}
		else
		{
			return Redirect::to('/');
		}
		
	}

	function postDis(){
		if(Auth::user()->priv==1){
			$cre = [
				"name"=>Input::get('name'),
				"agent_uname"=>Input::get('agent_uname'),
			];
			$rules=[
				"name"=>'required',
				"agent_uname"=>'required|unique:members,username'
			];
			$password = "tgr123";
			$validation=Validator::make($cre,$rules);
			if($validation->passes()){
				$user = new User;
				$user->username = Input::get('agent_uname');
				$user->name = Input::get('name');
				$user->email = Input::get('email');
				$user->password = Hash::make($password);
				$user->priv = 3;
				$user->admin_id = Auth::id();
				$user->save();
				return Redirect::Back()->with('success','Distributor Added');
			}
			else{
				return Redirect::Back()->withErrors($validation)->withInput();
			}
		}
		else
		{
			return Redirect::to('/');
		}
		
	}

	function editAgent($id){
		if(Auth::user()->priv==1){
			$agent = User::where('id',$id)->first();
			$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>1]);			
			$this->layout->main = View::make('admin.edit',["agent"=>$agent]);
		}
		else
		{
			return Redirect::to('/');
		}
		
	}
	function updateAgent($id){
		if(Auth::user()->priv==1){
			$check=User::where('id','!=',$id)->where('email',Input::get('email'))->get();
			$count=count($check);
			if($count==0){
				$cre = [
					"name"=>Input::get('name'),
					"email"=>Input::get('email')
				];
				$rules=[
					"name"=>'required',
					"email"=>'required|email'
				];
				$validation=Validator::make($cre,$rules);
				if($validation->passes()){
					$agent=User::find($id);
					$agent->name=Input::get('name');
					$agent->email=Input::get('email');
					$agent->save();
					return Redirect::to('admin')->with('success','Agent Details Updated!');
				}
				else{
					return Redirect::Back()->withErrors($validation)->withInput();
				}
			}
			else{
					return Redirect::Back()->with('failure','This Email has Already been taken')->withInput();
			}
		}
		else
		{
			return Redirect::to('/');
		}
		
	}

	function deleteAgent($id){
		if(Auth::user()->priv==1){
			$del=User::where('id',$id)->delete();
			return Redirect::to('admin')->with('success','Agent Deleted');
		}
		else
		{
			return Redirect::to('/');
		}
		
	}

//----------fund Transfer-------
	function fundtransfer(){

		// if(Auth::user()->priv==1){
			
		// 	$pay_to_get = User::where('priv',3)->where('admin_id',Auth::id())->get();
		// 	$pay_to = array();
		// 	foreach ($pay_to_get as $u) {
		// 		$pay_to[$u->id] = $u->name.' ('.$u->username.')';
		// 	}

		// 	$pay_to_agent_get = User::where('priv',2)->where('admin_id',Auth::id())->get();
		// 	$pay_to_agent = array();
		// 	foreach ($pay_to_agent_get as $u) {
		// 		$pay_to_agent[$u->id] = $u->name.' ('.$u->username.')';
		// 	}

		// }else if(Auth::user()->priv==3){

		// 	$pay_to_get = User::where('priv',2)->where('distributor_id',Auth::id())->get();
		// 	$pay_to = array();
		// 	foreach ($pay_to_get as $u) {
		// 		$pay_to[$u->id] = $u->name.' ('.$u->username.')';
		// 	}
		
		// } else {
		// 	$pay_to_get = Ruser::where('agent_id',Auth::id())->get();
		// 	$pay_to = array();
		// 	foreach ($pay_to_get as $u) {
		// 		$pay_to[$u->id] = $u->name.' ('.$u->user_name.')';
		// 	}
		// }

		$pay_to_get = DB::table("user")->where("type",1)->get();
		$pay_to = array();
		foreach ($pay_to_get as $u) {
			$pay_to[$u->id] = $u->name.' ('.$u->user_name.')';
		}

		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>3]);
		// if(Auth::user()->priv==1){
		// 	$this->layout->main = View::make('admin.fund_transfer',["pay_to"=>$pay_to, "pay_to_agent"=>$pay_to_agent]);
		// } else {
		// 	$this->layout->main = View::make('admin.fund_transfer',["pay_to"=>$pay_to]);
		// }
		$this->layout->main = View::make('admin.fund_transfer',["pay_to"=>$pay_to]);
	    $this->layout->page_id = 3;
	}

	function getPayee(){
		if(Input::get('to')==1){
			$list=User::where('priv','!=',1)->lists('username','id');
			$final_list = [];
			foreach ($list as $key => $value) {
				array_push($final_list, array("id"=>$key, "value"=>$value)); 
			}
			return json_encode($final_list);
		}
		if(Input::get('to')==2){
			$list=Ruser::lists('user_name','id');
			$final_list = [];
			foreach ($list as $key => $value) {
				array_push($final_list, array("id"=>$key, "value"=>$value)); 
			}
			return json_encode($final_list);

		}
	}

	function transferMoney(){
		$cre=[
			"payee"=>Input::get('payee'),
			"amount"=>Input::get('amount')
		];
		$rules=[
			"payee"=>'required',
			"amount"=>'required|regex:([0-9])'
		];
		$Validator=Validator::make($cre,$rules);
		if($Validator->passes() && Input::get("amount") > 0){
			if(Auth::user()->priv==1  ){
					//TRANSFER MONEY TO AGENT
					$transaction = new Transaction;
					$transaction->admin_id=Auth::user()->id;
					$transaction->distributor_id=Input::get('payee');
					$transaction->remark= Input::get('remark');
					$transaction->amount= Input::get('amount');
					$transaction->save();
					$agent = User::find(Input::get('payee'));
					$agent->balance = $agent->balance + Input::get('amount');
					$agent->save();
					return Redirect::Back()->with('success','Fund Transfered Successfully');
			}else if(Auth::user()->priv == 3  ){
					//TRANSFER MONEY TO AGENT
					$dis = User::find(Auth::id());

					if($dis->balance >= Input::get('amount') && Input::get('amount') > 0){


					$transaction = new Transaction;
					$transaction->distributor_id=Auth::user()->id;
					$transaction->agent_id = Input::get('payee');
					$transaction->remark= Input::get('remark');
					$transaction->amount= Input::get('amount');
					$transaction->save();

					$agent = User::find(Input::get('payee'));
					$agent->balance = $agent->balance + Input::get('amount');
					$agent->save();

					$dis->balance = $dis->balance - Input::get('amount');
					$dis->save();

					return Redirect::Back()->with('success','Fund Transfered Successfully');
				} else{
					return Redirect::Back()->withErrors($Validator)->withInput()->with('failure','Balance is not enough or Amount should be more than 0');
				}
			} else {
				if(Auth::user()->balance >= Input::get('amount')){
					$flag = false;
					$redis = Redis::connection();
					if($redis->INCRBY('balance_'.Input::get('payee'), Input::get('amount')) ){
						$transaction = new Transaction;
						$transaction->agent_id=Auth::user()->id;
						$transaction->user_id=Input::get('payee');
						$transaction->amount= Input::get('amount');
						$transaction->remark= Input::get('remark');
						if($transaction->save()){
							$count_user=UserBalance::where('user_id',Input::get('payee'))->count();
							
							if($count_user==0){
								$user_balance=new UserBalance;
								$user_balance->user_id=Input::get('payee');
								$user_balance->balance=Input::get('amount');
								if($user_balance->save()){
									$flag = true;
								}
							}
							else{
								$balance_prev=DB::table('user_balance')->where('user_id',Input::get('payee'))->first();
								$total_balance = $balance_prev->balance + Input::get('amount');
								if(DB::table('user_balance')->where('user_id',Input::get('payee'))->update(array("balance"=>$total_balance))){
									$flag = true;
								}
							}

							if($flag){
								$agent = User::find(Auth::user()->id);
								$agent->balance = $agent->balance - Input::get('amount');
								$agent->save();
								return Redirect::Back()->with('success','Fund Transfered Successfully');
							} else {
								$transaction->delete();
								$redis->DECRBY('balance_'.Input::get('payee'), Input::get('amount'));
								return Redirect::Back()->with('failure','Transaction error');
							}

						} else {
							$redis->DECRBY('balance_'.Input::get('payee'), Input::get('amount'));
							return Redirect::Back()->with('failure','Fund Transfered Successfully');
						}	
					} else {
						return Redirect::Back()->with('failure','Not connected to redis!!');
					}
				} else {
					return Redirect::Back()->with('failure','Not enough funds!!');

				}
			}
			
		}
		else{
			return Redirect::Back()->withErrors($Validator)->withInput()->with('failure','Amount should be more than 0');
		}
	}

	function transferMoneyAgent(){
		$cre=[
			"payee"=>Input::get('payee'),
			"amount"=>Input::get('amount')
		];
		$rules=[
			"payee"=>'required',
			"amount"=>'required|regex:([0-9])'
		];
		$Validator=Validator::make($cre,$rules);
		if($Validator->passes() && Input::get("amount") > 0){
			if(Auth::user()->priv==1  ){
					//TRANSFER MONEY TO AGENT
					$transaction = new Transaction;
					$transaction->admin_id=Auth::user()->id;
					$transaction->agent_id=Input::get('payee');
					$transaction->remark= Input::get('remark');
					$transaction->amount= Input::get('amount');
					$transaction->save();
					$agent = User::find(Input::get('payee'));
					$agent->balance = $agent->balance + Input::get('amount');
					$agent->save();
					return Redirect::Back()->with('success','Fund Transfered Successfully');
			}
			
		}
		else{
			return Redirect::Back()->withErrors($Validator)->withInput()->with('failure','Amount should be more than 0');
		}
	}

	function transferhistoryagent($id = null){

		$agents = User::where('priv',2)->lists('name','id');
		$distributors = User::where('priv',3)->lists('name','id');
		if($id){
			$transactions = Transaction::select('transactions.*','members.name')->leftJoin('members','transactions.agent_id','=','members.id')->where('transactions.agent_id',$id)->where('transactions.user_id',0)->orderBy('id','DESC')->get();
		}
		$agent_id = $id;
		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>6]);
		$this->layout->main = View::make('admin.transferhistoryagent',["agents"=>$agents,"transactions"=>$transactions, "distributors" => $distributors, "agent_id" => $id ]);
		
	}

	function transferhistory($id = null){

		$agents = User::where('priv',2)->where('admin_id',Auth::id())->lists('name','id');
		$distributors = User::where('priv',3)->where('admin_id',Auth::id())->lists('name','id');
		$transactions = Transaction::select('transactions.*')->where('transactions.admin_id',Auth::id())->orderBy('id','DESC')->get();
		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>6]);
		$this->layout->main = View::make('admin.transferhistory',["agents"=>$agents,"transactions"=>$transactions, "distributors" => $distributors]);
		
	}

	function alltransferhistory($id = null){

		if(Auth::id() == 28){
			$agents = User::where('priv',2)->lists('name','id');
			$distributors = User::where('priv',3)->lists('name','id');
			$users = Ruser::select('user.id','user.user_name')->join('members','members.id','=','user.agent_id')->lists('user_name','id');
		} else {
			$agents = User::where('priv',2)->where('admin_id',Auth::id())->lists('name','id');
			$distributors = User::where('priv',3)->where('admin_id',Auth::id())->lists('name','id');
			$users = Ruser::select('user.id','user.user_name')->join('members','members.id','=','user.agent_id')->where('members.admin_id',Auth::id())->lists('user_name','id');
		}
		$transactions = Transaction::select('transactions.*')->orderBy('id','DESC')->take(500)->get();
		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>10]);
		$this->layout->main = View::make('admin.alltransferhistory',["agents"=>$agents,"transactions"=>$transactions, "distributors" => $distributors, "users" => $users]);
		
	}

	function transferhistoryuser($id){

		$user = Ruser::find($id);
		if(Auth::user()->priv != 1){
			if($user->agent_id != Auth::id()){
				return "You are not authorized";
			}
		}
		$transactions = Transaction::select('transactions.*','members.name')->leftJoin('members','transactions.agent_id','=','members.id')->where('transactions.user_id',$id)->orderBy('id','DESC')->get();
		
		
		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>6]);
		$this->layout->main = View::make('admin.transferhistoryuser',["user"=>$user,"transactions"=>$transactions ]);
		
	}

	
	function transferhistorydis($id){

		$user = User::find($id);
		if(Auth::user()->priv != 1){
			if($user->agent_id != Auth::id()){
				return "You are not authorized";
			}
		}

		$transactions = Transaction::select('transactions.*','members.name')->leftJoin('members','transactions.distributor_id','=','members.id')->where('transactions.distributor_id',$id)->where('admin_id','!=',0)->orderBy('id','DESC')->get();
		
		
		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>9]);
		$this->layout->main = View::make('admin.transferhistorydis',["user"=>$user,"transactions"=>$transactions ]);
		
	}

	function bettinghistoryuser($id){
		$user = Ruser::find($id);
		
		$betting = DB::table('bet_transaction_new')->select('bet_transaction_new.*','game_numbers.number1','game_numbers.number2')->join("game_numbers","game_numbers.game_number","=","bet_transaction_new.game_id")->where('user_id',$id)->orderBy('created_timestamp','DESC')->get();
		
		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>2]);
		$this->layout->main = View::make('admin.bettinghistoryuser',["user"=>$user,"betting"=>$betting ]);
	}



	function bettinghistoryagent($id){

		$agent = User::find($id);

		if(Auth::user()->priv != 1){
			if($agent->id != Auth::id()){
				return "You are not authorized";
			}
		}
		$betting = DB::table('bet_transaction')->select('bet_transaction.*','user.name')->join('user','bet_transaction.user_id','=','user.id')->where('user.agent_id',$id)->orderBy('created_timestamp','DESC')->get();
		
		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>1]);
		$this->layout->main = View::make('admin.bettinghistoryagent',["agent"=>$agent,"betting"=>$betting ]);
	}

	function latest(){

		if(Auth::user()->priv != 1){
			if($agent->id != Auth::id()){
				return "You are not authorized";
			}
		}
		if(Auth::id() == 28){
			$betting = DB::table('bet_transaction')->select('bet_transaction.*','user.name')->join('user','bet_transaction.user_id','=','user.id')->join('members','members.id','=','user.agent_id')->orderBy('created_timestamp','DESC')->take(100)->get();

		} else {
			$betting = DB::table('bet_transaction')->select('bet_transaction.*','user.name')->join('user','bet_transaction.user_id','=','user.id')->join('members','members.id','=','user.agent_id')->where('members.admin_id',Auth::id())->orderBy('created_timestamp','DESC')->take(100)->get();

		}
		
		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>11]);
		$this->layout->main = View::make('admin.latest',["betting"=>$betting ]);
	}

	function stats(){

		if(Auth::id() == 28){
			$distributors=User::where('priv',3)->lists("name","id");
		} else {
			$distributors=User::where('priv',3)->where('admin_id',Auth::id())->lists("name","id");
		}

		$data_dis = array();

		if(Input::has('start_date') && Input::has('end_date')){
			$start_date = date("Y-m-d",strtotime(Input::get('start_date')));
			$end_date = date("Y-m-d",(strtotime(Input::get('end_date')) + 86400) );

			$data = DB::table('bet_transaction')->select(DB::raw('SUM(profit_loss) as profit_loss, members.id, members.name, members.distributor_id '))->join('user','bet_transaction.user_id','=','user.id')->join('members','user.agent_id','=','members.id')->groupBy('members.id')->where('created_timestamp','>=',$start_date)->orderBy('members.distributor_id','asc')->where('created_timestamp','<=',$end_date)->get();

		} else {
			$data = DB::table('bet_transaction')->select(DB::raw('SUM(profit_loss) as profit_loss, members.id, members.name, members.distributor_id '))->join('user','bet_transaction.user_id','=','user.id')->join('members','user.agent_id','=','members.id')->groupBy('members.id')->get();
		}

		foreach ($data as $dt) {
			$data_dis[$dt->distributor_id][$dt->id] = array("profit_loss"=>$dt->profit_loss, "name" => $dt->name);
		}
		
		$data_given = DB::table('amount_given')->select('amount_given.*','members.name')->join('members','amount_given.agent_id','=','members.id')->get();
		$agents = DB::table('members')->where('priv',2)->where('admin_id',Auth::id())->lists('name','id');
		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>8]);
		$this->layout->main = View::make('admin.stats',["p_loss"=>$data, "given" => $data_given, "agents" => $agents, "data_dis" => $data_dis, "distributors" => $distributors ]);

	}

	function statsNew(){

		$data_dis = array();

		if(Input::has('start_date') && Input::has('end_date')){
			$start_date = date("Y-m-d",strtotime(Input::get('start_date')));
			$end_date = date("Y-m-d",(strtotime(Input::get('end_date')) + 86400) );

			$data = DB::table('bet_transaction_new')->select(DB::raw('SUM(total_amount) as total_amount, SUM(final_amount) as final_amount, user.user_name '))->join('user','bet_transaction_new.user_id','=','user.id')->where('created_timestamp','>=',$start_date)->where('created_timestamp','<=',$end_date)->groupBy('bet_transaction_new.user_id')->get();

		} else {
			$data = DB::table('bet_transaction_new')->select(DB::raw('SUM(total_amount) as total_amount, SUM(final_amount) as final_amount, user.user_name '))->join('user','bet_transaction_new.user_id','=','user.id')->groupBy('bet_transaction_new.user_id')->get();
		}


		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>8]);
		$this->layout->main = View::make('admin.stats_new',[ "p_loss"=>$data ]);

	}


	function makepaymentUser(){
		$cre=[
			"user_id"=>Input::get('payee'),
			"amount"=>Input::get('amount')
		];
		$rules=[
			"user_id"=>'required',
			"amount"=>'required|regex:([0-9])'
		];
		$Validator=Validator::make($cre,$rules);
		if($Validator->passes()){
			$transaction = new Transaction;
			$transaction->agent_id=0;
			$transaction->user_id=Input::get('payee');
			$transaction->amount= Input::get('amount');
			$transaction->remark= Input::get('remark');
			if($transaction->save()){

				$count_user = UserBalance::where('user_id',Input::get('payee'))->count();
				
				if($count_user==0){
					$user_balance=new UserBalance;
					$user_balance->user_id=Input::get('payee');
					$user_balance->balance=Input::get('amount');
					if($user_balance->save()){
						$flag = true;
					}
				}
				else{
					$balance_prev=DB::table('user_balance')->where('user_id',Input::get('payee'))->first();
					$total_balance = $balance_prev->balance + Input::get('amount');
					if(DB::table('user_balance')->where('user_id',Input::get('payee'))->update(array("balance"=>$total_balance))){
						$flag = true;
					}
				}

				return Redirect::Back()->with('success','Fund Transfered Successfully');

			} else {
				
				return Redirect::Back()->with('failure','Fund Transfered Failed');
			}
		}
		else{
			return Redirect::Back()->withErrors($Validator)->withInput()->with('failure','Amount should be more than 0');
		}
	}
	function makepayment(){
		$cre=[
			"agent_id"=>Input::get('agent_id'),
			"amount"=>Input::get('amount')
		];
		$rules=[
			"agent_id"=>'required',
			"amount"=>'required|regex:([0-9])'
		];
		$Validator=Validator::make($cre,$rules);
		if($Validator->passes() && Input::get("amount") > 0){
			if(Auth::user()->priv==1  ){
					//TRANSFER MONEY TO AGENT
					DB::table('amount_given')->insert(["agent_id"=>Input::get('agent_id'), "amount"=>Input::get('amount'), "remark"=>Input::get('remark')]);
					return Redirect::Back()->with('success','Fund Transfered Successfully');
			}
			
		}
		else{
			return Redirect::Back()->withErrors($Validator)->withInput()->with('failure','Amount should be more than 0');
		}
	}

	public function checkBalance($user_id){

		return Redirect::to("check-balance-main?uid=".urlencode(base64_encode($user_id)));

	}

	public function checkBalanceMain(){
		$user_id = base64_decode(Input::get("uid"));

		if(Input::has("start_date")){
			$start_date = date("Y-m-d",strtotime(Input::get("start_date")));
		} else {
			$start_date = date("Y-m-d");
		}

		$start_date_show = date("d-m-Y",strtotime($start_date));

		if(Input::has("end_date")){
			$end_date = date("Y-m-d",strtotime(Input::get("end_date")));
			$end_date_show = date("d-m-Y",strtotime($end_date));
		} else {
			$end_date = "";
			$end_date_show = "";
		}

		$transactions = DB::table("bet_transaction_new")->select("bet_transaction_new.*","game_numbers.game_time","game_numbers.number1","game_numbers.number2")->where("created_timestamp",">=",$start_date." 00:00:00")->join("game_numbers","game_numbers.game_number","=","bet_transaction_new.game_id");
		if($end_date){
			$transactions = $transactions->where("created_timestamp","<=",$end_date." 23:59:59");
		}

		$transactions = $transactions->where("user_id",$user_id)->orderBy("created_timestamp","DESC")->get();

		return View::make('admin.balance',[
			"user_id"=>Input::get("uid"),
			"start_date" => $start_date_show,
			"end_date" => $end_date_show,
			"transactions" => $transactions
		]);

	}

	public function allBalance(){
		header('Access-Control-Allow-Origin: *');
		$today = date("Y-m-d");
		$users = DB::table("user_balance")->select("user_balance.balance","user.user_name","user_balance.user_id")->whereNotIn("user.id",[16])->join("user","user.id","=","user_balance.user_id")->get();

		$today_balances = DB::table("bet_transaction_new")->select(DB::raw(" SUM(total_amount) as total_amount, SUM(final_amount) as final_amount, user_id "))->where("created_timestamp",">=",$today." 00:00:00")->where("cancelled",0)->groupBy("user_id")->get();

		$overall_balances = DB::table("bet_transaction_new")->select(DB::raw(" SUM(total_amount) as total_amount, SUM(final_amount) as final_amount, user_id "))->where("cancelled",0)->groupBy("user_id")->get();

		foreach ($users as $user) {
			$user->today_profit = 0;
			$user->overall_profit = 0;

			foreach ($today_balances as $today_balance) {

				if($today_balance->user_id == $user->user_id){
					$user->today_profit = ($today_balance->total_amount - $today_balance->final_amount)*10;
				}
			}

			foreach ($overall_balances as $overall_balance) {
				if($overall_balance->user_id == $user->user_id){
					$user->overall_profit = ($overall_balance->total_amount - $overall_balance->final_amount)*10;
				}
			}
		}

		return $users;
	}

	public function checkRedis(){
		$redis = Redis::connection();
		if($redis->GET('balance_3') ){
			return $redis->GET('balance_3');
		} else {
			return "Not connected";
		}
	}

}
