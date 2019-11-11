### Requirements

1) PHP 7.1+
2) Composer installed on your computer and added in your system PATH.

### Set up

1. Clone project
2. cd into project
3. run ``composer install``
4. run ``php artisan csv:json``
5. Done

# Code to review location
I have created the following folders under app/
    - json/
        - JsonableObjects
    - readers/
    - writers/

# Output json files
You will find the output files in the project root; in the same level as .env and phpunit.xml file.
## Unit Tests

run ``./vedor/bin/phpunit``

#### Shortcuts and design 

1) Complete the unit tests and increase code coverage to 90%+
2) I didn't have time to do clean up and small refactoring for consistently and mistakes.
3) If I had more time, i would try to figure out away NOT to use laravel validator (maybe build one)