# BuBoard
CS440 - BuBoard Assignment

## Agile Scrum Kanban Trello Buzzword Sprint Tracking
https://trello.com/b/gqkhN5NT/buboard-dev

## Using / Hacking

### Database Browsing
A PhpMyAdmin server is available locally on port 8080.

### Starting in Docker
#### First Run:
Clone the repo, then run `docker-compose up`

#### To reflect changes in code after making them:
`docker-compose up --build`

#### To reset the database to a blank slate from the schema:
```
docker-compose down
docker rm buboard_buboard-database_1 
docker volume rm buboard_buboard-db
docker-compose up --build
```
