<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CheckoutController extends Controller
{
    public function checkout($id ,Request $request)
    {   
        $this->validate($request, [
            'accompany_number'      => 'required',
            'from'      => 'required|date|date_format:Y-m-d|before:to',
            'to'        => 'required|date|date_format:Y-m-d|after:from',
        ]);

        $room = Room::find($id);
        if( $room != null ) {
            $amount = $room->price;

         // Enter Your Stripe Secret
        \Stripe\Stripe::setApiKey('sk_test_51IZLNbJKsrcvtLl9X6dKeEAATzjsTKNm5IDJelHMvxftNiWb4ciSRUGAS0C49eIKOSeu1atrJZSjSBl5WLYdzYTS00d7aMlMwd');
        
        $payment_intent = \Stripe\PaymentIntent::create([
			'description' => 'Stripe Test Payment',
			'amount' => $amount,
			'currency' => 'usd',
			'description' => 'Payment From Codehunger',
			'payment_method_types' => ['card'],
		]);
		    $intent = $payment_intent->client_secret;

            $from = $request->from;
            $to = $request->to;
            $accompany_number = $request->accompany_number;
            $datetime1 = strtotime($from); // convert to timestamps
            $datetime2 = strtotime($to); // convert to timestamps
            $days = (int)(($datetime2 - $datetime1)/86400); // will give the difference in days , 86400 is the timestamp difference of a day

            $total = $days * $amount;
            return view('checkout.credit-card',compact('intent', 'room', 'from', 'to', 'total', 'accompany_number'));

        }

        return redirect()->route('/');

    }

    public function afterPayment(Request $request)
    {
        $room = Room::find($request->plan);
        if( $room != null ) {
            Reservation::create([
                'room_id' => $room->id,
                'user_id' => auth()->user()->id,
                'from' => $request->from,
                'to' => $request->to,
                'accompany_number' => $request->accompany_number,
                'total' => $request->total,
            ]);
            return redirect()->route('/')->with([
                'success' => 'Payment Successed'
            ]);

        }

        return redirect()->back();

    }
}




