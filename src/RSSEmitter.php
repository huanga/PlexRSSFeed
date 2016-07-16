<?php
namespace PlexRSSFeed;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\EmitterInterface;

class RSSEmitter implements EmitterInterface
{
    public function emit(ResponseInterface $response, $maxBufferLevel = null)
    {
        $response = $this->injectContentLength($response);

        $this->emitStatusLine($response);
        $this->emitHeaders($response);
        $this->flush($maxBufferLevel);
        $this->emitBody($response);
    }

    private function emitBody(ResponseInterface $response)
    {
        echo $response->getBody();
    }
}