Victoire DCMS SliderNav Bundle
============

##What is the purpose of this bundle

This bundles gives you access to the *SliderNav Widget* which set up a navigation slider.
You can define the main picture and the pictures on each side with their link.

##Set Up Victoire

If you haven't already, you can follow the steps to set up Victoire *[here](https://github.com/Victoire/victoire/blob/master/setup.md)*

##Install the bundle

    php composer.phar require friendsofvictoire/slidernav-widget

###Reminder

Do not forget to add the bundle in your AppKernel !

```php
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                ...
                new Victoire\Widget\SliderNavBundle\VictoireWidgetSliderNavBundle(),
            );

            return $bundles;
        }
    }
```
