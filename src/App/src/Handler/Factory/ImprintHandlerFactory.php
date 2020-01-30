<?php
declare(strict_types=1);

namespace App\Handler\Factory;

use App\Handler\ImprintHandler;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Create a configured ImprintHandler
 *
 * @author Marcel Kempf <marcel.kempf@check24.de>
 * @codeCoverageIgnore
 */
final class ImprintHandlerFactory
{

    /**
     * Create the service
     *
     * @param ContainerInterface $container
     * @return ImprintHandler
     */
    public function __invoke(ContainerInterface $container): ImprintHandler
    {
        /** @var TemplateRendererInterface $templateRenderer */
        $templateRenderer = $container->get(TemplateRendererInterface::class);

        return new ImprintHandler($templateRenderer);
    }
}
