<?php

namespace SatisAdmin\Controller;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
abstract class Controller implements ControllerProviderInterface
{
    /**
     * @var \SatisAdmin\Application
     */
    protected $app;

    /**
     * @param ControllerCollection $collection
     *
     * @return ControllerCollection
     */
    abstract protected function mount(ControllerCollection $collection);

    /**
     * {@inheritDoc}
     */
    public function connect(Application $app)
    {
        $this->app   = $app;
        $controllers = $app['controllers_factory'];

        $this->mount($controllers);

        return $controllers;
    }
    /**
     * @param string $template
     * @param array  $params
     *
     * @return string
     */
    protected function render($template, array $params = array())
    {
        return $this->getTwig()->render($template, $params);
    }

    /**
     * @return \Twig_Environment
     */
    protected function getTwig()
    {
        return $this->app['twig'];
    }

    /**
     * @return \SatisAdmin\Model\ModelManager
     */
    protected function getModelManager()
    {
        return $this->app['model_manager'];
    }

    /**
     * @return \Symfony\Component\Form\FormFactoryInterface
     */
    protected function getFormFactory()
    {
        return $this->app['form.factory'];
    }

    /**
     * @return \Symfony\Component\Routing\Generator\UrlGenerator
     */
    protected function getRouter()
    {
        return $this->app['url_generator'];
    }
}
