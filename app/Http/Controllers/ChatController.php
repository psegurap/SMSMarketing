<?php

namespace App\Http\Controllers;
use App\Conversation;
use App\Contact;

use Illuminate\Http\Request;
use \Nexmo\Client;



class ChatController extends Controller
{
    

    public function send_message(Request $request){
        $basic = new \Nexmo\Client\Credentials\Basic(env('NEXMO_KEY'), env('NEXMO_SECRET'));
        $client = new \Nexmo\Client($basic);

        $contact_info = $request->contact_info;
    
        $message = $client->message()->send([
            'to' => $contact_info['phone_number'],
            'from' => env('NEXMO_NUMBER'),
            'text' => $request->text_details
        ]);

        $text_info = [
            'contact_id' => $contact_info['id'],
            'campaign_id' => $contact_info['campaign_id'],
            'phone_number' => $contact_info['phone_number'],
            'text_details' => $request->text_details,
            'type' => 'send',
            'message_id' => $message['message-id'],
            'remaining_balance' => $message['remaining-balance'],
        ];
        Conversation::create($text_info);

    }

    public function receive_message(){

        $incoming = \Nexmo\SMS\Webhook\Factory::createFromGlobals();
        $from = strlen(trim($incoming->getFrom())) == 10 ? '1' . trim($incoming->getFrom()) : trim($incoming->getFrom());

        $conversation_info = Conversation::where('phone_number', $from)->first();
        $contact_info = Contact::where('id', $conversation_info->contact_id)->where('phone_number', $from)->first();
        $last_record = Conversation::orderBy('id', 'desc')->first();
    
        $text_info = [
            'contact_id' => $contact_info['id'],
            'campaign_id' => $contact_info['campaign_id'],
            'phone_number' => $contact_info['phone_number'],
            'text_details' => $incoming->getText(),
            'type' => 'receive',
            'message_id' => $incoming->getMessageId(),
            'remaining_balance' => $last_record->remaining_balance,
        ];
        Conversation::create($text_info);
    }
}
