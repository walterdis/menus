# Menus

A nice Menu builder for PHP.


![Version](http://img.shields.io/packagist/v/lavary/menus.svg?style=flat-square)
![Build](http://img.shields.io/travis/lavary/menus.svg?style=flat-square)


* [Documentation](https://github.com/lavary/menus/wiki/Menus)

To install it, use composer:

```bash
composer require lavary/menus
```

You can create a menu by calling `make()` method.

Here's a basic usage:

```php
<?php

use Lavary\Menus\MenuBuilder;

$builder = new MenuBuilder();

$builder->make('MyNavBar', function($menu) {
  
  $menu->add('Home');
  
  $menu->add('About', ['url' => 'about', 'class' => 'foo bar', 'data-role' => 'item'])->data('weight', 15);
  $menu->about->add('Goals', 'about/goals');
  
  $menu->add('services', 'services');
  $menu->add('Contact', 'contact');
  
});

echo $builder->get('myNavBar')->asBootstrap(['navbar-inverse']);

// or

echo $builder->get('myNavBar')->asUl();
```

Please checkout the [documentation](https://github.com/lavary/menus/wiki/Menus) to learn about all the features.


## If You Need Help

Please submit all issues and questions using GitHub issues and I will try to help you.


## License

*Menus* is free software distributed under the terms of the MIT license.
