<?php

namespace App\Controllers;

date_default_timezone_set('Asia/Kolkata');
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
        if ($_POST) {
            $validations = $this->validate([
                'issue' => 'required',
                'name' => 'required|regex_match[/^[a-zA-Z0-9\s]+$/]',
                'priority' => 'required',
                'attachment' => 'max_size[attachment,2048]|mime_in[attachment,image/png,image/jpg,image/jpeg]',
                'msg' => 'permit_empty|regex_match[/^[a-zA-Z0-9.,\s]+$/]',
            ]);

            if (!$validations) {
                $validation = \Config\Services::validation();
                $errors = $validation->getErrors();
                $message = ['status' => 'errors', 'data' => 'Validate form', 'errors' => $errors];
                return $this->response->setJSON($message);
            } else {
                $isu = trim($this->request->getPost('issue'));
                $nm = trim($this->request->getPost('name'));
                $prt = trim($this->request->getPost('priority'));
                $atch = $this->request->getFile('attachment');
                $msg = trim($this->request->getPost('msg'));
                $userData = session()->get('username');

                $prefix = "RMH-";
                $tktId = $this->gM->getLastID('raised_tickets', $prefix);

                $path = '';
                if ($atch && $atch->isValid() && !$atch->hasMoved()) {
                    $newFileName = $atch->getRandomName();
                    $atch->move('public/uploads/', $newFileName);
                    $path = 'public/uploads/' . $newFileName;
                }

                $data1 = [
                    'tkt_status' => 'Open',
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                $statusId = $this->gM->insertInto("ticket_status", $data1);

                if ($statusId) {
                    $data = [
                        'tkt_id' => strtoupper($tktId),
                        'issue' => ucwords(esc($isu)),
                        'raised_by' => ucwords(esc($nm)),
                        'priority' => ucwords(esc($prt)),
                        'attachment' => $path,
                        'msg' => esc($msg),
                        'raised_by_dept' => esc($userData),
                        'status_id' => $statusId,
                        'tkt_raised_date' => date('Y-m-d H:i:s'),
                    ];

                    $Q = $this->gM->insertInto("raised_tickets", $data);

                    if ($Q) {
                        $response = ['status' => 'success', 'message' => 'Data Added Successfully!'];
                    } else {
                        $response = ['status' => 'error', 'message' => 'Something went wrong!'];
                    }
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to insert ticket status!'];
                }

                return $this->response->setJSON($response);
            }
        } else {
            $data['services'] = $this->gM->getTableData('service');
            return view('home/dashboard', $data);
        }
    }

    public function raisedTickets()
    {
        try {
            $draw = $_GET['draw'] ?? 1;
            $start = $_GET['start'] ?? 0;
            $length = $_GET['length'] ?? 10;
            $searchValue = $_GET['search']['value'] ?? '';
            $orderColumnIndex = $_GET['order'][0]['column'] ?? 0;
            $orderColumnName = $_GET['columns'][$orderColumnIndex]['data'] ?? 'id';
            $orderDir = $_GET['order'][0]['dir'] ?? 'asc';

            $dt = $this->gM->getRespData('raised_tickets');

            if (!empty($searchValue)) {
                $dt->groupStart()
                    ->orLike('tkt_id', $searchValue)
                    ->orLike('priority', $searchValue)
                    ->groupEnd();
            }

            $dt->orderBy($orderColumnName, $orderDir);

            $data = $dt->get($length, $start)->getResultArray();

            $totalRecords = $this->gM->countData('raised_tickets');
            $totalFilteredRecords = !empty($searchValue) ? $this->gM->countFilteredTckts('raised_tickets', $searchValue) : $totalRecords;

            $associativeArray = array_map(function ($row) {
                if ($row['tkt_status'] === 'Resolved') {
                    $stColor = 'btn btn-outline-success';
                    $btn = 'fas fa-check-circle';
                    $btnColor = 'btn btn-success';
                    $dsb = 'disabled';
                } elseif ($row['tkt_status'] === 'In-Progress') {
                    $stColor = 'btn btn-outline-warning';
                    $btn = 'fas fa-arrow-alt-circle-up';
                    $btnColor = 'btn btn-outline-info';
                    $dsb = '';
                } else {
                    $stColor = 'btn btn-outline-danger';
                    $btn = 'fas fa-arrow-alt-circle-up';
                    $btnColor = 'btn btn-outline-info';
                    $dsb = '';
                }
                return [
                    0 => $row['id'],
                    1 => $row['tkt_id'],
                    2 => $row['service'],
                    3 => $row['raised_by'],
                    4 => $row['priority'],
                    5 => !empty($row['attachment']) ? '<a href="' . base_url($row['attachment']) . '" target="_blank">View Attachment</a>' : '',
                    6 => $row['msg'],
                    7 => '<button class="btn ' . $stColor . '" id="sts" style="width:80px!important;text-align:center!important;font-size:12px!important">' . $row['tkt_status'] . '</button>',
                    8 => date('d-m-Y H:i:s', strtotime($row['tkt_raised_date'])),
                    9 => $row['tkt_closed_date'] == '0000-00-00 00:00:00' ? '' : date('d-m-Y H:i:s', strtotime($row['tkt_closed_date'])),
                    10 => '<button class="' . $btnColor . '" id="edit" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Update Status" ' . $dsb . '><i class="' . $btn . '"></i></button>',

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

    public function getRaisedDatabyDept()
    {
        try {
            $draw = $_GET['draw'] ?? 1;
            $start = $_GET['start'] ?? 0;
            $length = $_GET['length'] ?? 10;
            $searchValue = $_GET['search']['value'] ?? '';
            $orderColumnIndex = $_GET['order'][0]['column'] ?? 0;
            $orderColumnName = $_GET['columns'][$orderColumnIndex]['data'] ?? 'id';
            $orderDir = $_GET['order'][0]['dir'] ?? 'asc';

            $dept = session()->get('username');

            $dt = $this->gM->getRespDeptData('raised_tickets', $dept);

            if (!empty($searchValue)) {
                $dt->groupStart()
                    ->orLike('tkt_id', $searchValue)
                    ->orLike('priority', $searchValue)
                    ->groupEnd();
            }

            $dt->orderBy($orderColumnName, $orderDir);

            $data = $dt->get($length, $start)->getResultArray();

            $totalRecords = $this->gM->countData('raised_tickets');
            $totalFilteredRecords = !empty($searchValue) ? $this->gM->countFilteredTckts('raised_tickets', $searchValue) : $totalRecords;

            $associativeArray = array_map(function ($row) {
                if ($row['tkt_status'] === 'Resolved') {
                    $stColor = 'btn btn-outline-success';
                    $btn = 'fas fa-check-circle';
                    $btnColor = 'btn btn-success';
                    $dsb = 'disabled';
                } elseif ($row['tkt_status'] === 'In-Progress') {
                    $stColor = 'btn btn-outline-warning';
                    $btn = 'fas fa-arrow-alt-circle-up';
                    $btnColor = 'btn btn-outline-info';
                    $dsb = '';
                } else {
                    $stColor = 'btn btn-outline-danger';
                    $btn = 'fas fa-arrow-alt-circle-up';
                    $btnColor = 'btn btn-outline-info';
                    $dsb = '';
                }
                return [
                    0 => $row['id'],
                    1 => $row['tkt_id'],
                    2 => $row['service'],
                    3 => $row['raised_by'],
                    4 => $row['priority'],
                    5 => !empty($row['attachment']) ? '<a href="' . base_url($row['attachment']) . '" target="_blank">View Attachment</a>' : '',
                    6 => $row['msg'],
                    7 => '<button class="btn ' . $stColor . '" id="sts" style="width:80px!important;text-align:center!important;font-size:12px!important">' . $row['tkt_status'] . '</button>',
                    8 => date('d-m-Y H:i:s', strtotime($row['tkt_raised_date'])),
                    9 => $row['tkt_closed_date'] == '0000-00-00 00:00:00' ? '' : date('d-m-Y H:i:s', strtotime($row['tkt_closed_date'])),
                    10 => '<button class="' . $btnColor . '" id="edit" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Update Status" ' . $dsb . '><i class="' . $btn . '"></i></button>',

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

    public function getRaisedData()
    {
        $id = trim($this->request->getPost('id'));
        $q = $this->gM->getRow('raised_tickets', $id);

        if ($q) {
            return $this->response->setJSON(['status' => 'success', 'message' => $q]);
        } else {
            return $this->response->setJSON(['error' => 'error', 'message' => 'Unable to Fetch Data for this Id!']);
        }
    }

    public function updateStatus()
    {
        if ($_POST) {
            $id = trim($this->request->getPost('id'));
            $dt = trim($this->request->getPost('status'));

            $data = array();
            $data['tkt_status'] = esc($dt);
            $data['updated_at'] = date('Y-m-d H:i:s');

            $Q = $this->gM->updateDepartment("ticket_status", $id, $data);

            if ($Q) {
                $data1 = array();
                $data1['tkt_closed_date'] = date('Y-m-d H:i:s');

                $tkt = $this->gM->updateTicket("raised_tickets", $id, $data1);

                if ($tkt) {
                    $response = ['status' => 'success', 'message' => 'Status Updated Successfully!'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Something went wrong!'];
                }

            } else {
                $response = ['status' => 'error', 'message' => 'Something went wrong!'];
            }

            return $this->response->setJSON($response);
        }
    }

}
