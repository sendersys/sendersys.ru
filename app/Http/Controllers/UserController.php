<?php

namespace App\Http\Controllers;


use Auth;
use Input;
use Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\Main_page;


class UserController extends BaseController 
{
	public function signup() {
		if(Auth::check()){
			return redirect()->intended('dashboard');
		}

		 $user = new \App\User;
		 $name = Input::get('email');
		 $password = "password";
		if($name){
			$email = Input::get('email');
			$username = Input::get('username');
			
			$validators = Validator::make(
				[
					'email' => $email,
					'username' => $username,
				],
				[
					'email' => 'required|email|unique:sendersysusers',
					'username' => 'required',
				],
				[
					'required' => 'Вы не заполнили поле :attribute',
					'email' => 'Email быть корректным',
					'unique' => 'Такой :attribute уже используется',
					'min' => 'Поле :attribute должно содержать минимум :min символов',
				] 
			);

			if($validators->fails()) {
				$errorMessage = $validators -> messages();
				$errors = "";
				foreach ($errorMessage-> all() as $messages) {
					$errors .= $messages . " ";
					// dd($errors);
				}
			}
			else {
				$user -> fill(Input::all());

				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			    $charactersLength = strlen($characters);
			    $randomString = '';
			    for ($i = 0; $i < 10; $i++) {
			        $randomString .= $characters[rand(0, $charactersLength - 1)];
			    }

				$user -> $password = $randomString;
				if($user-> signup()){
					$success = "Пользователь успешно зарегистрирован";
					$emailSend = Input::get('email');

					$to  = '<'.$email.'>'; 
					$subject = "Добро пожаловать на Sendersys;"; 
					$message = ' <h3>Ваш пароль</h3>'.$randomString.' </br>';
					$mailheaders = "Content-type: text/html; UTF-8 \r\n";
					$mailheaders .= "From: no-reply@sendersys.ru";
					mail($to, $subject, $message, $mailheaders); 

					return view('main', array('emailSend' => isset($emailSend) ? $emailSend:null));
			 	}
			}

		}
		$main_page = Main_page::where(['active' => 1])->orderBy('updated_at', 'desc')->first();
		return view('main', ['main_page' => $main_page])->with('signup_errors', array(isset($errors) ? $errors:null));

	}
    // use DispatchesJobs, ValidatesRequests;

	public function login() {
		if(Auth::check()){
			return redirect()->intended('dashboard');
		}
		$name = Input::get('email');
		if($name) {
			$email = Input::get('email');
			$password = Input::get('password');
			// $remember = Input::has('remember') ? true : false; 

			$validators = Validator::make(
				[
					'email' => $email,
					'пароль' => $password,
				],
				[
					'email' => 'required|email',
					'пароль' => 'required',
				],
				[
					'required' => 'Вы не заполнили поле :attribute',
					'email' => 'Email должен быть корректным',
				] 
			);

			if($validators->fails()) {
				$errorMessage = $validators -> messages();
				$errors = "";
				foreach ($errorMessage-> all() as $messages) {
					$errors .= $messages . "\n" . nl2br("\n");
				}
			}
			else {
				if(Auth::attempt(['email' => $email, 'password' => $password]/*, $remember*/)){
					return redirect()->intended('dashboard');
				}
				else {
					$errors = "Произошла ошибка аутентификации";
				}
		 	}
		}
	$main_page = Main_page::where(['active' => 1])->orderBy('updated_at', 'desc')->first();
	return view('main', ['main_page' => $main_page])->with('login_errors', array(isset($errors) ? $errors:null));

	}

	public function main() {
		$main_page = Main_page::where(['active' => 1])->orderBy('updated_at', 'desc')->first();
		return View('main', ['main_page' => $main_page]);
	}

	public function email() {
		return View('email');
	}
}
