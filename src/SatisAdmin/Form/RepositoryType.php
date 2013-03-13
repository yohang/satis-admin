<?php

namespace SatisAdmin\Form;

use SatisAdmin\Model\Repository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RepositoryType extends AbstractType implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventSubscriber($this)
            ->add('type', 'choice', ['choices' => $this->getTypeChoices()])
            ->add(
                'data',
                new ComposerRepositoryType,
                [
                    'virtual' => true,
                    'data_class' => 'SatisAdmin\Model\ComposerRepository'
                ]
            );
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'SatisAdmin\Model\Repository']);
    }

    /**
     * @param FormEvent $event
     */
    public function onPreSetData(FormEvent $event)
    {
        /** @var $repo \SatisAdmin\Model\Repository */
        $repo = $event->getData();
        if (null === $repo) {
            return;
        }

        $this->loadDataType($event->getForm(), $event->getData());
    }

    /**
     * @param FormEvent $event
     */
    public function onPreBind(FormEvent $event)
    {
        $repo = Repository::create($event->getData()['type'])->fromArray($event->getData());
        $event->getForm()->setData($repo);
        $this->loadDataType($event->getForm(), $repo);
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::PRE_BIND     => 'onPreBind',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'repository';
    }

    /**
     * @param FormInterface $form
     * @param Repository    $repository
     */
    protected function loadDataType(FormInterface $form, Repository $repository)
    {
        $formClass = 'SatisAdmin\Form\\'.ucfirst($repository->getType()).'RepositoryType';
        $form->remove('data');
        $form->add('data', new $formClass, ['virtual' => true, 'data_class' => get_class($repository)]);
    }

    /**
     * @return string[]
     */
    protected function getTypeChoices()
    {
        return [
            'composer' => 'Composer',
            'vcs'      => 'VCS',
            'pear'     => 'PEAR',
            'package'  => 'Package'
        ];
    }
}
