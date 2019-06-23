<?php

class UserController extends BaseController {
    protected $layout = 'layout';

    public function index(){
        $this->layout->sidebar = 'users';
        $this->layout->subsidebar = 2;
        $users = User::get();
        $array_yn = array("0"=>"No","1"=>"Yes");
        $this->layout->main = View::make("admin.users.index",['users'=>$users,'yn'=>$array_yn]);
    }

    public function new_user(){
        $this->layout->sidebar = 'users';
        $this->layout->subsidebar = 1;
        $this->layout->main = View::make("admin.users.new");
    }

    public function edit_user($id){
        $this->layout->sidebar = 'users';
        $this->layout->subsidebar = 2;
        $user = User::find($id);
        $this->layout->main = View::make("admin.users.edit",["user"=>$user]);
    }


    public function postLogin()
    {
        $credentials = [
            'username' => Input::get('username'),
            'password' => Input::get('password')
        ];
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->passes()) {
            if (Auth::attempt(['username' => Input::get('username'), 'password' => Input::get('password'), 'active' => 0] )){
                Session::put('priviledge', Auth::user()->priv);
                if(Auth::user()->priv == 11) return Redirect::to('super_admin');
                if(Auth::user()->priv == 1) return Redirect::to('tm_admin');
                if(Auth::user()->priv == 3) return Redirect::to('ref-head');

                if(Auth::user()->priv == 2) return Redirect::to('mc');
                if(Auth::user()->priv == 4) return Redirect::to('referee');
                if(Auth::user()->priv == 5) return Redirect::to('referee-assessor');
                if(Auth::user()->priv == 6 || Auth::user()->priv == 7) return Redirect::to('teams');
            }
            else return Redirect::back()->withInput()->with('failure', 'username or password is invalid!');
        } else {
            return Redirect::back()->withErrors($validator)->withInput();
        }
    }

    public function getUserProfile(){
        $this->layout->sidebar = View::make('admin.sidebar',["page_id"=>7]);
        $this->layout->main = View::make("profile");
        $this->layout->list = '';
    }

    public function postChangePassword(){
        $credentials = [
            'old_p' => Input::get('old_p'),
            'new_p' => Input::get('new_p'),
            're_new_p' => Input::get('re_new_p')
        ];
        $rules = [
            'old_p' => 'required',
            'new_p' => array('required', 'min:8'),
            're_new_p' => array('required')
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->passes()) { 
            if (Hash::check(Input::get('old_p'), Auth::user()->password )) {
                if(Input::get('new_p') === Input::get('re_new_p')){
                    $password = Hash::make(Input::get('new_p'));
                    $user = User::find(Auth::id());
                    $user->password = $password;
                    $user->save();
                    return Redirect::back()->withInput()->with('success', 'Password successfully changed');
                } else return Redirect::back()->withInput()->with('failure', 'New passwords does not match.');
            } else {
                return Redirect::back()->withInput()->with('failure', 'Old password does not match.');
            }
        } else {
            return Redirect::back()->withErrors($validator)->withInput();
        }
    }

    //  public function ResetPassword($user_id){
    //     $password = str_random(8);
    //     $user = User::find($user_id);
    //     $user->password = Hash::make($password);
    //     $user->password_check = $password;
    //     $user->save();
    //     $data["success"] = true;
    //     $data["message"] = "";

    //     require app_path().'/classes/PHPMailerAutoload.php';
    //     $mail = new PHPMailer;
    //     $mail->isMail();
    //     $mail->setFrom('info@the-aiff.com', 'All India Football Federation');
    //     $mail->addAddress($user->username);
    //     $mail->isHTML(true);
    //     $mail->Subject = "AIFF - Password Reset";
    //     $mail->Body = View::make('mail',["type" => 2, "username"=>$user->username, "password"=>$password]);
    //     $mail->send();
                
    //     return json_encode($data);
    // }
}