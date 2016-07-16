<?php
namespace PlexRSSFeed;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\EmitterInterface;
use Zend\Diactoros\Response\SapiEmitterTrait;

class RSSEmitter implements EmitterInterface
{
    use SapiEmitterTrait;

    public function emit(ResponseInterface $response, $maxBufferLevel = null)
    {
        $response = $this->injectContentLength($response);

        $this->emitStatusLine($response);
        $this->emitHeaders($response);
        $this->emitBody($response);
        $this->flush(0);
    }

    private function emitBody(ResponseInterface $response)
    {
        echo $response->getBody();
    }
}