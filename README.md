# SS02-01-Chat

![a](../assets/a.png?raw=true)

## Commands
* Run `$ php artisan serve`
* Run `$ npm install`
* Run `$ npm run watch` to compile `resources/assets/js/app.js` to `public/js` as defined in `webpack.mix.js`

## Pusher
* `$ composer require pusher/pusher-php-server "~3.0"`
* Uncomment `App\Providers\BroadcastServiceProvider::class,` in `config/app.php`
* Enter Pusher keys and set `BROADCAST_DRIVER` to `pusher` in `.env`

## Events
* Edit `app/Providers/EventServiceProvider` with event and listener names, and run `$ php artisan event:generate` to create
  * `app/Events/ChatEvent.php` which will broadcast on private channel `chat`
  * `app/Listeners/ChatListener.php` (not used)

## Routes
* `/chat` route uses `ChatController@chat` to render `resources/views/chat.blade.php` with
  * Unordered list of `<message>` components (`resources/assets/js/components/message.vue`)
  * Input field for entering a new message
* `/send` route uses `ChatController@send` to
  * Get info of logged-in user from database
  * Broadcast message, user, and time to others

## Vue Instance `app.js`
* Binds `message` variable to `<input>` field
* When `enter` key is pressed,
  * `send()` is executed to create a new object appended to `chat.messages[]` array
  * Each object `{msg, usr, clr, tm}` contains the message, sender (logged-in user) info, display color, and time
  * Sender is given a `success` color
  * `POST` request is sent using `axios` to `/send` route
  * New message is displayed in `resources/assets/js/components/message.vue` component where the sender sees `usr` as 'me'
* Laravel `Echo`
  * `$ npm i laravel-echo pusher-js`
  * Uncomment `Echo` section in `resources/assets/js/bootstrap.js`
  * Used in `mounted` lifecycle hook of `resources/assets/js/app.js` to
    * listen for incoming messages (register the channel in `routes/channels.php` first)
    * join/leave the chat room
  * Recipients are given a `warning` color    
* To monitor user's typing 
  * Update `Enable client events` under `App Settings` in `pusher.com`
  * `watch` for changes to `message` variable and use `Echo` to `whisper 'typing'` event
  * Listen for `typing` and use `typing` variable to display badge

## Scrolling Package
* npm package `vue-chat-scroll` is used to scroll to the bottom of the unordered list when new content is added
  ```html
  <ul id="msgs" class="list-group" v-chat-scroll>...</ul>
  ```

## Toaster Package
* npm package `v-toaster` is used to notify when user joins/leaves chat room
* CSS added to `resources/assets/sass/app.scss`

## Added Features
* Created `messages` table in database to store all messages
* Used `beforeMount` lifecycle hook in `resources/assets/js/app.js` to show the 10 latest messages from database with `light` background color
* Removed `/home` route and `HomeController.php`
* Added `logout` button in `resources/views/chat.blade.php`
* `VueJS` is not used for `login` or `register`, so a separate `public/js/bootstrap.js` is compiled from `resources/assets/js/bootstrap.js` for those views