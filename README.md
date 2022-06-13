# PinkiesGallery
The code you find here is for a website where I post my pictures on. All the pictures on the website are made by me (Julie Lauwers).

## Documentation I used
* [PHP Documentation](https://www.php.net/docs.php)
* [MySQL 5.7 Reference Manual](https://dev.mysql.com/doc/refman/5.7/en/)
* [Docker docs](https://docs.docker.com/)
* [Inrupt developer tools, Javascript client libraries](https://docs.inrupt.com/developer-tools/javascript/client-libraries/)


## Cloning and pushing the project to your own repository
```shell
mkdir <your-project>
cd <your-project>
git init
git pull https://github.com/JulieLauwers/PinkiesGallery.git
git remote add origin https://github.com/<your name>/<your repository>.git
git push -u origin main
```

## Running and stopping docker
* Start the docker enviroment
```shell
cd <your project>
docker compose up
```
* Stop the docker enviroment
```shell
docker compose down
```

## Installing packages
```shell
npm i
```
## Or installing packages individually
* Installing prettier
```shell
npm install --save-dev prettier
```
* Installing bulma
```shell
npm install bulma
```
* Installing inrupt
```shell
npm install @inrupt/solid-client @inrupt/solid-client-authn-browser @inrupt/vocab-common-rdf
```

## Installing dependencies in Docker web container
* First you need find out the what the id of the web container is
```shell
docker ps
```
* Then to log in to you web container
```shell
docker exec -it <id web container> bash
```
* Then type in this command
```shell
composer install
```
## Or installing dependencies in Docker web container individually
* First you need find out the what the id of the web container is
```shell
docker ps
```
* Then to log in to you web container
```shell
docker exec -it <id web container> bash
```
* Install doctrine dbal
```shell
composer require doctrine/dbal
```
* Install twig
```shell
composer require "twig/twig:^2.0"
```
* Install Bramus router
```shell
composer require bramus/router ~1.6
```

## Important comments!
### If you make a new controller always make sure to do a dump autoload!
* First you need find out the what the id of the web container is
```shell
docker ps
```
* Then to log in to you web container
```shell
docker exec -it <id web container> bash
```
* Then type the command you see below
```shell
composer dumpautoload
```


## Troubleshooting
### If you are using docker and you start this project with <code>docker-compose up</code> but you get an error, make sure there are no other projects running on the same post as this project. If so, use <code>docker-compose down</code> in your other project to stop it from running. If necessary, delete the containers with <code>docker rm idcontainer</code>.

## Last but not least
### If you use my pictures, always write my name with them because they are 100% mine and I don't want others to use them as their own.
