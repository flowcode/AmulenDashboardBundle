<?php

namespace Flowcode\DashboardBundle\Form\Type;

use Flowcode\DashboardBundle\Entity\Setting;
use Flowcode\DashboardBundle\Service\SettingService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SettingType extends AbstractType
{

    /**
     * @var SettingService
     */
    protected $settingService;

    /**
     * SettingType constructor.
     * @param SettingService $settingService
     */
    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    private function getChoices()
    {
        $choices = [];
        $settingOptions = $this->settingService->getAll();
        foreach ($settingOptions as $settingOption) {
            $choices[$settingOption['key']] = $settingOption['label'];
        }
        return $choices;
    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', ChoiceType::class, array(
                'choices' => $this->getChoices(),
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
