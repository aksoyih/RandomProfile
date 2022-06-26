Random Profile Generator
=============
[![Latest Stable Version](http://poser.pugx.org/aksoyih/random-profile/v)](https://packagist.org/packages/aksoyih/random-profile) [![Total Downloads](http://poser.pugx.org/aksoyih/random-profile/downloads)](https://packagist.org/packages/aksoyih/random-profile) [![Latest Unstable Version](http://poser.pugx.org/aksoyih/random-profile/v/unstable)](https://packagist.org/packages/aksoyih/random-profile) [![License](http://poser.pugx.org/aksoyih/random-profile/license)](https://packagist.org/packages/aksoyih/random-profile) [![PHP Version Require](http://poser.pugx.org/aksoyih/random-profile/require/php)](https://packagist.org/packages/aksoyih/random-profile)

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

##Example Profile

```json
// 20220626132250
// http://localhost/test/

[
  {
    "gender": "female",
    "name": "Ece",
    "surname": "Yazıcı",
    "tckn": "37555325128",
    "serialNumber": "XX0X1EHDY",
    "birthdate": "1970-11-03",
    "age": 51,
    "titles": {
      "academic_title": null
    },
    "email": "ece.yazici.kastamonu@example.com",
    "phone": {
      "number": "05516725051",
      "device_operation_system": "iOS",
      "device": "Apple iPhone SE 2020",
      "imei": "253945664829579"
    },
    "loginCredentials": {
      "username": "kastamonu_ece25",
      "email": "ece.yazici.kastamonu@example.com",
      "password": "$J.J(Iz*M1)_}i{me",
      "salt": "=uwFya_qQ@or,<~~K&rfe9CC\"",
      "hash": "Gc&E&=ybGE\"1Glp&-f$,",
      "md5": "0986c1dffbfd39e99a209e43771b035d",
      "sha1": "31f16c3351a53d6f7fa45fd74381f4d7fe4d7528",
      "sha256": "$2y$10$kYyQOcumEt.tt3yTJiP9.OLe84HNpvCfoAXF5itBFpJdoVQiQtXKW",
      "created_at": "2021-11-03 22:17:10",
      "updated_at": "2021-01-19 06:15:05"
    },
    "miscellaneous": {
      "favorite_emojis": [
        "😡",
        "😂"
      ],
      "language_code": "ta",
      "country_code": "TK",
      "locale_data": "sv_FI",
      "currency_code": "BBD"
    },
    "networkInfo": {
      "ipv_4": "83.76.164.69",
      "ipv_6": "c7e7:d8e8:13c4:da4e:a343:ab59:2c0a:20ed",
      "mac_address": "DB:65:05:1F:C2:21"
    },
    "maritalInfo": {
      "status": "married",
      "marriage_date": "1983-05-10",
      "marriedFor": 39,
      "spouse": {
        "gender": "male",
        "name": "Sarp",
        "surname": "Yazıcı",
        "tckn": "20883598418",
        "serialNumber": "UNXPTRE4J",
        "birthdate": "1950-07-28",
        "age": 71,
        "email": "keseroglu_bitlis@example.com",
        "phone": {
          "number": "0 (505) 013 79 80",
          "device_operation_system": "iOS",
          "device": "Apple iPhone 12",
          "imei": "572518440097912"
        }
      }
    },
    "children": {
      "count": 2,
      "children": [
        {
          "gender": "female",
          "name": "Ümran",
          "surname": "Yazıcı",
          "tckn": "56107641066",
          "serialNumber": "MBVJB60TB",
          "birthdate": "1998-10-15",
          "age": 23,
          "email": "pekkan_umran@example.com",
          "phone": {
            "number": "0 (222) 687 19 25",
            "device_operation_system": "Android",
            "device": "Samsung Galaxy S9",
            "imei": "487564188315789"
          },
          "address": {
            "fullAddress": "Çaycevher köyü, ramazan mevkii Taşköprü 77 /  Kastamonu",
            "city": "Kastamonu",
            "district": "Taşköprü",
            "street": "Çaycevher köyü, ramazan mevkii",
            "apartmentNumber": 77,
            "postalCode": 74949,
            "timeZone": {
              "timeZone": "Europe/Istanbul",
              "time": "13:22:50"
            },
            "coordinates": {
              "latitute": "41,38871",
              "longitute": "33,78273"
            },
            "openstreetmap_link": "https://www.openstreetmap.org/?mlat=41,38871&mlon=33,78273"
          }
        },
        {
          "gender": "male",
          "name": "Doruk",
          "surname": "Yazıcı",
          "tckn": "73683349216",
          "serialNumber": "FZ5WITPKW",
          "birthdate": "2017-03-25",
          "age": 5,
          "email": "doruk.denkel@example.com",
          "phone": {
            "number": "0 (507) 943 66 02",
            "device_operation_system": "iOS",
            "device": "Apple iPhone 11",
            "imei": "026461998721348"
          },
          "address": {
            "fullAddress": "Çaycevher köyü, ramazan mevkii Taşköprü 77 /  Kastamonu",
            "city": "Kastamonu",
            "district": "Taşköprü",
            "street": "Çaycevher köyü, ramazan mevkii",
            "apartmentNumber": 77,
            "postalCode": 74949,
            "timeZone": {
              "timeZone": "Europe/Istanbul",
              "time": "13:22:50"
            },
            "coordinates": {
              "latitute": "41,38871",
              "longitute": "33,78273"
            },
            "openstreetmap_link": "https://www.openstreetmap.org/?mlat=41,38871&mlon=33,78273"
          }
        }
      ]
    },
    "address": {
      "fullAddress": "Çaycevher köyü, ramazan mevkii Taşköprü 77 /  Kastamonu",
      "city": "Kastamonu",
      "district": "Taşköprü",
      "street": "Çaycevher köyü, ramazan mevkii",
      "apartmentNumber": 77,
      "postalCode": 74949,
      "timeZone": {
        "timeZone": "Europe/Istanbul",
        "time": "13:22:50"
      },
      "coordinates": {
        "latitute": "41,38871",
        "longitute": "33,78273"
      },
      "openstreetmap_link": "https://www.openstreetmap.org/?mlat=41,38871&mlon=33,78273"
    },
    "bankAccount": {
      "iban": "TR79694464241X1J7P46986BJ3",
      "bic": "LVRJXA9S",
      "bank": "Türkiye Vakıflar Bankası",
      "currency": "TRY",
      "balance": 50648.65,
      "debt": 6245.49
    },
    "images": {
      "avatar": "https://avatars.dicebear.com/api/personas/cercetin.jpg",
      "profile_picture": "https://xsgames.co/randomusers/avatar.php?g=female",
      "pixel_art": "https://xsgames.co/randomusers/avatar.php?g=pixel"
    },
    "job": {
      "workingStatus": "working",
      "company": "Başoğlu Ticaret A.Ş.",
      "position": "Falcı",
      "startDate": "2010-10-19",
      "endDate": null,
      "experience": 11,
      "salary": {
        "monthly": 17563.76,
        "annually": 210765.12
      }
    }
  }
]
```

## Contributing

Contributions are always welcome!



[![MIT License](https://img.shields.io/apm/l/atomic-design-ui.svg?)](https://github.com/tterb/atomic-design-ui/blob/master/LICENSEs)
