<?php
namespace PlexRSSFeed\Factory;

use League\Container\ContainerInterface;

trait ContainerAwareTrait {
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }    
}