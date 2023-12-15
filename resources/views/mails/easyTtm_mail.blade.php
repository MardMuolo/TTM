<x-mail::message>
<img src="{{Vite::asset('resources/images/logo.svg')}}" alt="" srcset="" width="60" height="60" style="margin:auto;">
<h1 class="text-center">{{$message->type}}</h1>

<p class="text-justify">
    {{$message->body}}
</p>

@if($message->action == true)
<a href="{{$url}}" style="color: white; background-color:midnightblue; padding:0.5em; border-radius:10%; text-decoration:none; margin:auto; align-item:center">Cliquez ici</a>
@endif




Thanks,<br>
<em class="fw-bold">EasyTTM</em>
</x-mail::message>
