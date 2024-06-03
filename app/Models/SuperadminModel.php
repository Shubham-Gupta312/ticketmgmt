<?php

namespace App\Models;

use CodeIgniter\Model;

class SuperadminModel extends Model
{
    protected $table = 'superadmin';
    protected $primaryKey = 'id';
    protected $protectFields = [];

    public function getTableData($table)
    {
        return $this->db->table($table)
            ->select('raised_tickets.*, service.service AS issue, ticket_status.tkt_status AS status_id')
            ->join('service', 'service.id = raised_tickets.issue', 'left')
            ->join('ticket_status', 'ticket_status.id = raised_tickets.status_id', 'left')
            ->get()
            ->getResultArray();
    }
}