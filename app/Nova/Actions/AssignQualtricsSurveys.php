<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

use App\Helpers\GuzzleQualtrics;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;

class AssignQualtricsSurveys extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $this->make_list();
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }

    private function make_list()
    {
        $client = GuzzleQualtrics::client();

        try {
            $res = $client->get(env('QUALTRICS_API_BASE') . "API/v3/directories/" . env('QUALTRICS_DIRECTORY_ID') . "/mailinglists");
            //dd(json_decode($res->getBody(), true));
            Action::message('hi');
        } catch (ClientException $e) {
            Action::danger('Something went wrong!');
        }
    }
}
