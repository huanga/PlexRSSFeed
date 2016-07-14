<?php
namespace PlexRSSFeed\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use \Suin\RSSWriter\Feed;
use \PlexRSSFeed\Factory\ChannelFactory;
use \PlexRSSFeed\Factory\ItemFactory;

class FeedController
{
    /**
     * @var \Suin\RSSWriter\Feed
     */
    private $feed;

    /**
     * @var \PlexRSSFeed\Factory\ChannelFactory
     */
    private $channelFactory;

    /**
     * @var \PlexRSSFeed\Factory\ItemFactory
     */
    private $itemFactory;

    public function __construct(Feed $feed, ChannelFactory $channelFactory, ItemFactory $itemFactory)
    {
        $this->feed = $feed;
        $this->channelFactory = $channelFactory;
        $this->itemFactory = $itemFactory;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $feed = $this->feed;
        $channel = $this->channelFactory->create();
        $channel->title('Plex RSS Feed ' . $args['feed']);
        $channel->description('An auto-generated RSS Feed for your Plex Media Server');
        
        $feed->addChannel($channel);
        $response->getBody()->write($feed->render());
    }
}