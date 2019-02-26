Dies ist eine Erweiterung für das Plugin FroshTemplateMail. Das Plugin fügt die Extension .mjml ein, so können Sie MJML für Mail Templates verwenden.
Das MJML Template wird ebenfalls durch Smarty interpretiert, so dass Sie Variabeln verwenden können

### Wie benutze ich das Plugin?

Es muss entweder auf dem Server MJML installiert sein Global (PATH Variable). Oder Sie können eine Web-Api benutzen die Sie in die config.php einfügen.


#### Beispiel mjml.io

```php
    'mjml_api' => 'https://user:key@api.mjml.io/v1/render'
```

#### Alternative MJML API

```php
    'mjml_api' => 'https://mjml.shyim.de'
```

#### Selber Hosten

[Repository](https://github.com/shyim/mjml-server)

Das Plugin wird von der Github Organization [FriendsOfShopware](https://github.com/FriendsOfShopware/) entwickelt.
Maintainer des Plugin ist [Soner Sayakci](https://github.com/shyim).
Das Github Repository ist zu finden [hier](https://github.com/FriendsOfShopware/FroshTemplateMailMjml)
[Bei Fragen / Fehlern bitte ein Github Issue erstellen](https://github.com/FriendsOfShopware/FroshTemplateMailMjml/issues/new)