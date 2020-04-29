# Laminas test

## Tasks

Create a userlogin on the frontpage

A closed part, that the user has to login to see.

Once logged in the user has to be able to add some content that will be shown on the frontpage.

Please comment your code.

## Installation

- Clone the project

- Get into the folder and run
```
docker-compose up -d --build

composer install
```
    When it asks:
    - Please select which config file you wish to inject 'Laminas\I18n' into - 
    Answer: 0
    -  Remember this option for other packages of the same type? (Y/n) - 
    Answer: Y

- Get into the DB:
```
Host: 127.0.0.1
User: root
Password: root
Port: 3306
```

- Run the Migrations in data/Migrations folder
- Run the minimal_fixtures in data/minimal_fixtures



Project will be running in http://localhost/

Test user is:

    Username: test@test.com
    Password: test

