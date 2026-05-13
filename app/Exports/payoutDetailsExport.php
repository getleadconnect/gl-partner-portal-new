<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\LeadCommission;

use Carbon\Carbon;

class payoutDetailsExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = is_array($filters) ? $filters : [];
    }

    public function headings(): array
    {
        return [
            'Lead',
            'Mobile',
            'Partner',
            'Type',
            'Amount Collected',
            'Commission',
            'Paid',
            'Balance',
            'Payment Status',
            'Updated Date',
        ];
    }

    public function collection()
    {
        $partnerId    = $this->filters['partner_id']    ?? '';
        $statusFilter = $this->filters['status_filter'] ?? '';
        $dateFrom     = $this->filters['date_from']     ?? '';
        $dateTo       = $this->filters['date_to']       ?? '';

        $rows = LeadCommission::select(
                'lead_commissions.*',
                'leads.name as lead_name',
                'leads.mobile',
                'leads.country_code',
                'partners.name as partner_name'
            )
            ->leftJoin('leads',    'lead_commissions.lead_id',     '=', 'leads.id')
            ->leftJoin('partners', 'lead_commissions.partner_id',  '=', 'partners.id')
            ->when($partnerId !== '' && $partnerId !== null, function ($q) use ($partnerId) {
                $q->where('lead_commissions.partner_id', $partnerId);
            })
            ->when($statusFilter === 'paid', function ($q) {
                $q->where('lead_commissions.payment_status', 1);
            })
            ->when($statusFilter === 'unpaid', function ($q) {
                $q->where('lead_commissions.payment_status', '!=', 1);
            })
            ->when(!empty($dateFrom), function ($q) use ($dateFrom) {
                $q->whereDate('lead_commissions.updated_at', '>=', $dateFrom);
            })
            ->when(!empty($dateTo), function ($q) use ($dateTo) {
                $q->whereDate('lead_commissions.updated_at', '<=', $dateTo);
            })
            ->orderBy('lead_commissions.updated_at', 'DESC')
            ->get();

        return $rows->map(function ($r) {
            $mobile = ($r->country_code ? '+'.$r->country_code.' ' : '').$r->mobile;
            $type   = (strtolower((string) $r->renewal_status) === 'renewal') ? 'R (Renewal)' : 'I (First)';
            $pay    = ((int) $r->payment_status === 1) ? 'Paid' : 'Not Paid';

            return [
                $r->lead_name,
                $mobile,
                $r->partner_name ?: '—',
                $type,
                (int) $r->amount_collected,
                (int) $r->commission_amount,
                (int) $r->paid_amount,
                (int) $r->balance,
                $pay,
                $r->updated_at ? Carbon::parse($r->updated_at)->format('Y-m-d H:i') : '',
            ];
        });
    }
}
