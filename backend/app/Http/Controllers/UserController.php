<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\ResponseFormat;
use Exception;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class UserController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            //meta
            $page = $request->page ?? 1;
            $perPage = $request->perPage ?? 20;

            //filter
            $role = $request->role;

            $users = User::query();

            //applying filter
            if ($role)
                $users = $users->where('role', $role);

            $users = $users->paginate($perPage, ['*'], 'page', $page);
            $data = $users->items();
            $meta = [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'total' => $users->total()
            ];

            return ResponseFormat::response(200, null, $data, $meta);
        } catch (Exception $e) {
            return ResponseFormat::exceptionResponse($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //data validation
            User::validateData($request);

            $user = User::create($request->all());

            return ResponseFormat::response(201, "User successfully stored", $user);
        } catch (Exception $e) {
            return ResponseFormat::exceptionResponse($e);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            //data validation
            User::validateData($request, $update = true);

            $user = User::find($id);
            if (!$user) {
                throw new Exception("User not found", 404);
            }

            $user->update($request->all());

            return ResponseFormat::response(201, "User successfully updated", $user);
        } catch (Exception $e) {
            return ResponseFormat::exceptionResponse($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $user = User::find($id);
            if (!$user) {
                throw new Exception("User not found", 404);
            }

            $user->delete();

            return ResponseFormat::response(201, "User successfully deleted", $user);
        } catch (Exception $e) {
            return ResponseFormat::exceptionResponse($e);
        }
    }

    public function statistics(Request $request)
    {
        try {

            $stats = User::select('role')
                ->selectRaw("count(*) as users")
                ->groupBy('role')
                ->get();

            $total = $stats->sum('users');

            $stats->map(function ($item) use ($total) {
                $item->percentage = round($item->users * 100 / $total, 2);
            });

            $data = [
                'total' => $total,
                'roles_users' => $stats
            ];

            return ResponseFormat::response(200, null, $data);
        } catch (Exception $e) {
            return ResponseFormat::exceptionResponse($e);
        }
    }
}
