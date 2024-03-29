<?php

namespace App\Http\Controllers;

use App\Http\Resources\reservationCollection;
use App\Http\Resources\reservationResource;
use App\Mail\AnnulationAcceptation;
use App\Mail\AnnulationDemande;
use App\Mail\ReservationAcceptation;
use App\Mail\ReservationConfirmation;
use App\Mail\ReservationRefus;
use App\Models\Menu;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\plat;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    use ResponseTrait;
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'nombre_personnes' => 'required|integer|min:1',
            'plats' => 'required|array',
            'plats.*.id' => 'required|exists:plats,id',
            'plats.*.quantite' => 'required|integer|min:1',
            'date_reservation' => 'required|date|after:today',
            'heure_reservation' => 'required|date_format:H:i',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'numero_telephone' => 'required|string|max:20',
        ]);

        // Calcul du prix total de la réservation
        $prix_total = 0;
        foreach ($request->plats as $plat) {
            $plat_details = Plat::findOrFail($plat['id']);
            $prix_total += $plat_details->prix * $plat['quantite'];
        }

        // Création de la réservation
        $reservation = Reservation::create([
            'nombre_personnes' => $request->nombre_personnes,
            'date_reservation' => $request->date_reservation,
            'heure_reservation' => $request->heure_reservation,
            'nom' => $request->nom,
            'email' => $request->email,
            'numero_telephone' => $request->numero_telephone,
            'prix_total' => $prix_total,
        ]);

        foreach ($request->plats as $plat) {
            $reservation->plats()->attach($plat['id'], ['quantite' => $plat['quantite']]);
        }

        // Envoyer un message de confirmation (vous devez implémenter cette fonctionnalité)
        // Mail::to($request->email)->send(new ReservationConfirmation($request->nom));

        // Retourner une réponse JSON avec les détails de la réservation
        return $this->responseData('Réservation effectuée avec succès. Un e-mail de confirmation sera envoyé.', true, Response::HTTP_OK, $reservation);
    }

    public function index()
    {
        $reservations = Reservation::paginate(4);
       return reservationCollection::make($reservations);
    }





        public function accept(Request $request, $id)
        {
            $reservation = Reservation::findOrFail($id);


            $reservation->statut = 'acceptee';
            $reservation->save();

            // Mail::to($reservation->email)->send(new ReservationAcceptation($reservation->nom, $reservation->date_reservation));
            return $this->responseData('Réservation Acceptée. Un e-mail a été envoyer au client.', true, Response::HTTP_OK, reservationResource::make($reservation));
        }


        public function refuse(Request $request, $id)
        {
            $reservation = Reservation::findOrFail($id);

            // Mettre à jour le statut de la réservation
            $reservation->statut = 'refusee';
            $reservation->save();

            // Mail::to($reservation->email)->send(new ReservationRefus($reservation->nom, $reservation->date_reservation, $request->raison_refus));

            // Retourner une réponse JSON avec les détails de la réservation mise à jour
            return $this->responseData('Réservation Refuser. Un e-mail a été envoyer au client pour lui dire les raisons.', true, Response::HTTP_OK, reservationResource::make($reservation));

        }

        public function annuler(Request $request, $id)
        {
            $reservation = Reservation::findOrFail($id);

            // Mettre à jour le statut de la réservation
            $reservation->statut = 'annulee';
            $reservation->save();

            // Mail::to($reservation->email)->send(new ReservationRefus($reservation->nom, $reservation->date_reservation, $request->raison_refus));

            // Retourner une réponse JSON avec les détails de la réservation mise à jour
            return $this->responseData('Réservation Annuler. Un e-mail a été envoyer au client pour lui dire.', true, Response::HTTP_OK, reservationResource::make($reservation));


        }

        // public function annuler(Request $request, $id)
        // {
        //     // Récupérer la réservation spécifique
        //     $reservation = Reservation::findOrFail($id);

        //     // Vérifier si la réservation est en attente ou acceptée
        //     if ($reservation->statut == 'en_attente') {
        //         // Mettre à jour le statut de la réservation
        //         $reservation->statut = 'annulee';
        //         $reservation->save();

        //     } elseif ($reservation->statut == 'acceptee') {
        //         $reservation->statut = 'demande_annulation';
        //         $reservation->save();
        //         Mail::to($reservation->email)->send(new AnnulationDemande($reservation->nom, $reservation->date_reservation));
        //     }
        //     return $this->responseData('Réservation Annuler. Un e-mail a été envoyer au client pour lui dire.', true, Response::HTTP_OK, reservationResource::make($reservation));
        // }


        public function Acceptannulation(Request $request, $id)
        {
            // Récupérer la réservation spécifique
            $reservation = Reservation::findOrFail($id);

            // Vérifier si le statut de la réservation est 'demande_annulation'
            if ($reservation->statut == 'demande_annulation') {
                // Mettre à jour le statut de la réservation en 'annulee'
                $reservation->statut = 'annulee';
                $reservation->save();

                // Envoyer un e-mail d'acceptation de l'annulation au client avec les détails de la réservation
                Mail::to($reservation->email)->send(new AnnulationAcceptation($reservation->nom, $reservation->date_reservation));

                // Retourner une réponse JSON avec les détails de la réservation mise à jour
                return response()->json($reservation, 200);
            } else {
                // Si le statut de la réservation n'est pas 'demande_annulation', retourner une réponse avec un code d'erreur
                return response()->json(['message' => 'Impossible d\'annuler cette réservation.'], 400);
            }
        }


        public function getByStatus(Request $request, $status)
{
        $validStatus = ['acceptee', 'refusee', 'en_attente'];
        if (!in_array($status, $validStatus)) {
            return response()->json(['message' => 'Statut invalide.'], 400);
        }

        $reservations = Reservation::where('statut', $status)->paginate(4);

        return reservationCollection::make($reservations);
}


}

