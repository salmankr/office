<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\models\logdata\log;
use telesign\sdk\messaging\MessagingClient;
use function telesign\sdk\util\randomWithNDigits;
use App\twoFA;
use App\User;
// define('STDIN',fopen("php://stdin","r"));
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $log = log::saveData(3);
        $id = Auth::id();
        $userObj = User::find($id);
        if($userObj->email_verified_at == null){
            $message = $userObj->name . '! Please verify your email first';
            return view('home', compact('message'));
        }
        return view('home', compact('userObj'));
    }

    public function sendMessage(){

        // define('STDIN',fopen("php://stdin","r"));
          $customer_id = "186CB5DE-6192-49D2-96D7-14257EF5589B";
          $api_key = "tVcU0QIk8rZNj6dpqhqFkNYyFShaA4u0k3MoxtNcBDSh5zQDOgU6B6JD6aGtiJBDcSBhcwoJqlRIQIH0cSlymw==";
          $phone_number = "923204310646";
          $ifexists = twoFA::where('user_id', Auth::id())->first();
          if (is_null($ifexists)) {

               $verify_code = randomWithNDigits(5);
               $message = "Your code is $verify_code";
               $message_type = "OTP";
               $messaging = new MessagingClient($customer_id, $api_key);
               $response = $messaging->message($phone_number, $message, $message_type);
               $save = new twoFA;
               $save->user_id = Auth::id();
               $save->code = $verify_code;
               $save->status = 'pending';
               $save->save();
               $msg = 'message sent';
               return view('2fa', compact('msg'));
           }
          if($ifexists->status == 'pending') {
              // dd($ifexists);
               $verify_code = randomWithNDigits(5);
               $message = "Your code is $verify_code";
               $message_type = "OTP";
               $messaging = new MessagingClient($customer_id, $api_key);
               $response = $messaging->message($phone_number, $message, $message_type);
               $ifexists->update([
                  'code' => $verify_code,
               ]);
               $msg = 'message sent';
               return view('2fa', compact('msg'));
          }

          // return response()->json(['message'  => 'sent']);
          $msg = 'already approved';
          return view('2fa', compact('msg'));
    }

    public function twofaverif(Request $request){
        $entered_code = $request->code;
        $ifexists = twoFA::where('user_id', Auth::id())->first();
        if($entered_code == $ifexists->code) {
            $ifexists->update([
                'status' => 'verified',
            ]);
            return response()->json(['message' => 'congrats! you have been aproved']);
        }
        return response()->json(['message' => 'your entered code is invalid']);
    }
}
