# API PHP Slim and Doctrine

Struturing API with PHP Slim and Doctrine.

* Composer Install:
```bash
$ curl -sS https://getcomposer.org/installer -o composer-setup.php
$ HASH=a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1
$ php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
$ sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
$ php -r "unlink('composer-setup.php');"
```

* Composer JSON:
```javascript
{
    "require": {
        "slim/slim": "^3.8",
        "slim/psr7": "^0.4.0",
        "doctrine/orm": "^2.5"
    },
    "autoload": {
        "psr-4": {"App\\": "./src"}
    }
}
```

### Struture

* bootstrap.php
* public/index.php
* vendor/autoload.php


## Referencias

[PHP Slim Docs](http://www.slimframework.com/docs/v3/tutorial/first-app.html)
[Doctrine DateTime](https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/cookbook/working-with-datetime.html#working-with-datetime-instances)