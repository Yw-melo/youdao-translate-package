## This package based on youdao translate API.

## Install

```shell
composer require ywmelo/translate
```
## Publish config file.
```shell
php artisan vendor:publish --provider="Youdao\\Translate\\TranslateServiceProvider" --tag="config"
```

## Use
```php
$translate = app('translate');
//$translate = new \Youdao\Translate\Translate();

$translate->translate('你好帅', 'zh-CHS', 'en');
```
##Detailed documentation

https://ai.youdao.com/docs/doc-trans-api.s#p01 
