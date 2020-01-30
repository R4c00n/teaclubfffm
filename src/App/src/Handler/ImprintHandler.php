<?php
declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Render the imprint
 *
 * @author Marcel Kempf <marcel.kempf@check24.de>
 */
final class ImprintHandler implements RequestHandlerInterface
{

    /** @var TemplateRendererInterface */
    private $template;

    /**
     * The ImprintHandler constructor.
     *
     * @param TemplateRendererInterface $template
     */
    public function __construct(TemplateRendererInterface $template)
    {
        $this->template = $template;
    }

    /**
     * Render the imprint
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->template->render('app::imprint'));
    }
}