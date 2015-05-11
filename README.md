Congres
=======

[![Build Status](https://travis-ci.org/LePartiDeGauche/congres.svg?branch=master)](https://travis-ci.org/LePartiDeGauche/congres)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/2277f988-ed05-44c8-bdbf-74bd53f7eec2/mini.png)](https://insight.sensiolabs.com/projects/2277f988-ed05-44c8-bdbf-74bd53f7eec2)

First user creation
-------------------

1. Create an admin in command line:

    app/console fos:user:create --super-admin

2. Login with your newly created admin user in the backoffice (/admin)
3. Create an adherent in the back office
4. Register a new user in the front office
5. Valid the user email by clicking on the link sent or manually in the database

Coding Standards
----------------

Please use [PHP CS Fixer](http://cs.sensiolabs.org/) to fix Coding Standards according to PSR.

Run the following command-line before commiting:

    php-cs-fixer.phar fix src/
