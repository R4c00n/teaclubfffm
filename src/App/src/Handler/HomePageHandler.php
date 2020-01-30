<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Home page handler
 *
 * @author Marcel Kempf <marcel.kempf@check24.de>
 */
class HomePageHandler implements RequestHandlerInterface
{

    /** @var TemplateRendererInterface */
    private $template;

    /**
     * The HomePageHandler constructor.
     *
     * @param TemplateRendererInterface $template
     */
    public function __construct(TemplateRendererInterface $template)
    {
        $this->template = $template;
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->template->render('app::home-page', []));
    }
}
