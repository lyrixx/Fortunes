<?php

namespace Lyrixx\Bundle\FortuneBundle\Twig;

class FortuneExtension extends \Twig_Extension
{
    private static $defaultColors = array(
        '#FF0000',
        '#FF7F00',
        '#FFFF00',
        '#00FF00',
        '#0000FF',
        '#4B0082',
        '#8F00FF',
    );

    private $ring;

    public function __construct(array $colors = array())
    {
        $colors = $colors ?: self::$defaultColors;

        // the max hash is 255
        $onePieceOfRing = 255 / count($colors);
        $this->ring = array_map(function($v) use ($onePieceOfRing) {
            return ($v + 1) * $onePieceOfRing;
        }, array_flip($colors));

    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('random_color', array($this, 'randomColor'), array('is_safe' => array('html'))),
        );
    }

    public function randomColor($text)
    {
        // max is 255
        $hash = hexdec(substr(sha1($text), 0, 2));

        foreach ($this->ring as $color => $value) {
            if ($hash <= $value) {
                break;
            }
        }

        return sprintf('<span style="color:%s">%s</span>', $color, $text);
    }

    public function getName()
    {
        return 'lyrixx_fortune';
    }
}
