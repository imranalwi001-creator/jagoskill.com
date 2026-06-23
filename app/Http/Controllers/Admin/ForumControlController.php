<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Translation\SettingTranslation;
use Illuminate\Http\Request;

class ForumControlController extends Controller
{
    public function index(Request $request)
    {
        return redirect(getAdminPanelUrl('/forums/settings'));
    }

    public function update(Request $request)
    {
        $this->authorizeAdmin();

        $name = Setting::$forumsGeneralSettingsName;
        $locale = mb_strtolower($request->get('locale', Setting::$defaultSettingsLocale));
        $values = $this->getForumGeneralValues($request);
        $values['forums_status'] = $request->has('forums_status') ? '1' : '0';

        $setting = Setting::updateOrCreate(
            ['name' => $name],
            [
                'page' => 'forum',
                'updated_at' => time(),
            ]
        );

        SettingTranslation::updateOrCreate(
            [
                'setting_id' => $setting->id,
                'locale' => $locale,
            ],
            [
                'value' => json_encode($values),
            ]
        );

        cache()->forget('settings.' . $name);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => 'Forum control updated successfully.',
            'status' => 'success',
        ];

        return back()->with(['toast' => $toastData]);
    }

    private function authorizeAdmin()
    {
        if (empty(auth()->user()) || !auth()->user()->isAdmin()) {
            abort(403);
        }
    }

    private function getForumGeneralValues(Request $request): array
    {
        $locale = mb_strtolower($request->get('locale', Setting::$defaultSettingsLocale));
        $setting = Setting::where('page', 'forum')
            ->where('name', Setting::$forumsGeneralSettingsName)
            ->first();

        if (empty($setting)) {
            return [];
        }

        $translation = SettingTranslation::where('setting_id', $setting->id)
            ->where('locale', $locale)
            ->first();

        $value = !empty($translation) ? $translation->value : $setting->value;

        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }
}
