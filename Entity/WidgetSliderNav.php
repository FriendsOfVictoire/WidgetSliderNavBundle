<?php

namespace Victoire\Widget\SliderNavBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Victoire\Bundle\CoreBundle\Annotations as VIC;
use Victoire\Bundle\WidgetBundle\Entity\Widget;

/**
 * WidgetSliderNav.
 *
 * @ORM\Table("vic_widget_slidernav")
 * @ORM\Entity
 */
class WidgetSliderNav extends Widget
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=55, nullable=true)
     * @VIC\ReceiverProperty("textable")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="\Victoire\Bundle\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="picture_id", referencedColumnName="id", onDelete="CASCADE")
     * @VIC\ReceiverProperty("imageable")
     */
    protected $picture;

    /**
     * @ORM\OneToOne(targetEntity="Victoire\Bundle\CoreBundle\Entity\Link", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="leftLink_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     **/
    protected $leftLink;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="\Victoire\Bundle\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="left_picture_id", referencedColumnName="id", onDelete="CASCADE")
     * @VIC\ReceiverProperty("imageable")
     */
    protected $leftPicture;

    /**
     * @ORM\OneToOne(targetEntity="Victoire\Bundle\CoreBundle\Entity\Link", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="rightLink_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     **/
    protected $rightLink;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="\Victoire\Bundle\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="right_picture_id", referencedColumnName="id", onDelete="CASCADE")
     * @VIC\ReceiverProperty("imageable")
     */
    protected $rightPicture;

    /**
     * @ORM\ManyToOne(targetEntity="Victoire\Bundle\BusinessPageBundle\Entity\BusinessTemplate")
     */
    protected $targetPattern;

    /**
     * To String function
     * Used in render choices type (Especially in VictoireWidgetRenderBundle).
     *
     * @return string
     */
    public function __toString()
    {
        return 'SliderNav #'.$this->id.' - '.$this->title;
    }

    /**
     * Set title.
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set picture.
     *
     * @param string $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture.
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set leftLink.
     *
     * @param string $leftLink
     */
    public function setLeftLink($leftLink)
    {
        $this->leftLink = $leftLink;

        return $this;
    }

    /**
     * Get leftLink.
     *
     * @return string
     */
    public function getLeftLink()
    {
        return $this->leftLink;
    }

    /**
     * Set leftPicture.
     *
     * @param string $leftPicture
     */
    public function setLeftPicture($leftPicture)
    {
        $this->leftPicture = $leftPicture;

        return $this;
    }

    /**
     * Get leftPicture.
     *
     * @return string
     */
    public function getLeftPicture()
    {
        return $this->leftPicture;
    }

    /**
     * Set rightLink.
     *
     * @param string $rightLink
     */
    public function setRightLink($rightLink)
    {
        $this->rightLink = $rightLink;

        return $this;
    }

    /**
     * Get rightLink.
     *
     * @return string
     */
    public function getRightLink()
    {
        return $this->rightLink;
    }

    /**
     * Set rightPicture.
     *
     * @param string $rightPicture
     */
    public function setRightPicture($rightPicture)
    {
        $this->rightPicture = $rightPicture;

        return $this;
    }

    /**
     * Get rightPicture.
     *
     * @return string
     */
    public function getRightPicture()
    {
        return $this->rightPicture;
    }

    /**
     * Get leftLink (previousRecord) and rightLink (nextRecord) targetPattern.
     *
     * @return string
     */
    public function getTargetPattern()
    {
        return $this->targetPattern;
    }

    /**
     * Set targetPattern.
     *
     * @param string $targetPattern
     *
     * @return $this
     */
    public function setTargetPattern($targetPattern)
    {
        $this->targetPattern = $targetPattern;

        return $this;
    }
}
