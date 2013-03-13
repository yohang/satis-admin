<?php

namespace SatisAdmin\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class PearRepositoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url')
            ->add('vendorAlias', null, ['required' => true]);
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
        return 'pear_repository';
    }
}
