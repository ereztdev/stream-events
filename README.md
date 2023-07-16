![](https://github.com/ereztdev/stream-events/blob/master/public/logo.png?raw=true)

# Stream Events

## Installation For Local Environment

#### pre-requisites

- **PHP** - via your webserver
- **Node.js** - we'll be using Node's npm packagee manager for the front end, if you dont have it, you can get it [here](https://nodejs.org/en)
- **Composer** - PHP Dependency Manager, if you don't have it, you
  can [download it right here](https://getcomposer.org/download/).
- **MySQL OR MariaDB** - a persistent storage layer for our data (database)

#### Installation Procedure

- clone this repo (`git clone https://github.com/ereztdev/stream-events`) into your webserver
- switch into the repo directory where you pulled the repo: (`cd stream-events`)
- install PHP dependencies (`composer install`)
- setup your environment, lets copy the env `cp .env.example .env`
- now let's populate the db config there according to your SQL setup, here's an example:
    - DB_CONNECTION=mysql
    - DB_HOST=127.0.0.1
    - DB_PORT=3306
    - DB_DATABASE=stream_events
    - DB_USERNAME=erez
    - DB_PASSWORD=password
- As we are using here a 3rd party login (twitch), update the following paramters in the `.env` with your twitch credentials:
  - TWITCH_CLIENT_ID=<your client ID>
  - TWITCH_CLIENT_SECRET=<your clien secret>
  - TWITCH_REDIRECT_URL=http://localhost:8000/auth/twitch/cb

- in one swoop, lets migrate and populate our db: ` php artisan db:wipe && php artisan migrate && php artisan db:seed`
- Let's generate our app unique encryption key, run `php artisan key:generate``
- Let's install all front end packages, run `npm run dev`
- since the above command will occupy a window to serve our front end REPL, let's open a new bash/command window
- in our new window we'll fire up our app, run `php artisan serve`
- goto [http://localhost:8000](http://localhost:8000)
- In both `/register` and `/login` you will have an option to login with twitch, don't worry about double registrations or any of that

## Route Map

### GET / 
##### generic welcome page, either login or register there

#### Response (HTTP 200 OK)
***

### GET /dashboard
##### Get the dashboard and if user has events, it will show here

#### Response (HTTP 200 OK):

***
### PATCH /dashboard
##### Update specific user events read status by an event ID

Parameters:

- eventId (integer) - The ID of the event to update
- eventType (string) - The type of the event to update
- eventRead (boolean) - The current read status of the event to update

#### Response:

Success (HTTP 200 OK):
```
{
"message": "successfully updated read status",
"data": {event},
"error": false
}
```
Failure (HTTP 400 Bad Request):
```
{
"message": "<exception message>",
"data": null,
"error": true
}
```