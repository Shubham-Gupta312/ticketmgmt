<?php
namespace App\Models;

use CodeIgniter\Model;

class GeneralModel extends Model
{
    protected $db;
    public function __construct()
    {
        $this->db = db_connect();
    }
    function insertInto($table, $data)
    {
        $builder = $this->db->table($table);
        $builder->insert($data);
        return $this->db->insertID();
    }

    function getResp($table)
    {
        return $this->db->table($table);
    }
    function getRespData($table)
    {
        return $this->db->table($table)
            ->select('raised_tickets.*, service.service, ticket_status.tkt_status AS tkt_status')
            ->join('service', 'service.id = raised_tickets.issue', 'left')
            ->join('ticket_status', 'ticket_status.id = raised_tickets.status_id', 'left');
    }
    function getRespDeptData($table, $dept = null)
    {
        $query = $this->db->table($table)
            ->select('raised_tickets.*, service.service, ticket_status.tkt_status AS tkt_status')
            ->join('service', 'service.id = raised_tickets.issue', 'left')
            ->join('ticket_status', 'ticket_status.id = raised_tickets.status_id', 'left');

        if ($dept) {
            $query->where('raised_tickets.raised_by_dept', $dept);
        }

        return $query;
    }

    function countData($table)
    {
        return $this->db->table($table)->countAllResults();
    }
    function countDeptData($table, $where)
    {
        return $this->db->table($table)->where('raised_by_dept', $where)->countAllResults();
    }

    function countFilteredData($table, $searchValue)
    {
        $builder = $this->db->table($table);
        $builder->groupStart()
            ->orLike('dept_name', $searchValue)
            ->orLike('dept_username', $searchValue)
            ->groupEnd();
        return $builder->countAllResults();
    }
    function countFilteredserviceData($table, $searchValue)
    {
        $builder = $this->db->table($table);
        $builder->groupStart()
            ->orLike('service', $searchValue)
            ->groupEnd();
        return $builder->countAllResults();
    }
    function countFilteredTckts($table, $searchValue)
    {
        $builder = $this->db->table($table);
        $builder->groupStart()
            ->orLike('tkt_id', $searchValue)
            ->orLike('priority', $searchValue)
            ->groupEnd();
        return $builder->countAllResults();
    }

    function updateStatus($table, $where, $status)
    {
        $builder = $this->db->table($table);
        $builder->set('is_active', $status);
        $builder->where('id', esc($where));

        return $builder->update();
    }

    function deleteData($table, $where)
    {
        $builder = $this->db->table($table);
        $builder->where('id', esc($where));
        return $builder->delete();
    }

    function getRow($table, $where)
    {
        $builder = $this->db->table($table);
        $builder->where('id', esc($where));
        $query = $builder->get();

        return $query->getRowArray();
    }

    function updateDepartment($table, $where, $data)
    {
        $builder = $this->db->table($table);
        $builder->where('id', esc($where));
        return $builder->update($data);
    }

    function getData($table, $where)
    {
        $table = esc($table);
        $where = esc($where);

        $builder = $this->db->table($table);
        $builder->where('dept_username', $where);
        $q = $builder->get();

        return $q->getRowArray();
    }

    function getTableData($table)
    {
        $builder = $this->db->table($table);
        return $builder->where('is_active', 1)->get()->getResult();
    }

    public function getLastID($table, $prefix)
    {
        $builder = $this->db->table($table);
        $builder->select('MAX(tkt_id) as max_id');
        $builder->like('tkt_id', $prefix, 'after');
        $query = $builder->get();
        $lastId = $query->getRow()->max_id;

        if ($lastId) {
            $lastNumber = (int) str_replace($prefix, '', $lastId);
            $newNumber = $lastNumber + 1;
            return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        } else {
            return $prefix . "0001";
        }
    }

    function updateTicket($table, $where, $data)
    {
        $builder = $this->db->table($table);
        $builder->where('status_id', esc($where));
        return $builder->update($data);
    }

    function getNotificationData($table)
    {
        $query = $this->db->table($table)
            ->select('notification.*, raised_tickets.*')
            ->join('raised_tickets', 'raised_tickets.id = notification.ticket_id', 'left')
            ->where('is_notified', '0')
            ->get();

        return $query->getResult();
    }

    function updateNotificationStatus($table, $where, $data)
    {
        $builder = $this->db->table($table);
        $builder->where('ticket_id', esc($where));
        return $builder->update($data);
    }

    function getAllTkts($table)
    {
        $builder = $this->db->table($table);
        return $builder->countAll();
    }

    function countTodayTkts($table, $where)
    {
        $builder = $this->db->table($table);
        $builder->where('DATE(tkt_raised_date)', $where);
        return $builder->countAllResults();
    }
    function countPendingTkts($table, $statusTable)
    {
        $builder = $this->db->table($table);
        $builder->join($statusTable, "$table.status_id = $statusTable.id");
        $builder->where("$statusTable.tkt_status", 'In-Progress');
        return $builder->countAllResults(); 
    }
    function countResolvedTkts($table, $statusTable)
    {
        $builder = $this->db->table($table);
        $builder->join($statusTable, "$table.status_id = $statusTable.id");
        $builder->where("$statusTable.tkt_status", 'Resolved');
        return $builder->countAllResults(); 
    }



}