<?php

namespace Lyrixx\Bundle\FortuneBundle\Twig;

class FortuneExtension extends \Twig_Extension
{
    private static $defaultColors = array(
        0 => '#fa3c3c',
        1 => '#00dc00',
        2 => '#1e3cff',
        3 => '#00c8c8',
        4 => '#f00082',
        5 => '#e6dc32',
        6 => '#f08228',
        7 => '#a000c8',
        8 => '#a0e632',
        9 => '#00a0ff',
        10 => '#e6af2d',
        11 => '#00d28c',
        12 => '#8200dc',
        13 => '#aaaaaa',
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
        $textRaw = $text;
        // We want to normalize the name
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        if (function_exists('iconv')) {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);

        // max is 255
        $hash = hexdec(substr(sha1($text), 0, 2));

        foreach ($this->ring as $color => $value) {
            if ($hash <= $value) {
                break;
            }
        }

        return sprintf('<span style="color:%s">%s</span>', $color, $textRaw);
    }

    public function getName()
    {
        return 'lyrixx_fortune';
    }
}
