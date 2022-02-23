@component('mail::message')
## Vegano Contact Form

From: {{ $contact['name'] }}

Email: {{ $contact['email'] }}

Message:

{{ $contact['message'] }}

@endcomponent
