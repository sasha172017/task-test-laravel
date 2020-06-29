<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function authentication(Request $request)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $user = User::where(['email' => $data['email']])->first();
        if($user){
            if(Hash::check($data['password'], $user->password)){
                $user->expired_at = (new \DateTime())->format('Y-m-d H:s');
                $user->save();
                return response()->json(['message' => ['status' => true, 'text' =>'You are logged in'], 'token' => $user->token]);
            }
        }
        return response()->json(['message' => ['status' => false, 'text' => 'Failed email or password']], 400);
    }

}
