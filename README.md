Fortunes
========

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a3518a42-a1f6-4874-9c2e-901be8fcb61a/mini.png)](https://insight.sensiolabs.com/projects/a3518a42-a1f6-4874-9c2e-901be8fcb61a)
[![Build Status](https://travis-ci.org/lyrixx/Fortunes.png?branch=master)](https://travis-ci.org/lyrixx/Fortunes)

Screenshot
----------
[![Screenshot](https://github.com/lyrixx/Fortunes/blob/master/src/Lyrixx/Bundle/FortuneBundle/Resources/doc/screenshot.png)](https://github.com/lyrixx/Fortunes/blob/master/src/Lyrixx/Bundle/FortuneBundle/Resources/doc/screenshot.png)

Installation
------------

    curl -sS https://getcomposer.org/installer | php
    php composer.phar install
    php app/console doctrine:database:create
    php app/console doctrine:schema:update --force
    php app/console assetic:dump --env="prod"

    # Enjoy

License
-------

This library is under the MIT license. For the full copyright and license
information, please view the LICENSE file that was distributed with this source
code.
