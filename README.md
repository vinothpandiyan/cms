yii2-cms
=========

Yii2 cms module
Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist caritor/yii2-cms "*"
```

or add

```
"cms/yii2-cms": "*"
```

to the require section of your `composer.json` file.

Apply migration
```sh
yii migrate --migrationPath=vendor/caritor/yii2-cms/migrations
```

Configuration:

```php
'modules' => [
    'cms' => [
        'class' => 'caritor\cms\Module'
    ],
],
```