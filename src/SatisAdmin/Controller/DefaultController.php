<?php

namespace SatisAdmin\Controller;

use SatisAdmin\Form\ConfigType;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class DefaultController extends Controller
{
    /**
     * @var \SatisAdmin\Application
     */
    protected $app;

    /**
     * {@inheritDoc}
     */
    public function mount(ControllerCollection $controllers)
    {
        $controllers->get('/', array($this, 'indexAction'))->bind('config_index');
        $controllers->get('/edit', array($this, 'editAction'))->bind('config_edit');
        $controllers->post('/edit', array($this, 'updateAction'))->bind('config_update');
    }

    /**
     * @return string
     */
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
     * @return string
     */
    public function editAction()
    {
        return $this->render('default/edit.html.twig', array('form' => $this->getForm()->createView()));
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function updateAction(Request $request)
    {
        $form = $this->getForm();
        $form->bind($request);
        if ($form->isValid()) {
            $this->getModelManager()->persist($form->getData());

            $this->app->redirect($this->getRouter()->generate('config_index'));
        }

        return $this->render('default/edit.html.twig', array('form' => $form->createView()));
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getForm()
    {
        return $this->getFormFactory()->create(new ConfigType, $this->getModelManager()->getConfig());
    }
}
