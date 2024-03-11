<!DOCTYPE html>
<html>
<head>
    <title>{{__('messages.email_confirmation')}}</title>
</head>
<body>
<h1>{{__('messages.email_confirmation')}}</h1>
<p>{{__('messages.finish_register')}}</p>
<a href="{{ $confirmationLink }}">{{__('messages.email_confirmation')}}</a>
<p>{{__('messages.thanks')}},<br>{{ config('app.name') }}</p>
</body>
</html>
