<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Admin\SidebarController;
use App\Mixins\Financial\MultiCurrency;
use App\Models\AiContentTemplate;
use App\User;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class AdminAuthenticate
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
        if (auth()->check() and auth()->user()->isAdmin()) {

            \Session::forget('impersonated');

            if (auth()->user()->hasPermission('admin_notifications_list')) {
                $adminUser = User::getMainAdmin();

                if (!empty($adminUser)) {
                    $unReadNotifications = $adminUser->getUnReadNotifications();

                    view()->share('unReadNotifications', $unReadNotifications);
                }
            }

            $generalSettings = getGeneralSettings();
            view()->share('generalSettings', $generalSettings);


            $userLanguages = $this->getUserLanguagesLists($generalSettings);

            view()->share('userLanguages', $userLanguages);

            $currency = currencySign();
            view()->share('currency', $currency);

            if (getFinancialCurrencySettings('multi_currency')) {
                $multiCurrency = new MultiCurrency();
                $currencies = $multiCurrency->getCurrencies();

                if ($currencies->isNotEmpty()) {
                    view()->share('currencies', $currencies);
                }
            }

            $user = auth()->user();
            view()->share('authUser', $user);

            $sidebarBeeps = $this->getSidebarBeeps();

            view()->share('sidebarBeeps', $sidebarBeeps);

            $aiContentTemplates = $this->getAiContentTemplates();
            view()->share('aiContentTemplates', $aiContentTemplates);

            // Theme Color Mode
            view()->share('userThemeColorMode', getUserThemeColorMode());

            // locale config
            if (!Session::has('locale')) {
                Session::put('locale', mb_strtolower(getDefaultLocale()));
            }
            App::setLocale(session('locale'));

            return $next($request);
        }

        return redirect($this->localBaseUrl($request) . getAdminPanelUrl('/login'));
    }

    private function localBaseUrl($request): string
    {
        $originalHost = $request->server('HTTP_X_ORIGINAL_HOST');

        if (!empty($originalHost) && preg_match('/^(localhost|127\.0\.0\.1)(:\d+)?$/', $originalHost)) {
            return 'http://' . $originalHost;
        }

        return rtrim(config('app.url'), '/');
    }

    private function getSidebarBeeps(): array
    {
        return Cache::remember('admin.sidebar_beeps', now()->addMinute(), function (): array {
            $sidebarController = new SidebarController();

            return [
                'courses' => $sidebarController->getCoursesBeep(),
                'bundles' => $sidebarController->getBundlesBeep(),
                'webinars' => $sidebarController->getWebinarsBeep(),
                'textLessons' => $sidebarController->getTextLessonsBeep(),
                'reviews' => $sidebarController->getReviewsBeep(),
                'classesComments' => $sidebarController->getClassesCommentsBeep(),
                'bundleComments' => $sidebarController->getBundleCommentsBeep(),
                'blogComments' => $sidebarController->getBlogCommentsBeep(),
                'productComments' => $sidebarController->getProductCommentsBeep(),
                'eventsComments' => $sidebarController->getEventsCommentsBeep(),
                'payoutRequest' => $sidebarController->getPayoutRequestBeep(),
                'offlinePayments' => $sidebarController->getOfflinePaymentsBeep(),
            ];
        });
    }

    private function getAiContentTemplates()
    {
        $cacheKey = 'admin.ai_content_templates.' . mb_strtolower(app()->getLocale());

        return Cache::remember($cacheKey, now()->addMinutes(5), function () {
            return AiContentTemplate::query()->where('enable', true)->get();
        });
    }

    public function getUserLanguagesLists($generalSettings)
    {
        $userLanguages = ($generalSettings and !empty($generalSettings['user_languages'])) ? $generalSettings['user_languages'] : null;

        if (!empty($userLanguages) and is_array($userLanguages)) {
            $userLanguages = getLanguages($userLanguages);
        } else {
            $userLanguages = [];
        }

        if (count($userLanguages) > 0) {
            $site_language = $generalSettings['site_language'] ?? app()->getLocale();

            foreach ($userLanguages as $locale => $language) {
                if (mb_strtolower($locale) == mb_strtolower($site_language)) {
                    $firstKey = array_key_first($userLanguages);

                    if ($firstKey != $locale) {
                        $firstValue = $userLanguages[$firstKey];

                        unset($userLanguages[$locale]);
                        unset($userLanguages[$firstKey]);

                        $userLanguages = array_merge([
                            $locale => $language,
                            $firstKey => $firstValue
                        ], $userLanguages);
                    }
                }
            }
        }

        return $userLanguages;
    }
}
