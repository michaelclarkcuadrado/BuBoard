# BuBoard
CS440 - BuBoard Assignment

## Starting in Docker

### First Run
Clone the repo, then run `docker-compose up`

### To reflect changes in code after making them:
`docker-compose up --build`

### To reset the database to a blank slate from the schema
`docker-compose down`
`docker rm buboard_buboard-database_1 `
`docker volume rm buboard_buboard-db`