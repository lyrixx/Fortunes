Fortunes
========

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
