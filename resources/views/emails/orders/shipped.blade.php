<x-mail::message>
# Hello FRIEND!

Your reset code: {{ $token }}

<x-mail::button :url="'localhost/api/set_new_password'">
Set new password!
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
