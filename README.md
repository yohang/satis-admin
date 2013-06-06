Satis Admin
===========

[![Build Status](https://travis-ci.org/yohang/satis-admin.png?branch=master)](https://travis-ci.org/yohang/satis-admin)

Satis Admin is a web-based version of Satis, the composer package repository generator.

It allows you to build the satis configuration json file, and to run the `satis build` task via web interface.

Screenshots
-----------

![Dashboard](https://s3-eu-west-1.amazonaws.com/frequence-web/misc/dashboard.png)
![Edit](https://s3-eu-west-1.amazonaws.com/frequence-web/misc/edit.png)

Requirements
------------

This project is based on [Silex](https://github.com/fabpot/Silex) and PHP5.4+

Installation
------------

```sh

 $ curl -sS https://getcomposer.org/installer | php
 $ php composer.phar create-project yohang/satis-admin
 $ php bin/console user:add username password

```

Run test suite
--------------

```sh
 $ php composer.phar install --dev
 $ ./bin/behat
```
