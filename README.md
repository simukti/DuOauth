DuOauth
============
This ZF2 module provide user authentication using combination of Twitter OAuth, database checking, and Two-Factor-Authentication (Duo Security). 
Database checking process is up to developer, they can use mapper or whatever that return user data contain "username" field in a single array.

Goal
------------
* Simple and secure authentication.
* Works with Twitter API v1.1.
* For small web app/personal website.

Flow
------------
Twitter Oauth Authentication --> Duo Auth TFA --> Database Verification

Requirements
------------
* [Zend Framework 2](https://github.com/zendframework/zf2) (latest master)
* [ZendService Twitter](https://github.com/zendframework/ZendService_Twitter) (latest master)
* [Duo Security application keys](https://www.duosecurity.com)
* [Twitter OAuth consumer key/secret](https://developer.twitter.com)

Installation
------------
### (1) Installation

#### Download Zip/TarGz
Download from [github repo](https://github.com/simukti/DuOauth) ,extract, and place DuOauth folder in your application `module_paths`.

###  (2) Configuration

1. Ensure this module, `DuOauth` are enabled in your `application.config.php`:
2. Copy `./config/duoauth.config.php.dist` to `./config/duoauth.config.php`.
3. Fill required configuration variable values in  `./config/duoauth.config.php`

Note
-------
* Logic after auth success / after auth failed, and database checking implements `DuOauth\Mapper\UserFinderInterface` is up to you.
* You can set your route name after auth success (see more in `./config/duoauth.config.php`).
* Constructive feedbacks are welcome.

License
-------
This module released under the MIT License.  
See file LICENSE included with the source code for this project for a copy of the licensing terms.
