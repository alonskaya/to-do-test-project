<?php

namespace App\Service\Initializer;

use App\Service\ProjectPathKeeper;
use Klein\Klein;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\FormRenderer;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\RuntimeLoader\FactoryRuntimeLoader;
use Symfony\Bridge\Twig\AppVariable;

/**
 * Class TwigInitializer
 * @package App\Service\Initializer
 */
class TwigInitializer implements ServiceInitializerInterface
{
    /**
     * @param Klein $klein
     *
     * @return callable
     */
    public static function initService(Klein $klein): callable
    {
        return static function() {
            $twig = new Environment(
                new FilesystemLoader(
                    [
                        ProjectPathKeeper::getTemplatesDirectory(),
                        dirname((new \ReflectionClass(AppVariable::class))->getFileName()) . '/Resources/views/Form',
                    ]
                ),
                ['autoescape' => false, 'debug' => true]
            );

            $formEngine = new TwigRendererEngine(['form_div_layout.html.twig'], $twig);

            $twig->addRuntimeLoader(
                new FactoryRuntimeLoader(
                    [
                        FormRenderer::class => function() use ($formEngine) {
                            return new FormRenderer($formEngine);
                        },
                    ]
                )
            );

            $twig->addExtension(new FormExtension());
            $twig->addExtension(new DebugExtension());
            $twig->addExtension(new TranslationExtension());

            return $twig;
        };
    }
}
