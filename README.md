# Simple Twitter
1. User can register and login
2. User can login with social sites like (Facebook and Gmail).
3. User can follow other users.
4. User can make CRUD operation over his tweets.
5. User can favorite tweets.
6. Followers get new follows's tweets.

## Requirement

```
  1. [Laravel 5.5.*](https://laravel.com/docs/5.5)
  2. [PHP >= 7.0] (http://php.net/downloads.php)
  4. [Composer](https://getcomposer.org/)
  5. [NodeJS + NPM](https://nodejs.org/en/)
```

## Installation
1. Clone the repo via this url 
  ```
      https://github.com/abeer93/Simple-Twitter
  ```

2. Enter inside the folder
```
    cd twitter-with-socket.io
```
3. Create a `.env` file by running the following command 
  ```
      cp .env.example .env
  ```
4. Install various packages and dependencies: 
  ```
      composer install
  ```
  ```
      npm install
  ```
5. Update database information in the .env file.
6. Update ` BROADCAST_DRIVER ` in the .env file make it ` redis `
7. Run migrations the database:
    ```bash
    php artisan migrate
    ```
8. Generate an encryption key for the app:
  ```
      php artisan key:generate
  ```
9. Run Servers
  ```
      npm run socket-io-server
  ```
  ```
      php artisan serve
  ```
10. If you need to run test cases
```
      vendor/bin/phpunit tests
```

Now, open your web browser and got `http://localhost:8000` .

### Configuration

App support login with the following social sites:

`facebook`, `google`.

Each drive uses the same configuration keys: `client_id`, `client_secret`, `redirect`.

Example:
```
  'facebook' => [
    'client_id'     => 'your-app-id',
    'client_secret' => 'your-app-secret',
    'redirect'      => 'http://localhost/{provider}/callback.php',
  ],

```

### Docs & Help

- [Laravel 5.5 Documentation](https://laravel.com/docs/5.5)
- [Redis Documentation] (https://redis.io/documentation)
- [Socket.io Documentation] (https://socket.io/docs/)
- [IORedis node Driver] (https://www.npmjs.com/package/ioredis)
- [Socket.io node Driver] (https://www.npmjs.com/package/socket.io)
