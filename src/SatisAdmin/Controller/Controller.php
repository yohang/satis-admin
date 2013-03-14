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
}
