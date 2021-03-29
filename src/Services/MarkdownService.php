<?php


namespace App\Services;


use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownService
{
    /**
     * @var MarkdownInterface
     */
    private $markdown;
    /**
     * @var AdapterInterface
     */
    private $cache;

    private $logger;

    public function __construct(MarkdownInterface $markdown, AdapterInterface $cache, LoggerInterface $markdownLogger)
    {

        $this->markdown = $markdown;
        $this->cache = $cache;
        $this->logger = $markdownLogger;
    }

    public function parse(string $source)
    {
        if(stripos($source, 'bacon') !== false){
            $this->logger->info('They are talking about bacon again!');
        }
        $item = $this->cache->getItem('markdown_'.md5($source));
        if(!$item->isHit()){
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }
        return $item->get();
    }
}