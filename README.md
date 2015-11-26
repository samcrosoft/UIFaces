UIFaces
=======

![Travis](https://api.travis-ci.org/samcrosoft/UIFaces.svg)

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