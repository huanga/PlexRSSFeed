<?php
require_once './vendor/autoload.php';

use Turbine\Application;

$config = [
    'baseDirectory' => '/PlexRSSFeed'
];

$app = new Application($config);
if (getenv('DEVELOPMENT') === 'true') {
    $app->getErrorHandler()->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $app->setConfig('error', true);
}

$container = $app->getContainer();
$app->getContainer()->share(\Zend\Diactoros\Response\EmitterInterface::class, \PlexRSSFeed\PlexRSSFeedEmitter::class);

$container->share('\Suin\RSSWriter\Feed');

$container->add('\Suin\RSSWriter\Channel');
$container->add('\Suin\RSSWriter\Item');

$container->add('\PlexRSSFeed\Factory\ChannelFactory')
            ->withMethodCall(
                'setContainer',
                [new League\Container\Argument\RawArgument($container)]
            );
$container->add('\PlexRSSFeed\Factory\ItemFactory')
            ->withMethodCall(
                'setContainer',
                [new League\Container\Argument\RawArgument($container)]
            );


$container->add('\PlexRSSFeed\Controller\FeedController')
            ->withArguments([
                '\Suin\RSSWriter\Feed',
                '\PlexRSSFeed\Factory\ChannelFactory',
                '\PlexRSSFeed\Factory\ItemFactory'
            ]);

$app->get($config['baseDirectory'] . '/{feed}/{items}', '\PlexRSSFeed\Controller\FeedController::__invoke');

$app->run();


