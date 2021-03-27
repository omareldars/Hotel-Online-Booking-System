<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PHPUnit\TextUI\ResultPrinter;

class PaymentController extends Controller
{
    public function paypal(Request $request, Room $room)
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'ARnIw5ybaLmRfu3f6DCSEP3IOcnY4sFOcr18_YDqk0lXCbxM7wxhdFGFadwakgU6_mmsuSPU90zHTdfU',     // ClientID
                'EM1XJcov2olwP9PAJ1ebYetJ3PyR0PzvwzRzD3qvCmWuil8T33y11JC39gEcmm77WnJF9sR_AohWHWx2'      // ClientSecret
            )
        );

        // After Step 2
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal($room->price);
        $amount->setCurrency('USD');

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal.success', $room))
            ->setCancelUrl(route('paypal.cancel'));

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        // After Step 3
        try {
            $payment->create($apiContext);
            echo $payment;
            echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";

            return redirect($payment->getApprovalLink());
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getMessage();
        }
    }
    public function payDone (Room $room)
    {
        $room->update([
            'reservation' => 1,
            'user_id' => auth()->user()->id,
        ]);
        session()->flash('success', 'The Payment Successfuly');
        return redirect()->route('/');
    }

    public function payCancel ()
    {
        session()->flash('error', 'The Payment Is Canceled');
        return redirect()->route('/');
    }
}
