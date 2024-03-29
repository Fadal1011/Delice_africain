<x-mail::message>
# Bonjour {{ $nom }},

Nous avons le plaisir de vous informer que votre réservation pour le {{ $date_reservation }} a été acceptée avec succès.

Veuillez noter que cette confirmation est sous réserve de disponibilité et de validation finale par le restaurant.

Merci pour votre réservation!

Cordialement,<br>

{{ config('app.name') }}
</x-mail::message>
