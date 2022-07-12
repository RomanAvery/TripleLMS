<?php

namespace App\Helpers;

use App\Models\Course;
use App\Models\User;
use App\Models\Qualtrics\Contact;
use App\Models\Qualtrics\MailingList;
use App\Models\Qualtrics\Survey;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use QBNK\Guzzle\Oauth2\GrantType\RefreshToken;
use QBNK\Guzzle\Oauth2\GrantType\ClientCredentials;
use QBNK\Guzzle\Oauth2\Middleware\OAuthMiddleware;

class GuzzleQualtrics
{
    public $client;
    private $lib_id;

    public static function make_client($scope = 'manage:all')
    {
        $base_uri = env('QUALTRICS_API_BASE', 'https://ca1.qualtrics.com/');
        $config = [
            ClientCredentials::CONFIG_CLIENT_ID => env('QUALTRICS_CLIENT_ID'),
            ClientCredentials::CONFIG_CLIENT_SECRET => env('QUALTRICS_CLIENT_SECRET'),
            ClientCredentials::CONFIG_TOKEN_URL => $base_uri . "oauth2/token",
            'scope' => $scope,
        ];

        $oauthClient = new Client();
        $grantType = new ClientCredentials($oauthClient, $config);
        $refreshToken = new RefreshToken($oauthClient, $config);
        $middleware = new OAuthMiddleware($oauthClient, $grantType, $refreshToken);

        $handlerStack = HandlerStack::create();
        $handlerStack->push($middleware->onBefore());
        $handlerStack->push($middleware->onFailure(5));

        $client = new Client(['handler'=> $handlerStack, 'auth' => 'oauth2']);

        return $client;
    }

    function __construct($scope = 'manage:all')
    {
        $this->scope = $scope;
        $this->client = static::make_client($scope);

        $this->lib_id = env('QUALTRICS_LIBRARY_ID');
    }

    public function create_mailing_list($name, $course_id)
    {
        $list_id = null;
        
        try {
            $res = $this->client->post(env('QUALTRICS_API_BASE') . 'API/v3/mailinglists', [
                \GuzzleHttp\RequestOptions::JSON => [
                    'name' => $name,
                    'libraryId' => $this->lib_id,
                ]
            ]);
            
            if ($res->getStatusCode() !== 200) return;

            $data = json_decode($res->getBody());
            $list_id = $data?->result?->id;

        } catch (RequestException $e) {
            \Sentry\captureException($e);
            //$err_meta = 
            //dd($e->getResponse()?->getBody());
        } catch (Exception $e) {
            \Sentry\captureException($e);
        }

        if ($list_id === null) return;

        return MailingList::create([
            'name' => $name,
            'list_id' => $list_id,
            'course_id' => $course_id,
        ]);
    }

    /*
     * Returns true if deleted, false otherwise.
    **/
    public function delete_mailing_list($list_id)
    {
        $deleted = false;
        
        try {
            $res = $this->client->delete(env('QUALTRICS_API_BASE') . 'API/v3/mailinglists/' . $list_id);
            
            if ($res->getStatusCode() !== 200) return;

            MailingList::where('list_id', $list_id)->get()->each->delete();
            return true;

        } catch (RequestException $e) {
            \Sentry\captureException($e);
            return false;
        } catch (Exception $e) {
            \Sentry\captureException($e);
            return false;
        }
    }

    public function create_contact(User $user, MailingList $list)
    {
        $contact_id = null;
        
        try {
            $res = $this->client->post(env('QUALTRICS_API_BASE') . 'API/v3/mailinglists/' . $list->list_id . '/contacts', [
                \GuzzleHttp\RequestOptions::JSON => [
                    'email' => $user->email,
                ]
            ]);
            
            if ($res->getStatusCode() !== 200) return;

            $data = json_decode($res->getBody());
            $contact_id = $data?->result?->id;

        } catch (RequestException $e) {
            \Sentry\captureException($e);
            //$err_meta = 
            //dd($e->getResponse()?->getBody());
        } catch (Exception $e) {
            \Sentry\captureException($e);
        }

        if ($contact_id === null) return;

        return Contact::create([
            'contact_id' => $contact_id,
            'mailing_list_id' => $list->id,
            'user_id' => $user->id,
        ]);
    }
}
