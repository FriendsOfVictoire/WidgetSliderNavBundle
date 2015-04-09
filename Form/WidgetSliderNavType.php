<?php

namespace Victoire\Widget\SliderNavBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\Bundle\CoreBundle\Form\WidgetType;
use Victoire\Bundle\WidgetBundle\Entity\Widget;
use Symfony\Component\Form;
use Doctrine\ORM\EntityRepository;

/**
 * WidgetSliderNav form type
 */
class WidgetSliderNavType extends WidgetType
{
    /**
     * define form fields
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (Widget::MODE_STATIC == $options['mode']) {
            $builder
                ->add('title', null, array(
                        'label' => 'widget_slidernav.form.title.label',
                ))->add('picture', 'media', array(
                        'label' => 'widget_slidernav.form.picture.label',
                ))->add('leftLink', 'victoire_link', array(
                        'label' => 'widget_slidernav.form.leftLink.label',
                ))->add('leftPicture', 'media', array(
                        'label' => 'widget_slidernav.form.leftPicture.label',
                ))->add('rightLink', 'victoire_link', array(
                        'label' => 'widget_slidernav.form.rightLink.label',
                ))->add('rightPicture', 'media', array(
                        'label' => 'widget_slidernav.form.rightPicture.label',
                ));
        } else {
            $builder
                ->add('targetPattern', null, array(
                        'label' => 'widget_slidernav.form.targetPattern.label',
                        'empty_value' => false,
                        'query_builder' => function (EntityRepository $er) use ($options) {
                            return $er->getPagePatternByBusinessEntity($options['entityName']);
                        },
                ));
        }
        parent::buildForm($builder, $options);
    }

    /**
     * bind form to WidgetSliderNav entity
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'data_class'         => 'Victoire\Widget\SliderNavBundle\Entity\WidgetSliderNav',
            'widget'             => 'SliderNav',
            'translation_domain' => 'victoire',
        ));
    }

    /**
     * get form name
     *
     * @return string The form name
     */
    public function getName()
    {
        return 'victoire_widget_form_slidernav';
    }
}
