<?php
namespace Intaro\LibraryBundle\Twig;

class ImageToolsExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('show_image', array($this, 'showImage'), array('is_safe' => array('html'))),
        );
    }

    public function showImage($src, $width = 125, $height = 125, $alt = "", $class = "")
    {
        if(strlen($class))
            $class = "class=\"" . $class . "\" ";
        $alt = "alt=\"" . htmlspecialchars($alt) . "\" ";
        return "<img src=" . $src. " width=" . $width . " height=" . $height . " " . $class . $alt. " />";
    }

    public function getName()
    {
        return 'image_tools_extensions';
    }
}