<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller {
  public function create() {
    return Inertia::render('Chat/Create', [
      "botAnswers" => [],
    ]);
  }

  public function store(Request $request) {
    // dd($request->message); //
    $answer = "Hey";
    // return ["userMessage" => $request->message, "botAnswer" => "Bot Answer"];
    return [$request->message, "Bot Answer"];
  }
}
