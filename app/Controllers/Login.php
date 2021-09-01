<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{
	public function login()
	{
		$login	  = $this->request->getPost('login');
		$password = $this->request->getPost('password');
		$session  = session();

		if ($login === 'admin' && $password === 'YfabuJyYfvYflj2020')
		{
			$session->set('admin', true);
			return $this->response->setJSON([
				'ok' => 'ok',
			]);
		}
		$session->set('admin', false);
		return $this->response->setJSON([
			'ok' => 'fail',
		]);
	}

	public function isLogin() {
		$session = session();
		
		return $this->response->setJSON([
			'login' => $session->admin
		]);
	}
}