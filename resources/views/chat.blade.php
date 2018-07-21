<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <title>{{config('app.name')}}</title>
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
  <div id="app" class="container">
    <div class="row py-5 px-2">
      <div class="d-flex justify-content-between w-75 mb-4 mx-auto">
        <h1 class="text-center">Chat Room</h1>
        @auth
        <form action="{{route('logout')}}" method="POST">
          @csrf
          <input type="submit" class="btn btn-danger btn-lg float-right" value="Logout">
        </form>
        @endauth
      </div>
      <div class="col-sm-12 col-md-8 mb-5">
        <ul id="msgs" class="list-group border border-dark bg-light" v-chat-scroll>
          <message v-for="m in chat.messages" :key="m.index" :message="m"></message>
        </ul>
        <input type="text" class="form-control mt-5" v-model="message" @keyup.enter="send" placeholder="Type your message..." autofocus>
        <h5 class="mt-2"><span class="badge badge-dark">@{{typing}}</span></h5>
      </div>
      <div class="col-sm-12 col-md-3 offset-md-1 border border-secondary bg-light py-5">
        <h5><span class="badge badge-info">@{{users.length}}</span> users in chat room:</h5>
        <ol>
          <li v-for="u in users">@{{u.name}}</li>
        </ol>
      </div>
    </div>
  </div>
  <script src="{{asset('js/app.js')}}"></script>
</body>
</html>
