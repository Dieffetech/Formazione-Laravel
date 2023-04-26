<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\WrongCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TokenRequest;
use App\Http\Requests\CustomerInsertRequest;
use App\Http\Requests\UserInsertRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\UserCollection;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param UserInsertRequest $request
     * @return JsonResponse
     */
    public function insert(UserInsertRequest $request)
    {

        $user_id = $request->input('user_id');
        $user = User::query()->where("id", $user_id)->first();

        if ($user) {
            $user->fill($request->all());
            $user->password = bcrypt($user->password);
            $user->save();
        } else {
            $user = new User();
            $id = User::max("id") ?? 0;
            $user->id = ($id + 1);
            $user->fill($request->all());
            $user->password = bcrypt($user->password);
            $user->save();
        }

        return response()->json([
            'user' => $user,
        ]);
    }

    public function index(Request $request)
    {
        $user = User::query()->where("status", "=", true)->get();

        return new UserCollection($user);
    }

    public function delete($user_id)
    {
        try {
            $user_delete = User::findOrFail($user_id);
            $user_delete->delete();

            return response()->json([
                "message" => "Utente eliminato con successo"
            ]);

        } catch (ModelNotFoundException) {
            return response()->json([
                "error" => "Nessun Utente Trovato"
            ]);
        }
    }
}
