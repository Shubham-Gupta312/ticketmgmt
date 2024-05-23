<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IsLogin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $loggedin = session()->get('loggedin');

        if ($loggedin !== 'authloggedin' && $loggedin !== 'adminloggedin') {
            return redirect()->to(base_url('home/ticket_login'));
        }

        $currentPath = $request->getUri()->getPath();

        if ($loggedin === 'authloggedin' && str_contains($currentPath, 'superadmin/login')) {
            return redirect()->to(base_url('home/ticket_login'));
        }

        if ($loggedin === 'adminloggedin' && str_contains($currentPath, 'home/ticket_login')) {
            return redirect()->to(base_url('superadmin/login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
