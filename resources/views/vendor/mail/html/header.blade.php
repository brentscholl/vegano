<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Vegano')
<img src="{{ asset('/images/assets/vegan-meal-deliver_vegano-logo-v-2.svg') }}" class="logo" alt="Vegano Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
