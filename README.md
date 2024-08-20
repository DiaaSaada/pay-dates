# PayDates Test

### To RUN

`php .\src\PayDatesCommand.php `

#### with optional args

`--store=file|cloud`

`--year=[valid year]`

e.g.

` php .\src\PayDatesCommand.php --store=file --year=2024`

### To RUN TESTS

`vendor/bin/phpunit`

### To RUN WITH DOCKER

`docker build -t pay-dates-cli .`

`docker run -v "[DESTINATION-FOLDER]:/app/output" -it pay-dates-cli`


