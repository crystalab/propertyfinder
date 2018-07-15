# PropertyFinder travel service

## Getting started

This project created to demonstrate my understanding of dependency inversion, TDD, OOP, SOLID, etc. skills.

### Project structure

Travel service contains pretty standard folder structure for common PHP projects:
 - bin - contains executable files (including 3rd party);
 - src - contains all source code related to this project.

### Code style

In this project I tried to stick to PSR coding standards, but I made few exceptions:
 - Interfaces doesn't contain `Interface` suffix in their names;
 - Abstract classes doesn't contain `Abstract` prefix in their names;
 - Test classes located under same directory with classes their test.

All of the abode in my understanding make code more laconic and easy to read.

### PHPUnit tests

To be able to run tests you do need to install composer dependencies by executing `composer install` command.
After this you could run all tests by executing `composer test` or `bin/phpunit` from the project directory.

### Code example

The `bin/travel-service` file contains example of usage of travel service. 
As this project doesn't depend on external libraries,  all dependency injection performed manually.

## Assumptions

While written code of this project I made several assumptions.

### Invalid routes

Following cases will throw appropriate exceptions:
 - Cross routes are not allowed;
 - Broken routes are not allowed;
 - Chained routes are not allowed.

### Incomplete boarding pass information

Some of type of boarding passes could contain incomplete information, for example:
- The route and seat numbers could be absent for Bus boarding passes;
- The seat and gate numbers as well as luggage information could be absent for Flights boarding passes;
- The seat number could be absent for Train boarding passes.

All this I did intentionally to demonstrate one way of extending messaging mechanism.

## Extension with new types of boarding passes

[see here](EXTENSION.md)
