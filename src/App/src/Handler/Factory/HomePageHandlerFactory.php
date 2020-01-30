<?php

declare(strict_types=1);

namespace App\Handler\Factory;

use App\Handler\HomePageHandler;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Create a configured HomePageHandler
 *
 * @author Marcel Kempf <marcel.kempf@check24.de>
 * @codeCoverageIgnore
 */
class HomePageHandlerFactory
{

    /**
     * Create the service
     *
     * @param ContainerInterface $container
     * @return RequestHandlerInterface
     */
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {

        /** @var TemplateRendererInterface $template */
        $template = $container->get(TemplateRendererInterface::class);

        return new HomePageHandler($template);
    }
}
