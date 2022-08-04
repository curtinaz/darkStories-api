<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    public function index() {
        $cards = Card::all();

        return response($cards, 200);
    }

    public function getRandomCard() {
        $card = Card::inRandomOrder()->first();

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
}
