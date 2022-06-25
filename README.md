Random Profile Generator
=============
[![Github All Releases](https://img.shields.io/github/downloads/aksoyih/RandomProfile/total.svg)]()

Turkish profile generator

Features
------------
This package makes heavy use of the [FakerPHP/Faker](https://github.com/FakerPHP/Faker) to create totally random profiles with extensive details.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require aksoyih/random-profile
```

or add

```
"{package}": "aksoyih/random-profile"
```

to the require section of your `composer.json` file.
## Usage/Examples

Firstly, require the autoloader from Composer
```php
<?php
require_once "vendor/autoload.php";

```

Use `Aksoyih\RandomProfile\Profile()` to create and initialize a Profile instance.
```php
$profiles = new Aksoyih\RandomProfile\Profile();
```

Optionally, use `setNumberOfProfiles()` method to specify how many profiles you want to create. If it is not used only one profile is created.
```php
$profiles->setNumberOfProfiles(3);
```

Use `createProfiles()` method to create given amount of profiles.
```php
$profiles->createProfiles();
```

Finally, use `getProfiles()` method to get the created profiles.
```php
$profiles->getProfiles();
```

## Contributing

Contributions are always welcome!



[![MIT License](https://img.shields.io/apm/l/atomic-design-ui.svg?)](https://github.com/tterb/atomic-design-ui/blob/master/LICENSEs)
