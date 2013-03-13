<?php

namespace SatisAdmin\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class VcsRepositoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('url');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['virtual' => true]);
    }


    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'vcs_repository';
    }
}
