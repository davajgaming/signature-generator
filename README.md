# Signature Generator Framework

Copyright (c) 2010 Sam Thompson 
http://www.opensource.org/licenses/mit-license.php The MIT License

All images, characters, and related content is property of their respective owners. The licence does not apply to these items, only to the code and images produced by the author(s) of this software.

## Requirements
 * PHP 5.3.0 min
 * PDO
 * PHP-GD library
 * DBMS with a PDO driver

## Installation

Copy the "signature" directory to a location on your server.
Rename signature/sample.config.php to signature/config.php

### config.php vars
 * $dsn: The PDO connection string
 * $dbUser: Username for the database
 * $dbPass: Password for user mentioned above
 