<?php

namespace Victoire\Widget\SliderNavBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\Bundle\CoreBundle\Form\WidgetType;
use Victoire\Bundle\WidgetBundle\Entity\Widget;

/**
 * WidgetSliderNav form type.
 */
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
                ])->add('picture', 'media', [
                        'label' => 'widget_slidernav.form.picture.label',
                ])->add('leftLink', 'victoire_link', [
                        'label' => 'widget_slidernav.form.leftLink.label',
                ])->add('leftPicture', 'media', [
                        'label' => 'widget_slidernav.form.leftPicture.label',
                ])->add('rightLink', 'victoire_link', [
                        'label' => 'widget_slidernav.form.rightLink.label',
                ])->add('rightPicture', 'media', [
                        'label' => 'widget_slidernav.form.rightPicture.label',
                ]);
        } else {
            $builder
                ->add('targetPattern', null, [
                        'label'         => 'widget_slidernav.form.targetPattern.label',
                        'empty_value'   => false,
                        'query_builder' => function (EntityRepository $er) use ($options) {
                            return $er->getPagePatternByBusinessEntity($options['businessEntityId']);
                        },
                ]);
        }
        parent::buildForm($builder, $options);
    }

    /**
     * bind form to WidgetSliderNav entity.
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'data_class'         => 'Victoire\Widget\SliderNavBundle\Entity\WidgetSliderNav',
            'widget'             => 'SliderNav',
            'translation_domain' => 'victoire',
        ]);
    }

    /**
     * get form name.
     *
     * @return string The form name
     */
    public function getName()
    {
        return 'victoire_widget_form_slidernav';
    }
}
