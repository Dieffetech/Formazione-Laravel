<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserInsertRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use App\Http\Resources\User as UserResources;
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
        $perPage = $request->input('perPage');
        $sortBy = $request->input('sort', 'name');
        $sortDirection = $request->input('sort_direction', 'asc');
        $search = $request->input('search');

        $query = User::query()->where("status", "=", true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('surname', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        $query->orderBy($sortBy, $sortDirection);

        $user = $query->paginate($perPage);

        return new UserCollection($user);
    }

    public function show($user_id, Request $request)
    {
        $search = [
            "user_id" => $user_id
        ];

        $user = User::paginate(1, $search);

        if ($user) {
            $return = [];
            $return["data"] = (new UserResources($user))->toArray($request);

            return $return;
        } else {
            return response()->json('Utente non trovato', 404);
        }
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
