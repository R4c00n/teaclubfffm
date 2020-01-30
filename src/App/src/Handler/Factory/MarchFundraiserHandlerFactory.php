<?php
declare(strict_types=1);

namespace App\Handler\Factory;

use App\Handler\MarchFundraiserHandler;
use Psr\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\I18n\Translator\TranslatorInterface;

/**
 * Create a configured MarchFundraiserHandler
 *
 * @author Marcel Kempf <marcel.kempf@check24.de>
 * @codeCoverageIgnore
 */
final class MarchFundraiserHandlerFactory
{

    /**
     * Create the service
     *
     * @param ContainerInterface $container
     * @return MarchFundraiserHandler
     */
    public function __invoke(ContainerInterface $container): MarchFundraiserHandler
    {
        /** @var TemplateRendererInterface $templateRenderer */
        $templateRenderer = $container->get(TemplateRendererInterface::class);

        /** @var TranslatorInterface $translator */
        $translator = $container->get(TranslatorInterface::class);

        /** @var AdapterInterface $db */
        $db = $container->get(AdapterInterface::class);

        return new MarchFundraiserHandler($templateRenderer, $translator, $db);
    }
}
