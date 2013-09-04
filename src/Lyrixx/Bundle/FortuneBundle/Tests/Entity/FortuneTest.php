<?php

namespace Lyrixx\Bundle\FortuneBundle\Tests\Entity;

use Lyrixx\Bundle\FortuneBundle\Entity\Fortune;

class FortuneTest extends \PHPUnit_Framework_TestCase
{
    public function getIsQuotesValidTests()
    {
        return array(
            array(true, '<me> Hello'),
            array(true, <<<EOL
<me> Hello
<him> Hello !
EOL
            ),
            array(false, ''),
            array(false, 'Hello'),
            array(false, '<>'),
            array(false, '<me>'),
            array(false, '<>Hello'),
        );
    }

    /** @dataProvider getIsQuotesValidTests */
    public function testIsQuotesValid($expected, $quotes)
    {
        $fortune = new Fortune();
        $fortune->setQuotes($quotes);

        $this->assertSame($expected, $fortune->isQuotesValid());
    }

    public function testGetQuotesAsArray()
    {
        $fortune = new Fortune();
        $fortune->setQuotes(<<<EOL
This line should not exist, expects when importing legacy fortune.
<me> Hello
<him> Hi !
EOL
        );

        $expected = array(
            array(
                'nick' => '',
                'quote' => 'This line should not exist, exept when importing legacy fortunes.',
            ),
            array(
                'nick' => 'me',
                'quote' => 'Hello',
            ),
            array(
                'nick' => 'him',
                'quote' => 'Hi !',
            ),
        );

        $this->assertSame($expected, $fortune->getQuotesAsArray());
    }
}
