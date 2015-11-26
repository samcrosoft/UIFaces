UIFaces
=======

[![Latest Version on Packagist](https://img.shields.io/packagist/v/samcrosoft/uifaces.svg?style=flat-square)](https://packagist.org/packages/samcrosoft/uifaces)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/samcrosoft/uifaces/master.svg?style=flat-square)](https://travis-ci.org/samcrosoft/uifaces)
[![Quality Score](https://img.shields.io/scrutinizer/g/samcrosoft/uifaces.svg?style=flat-square)](https://scrutinizer-ci.com/g/samcrosoft/uifaces)
[![Total Downloads](https://img.shields.io/packagist/dt/samcrosoft/uifaces.svg?style=flat-square)](https://packagist.org/packages/samcrosoft/uifaces)

UIFaces is a well written, lightweight PHP library that helps communicate with the UIFaces API

Create a UIFaces Generator

```php
<?php
$oGenerator = new Samcrosoft\UIFaces\Generators();

```

To Get UIFaces of a specific user

```php
<?php

$oUserSpecific = $oGenerator->getUser('calebogden');

// To get the Username
echo $oUserSpecific->getUsername();

// To get the Normal Image
echo $oUserSpecific->getNormalImage();
```

To get UIFaces of a random user
```php
<?php

$oUser = $oGenerator->getRandomUser();

// To get the Username
echo $oUser->getUsername();

// To get the Normal Image
echo $oUser->getNormalImage();
```


To get UIFaces for multiple random users
```php
<?php

$oUser = $oGenerator->getRandomUser();

// To get the Username
echo $oUser->getUsername();

// To get the Normal Image
echo $oUser->getNormalImage();
```