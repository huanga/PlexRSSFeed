<?php
namespace PlexRSSFeed;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\SapiEmitter;

class PlexRSSFeedEmitter extends SapiEmitter
{
    public function emit(ResponseInterface $response, $maxBufferLevel = null)
    {
        parent::emit($response, $maxBufferLevel);

        // Flush all the things
        while (ob_get_level() > 0) {
            ob_end_flush();
        }
    }
}