<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use App\Models\UserCards;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    public function index() {
        $cards = Card::all();

        return response($cards, 200);
    }

    public function getRandomCard(Request $req) {

        $userCards = [];

        if($req->token) {
            if($user = User::where('guid', $req->token)->first()) {
                $_userCards = UserCards::where('user_id', $user->id)->get();

                foreach($_userCards as $_c) {
                    array_push($userCards, $_c->card_id);
                }

            } else {
                $user = User::create([
                    "guid" => $req->token
                ]);
            }
        }

        $card = Card::whereNotIn('id', $userCards)->inRandomOrder()->first();

        // Se não houver cards disponíveis
        if(!$card) {
            return response([
                "error" => "Card not found"
            ], 404);
        }

        // Criar a carta para o usuário
        if($user) {
            UserCards::create([
                "user_id" => $user->id,
                "card_id" => $card->id
            ]);
        }

        return response($card, 200);
    }

    public function create(Request $req) {
        $card = Card::create([
            "title" => $req->title,
            "description" => $req->description,
            "answer" => $req->answer
        ]);

        return response($card, 200);
    }

    public function getUserCards(Request $req) {

        //Se não informar o token
        if(!$req->token) {
            return response(["error" => "Token cannot be null"], 401);
        }

        $user = User::where('guid', $req->token)->first();
        $_userCards = UserCards::where('user_id', $user->id)->get();
        $userCards = [];

        foreach($_userCards as $c) {
            array_push($userCards, $c->card_id);
        }

        $cards = Card::whereIn('id', $userCards)->get();

        return response($cards, 200);
    }
}
