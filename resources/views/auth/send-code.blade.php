@component('mail::message')
# Send Code

Your code is : {{$code}}.



Thanks,<br>
{{ config('app.name') }}
@endcomponent
