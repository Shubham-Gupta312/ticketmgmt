<?php

namespace App\Controllers;

date_default_timezone_set('Asia/Kolkata');
use App\Libraries\EncPass;

class Superadmin extends BaseController
{
    public function __construct()
    {
        $this->gM = Model("GeneralModel");
    }
    public function register()
    {
        if ($_POST) {
            $validation = $this->validate([
                'username' => 'required|regex_match[/^[a-zA-Z0-9\s]+$/]',
                'password' => 'required|min_length[5]|max_length[15]',
                'cpassword' => 'required|min_length[5]|max_length[15]|matches[password]'
            ]);
            if (!$validation) {
                $validation = \Config\Services::validation();
                $errors = $validation->getErrors();
                $message = ['status' => 'error', 'data' => 'Validate form', 'errors' => $errors];
                return $this->response->setJSON($message);
            } else {
                $un = trim($this->request->getPost('username'));
                $ps = trim($this->request->getPost('password'));

                $data = [
                    'username' => esc($un),
                    'password' => EncPass::pass_enc($ps),
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $athMdl = new \App\Models\SuperadminModel();
                try {
                    $query = $athMdl->insert($data);

                    if ($query) {
                        $response = ['status' => 'success', 'message' => 'SuperAdmin Register Successfully!'];
                    } else {
                        $response = ['status' => 'error', 'message' => 'Something went wrong!'];
                    }
                    return $this->response->setJSON($response);
                } catch (\Exception $e) {
                    $response = ['status' => 'false', 'message' => 'An unexpected error occurred. Please try again later.'];
                    return $this->response->setStatusCode(500)->setJSON($response);
                }
            }
        } else {
            return view('superadmin/register');
        }
    }

    public function login()
    {
        if ($_POST) {
            $validation = $this->validate([
                'username' => 'required|regex_match[/^[a-zA-Z0-9\s]+$/]',
                'password' => 'required|min_length[5]|max_length[15]',
            ]);
            if (!$validation) {
                $validation = \Config\Services::validation();
                $errors = $validation->getErrors();
                $message = ['status' => 'errors', 'data' => 'Validate form', 'errors' => $errors];
                return $this->response->setJSON($message);
            } else {
                $un = trim($this->request->getPost('username'));
                $ps = trim($this->request->getPost('password'));

                $adminModel = new \App\Models\SuperadminModel();

                $userData = $adminModel->where('username', esc($un))->first();

                if (is_null($userData)) {
                    $response = ['status' => 'false', 'message' => 'Username Not Found!'];
                    return $this->response->setJSON($response);
                }

                $verifyPass = EncPass::pass_dec(esc($ps), $userData['password']);
                if (!$verifyPass) {
                    $response = ['status' => 'error', 'message' => 'You Entered wrong Password!'];
                } else {
                    if (!is_null($userData)) {
                        $sessionData = [
                            'username' => $userData['username'],
                            'loggedin' => 'adminloggedin'
                        ];
                        session()->set($sessionData);
                    }
                    $response = ['status' => 'success', 'message' => 'Logged-In Succesfully!'];
                }
                return $this->response->setJSON($response);
            }
        } else {
            return view('superadmin/login');
        }
    }

    public function logout()
    {
        session_unset();
        session()->destroy();
        return redirect()->to(base_url('superadmin/login'));
    }

    public function addDepartment()
    {
        if ($_POST) {
            $validation = $this->validate([
                'dept' => 'required|regex_match[/^[a-zA-Z0-9\s]+$/]',
                'dept_user' => 'required|regex_match[/^[a-zA-Z0-9\s]+$/]',
                'dept_pass' => 'required'
            ]);
            if (!$validation) {
                $validation = \Config\Services::validation();
                $errors = $validation->getErrors();
                $message = ['status' => 'error', 'data' => 'Validate form', 'errors' => $errors];
                return $this->response->setJSON($message);
            } else {
                $dpt = trim($this->request->getPost('dept'));
                $dpt_usr = trim($this->request->getPost('dept_user'));
                $dpt_pas = trim($this->request->getPost('dept_pass'));

                $data = array();
                $data['dept_name'] = ucwords(esc($dpt));
                $data['dept_username'] = esc($dpt_usr);
                $data['dept_pass'] = EncPass::pass_enc($dpt_pas);
                $data['created_at'] = date('Y-m-d H:i:s');

                $Q = $this->gM->insertInto("department", $data);
                if ($Q) {
                    $response = ['status' => 'success', 'message' => 'Department Added Successfully!'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Something went wrong!'];
                }
                return $this->response->setJSON($response);
            }
        } else {
            return view('superadmin/addDepartment');
        }
    }

    public function fetchData()
    {
        try {
            $draw = $_GET['draw'] ?? 1;
            $start = $_GET['start'] ?? 0;
            $length = $_GET['length'] ?? 10;
            $searchValue = $_GET['search']['value'] ?? '';
            $orderColumnIndex = $_GET['order'][0]['column'] ?? 0;
            $orderColumnName = $_GET['columns'][$orderColumnIndex]['data'] ?? 'id';
            $orderDir = $_GET['order'][0]['dir'] ?? 'asc';

            $dt = $this->gM->getResp('department');

            if (!empty($searchValue)) {
                $dt->groupStart()
                    ->orLike('dept_name', $searchValue)
                    ->orLike('dept_username', $searchValue)
                    ->groupEnd();
            }

            $dt->orderBy($orderColumnName, $orderDir);

            $data = $dt->get($length, $start)->getResultArray();

            $totalRecords = $this->gM->countData('department');
            $totalFilteredRecords = !empty($searchValue) ? $this->gM->countFilteredData('department', $searchValue) : $totalRecords;

            $associativeArray = array_map(function ($row) {
                $status = $row['is_active'];
                $statusText = ($status == 1) ? 'active' : 'deactive';
                if ($status == 0) {
                    $buttonCSSClass = 'btn-outline-danger';
                    $buttonName = 'far fa-times-circle';
                } elseif ($status == 1) {
                    $buttonCSSClass = 'btn-outline-success';
                    $buttonName = 'fas fa-check-circle';
                }
                return [
                    0 => $row['id'],
                    1 => $row['dept_name'],
                    2 => ucfirst($row['dept_username']),
                    3 => '<button class="btn btn-outline-info" id="edit" data-bs-toggle="modal" data-bs-target="#editModal" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn ' . $buttonCSSClass . '" id="actv" data-status="' . $statusText . '" title="' . ucwords($statusText) . '"><i class="' . $buttonName . '"></i></button>
                    <button class="btn btn-outline-danger" id="dlt" title="Delete"><i class="fas fa-trash-alt"></i></button>'
                ];
            }, $data);

            $output = [
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalFilteredRecords,
                'data' => $associativeArray
            ];

            return $this->response->setJSON($output);

        } catch (\Exception $e) {
            // Handle exception if something goes wrong
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function togglestatus()
    {
        $id = $this->request->getPost('id');
        $sts = $this->request->getPost('status');

        if ($sts == 'active') {
            $status = '0';
        } else {
            $status = '1';
        }

        $res = $this->gM->updateStatus('department', $id, $status);
        if ($res) {
            return $this->response->setJSON(['status' => $status]);
        } else {
            return $this->response->setJSON(['error' => 'Something went wrong!']);
        }
    }

    public function deleteDepartment()
    {
        $id = $this->request->getPost('id');

        $res = $this->gM->deleteData('department', $id);
        if ($res) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['error' => 'error']);
        }
    }

    public function edata()
    {
        $id = $this->request->getPost('id');
        $q = $this->gM->getRow('department', $id);

        if ($q) {
            return $this->response->setJSON(['status' => 'success', 'message' => $q]);
        } else {
            return $this->response->setJSON(['error' => 'error', 'message' => 'Unable to Fetch Data for this Id!']);
        }
    }

    public function updateData()
    {
        $validation = $this->validate([
            'edept' => 'required|regex_match[/^[a-zA-Z0-9\s]+$/]',
            'edept_user' => 'required|regex_match[/^[a-zA-Z0-9\s]+$/]',
            'edept_pass' => 'permit_empty'
        ]);
        if (!$validation) {
            $validation = \Config\Services::validation();
            $errors = $validation->getErrors();
            $message = ['status' => 'error', 'data' => 'Validate form', 'errors' => $errors];
            return $this->response->setJSON($message);
        } else {
            $id = trim($this->request->getPost('id'));
            $dt = trim($this->request->getPost('edept'));
            $dptusr = trim($this->request->getPost('edept_user'));
            $dpt_pss = trim($this->request->getPost('edept_pass'));

            $data = array();
            $data['dept_name'] = ucwords(esc($dt));
            $data['dept_username'] = esc($dptusr);
            $data['updated_at'] = date('Y-m-d H:i:s');

            if (!empty($dpt_pss)) {
                $data['dept_pass'] = EncPass::pass_enc($dpt_pss);
            }

            $Q = $this->gM->updateDepartment("department", $id, $data);
            if ($Q) {
                $response = ['status' => 'success', 'message' => 'Department Data Updated Successfully!'];
            } else {
                $response = ['status' => 'error', 'message' => 'Something went wrong!'];
            }
            return $this->response->setJSON($response);
        }
    }

    public function addService()
    {
        if ($_POST) {
            $validation = $this->validate([
                'srvc' => 'required|regex_match[/^[a-zA-Z0-9\s]+$/]',
                'dept' => 'required',
            ]);
            if (!$validation) {
                $validation = \Config\Services::validation();
                $errors = $validation->getErrors();
                $message = ['status' => 'error', 'data' => 'Validate form', 'errors' => $errors];
                return $this->response->setJSON($message);
            } else {
                $srvc = trim($this->request->getPost('srvc'));
                $dpt = trim($this->request->getPost('dept'));

                $data = array();
                $data['service'] = ucwords(esc($srvc));
                $data['department'] = esc($dpt);
                $data['created_at'] = date('Y-m-d H:i:s');

                $Q = $this->gM->insertInto("service", $data);
                if ($Q) {
                    $response = ['status' => 'success', 'message' => 'Services Added Successfully!'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Something went wrong!'];
                }
                return $this->response->setJSON($response);
            }
        } else {
            $data['dept'] = $this->gM->getTableData('department');
            return view('superadmin/addService', $data);
        }
    }

    public function servicedata()
    {
        try {
            $draw = $_GET['draw'] ?? 1;
            $start = $_GET['start'] ?? 0;
            $length = $_GET['length'] ?? 10;
            $searchValue = $_GET['search']['value'] ?? '';
            $orderColumnIndex = $_GET['order'][0]['column'] ?? 0;
            $orderColumnName = $_GET['columns'][$orderColumnIndex]['data'] ?? 'id';
            $orderDir = $_GET['order'][0]['dir'] ?? 'asc';

            $dt = $this->gM->getResp('service');

            if (!empty($searchValue)) {
                $dt->groupStart()
                    ->orLike('service', $searchValue)
                    ->groupEnd();
            }

            $dt->orderBy($orderColumnName, $orderDir);

            $data = $dt->get($length, $start)->getResultArray();

            $totalRecords = $this->gM->countData('service');
            $totalFilteredRecords = !empty($searchValue) ? $this->gM->countFilteredserviceData('service', $searchValue) : $totalRecords;

            $associativeArray = array_map(function ($row) {
                $status = $row['is_active'];
                $statusText = ($status == 1) ? 'active' : 'deactive';
                if ($status == 0) {
                    $buttonCSSClass = 'btn-outline-danger';
                    $buttonName = 'far fa-times-circle';
                } elseif ($status == 1) {
                    $buttonCSSClass = 'btn-outline-success';
                    $buttonName = 'fas fa-check-circle';
                }
                return [
                    0 => $row['id'],
                    1 => $row['service'],
                    2 => '<button class="btn btn-outline-info" id="edit" data-bs-toggle="modal" data-bs-target="#editModal" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn ' . $buttonCSSClass . '" id="actv" data-status="' . $statusText . '" title="' . ucwords($statusText) . '"><i class="' . $buttonName . '"></i></button>
                    <button class="btn btn-outline-danger" id="dlt" title="Delete"><i class="fas fa-trash-alt"></i></button>'
                ];
            }, $data);

            $output = [
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalFilteredRecords,
                'data' => $associativeArray
            ];

            return $this->response->setJSON($output);

        } catch (\Exception $e) {
            // Handle exception if something goes wrong
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function deleteService()
    {
        $id = $this->request->getPost('id');

        $res = $this->gM->deleteData('service', $id);
        if ($res) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['error' => 'error']);
        }
    }

    public function servicetogglestatus()
    {
        $id = $this->request->getPost('id');
        $sts = $this->request->getPost('status');

        if ($sts == 'active') {
            $status = '0';
        } else {
            $status = '1';
        }

        $res = $this->gM->updateStatus('service', $id, $status);
        if ($res) {
            return $this->response->setJSON(['status' => $status]);
        } else {
            return $this->response->setJSON(['error' => 'Something went wrong!']);
        }
    }

    public function eservicedata()
    {
        $id = $this->request->getPost('id');
        $q = $this->gM->getRow('service', $id);

        if ($q) {
            return $this->response->setJSON(['status' => 'success', 'message' => $q]);
        } else {
            return $this->response->setJSON(['error' => 'error', 'message' => 'Unable to Fetch Data for this Id!']);
        }
    }

    public function updateServiceData()
    {
        $validation = $this->validate([
            'esrvc' => 'required|regex_match[/^[a-zA-Z0-9\s]+$/]',
            'edept' => 'required',
        ]);
        if (!$validation) {
            $validation = \Config\Services::validation();
            $errors = $validation->getErrors();
            $message = ['status' => 'error', 'data' => 'Validate form', 'errors' => $errors];
            return $this->response->setJSON($message);
        } else {
            $id = trim($this->request->getPost('id'));
            $esrvc = trim($this->request->getPost('esrvc'));
            $edpt = trim($this->request->getPost('edept'));

            $data = array();
            $data['service'] = ucwords(esc($esrvc));
            $data['department'] = esc($edpt);
            $data['updated_at'] = date('Y-m-d H:i:s');

            $Q = $this->gM->updateDepartment("service", $id, $data);
            if ($Q) {
                $response = ['status' => 'success', 'message' => 'Service Data Updated Successfully!'];
            } else {
                $response = ['status' => 'error', 'message' => 'Something went wrong!'];
            }
            return $this->response->setJSON($response);
        }
    }
}
