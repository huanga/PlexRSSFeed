<?php
namespace PlexRSSFeed\Factory;

use League\Container\ContainerAwareTrait as LeagueContainerAwareTrait;

class ChannelFactory
{
    use LeagueContainerAwareTrait;

    /**
     * @return \Suin\RSSWriter\Channel
     */
    public function create() {
        $container = $this->getContainer();
        return $container->get('\Suin\RSSWriter\Channel');
    }
}