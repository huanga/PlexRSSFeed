<?php
namespace PlexRSSFeed\Factory;

use League\Container\ContainerAwareTrait as LeagueContainerAwareTrait;

class ItemFactory
{
    use LeagueContainerAwareTrait;
    use ContainerAwareTrait;

    /**
     * @return \Suin\RSSWriter\Item
     */
    public function create() {
        $container = $this->getContainer();
        return $container->get('\Suin\RSSWriter\Item');
    }
}