<?php

namespace Flowcode\DashboardBundle\Form\Type;

use Flowcode\DashboardBundle\Entity\Setting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SettingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', ChoiceType::class, array(
                'choices' => array(
                    Setting::SITE_NAME => Setting::SITE_NAME,
                    Setting::SITE_URL => Setting::SITE_URL,
                    Setting::HOME_SLUG => Setting::HOME_SLUG,
                    Setting::ACTIVE_THEME => Setting::ACTIVE_THEME,
                ),
            ))
            ->add('value');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Flowcode\DashboardBundle\Entity\Setting',
            'translation_domain' => 'Setting',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'setting';
    }
}
