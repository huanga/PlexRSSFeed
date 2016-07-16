<?php
require_once './vendor/autoload.php';

use Turbine\Application;

$config = [];

$app = new Application($config);
if (getenv('DEVELOPMENT') === 'true') {
    $app->getErrorHandler()->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $app->setConfig('error', true);
}

$container = $app->getContainer();
$container->share('\Suin\RSSWriter\Feed');

$container->add('\Suin\RSSWriter\Channel')
            ->withMethodCall(
                'setContainer',
                [new League\Container\Argument\RawArgument($container)]
            );
$container->add('\Suin\RSSWriter\Item')
            ->withMethodCall(
                'setContainer',
                [new League\Container\Argument\RawArgument($container)]
            );


$container->add('\PlexRSSFeed\Factory\ChannelFactory');
$container->add('\PlexRSSFeed\Factory\ItemFactory');

$container->add('\PlexRSSFeed\Controller\FeedController')
            ->withArguments([
                '\Suin\RSSWriter\Feed',
                '\PlexRSSFeed\Factory\ChannelFactory',
                '\PlexRSSFeed\Factory\ItemFactory'
            ]);

$app->get('/{feed}/{items}', '\PlexRSSFeed\Controller\FeedController::__invoke');

$app->run();


