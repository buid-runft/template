<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);
        return response()->json($users);
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate(['role' => 'required|string']);
        $user = User::findOrFail($id);
        $user->update(['role' => $request->role]);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}

