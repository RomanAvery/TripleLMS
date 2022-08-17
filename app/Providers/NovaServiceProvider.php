<?php

namespace App\Providers;

use App\Nova\Dashboards\Main;

use App\Models\Roles;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Murdercode\TinymceEditor\TinymceEditor;
use Laravel\Nova\Panel;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Lms\CourseGradebook\CourseGradebook;
use Lms\Gradebook\Gradebook;
use Lms\StudentGradebook\StudentGradebook;

use Illuminate\Support\Facades\Blade;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Itsmejoshua\Novaspatiepermissions\Novaspatiepermissions;
use Vyuldashev\NovaPermission\PermissionPolicy;
use Vyuldashev\NovaPermission\RolePolicy;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        \Outl1ne\NovaSettings\NovaSettings::addSettingsFields([
            Text::make('Site Title', 'site_title'),
            Image::make('Logo', 'logo_frontend'),
            Image::make('Brand Image', 'brand_image'),
            Image::make('Favicon', 'favicon'),
            Text::make('Google Analytics Tag', 'ga_tag'),
        ]);

        \Outl1ne\NovaSettings\NovaSettings::addSettingsFields([
            Textarea::make('Slideshow Images', 'slideshow_images')
                ->help('Enter multiple URLs seperated by a comma.'),
            TinymceEditor::make('Featured Column', 'featured_column_'),
            TinymceEditor::make('Main Content', 'main_content'),
        ], [], 'Homepage');

        \Outl1ne\NovaSettings\NovaSettings::addSettingsFields([
            
        ], [], 'Global Settings');

        Nova::footer(function ($request) {
            return Blade::render('
                <div class="mt-8 leading-normal text-xs text-gray-500 space-y-1">
                    <p class="text-center">© {{ date("Y") }} Victoria University of Wellington · by Roman Avery.</p>
                </div>
            ');
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return !$user->hasRole(Roles::STUDENT);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [

            \Spatie\BackupTool\BackupTool::make()
                ->canSee(function (){
                    return auth()->user()->can('manage backup');
                }),

            Novaspatiepermissions::make()
                ->canSee(function (){
                    return auth()->user()->can('manage roles');
                }),

            //\ChrisWare\NovaBreadcrumbs\NovaBreadcrumbs::make(),
            new \Outl1ne\NovaSettings\NovaSettings,
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Nova::report(function ($exception) {
            if (app()->bound('sentry')) {
                app('sentry')->captureException($exception);
           }
       });
    }
}
