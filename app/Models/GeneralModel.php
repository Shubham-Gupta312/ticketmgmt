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

    function countData($table)
    {
        return $this->db->table($table)->countAllResults();
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
}