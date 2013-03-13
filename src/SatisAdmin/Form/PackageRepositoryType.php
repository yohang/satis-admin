<?php

namespace SatisAdmin\Form;

use SatisAdmin\Form\DataTransformer\ArrayToJsonDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class PackageRepositoryType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('package', 'textarea', [])
            ->get('package')->addViewTransformer(new ArrayToJsonDataTransformer);
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['virtual' => true]);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'package_repository';
    }
}
