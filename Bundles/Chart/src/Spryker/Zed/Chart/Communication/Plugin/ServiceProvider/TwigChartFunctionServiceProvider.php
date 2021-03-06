<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Chart\Communication\Plugin\ServiceProvider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Twig_Environment;

/**
 * @method \Spryker\Zed\Chart\Communication\ChartCommunicationFactory getFactory()
 * @method \Spryker\Zed\Chart\Business\ChartFacadeInterface getFacade()
 */
class TwigChartFunctionServiceProvider extends AbstractPlugin implements ServiceProviderInterface
{
    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function register(Application $app): void
    {
        $app['twig'] = $app->share(
            $app->extend('twig', function (Twig_Environment $twig) {
                return $this->registerChartTwigFunctions($twig);
            })
        );
    }

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function boot(Application $app): void
    {
    }

    /**
     * @param \Twig_Environment $twig
     *
     * @return \Twig_Environment
     */
    protected function registerChartTwigFunctions(Twig_Environment $twig): Twig_Environment
    {
        foreach ($this->getChartTwigFunctions() as $function) {
            $twig->addFunction($function->getName(), $function);
        }

        return $twig;
    }

    /**
     * @return array
     */
    protected function getChartTwigFunctions(): array
    {
        $functions = [];
        foreach ($this->getFactory()->getTwigChartFunctionPlugins() as $twigFunctionPlugin) {
            $functions = array_merge($functions, $twigFunctionPlugin->getChartFunctions());
        }

        return $functions;
    }
}
