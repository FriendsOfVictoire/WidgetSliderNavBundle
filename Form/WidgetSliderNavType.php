<?php

namespace Victoire\Widget\SliderNavBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Victoire\Bundle\BusinessPageBundle\Repository\BusinessTemplateRepository;
use Victoire\Bundle\CoreBundle\Form\WidgetType;
use Victoire\Bundle\FormBundle\Form\Type\LinkType;
use Victoire\Bundle\MediaBundle\Form\Type\MediaType;
use Victoire\Bundle\WidgetBundle\Entity\Widget;

class WidgetSliderNavType extends WidgetType
{
    /**
     * define form fields.
     *
     * @param FormBuilderInterface $builder
     *
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (Widget::MODE_STATIC == $options['mode']) {
            $builder
                ->add('title', null, [
                    'label' => 'widget_slidernav.form.title.label',
                ])->add('picture', MediaType::class, [
                    'label' => 'widget_slidernav.form.picture.label',
                ])->add('leftLink', LinkType::class, [
                    'label' => 'widget_slidernav.form.leftLink.label',
                ])->add('leftPicture', MediaType::class, [
                    'label' => 'widget_slidernav.form.leftPicture.label',
                ])->add('rightLink', LinkType::class, [
                    'label' => 'widget_slidernav.form.rightLink.label',
                ])->add('rightPicture', MediaType::class, [
                    'label' => 'widget_slidernav.form.rightPicture.label',
                ]);
        } else {
            $builder
                ->add('targetPattern', null, [
                        'label'         => 'widget_slidernav.form.targetPattern.label',
                        'empty_value'   => false,
                        'query_builder' => function (EntityRepository $er) use ($options) {
                            /* @var BusinessTemplateRepository $er */
                            return $er->getPagePatternByBusinessEntity($options['businessEntityId']);
                        },
                ]);
        }
        parent::buildForm($builder, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class'         => 'Victoire\Widget\SliderNavBundle\Entity\WidgetSliderNav',
            'widget'             => 'SliderNav',
            'translation_domain' => 'victoire',
        ]);
    }
}
