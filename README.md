# MJML Extension for FroshTemplateMail

## Requirements

* FroshTemplateMail installed
* MJML installed and available in PATH or with a web api

## Template location

Example Mail **sORDER**

* HTML Template
  * themes/Frontend/MyTheme/email/sORDER.html.mjml

## Disable Cache

While developing set backend cache to `Blackhole` to disable cache. See guide https://en-community.shopware.com/_detail_1961.html#Debug_configuration

## Web API

If you cannot install mjml on the host, you can use the web api. Add the following configuration to your config.php

```php
    'mjml_api' => 'https://user:key@api.mjml.io/v1/render'
```

If you don't have a user account or public key, you can use this public available API endpoint. 

```php
    'mjml_api' => 'https://mjml.shyim.de'
```

otherwise you can also host your own mjml server see [Repository](https://github.com/shyim/mjml-server)
