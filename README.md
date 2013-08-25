Fortunes
========

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a3518a42-a1f6-4874-9c2e-901be8fcb61a/mini.png)](https://insight.sensiolabs.com/projects/a3518a42-a1f6-4874-9c2e-901be8fcb61a)
[![Build Status](https://travis-ci.org/lyrixx/Fortunes.png?branch=master)](https://travis-ci.org/lyrixx/Fortunes)

Screenshot
----------
[![Screenshot](https://raw.github.com/lyrixx/Fortunes/master/src/Lyrixx/Bundle/FortuneBundle/Resources/doc/screenshot.png)](https://raw.github.com/lyrixx/Fortunes/master/src/Lyrixx/Bundle/FortuneBundle/Resources/doc/screenshot.png)

Installation
------------

    curl -sS https://getcomposer.org/installer | php
    php composer.phar install
    php app/console doctrine:database:create
    php app/console doctrine:schema:update --force
    php app/console assetic:dump --env="prod"

    # Enjoy

Security
--------

If you want to add a security layer to this application, copy
`app/config.security.yml.dist` to `app/config.security.yml`. By default, this
file add HTTP Basic authentication with the `user` as username. The password
(plain text) is stored in `app/config/parameter.yml`. But feed free to adapt to
your needs.

License
-------

This library is under the MIT license. For the full copyright and license
information, please view the LICENSE file that was distributed with this source
code.
