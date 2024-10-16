<?php namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Login extends BaseController
{
    public function login()
    {
        helper(['form', 'url']);
        
        $data = [];
        
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'username' => 'required',
                'password' => 'required'
            ];
            
            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $u = $this->request->getPost('username');
                $p = $this->request->getPost('password');

                $model = new UsuarioModel();
                $user = $model->where('susuarionrodoc', $u)->first();  
                if ($user && password_verify($p, $user['susuariopassword'])) {
                    session()->set('logged_in', true);
                    session()->set('user_id', $user['susuarionrodoc']);
                    session()->set('username', $user['susuarionombre']);
                    return redirect()->to(base_url('reserva'));
                } else {
                    $data['error'] = 'Usuario o contraseña incorrectos.';
                }
            }
        }        
        return view('login/login', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    public function index()
    {
        echo view('login/login');
    }
}