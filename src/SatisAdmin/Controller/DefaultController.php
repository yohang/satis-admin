<?php

namespace SatisAdmin\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class DefaultController implements ControllerProviderInterface
{
    /**
     * @var \SatisAdmin\Application
     */
    protected $app;

    /**
     * {@inheritDoc}
     */
    public function connect(Application $app)
    {
        $this->app   = $app;
        $controllers = $app['controllers_factory'];

        $controllers->get('/', array($this, 'indexAction'));

        return $controllers;
    }

    public function indexAction()
    {
        return $this->render(
            'default/index.html.twig',
            array(
                'config' => $this->getModelManager()->getConfig()
            )
        );
    }

    /**
     * @param string $template
     * @param array  $params
     *
     * @return string
     */
    protected function render($template, array $params = array())
    {
        return $this->app['twig']->render($template, $params);
    }

    /**
     * @return \SatisAdmin\Model\ModelManager
     */
    protected function getModelManager()
    {
        return $this->app['model_manager'];
    }
}
