<?php
namespace App\Services;

use App\Models\General;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class InstagramService
{
    protected $client;
    protected $accessToken;

    public function __construct()
    {
        //$general = General::find(1);
        
        $this->client = new Client();
    //    $this->accessToken = $general->ig_token ?? "";
    }

    public function getUserMedia()
    {
          if ($this->accessToken === null) {
            $general = General::find(1);
            $this->accessToken = $general->ig_token ?? "";
        }
        if (empty($this->accessToken)) {
            error_log("Instagram access token is not set.");
            return [];
        }

        $url = "https://graph.instagram.com/me/media";
        $params = [
            'fields' => 'id,caption,media_type,media_url,thumbnail_url,permalink',
            'access_token' => $this->accessToken
        ];

        try {
            $response = $this->client->get($url, ['query' => $params]);
            $body = $response->getBody();
            $data = json_decode($body, true);

            return $data['data'] ?? [];
        } catch (ClientException $e) {
            // Log API client errors (4xx)
            error_log("ClientException: " . $e->getResponse()->getBody()->getContents());
            return [];
        } catch (RequestException $e) {
            // Log general request errors (network issues, 5xx, etc.)
            error_log("RequestException: " . $e->getMessage());
            return [];
        } catch (\Exception $e) {
            // Log unexpected errors
            error_log("Unexpected error: " . $e->getMessage());
            return [];
        }
    }
}