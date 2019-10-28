# PS Validation Assignment

## How to run the `Command`

Follow the steps to run the Symfony `Command`.
1. `git clone https://github.com/isfar/ps-assignment.git`
2. `cd ps-assignment`
3. `git checkout develop`
4. `git pull origin develop`
5. `composer install`
6. `docker image build -t isfarsifat .`
7. `docker run -it isfarsifat bash`
8. `bin/console identification-requests:process data/input.csv`

## Run the unit tests

```
$docker run -it isfarsifat bash 
root@3188a4b60ef5:/var/www/app# vendor/bin/phpunit
PHPUnit 8.4.1 by Sebastian Bergmann and contributors.

................................................................. 65 / 87 ( 74%)
......................                                            87 / 87 (100%)

Time: 93 ms, Memory: 6.00 MB

OK (87 tests, 115 assertions)

```

## `TODO`s

As the time was short, I couldn't do more than what I have done in these 4-5 days. There are still a great room for improvement. The worth mentionings are--

1. There is one `AbsrtactDocumentValidator` class and different child classes of it for different countries, e.g., `GermanDocumentValidator`, `PolishDocumentValidator` etc. What if we have more countries? So, these strategy classes should be refactored into one absract factory, i.e., `DocumentValidatorAbstractFactory` for creating `DocumentValidatorInterface` intances. The configs, i.e., `request_limit`, `workdays` etc will be moved out of the classes to `.yaml` config files. The Abstract factory will read those configs and create indiviual instances of `DocumentValidator` class for each countries.

2. More unit tests with more use cases.