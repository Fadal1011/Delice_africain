<x-mail::message>
# Bonjour {{ $nom }},

Nous sommes désolés de vous informer que votre réservation pour le {{ $date }} a été refusée pour la raison suivante :

**{{ $raison }}**

Nous vous remercions pour votre compréhension.

Cordialement,<br>

{{ config('app.name') }}
</x-mail::message>
