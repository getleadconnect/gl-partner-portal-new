<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Partner;
use App\Models\Lead;
use App\Models\LeadCommission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if($this->app->environment('production')) {
          \URL::forceScheme('https');
        }

        View::composer('admin.master', function ($view) {
            if (!Auth::guard('admin')->check()) {
                $view->with([
                    'sidebar_partners_count' => 0,
                    'sidebar_leads_count'    => 0,
                    'sidebar_payouts_count'  => 0,
                ]);
                return;
            }

            $payoutsCount = 0;
            if (Schema::hasTable('lead_commissions')) {
                $payoutsCount = LeadCommission::where('payment_status', '!=', 1)->count();
            }

            $view->with([
                'sidebar_partners_count' => Partner::count(),
                'sidebar_leads_count'    => Lead::count(),
                'sidebar_payouts_count'  => $payoutsCount,
            ]);
        });

        View::composer('partner.master', function ($view) {
            $count = 0;
            if (Auth::guard('partner')->check()) {
                $count = Lead::where('partner_id', Auth::guard('partner')->user()->id)->count();
            }
            $view->with([
                'sidebar_my_leads_count' => $count,
            ]);
        });
    }
}
