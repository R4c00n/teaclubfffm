<?php
declare(strict_types=1);

namespace App\I18n\Factory;

use Psr\Container\ContainerInterface;
use Zend\I18n\Translator\Translator;
use Zend\I18n\Translator\TranslatorInterface;

/**
 * Create a configured TranslatorInterface
 *
 * @author Marcel Kempf <marcel.kempf@check24.de>
 * @codeCoverageIgnore
 */
final class TranslatorFactory
{

    /**
     * Create the service
     *
     * @param ContainerInterface $container
     * @return TranslatorInterface
     */
    public function __invoke(ContainerInterface $container): TranslatorInterface
    {
        $translator = new Translator();
        $translator->addTranslationFilePattern(
            \Zend\I18n\Translator\Loader\PhpArray::class,
            __DIR__ . '/../../../../../data/i18n/',
            '%s.php'
        );
        $translator->setLocale('de_DE');

        return $translator;
    }
}
