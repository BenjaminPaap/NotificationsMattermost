<?php

namespace Bpa\Notifications\Handler;

use Bpa\Notifications\Notification\MessageInterface;
use GuzzleHttp\Client;

/**
 * Handler for Mattermost
 */
class MattermostHandler implements HandlerInterface
{

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $iconUrl;

    /**
     * @var Client
     */
    private $client;

    /**
     * MattermostHandler constructor.
     *
     * @param Client $client
     * @param string $url
     * @param string $username
     * @param string $iconUrl
     */
    public function __construct(Client $client, $url, $username, $iconUrl)
    {
        $this->url = $url;
        $this->username = $username;
        $this->iconUrl = $iconUrl;
        $this->client = $client;
    }

    /**
     * @param MessageInterface $message
     *
     * @return bool|void
     */
    public function notify(MessageInterface $message)
    {
        if (false === $message->getRoom() instanceof SlackRoom) {
            return false;
        }

        $body = json_encode($this->getContent($message));

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new \Exception(json_last_error_msg());
        }

        $response = $this->client->request(
            'POST',
            $this->url,
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => $body,
            ]
        );

        if ($response->getStatusCode() == 200) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param MessageInterface $message
     *
     * @return array
     */
    private function getContent(MessageInterface $message)
    {
        return [
            "channel" => $message->getRoom()->getIdentifier(),
            "username" => $this->username,
            "icon_url" => $this->iconUrl,
            'text' => $message->getMessage(),
        ];
    }
}
