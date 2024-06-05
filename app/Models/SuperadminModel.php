<?php

namespace App\Models;

use CodeIgniter\Model;

class SuperadminModel extends Model
{
    protected $table = 'superadmin';
    protected $primaryKey = 'id';
    protected $protectFields = [];

    public function getFilteredTableData($table, $dept = null, $priority = null, $status = null, $from = null, $to = null)
    {
        $builder = $this->db->table($table)
            ->select('raised_tickets.*, service.service AS issue, ticket_status.tkt_status AS status_id')
            ->join('service', 'service.id = raised_tickets.issue', 'left')
            ->join('ticket_status', 'ticket_status.id = raised_tickets.status_id', 'left');

        if ($dept) {
            $builder->where('raised_tickets.raised_by_dept', $dept);
        }
        if ($priority) {
            $builder->where('raised_tickets.priority', $priority);
        }
        if ($status) {
            $builder->where('ticket_status.tkt_status', $status);
        }
        if ($from) {
            $builder->where('raised_tickets.tkt_raised_date >=', $from . ' 00:00:00');
        }
        if ($to) {
            $builder->where('raised_tickets.tkt_closed_date <=', $to . ' 23:59:59');
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

}