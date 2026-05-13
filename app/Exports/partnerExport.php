<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\Partner;
use App\Models\Lead;
use App\Models\LeadCommission;

use Carbon\Carbon;

class partnerExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = is_array($filters) ? $filters : ['status' => $filters];
    }

    public function headings(): array
    {
        return [
            'Partner Name',
            'Unique ID',
            'Email',
            'Mobile',
            'Company',
            'Tier',
            'Leads (Month)',
            'GMV Lifetime',
            'Commission %',
            'Renewal Comm %',
            'Paid YTD',
            'Agent',
            'Last Activity',
            'Status',
        ];
    }

    public function collection()
    {
        $status   = $this->filters['status']   ?? '';
        $tier     = $this->filters['tier']     ?? '';
        $agentId  = $this->filters['agent_id'] ?? '';
        $activity = $this->filters['activity'] ?? '';

        if ($status === 'All') $status = '';

        $leadsMonthByPartner = Lead::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->selectRaw('partner_id, COUNT(*) as cnt')
            ->groupBy('partner_id')
            ->pluck('cnt', 'partner_id');

        $gmvByPartner = LeadCommission::whereRaw('UPPER(lead_status)=?', ['GOT BUSINESS'])
            ->selectRaw('partner_id, SUM(amount_collected) as gmv')
            ->groupBy('partner_id')
            ->pluck('gmv', 'partner_id');

        $paidYtdByPartner = LeadCommission::whereYear('payment_date', date('Y'))
            ->selectRaw('partner_id, SUM(paid_amount) as paid')
            ->groupBy('partner_id')
            ->pluck('paid', 'partner_id');

        $lastLeadByPartner = Lead::selectRaw('partner_id, MAX(created_at) as last_at')
            ->groupBy('partner_id')
            ->pluck('last_at', 'partner_id');

        $query = Partner::select('partners.*', 'agents.name as agent_name', 'partner_tiers.partner_tier as tier_label_db')
            ->leftJoin('agents', 'agents.id', 'partners.agent_id')
            ->leftJoin('partner_tiers', 'partner_tiers.id', 'partners.partner_tier_id');

        if ($status !== '') {
            $query->where('partners.status', $status);
        }
        if ($agentId !== '' && $agentId !== null) {
            $query->where('partners.agent_id', $agentId);
        }
        if ($tier !== '' && $tier !== null) {
            if ($tier === 'active')         $query->where('partners.status', 1);
            elseif ($tier === 'inactive')   $query->where('partners.status', 0);
            elseif (is_numeric($tier))      $query->where('partners.partner_tier_id', (int) $tier);
        }

        $rows = $query->orderBy('partners.id', 'ASC')->get()->map(function ($p) use ($leadsMonthByPartner, $gmvByPartner, $paidYtdByPartner, $lastLeadByPartner) {
            $lastAt = $lastLeadByPartner[$p->id] ?? null;

            return (object) [
                'partner'        => $p,
                'tier_label'     => $p->tier_label_db ?: '—',
                'leads_month'    => (int) ($leadsMonthByPartner[$p->id] ?? 0),
                'gmv_lifetime'   => (int) ($gmvByPartner[$p->id] ?? 0),
                'paid_ytd'       => (int) ($paidYtdByPartner[$p->id] ?? 0),
                'last_lead_at'   => $lastAt,
            ];
        });

        if ($activity !== '' && $activity !== null) {
            $now = Carbon::now();
            $rows = $rows->filter(function ($r) use ($activity, $now) {
                $last = $r->last_lead_at ? Carbon::parse($r->last_lead_at) : null;
                if ($activity === '7d')      return $last && $last->gte($now->copy()->subDays(7));
                if ($activity === '30d')     return $last && $last->gte($now->copy()->subDays(30));
                if ($activity === 'stale30') return !$last || $last->lt($now->copy()->subDays(30));
                return true;
            })->values();
        }

        return $rows->map(function ($r) {
            $p = $r->partner;
            return [
                $p->name,
                $p->unique_id,
                $p->email,
                ($p->country_code ? '+'.$p->country_code : '').$p->mobile,
                $p->company_name,
                $r->tier_label,
                $r->leads_month,
                $r->gmv_lifetime,
                $p->commission_percentage,
                $p->renewal_comm_percentage,
                $r->paid_ytd,
                $p->agent_name ?: '—',
                $r->last_lead_at ? Carbon::parse($r->last_lead_at)->diffForHumans() : '—',
                ((int) $p->status === 1) ? 'Active' : 'Inactive',
            ];
        });
    }
}
