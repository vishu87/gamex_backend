<?php

class agentController extends BaseController {
	protected $layout = 'layout';

	function agentPage(){
		if(Auth::user()->priv == 1){
			$users = DB::table('user')->select('user.*','members.name as agent_name','user_balance.balance')->leftJoin('members','user.agent_id','=','members.id')->leftJoin('user_balance','user.id','=','user_balance.user_id')->where("user.type",1)->get();
		}else if(Auth::user()->priv == 3){
			$users = DB::table('user')->select('user.*','members.name as agent_name','user_balance.balance')->leftJoin('members','user.agent_id','=','members.id')->leftJoin('user_balance','user.id','=','user_balance.user_id')->where('members.distributor_id',Auth::id())->where('user.type',1)->get();
		} else {
			$users = DB::table('user')->select('user.*','members.name as agent_name','user_balance.balance')->leftJoin('members','user.agent_id','=','members.id')->leftJoin('user_balance','user.id','=','user_balance.user_id')->where('user.agent_id',Auth::id())->get();
		}
		
		$agents = User::where('priv',2)->where('admin_id',Auth::id())->lists('name','id');
		$agents=[""=>"--Select Agent--"] + $agents;
		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>2]);
		$this->layout->main = View::make('agents.index',["users"=>$users,"agents"=>$agents]);
	}
	
	function addUser(){
		$cre = [
			"name"=>Input::get('name'),
			"username"=>Input::get('username'),
			"agent"=>Input::get('agent')
		];
		$rules=[
			"name"=>'required',
			"agent"=>'required',
			"username"=>'required|unique:user,user_name'
		];
		$password = "tgr123";
		$validation=Validator::make($cre,$rules);
		if($validation->passes()){
			$user = new Ruser;
			$user->user_name = Input::get('username');
			$user->name = Input::get('name');
			$user->agent_id = Input::get('agent');
			$user->email = Input::get('email');
			$user->password = md5($password);
			$user->status = 1;
			$user->type = 1;
			$user->save();

			$user_balance=new UserBalance;
			$user_balance->user_id=$user->id;
			$user_balance->balance=0;
			$user_balance->save();

			return Redirect::Back()->with('success','User Added');
		}
		else{
			return Redirect::Back()->withErrors($validation)->withInput();
		}
	}
	function editUser($id){
		$agent = Ruser::where('id',$id)->first();
		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>2]);
		$this->layout->main = View::make('agents.edit',["users"=>$agent]);
	}
	function updateUser($id){
		// $check=Ruser::where('id','!=',$id)->where('email',Input::get('email'))->get();
		// $count=count($check);
		$count = 0;
		if($count==0){
			$cre = [
				"name"=>Input::get('name'),
				"status"=>Input::get('status')
			];
			$rules=[
				"name"=>'required',
				"status"=>'required'
			];
			$validation=Validator::make($cre,$rules);
			if($validation->passes()){
				$agent=Ruser::find($id);
				$agent->name=Input::get('name');
				$agent->email=Input::get('email');
				$agent->status=Input::get('status');
				$agent->save();
				return Redirect::to('agents')->with('success','User Details Updated!');
			}
			else{
				return Redirect::Back()->withErrors($validation)->withInput();
			}
		}
		else{
				return Redirect::Back()->with('failure','This Email has Already been taken')->withInput();
		}
	}

	function updateUserPassword($id){

			$cre = [
				"password"=>Input::get('password')
			];
			$rules=[
				"password"=>'required'
			];
			$validation=Validator::make($cre,$rules);
			if($validation->passes()){
				$agent=Ruser::find($id);
				$agent->password=md5(Input::get('password'));
				$agent->save();
				return Redirect::to('agents')->with('success','User password Updated!');
			}
			else{
				return Redirect::Back()->withErrors($validation)->withInput();
			}

	}

	function deleteUser($id){
		$del=Ruser::where('id',$id)->delete();
		return Redirect::to('agents')->with('success','User Deleted!');
	}

	function transferhistoryagent(){
		
		$balance = Auth::user()->balance;
		$distributors=User::where('priv',3)->lists("name","id");
		$transactions = Transaction::select('transactions.*','user.name')->leftJoin('user','transactions.user_id','=','user.id')->where('transactions.agent_id',Auth::id())->orderBy('id','DESC')->get();
		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>4]);
		$this->layout->main = View::make('agents.transferhistoryagent',["balance"=>$balance,"transactions"=>$transactions,"distributors"=>$distributors]);

	}

	function transferhistorydis(){
		
		$balance = Auth::user()->balance;
		$transactions = Transaction::select('transactions.*','members.name')->leftJoin('members','transactions.agent_id','=','members.id')->where('transactions.distributor_id',Auth::id())->orderBy('id','DESC')->get();
		$this->layout->sidebar = View::make('admin.sidebar',["page_id"=>10]);
		$this->layout->main = View::make('agents.transferhistorydis',["balance"=>$balance,"transactions"=>$transactions]);

	}

	function withdrawMoney(){
		$cre=[
			"amount2"=>Input::get('amount')
		];
		$rules=[
			"amount2"=>'required|regex:([0-9])'
		];
		$Validator=Validator::make($cre,$rules);


		if($Validator->passes() && Input::get('amount') > 0){
			if(Auth::user()->balance >= Input::get('amount')){
				if(Auth::user()->priv == 2){
					$transaction = new Transaction;
					$transaction->agent_id = Auth::user()->id;
					$transaction->distributor_id = Auth::user()->distributor_id;
					$transaction->amount= Input::get('amount');
					$transaction->remark= Input::get('remark');
					$transaction->credit_debit = 1;
					if($transaction->save()){
						$agent = User::find(Auth::id());
						$agent->balance = $agent->balance - Input::get('amount');
						$agent->save();

						$dis = User::find(Auth::user()->distributor_id);
						$dis->balance = $dis->balance + Input::get('amount');
						$dis->save();

						return Redirect::Back()->with('success','Transaction is successfully completed');


					} else {
						return Redirect::Back()->with('failure','Transaction is not completed');
					}
				}

				if(Auth::user()->priv == 3){
					$transaction = new Transaction;
					$transaction->distributor_id = Auth::user()->id;
					$transaction->admin_id = Auth::user()->admin_id;
					$transaction->amount= Input::get('amount');
					$transaction->remark= Input::get('remark');
					$transaction->credit_debit = 1;
					if($transaction->save()){
						$agent = User::find(Auth::id());
						$agent->balance = $agent->balance - Input::get('amount');
						$agent->save();
						return Redirect::Back()->with('success','Transaction is successfully completed');
					} else {
						return Redirect::Back()->with('failure','Transaction is not completed');
					}
				}



			} else {
				return Redirect::Back()->with('failure','Not enough funds!!');

			}
		}
		else{
			return Redirect::Back()->withErrors($Validator)->withInput()->with('failure','Please provide money more than 0');
		}
	}

}
