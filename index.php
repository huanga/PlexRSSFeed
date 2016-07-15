<?php
require_once './vendor/autoload.php';

use Turbine\Application;

$config = [];

$app = new Application($config);
$container = $app->getContainer();
$container->share('\Suin\RSSWriter\Feed');

$container->add('\Suin\RSSWriter\Channel');
$container->add('\Suin\RSSWriter\Item');

$container->add('\PlexRSSFeed\Factory\ChannelFactory')
            ->withMethodCall(
                'setContainer',
                [$container]
            );
$container->add('\PlexRSSFeed\Factory\ItemFactory')
            ->withMethodCall(
                'setContainer',
                [$container]
            );

$container->share('\PlexRSSFeed\Controller\FeedController')
            ->withArguments([
                '\Suin\RSSWriter\Feed', 
                '\PlexRSSFeed\Factory\ChannelFactory',
                '\PlexRSSFeed\Factory\ItemFactory'
            ]);

$app->get('/{feed}/{items}', '\PlexRSSFeed\Controller\FeedController');

$app->run();


