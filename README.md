[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Feventum%2Frpc.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2Feventum%2Frpc?ref=badge_shield)

eventum-rpc
===========

Eventum RPC Client Library.

## Install via Composer ##

We recommend installing this package with [Composer](http://getcomposer.org/).

### Download Composer ###

To download Composer, run in the root directory of your project:

```bash
curl -sS https://getcomposer.org/installer | php
```

You should now have the file `composer.phar` in your project directory.

### Install Dependencies ###

Run in your project root:

```
php composer.phar require eventum/rpc
```

You should now have the files `composer.json` and `composer.lock` as well as
the directory `vendor` in your project directory. If you use a version control
system, `composer.json` should be added to it.

### Require Autoloader ###

After installing the dependencies, you need to require the Composer autoloader
from your code:

```php
require __DIR__ . '/vendor/autoload.php';
```

## Usage ##

```php
<?php

require __DIR__ . '/vendor/autoload.php';

$rpc_url = "http://example.org/rpc/xmlrpc.php";
$client = new Eventum_RPC($rpc_url);
$client->setCredentials("user@example.org", "password");

// add user@example.org as authorized replier in issue $issue_id belonging to project $project_id
$client->addAuthorizedReplier($issue_id, $project_id, "user@example.org");
```

The available XMLRPC Methods can be seen from [here](XMLRPC.md).

## Copyright and License ##

This software is Copyright (c) 2008 - 2017 Eventum Team.

This is free software, licensed under the GNU General Public License
version 2.


[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Feventum%2Frpc.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Feventum%2Frpc?ref=badge_large)