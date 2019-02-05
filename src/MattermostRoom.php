<?php

namespace Bpa\Notifications\Handler;

use Bpa\Notifications\Notification\AbstractRoom;

/**
 * Room for Mattermost
 */
class MattermostRoom extends AbstractRoom
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $name;

    /**
     * SlackRoom constructor.
     *
     * @param string $identifier
     * @param string $name
     */
    public function __construct($identifier, $name)
    {
        $this->identifier = $identifier;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
