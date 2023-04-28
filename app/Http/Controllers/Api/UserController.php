<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserInsertRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use App\Http\Resources\User as UserResources;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param UserInsertRequest $request
     * @return JsonResponse
     */
    public function insert(UserInsertRequest $request): JsonResponse
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

    public function index(Request $request): UserCollection
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');
        $query = User::paginate();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('surname', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        $user = $query->paginate($perPage);

        return new UserCollection($user);
    }


    public function show(User $user, Request $request): array
    {
            $return = [];
            $return["data"] = (new UserResources($user))->toArray($request);

            return $return;
    }

    public function delete(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            "message" => "Utente eliminato con successo"
        ]);
    }
}
