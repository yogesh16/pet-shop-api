@component('mail::message')
# Hi, {{ $name }}

You just logged in to a new device at {{ $login_at }} <br />
Device IP : {{ $ip }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
