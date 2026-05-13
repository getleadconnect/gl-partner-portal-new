<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\PaymentHistory;
use App\Models\Lead;

use Carbon\Carbon;

class paymentHistoryExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = is_array($filters) ? $filters : [];
    }

    public function headings(): array
    {
        return [
            'Partner',
            'Lead',
            'Payment Date',
            'Paid Amount',
            'Payment Id',
            'Status',
        ];
    }

    public function collection()
    {
        $partnerId = $this->filters['partner_id'] ?? '';
        $dateFrom  = $this->filters['date_from']  ?? '';
        $dateTo    = $this->filters['date_to']    ?? '';

        $rows = PaymentHistory::select(
                'payment_histories.*',
                'leads.name as lead_name',
                'leads.mobile',
                'leads.country_code',
                'partners.name as partner_name'
            )
            ->leftJoin('leads',    'payment_histories.lead_id',    '=', 'leads.id')
            ->leftJoin('partners', 'payment_histories.partner_id', '=', 'partners.id')
            ->when($partnerId !== '' && $partnerId !== null && $partnerId != 0, function ($q) use ($partnerId) {
                $q->where('payment_histories.partner_id', $partnerId);
            })
            ->when(!empty($dateFrom), function ($q) use ($dateFrom) {
                $q->whereDate('payment_histories.payment_date', '>=', $dateFrom);
            })
            ->when(!empty($dateTo), function ($q) use ($dateTo) {
                $q->whereDate('payment_histories.payment_date', '<=', $dateTo);
            })
            ->orderBy('payment_histories.payment_date', 'DESC')
            ->get()
            ->map(function ($q) {
                if ($q->multiple_leads != null) {
                    $ids = explode(',', $q->multiple_leads);
                    $names = Lead::whereIn('id', $ids)->pluck('name')->toArray();
                    $q->lead_name = implode(', ', $names);
                    $q->mobile    = '';
                }
                return $q;
            });

        return $rows->map(function ($r) {
            $pdate = $r->payment_date
                ? Carbon::createFromFormat('Y-m-d', $r->payment_date)->format('d-m-Y')
                : '';

            return [
                $r->partner_name ?: '—',
                $r->lead_name,
                $pdate,
                (int) $r->paid_amount,
                $r->payment_id,
                'Paid',
            ];
        });
    }
}
