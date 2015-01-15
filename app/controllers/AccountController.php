<?php
	
	class AccountController extends BaseController {

		public function getIndex()
		{
			return View::make('account.index');
		}

		public function getSignup()
		{
			return View::make('account.signup');
		}

		public function postSignup()
		{
			$input = Input::only(array('email', 'password'));

			$rules = array(
				'email' => 'required|unique:users,email',
				'password' => 'required|min:6'
			);

			$v = Validator::make($input, $rules);

			if($v->fails())
			{
				return Redirect::route('account.signup')
								->withErrors($v->errors())
								->withInput();
			}

			$email = Input::get('email');
			$password = Input::get('password');

			$errors = new Illuminate\Support\MessageBag;
			
			try
			{
			    // Create the user
			    $user = Sentry::createUser(array(
			        'email'     => $email,
			        'password'  => $password,
			        'activated' => true,
			    ));

			    // Find the group using the group name
			    $userGroup = Sentry::findGroupByName('users');

			    // Assign the group to the user
			    $user->addGroup($userGroup);

			    return Redirect::route('account');
			}
			catch (Exception $e)
			{
				$errors->add('error', $e->getMessage());
			}

			return Redirect::route('account.signup')->withErrors($errors)->withInput();
		}

		public function getLogin()
		{
			return View::make('account.login');
		}

		public function postLogin()
		{
			$input = Input::only(array('email', 'password'));

			$rules = array(
				'email' => 'required|email',
				'password' => 'required'
			);

			$v = Validator::make($input, $rules);

			if($v->fails())
			{
				return Redirect::route('account.login')->withErrors($v->errors())->withInput();
			}

			$errors = new Illuminate\Support\MessageBag;

			try
			{
				$credentials = array(
					'email' => array_get($input, 'email'),
					'password' => array_get($input, 'password')
				);

				$user = Sentry::authenticate($credentials);

				return Redirect::route('account');
			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
				$errors->add('error', 'User not found with those credentials.');
			}
			catch (Exception $e)
			{
				$errors->add('error', $e->getMessage());
			}

			return Redirect::route('account.login')->withErrors($errors)->withInput();
		}
	}