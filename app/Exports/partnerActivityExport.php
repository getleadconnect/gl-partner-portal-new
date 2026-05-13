<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\Partner;
use App\Models\Lead;

use Carbon\Carbon;

class partnerActivityExport implements FromCollection, WithHeadings
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
            'Email',
            'Unique ID',
            'Mobile',
            'Status',
            'Latest Lead',
            'Company',
            'Last Activity',
            'Lead Status',
        ];
    }

    public function collection()
    {
        $dateFrom  = $this->filters['date_from']  ?? '';
        $dateTo    = $this->filters['date_to']    ?? '';
        $partnerId = $this->filters['partner_id'] ?? '';

        $partners = Partner::select(
                'partners.id',
                'partners.unique_id',
                'partners.name',
                'partners.email',
                'partners.country_code',
                'partners.mobile',
                'partners.company_name',
                'partners.status'
            )
            ->where('status', 1)
            ->when($partnerId !== '' && $partnerId !== null, function ($q) use ($partnerId) {
                $q->where('partners.id', $partnerId);
            })
            ->orderBy('id', 'DESC')
            ->get()
            ->map(function ($p) use ($dateFrom, $dateTo) {
                $q = Lead::where('partner_id', $p->id);
                if (!empty($dateFrom)) $q->whereDate('created_at', '>=', $dateFrom);
                if (!empty($dateTo))   $q->whereDate('created_at', '<=', $dateTo);

                $lead = $q->latest()->first();

                if ($lead) {
                    $p->lead_name        = $lead->name;
                    $p->lead_company     = $lead->company_name;
                    $p->lead_created_at  = Carbon::parse($lead->created_at);
                    $p->lead_status_text = $lead->lead_status;
                } else {
                    $p->lead_name        = '';
                    $p->lead_company     = '';
                    $p->lead_created_at  = null;
                    $p->lead_status_text = '';
                }
                return $p;
            });

        // When a date range is active, drop partners with no leads in that window.
        if (!empty($dateFrom) || !empty($dateTo)) {
            $partners = $partners->filter(fn($p) => $p->lead_created_at !== null);
        }

        // Newest activity first
        $partners = $partners->sortByDesc(function ($p) {
            return $p->lead_created_at ? $p->lead_created_at->timestamp : 0;
        })->values();

        return $partners->map(function ($p) {
            $mobile = ($p->country_code ? '+'.$p->country_code.' ' : '').$p->mobile;
            $status = ((int) $p->status === 1) ? 'Active' : 'Inactive';
            $lastAt = $p->lead_created_at ? $p->lead_created_at->format('Y-m-d H:i') : '—';

            return [
                $p->name,
                $p->email,
                $p->unique_id,
                $mobile,
                $status,
                $p->lead_name        ?: '—',
                $p->lead_company     ?: '—',
                $lastAt,
                $p->lead_status_text ?: '—',
            ];
        });
    }
}
