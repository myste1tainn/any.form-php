<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

trait AuthAndRegiseterOverriden {

	// Overrideen to use username instead
	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'username' => 'required|username', 'password' => 'required',
		]);

		$credentials = $request->only('username', 'password');

		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
			return redirect()->intended($this->redirectPath());
		}

		return redirect($this->loginPath())
					->withInput($request->only('username', 'remember'))
					->withErrors([
						'username' => $this->getFailedLoginMessage(),
					]);
	}

}
