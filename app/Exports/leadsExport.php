<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\Lead;

use Carbon\Carbon;

class leadsExport implements FromCollection, WithHeadings
{
    protected $status;
    protected $partner;
    protected $payStatus;
    protected $age;

    public function __construct($status = null, $partner = null, $payStatus = null, $age = null)
    {
        $this->status    = $status;
        $this->partner   = $partner;
        $this->payStatus = $payStatus;
        $this->age       = $age;
    }

    public function headings(): array
    {
        return [
            'Lead',
            'Email',
            'Mobile',
            'Company',
            'Partner',
            'Days in Stage',
            'Deal Value',
            'Lead Status',
            'Payment',
            'Created At',
        ];
    }

    public function collection()
    {
        $status    = ($this->status    === 'All') ? '' : (string) $this->status;
        $partner   = ($this->partner   === 'All') ? '' : (string) $this->partner;
        $payStatus = ($this->payStatus === 'All') ? '' : (string) $this->payStatus;
        $age       = (string) $this->age;
        $now       = Carbon::now();

        $query = Lead::leftJoin('partners', 'leads.partner_id', '=', 'partners.id')
            ->select(
                'leads.id',
                'leads.name',
                'leads.email',
                'leads.country_code',
                'leads.mobile',
                'leads.company_name',
                'leads.lead_status',
                'leads.payment_status',
                'leads.amount_collected',
                'leads.created_at',
                'partners.name as partner_name'
            );

        if ($status   !== '') $query->where('leads.lead_status', $status);
        if ($partner  !== '') $query->where('leads.partner_id', $partner);
        if ($payStatus !== '') $query->where('leads.payment_status', $payStatus);
        if ($age === 'stale')  $query->where('leads.created_at', '<', $now->copy()->subDays(7));
        if ($age === 'cold')   $query->where('leads.created_at', '<', $now->copy()->subDays(14));

        $rows = $query->orderBy('leads.created_at', 'DESC')->get();

        return $rows->map(function ($r) use ($now) {
            $mobile = ($r->country_code ? '+'.$r->country_code.' ' : '').$r->mobile;
            $days   = $r->created_at ? $now->diffInDays(Carbon::parse($r->created_at)).' days' : '—';
            $deal   = $r->amount_collected ? (int) $r->amount_collected : '';

            switch ((int) $r->payment_status) {
                case 1:  $pay = 'Paid'; break;
                case 2:  $pay = 'Pending'; break;
                default: $pay = 'Not Paid';
            }

            return [
                $r->name,
                $r->email,
                $mobile,
                $r->company_name,
                $r->partner_name ?: '—',
                $days,
                $deal,
                $r->lead_status,
                $pay,
                $r->created_at ? Carbon::parse($r->created_at)->format('Y-m-d H:i') : '',
            ];
        });
    }
}
