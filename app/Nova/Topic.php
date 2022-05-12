<?php

namespace App\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;

use App\Nova\Actions\TopicGradebook;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\Tab;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Lms\TeacherTopicComment\TeacherTopicComment;

use PixelCreation\NovaFieldSortable\Concerns\SortsIndexEntries;
use PixelCreation\NovaFieldSortable\Sortable;

class Topic extends Resource
{
    use SortsIndexEntries;

    public static $defaultSortField = 'order';

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Topic::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name'
    ];


    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Topics');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Topic');
    }
    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make(__('Name'), 'name')
                ->required()
                ->rules('required', 'max:255'),

            BelongsTo::make(__('Course'), 'Course', Course::class),

            TeacherTopicComment::make(),

            HasMany::make(__('Activities'), 'Activities', Activity::class),

            //HasMany::make(__('Weekly Plans'), 'weeklyPlannings', WeeklyPlanning::class),

            Sortable::make(__('Order'), 'order')
                ->onlyOnIndex(),

            DateTime::make(__('Start Date'), 'startDate')
                ->withDateFormat('d-M-Y, H:i'),

            DateTime::make(__('End Date'), 'endDate')
                ->withDateFormat('d-M-Y, H:i'),

            Boolean::make(__('Visible'), 'isShow')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Text::make('Total Points', 'totalActivities')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

             /*SimpleLinkButton::make('Grades', function () {
                 return "/topicGradebook/{$this->id}" ;
             })
                 ->hideWhenUpdating()
                 ->hideFromDetail()
                 ->type('link')
                 ->style('grey')
                 ->attributes(['target' => '_blank']),

            SimpleLinkButton::make('Preview', function () {
                return "/courses/topic/{$this->id}" ;
            })
                ->hideWhenUpdating()
                ->hideFromDetail()
                ->type('link')  // fill, outline, link
                ->style('grey')
                ->attributes(['target' => '_blank']),*/
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            new TopicGradebook
        ];
    }

    /**
     * Get the parent to be displayed in the breadcrumbs.
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function breadcrumbParent()
    {
        return $this->model()->course;
    }
}
