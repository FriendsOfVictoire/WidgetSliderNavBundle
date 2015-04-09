<?php

namespace Victoire\Widget\SliderNavBundle\Resolver;

use Victoire\Bundle\WidgetBundle\Model\Widget;
use Victoire\Bundle\WidgetBundle\Resolver\BaseWidgetContentResolver;
use Doctrine\ORM\EntityManager;
/**
 * CRUD operations on WidgetSliderNav Widget
 *
 * The widget view has two parameters: widget and content
 *
 * widget: The widget to display, use the widget as you wish to render the view
 * content: This variable is computed in this WidgetManager, you can set whatever you want in it and display it in the show view
 *
 * The content variable depends of the mode: static/businessEntity/entity/query
 *
 * The content is given depending of the mode by the methods:
 *  getWidgetStaticContent
 *  getWidgetBusinessEntityContent
 *  getWidgetEntityContent
 *  getWidgetQueryContent
 *
 * So, you can use the widget or the content in the show.html.twig view.
 * If you want to do some computation, use the content and do it the 4 previous methods.
 *
 * If you just want to use the widget and not the content, remove the method that throws the exceptions.
 *
 * By default, the methods throws Exception to notice the developer that he should implements it owns logic for the widget
 */
class WidgetSliderNavContentResolver extends BaseWidgetContentResolver
{
    private $entityManager;

    /**
     * @param EntityManager $entityManager We need to query the database
     *                                     \ for the next and prev objects
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Get the static content of the widget
     *
     * @param  Widget $widget
     * @return string The static content
     */
    public function getWidgetStaticContent(Widget $widget)
    {
        return parent::getWidgetStaticContent($widget);
    }

    /**
     * Get the business entity content
     * @param  Widget $widget
     * @return string
     */
    public function getWidgetBusinessEntityContent(Widget $widget)
    {
        $parameters = parent::getWidgetBusinessEntityContent($widget);

        //get previous and next record if entity is set
        if ($entity = $widget->getEntity()) {
            $repository = $this->entityManager->getRepository(get_class($entity));
            $parameters['previousRecord'] = self::getPreviousRecord($repository, $entity);
            $parameters['nextRecord'] = self::getNextRecord($repository, $entity);
        }

        return $parameters;
    }

    /**
     * Get the content of the widget by the entity linked to it
     *
     * @param Widget $widget
     *
     * @return string
     */
    public function getWidgetEntityContent(Widget $widget)
    {
        return parent::getWidgetEntityContent($widget);
    }

    /**
     * Get the content of the widget for the query mode
     *
     * @param  Widget     $widget
     * @throws \Exception
     */
    public function getWidgetQueryContent(Widget $widget)
    {
        return parent::getWidgetQueryContent($widget);
    }

    /**
     * @param \Doctrine\ORM\EntityRepository $repository
     * @param mixed                          $entity
     */
    protected static function getPreviousRecord($repository, $entity)
    {
        //check if an overriden method exists
        if (method_exists($repository, 'getPreviousRecord')) {
            //run method then
            $previousRecord = $repository->getPreviousRecord();
        } else {
            //run default method to get previous record
            $queryBuilder = $repository->createQueryBuilder('a');
            $previousRecord = $queryBuilder
                ->where($queryBuilder->expr()->lt('a.id', ':id'))
                ->setParameter('id', $entity->getId())
                ->orderBy('a.id', 'DESC')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
            //if there isn't any previous record, we try to get the very last result
            if (!$previousRecord) {
                if (method_exists($repository, 'getVeryLastRecord')) {
                    //run overriden method then
                    $previousRecord = $repository->getVeryLastRecord();
                } else {
                    //run default method to get the very last record
                    $queryBuilder = $repository->createQueryBuilder('a');
                    $previousRecord = $queryBuilder
                        ->orderBy('a.id', 'DESC')
                        ->setMaxResults(1)
                        ->getQuery()
                        ->getOneOrNullResult();
                    //if the last record is the same as the entity, we set null
                    if ($previousRecord === $entity) {
                        $previousRecord = null;
                    }
                }
            }
        }

        return $previousRecord;
    }

    /**
     * @param \Doctrine\ORM\EntityRepository $repository
     * @param mixed                          $entity
     */
    protected static function getNextRecord($repository, $entity)
    {
        //check if an overriden method exists
        if (method_exists($repository, 'getNextRecord')) {
            //run method then
            $nextRecord = $repository->getNextRecord();
        } else {
            //run default method to get next record
            $queryBuilder = $repository->createQueryBuilder('a');
            $nextRecord = $queryBuilder
                ->where($queryBuilder->expr()->gt('a.id', ':id'))
                ->setParameter('id', $entity->getId())
                ->orderBy('a.id', 'ASC')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
            //if there isn't any next record, we try to get the very first result
            if (!$nextRecord) {
                if (method_exists($repository, 'getVeryLastRecord')) {
                    //run overriden method then
                    $nextRecord = $repository->getVeryLastRecord();
                } else {
                    //run default method to get the very first record
                    $queryBuilder = $repository->createQueryBuilder('a');
                    $nextRecord = $queryBuilder
                        ->orderBy('a.id', 'ASC')
                        ->setMaxResults(1)
                        ->getQuery()
                        ->getOneOrNullResult();
                    //if the first record is the same as the entity, we set null
                    if ($nextRecord === $entity) {
                        $nextRecord = null;
                    }
                }
            }
        }

        return $nextRecord;
    }
}
