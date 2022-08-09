<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $site_logo = nova_get_setting('logo_frontend');

        return array_merge(parent::share($request), [
            // Add site-wide settings
            'settings.title' => nova_get_setting('site_title') ?? config('app.name', 'TripleLMS'),
            'settings.logo' => ($site_logo !== null && Storage::exists($site_logo))
                ? Storage::url($site_logo)
                : null,
            'settings.ga' => nova_get_setting('ga_tag') ?? null,

            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'info' => fn () => $request->session()->get('info'),
                'error' => fn () => $request->session()->get('error'),
            ]
        ]);
    }
}
