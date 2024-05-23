<?php

namespace App\Controllers;

use App\Libraries\EncPass;

class Home extends BaseController
{
    public function __construct()
    {
        $this->gM = Model("GeneralModel");
    }
    public function index(): string
    {
        return view('superadmin/welcome_message');
    }

    public function ticket_login()
    {
        if ($_POST) {
            $validation = $this->validate([
                'username' => 'required|regex_match[/^[a-zA-Z0-9\s]+$/]',
                'password' => 'required|min_length[5]|max_length[30]',
            ]);
            if (!$validation) {
                $validation = \Config\Services::validation();
                $errors = $validation->getErrors();
                $message = ['status' => 'errors', 'data' => 'Validate form', 'errors' => $errors];
                return $this->response->setJSON($message);
            } else {
                $un = trim($this->request->getPost('username'));
                $ps = trim($this->request->getPost('password'));

                $md = $this->gM->getData('department', $un);

                if (is_null($md)) {
                    $response = ['status' => 'false', 'message' => 'Username Not Found!'];
                    return $this->response->setJSON($response);
                }

                $verifyPass = EncPass::pass_dec(esc($ps), $md['dept_pass']);
                if (!$verifyPass) {
                    $response = ['status' => 'error', 'message' => 'You Entered wrong Password!'];
                } else {
                    if (!is_null($md)) {
                        $sessionData = [
                            'username' => $md['dept_username'],
                            'loggedin' => 'authloggedin'
                        ];
                        session()->set($sessionData);
                    }
                    $response = ['status' => 'success', 'message' => 'Logged-In Succesfully!'];
                }
                return $this->response->setJSON($response);
            }
        } else {
            return view('home/ticketlogin');
            // echo 1;
        }
    }

    public function signout()
    {
        session_unset();
        session()->destroy();
        return redirect()->to(base_url('home/ticket_login'));
    }

    public function dashboard()
    {
        $data['services'] = $this->gM->getTableData('service');
        return view('home/dashboard', $data);
    }

}
