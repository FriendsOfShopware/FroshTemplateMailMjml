This is an extension for the plugin FroshTemplateMail. The plugin adds the extension .mjml, so you can use MJML for mail templates.
The MJML template is also interpreted by Smarty, so you can use variables.

### How do I use the plugin?

It must either be installed on the server MJML Global (PATH variable). Or you can use a web api which you insert into config.php.

#### Example mjml.io

```php
    'mjml_api' => 'https://user:key@api.mjml.io/v1/render'
```

#### Alternative MJML API

```php
    'mjml_api' => 'https://mjml.shyim.de'
```

#### Self-Hosted

[Repository](https://github.com/shyim/mjml-server)


The plugin is provided by the Github Organization [FriendsOfShopware](https://github.com/FriendsOfShopware/).
Maintainer of the plugin is [Soner Sayakci](https://github.com/shyim).
You can find the Github Repository [here](https://github.com/FriendsOfShopware/FroshTemplateMailMjml)
[For questions / errors please create a Github Issue](https://github.com/FriendsOfShopware/FroshTemplateMailMjml/issues/new)