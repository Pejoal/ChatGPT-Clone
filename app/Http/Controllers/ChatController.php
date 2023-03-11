<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller {
  public function create() {
    return Inertia::render('Chat/Create', [
      "botAnswers" => [],
    ]);
  }

  public function store(Request $request) {
    // dd($request->message); //
    $chatGPT_Response = OpenAI::chat()->create([
      'model' => 'davinci',
      'messages' => $request->message,
    ]);
    // dd($chatGPT_Response);
    // return ["userMessage" => $request->message, "botAnswer" => "Bot Answer"];
    return [$request->message, $chatGPT_Response->choices[0]->message->content];
  }
}
