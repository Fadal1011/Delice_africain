<x-mail::message>
# Bonjour {{ $nom }},

Nous vous informons que votre demande d'annulation pour la réservation du {{ $date }} a été acceptée.

Nous espérons vous revoir bientôt.

Cordialement,<br>

{{ config('app.name') }}
</x-mail::message>
