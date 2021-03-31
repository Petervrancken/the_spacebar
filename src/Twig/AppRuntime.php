<?php


namespace App\Twig;

use App\Services\MarkdownService;
use Twig\Extension\RuntimeExtensionInterface;

class AppRuntime implements RuntimeExtensionInterface
{
    private $markdownService;

    public function __construct(MarkdownService $markdownService)
    {
        $this->markdownService = $markdownService;
    }

    public function processMarkdown($value)
    {
        return $this->markdownService->parse($value);
    }
}