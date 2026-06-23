<?php

namespace App\Http\Middleware;

use App\Models\AiContentTemplate;
use App\Models\Setting;
use Closure;
use Illuminate\Support\Facades\Cache;

class PanelAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->user() and !empty(apiAuth())) {
            auth()->setUser(apiAuth());
        }

        if (auth()->check() and !auth()->user()->isAdmin()) {

            $referralSettings = getReferralSettings();
            view()->share('referralSettings', $referralSettings);

            $aiContentTemplates = $this->getAiContentTemplates();
            view()->share('aiContentTemplates', $aiContentTemplates);

            view()->share('panelNavbarLinks', $this->getNavbarLinks());


            return $next($request);
        }

        return redirect('/login');
    }

    private function getNavbarLinks()
    {
        $cacheKey = 'panel.navbar_links.' . mb_strtolower(app()->getLocale());

        return Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return Setting::where('name', Setting::$navbarLinkName)->first();
        });
    }

    private function getAiContentTemplates()
    {
        $cacheKey = 'panel.ai_content_templates.' . mb_strtolower(app()->getLocale());

        return Cache::remember($cacheKey, now()->addMinutes(5), function () {
            return AiContentTemplate::query()->where('enable', true)->get();
        });
    }
}
