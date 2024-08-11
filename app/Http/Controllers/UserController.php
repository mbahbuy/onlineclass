<?php

namespace App\Http\Controllers;

use App\Models\{User, Siswa};
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\{Hash, Validator};

class UserController extends Controller
{
    public function index(): View
    {
        return view('users.index', [
            'title' => 'Pengguna',
            'hal'   => 'users/index',
        ]);
    }

    public function json(Request $request): mixed
    {
        $users = User::where('is_admin', 0)->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'required|string|max:50',
            'pass' => 'required|string|min:8',
        ];

        // Custom validation messages (optional)
        $messages = [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.unique' => 'Email is already taken.',
            'role.required' => 'Role is required.',
            'pass.required' => 'Password is required.',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'bg' => 'bg-danger',
                'message' => $validator->errors()->first()
            ], 400);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->role == 'guru') {
            $user->is_guru = true;
        } else {
            $user->is_siswa = true;
        }
        $user->email_verified_at = now();
        $user->password = Hash::make($request->pass); // Hash the password
        $user->save();

        if ($request->role == 'siswa') {
            Siswa::create(['user_id'   => $user->id, 'status' => true]);
        }

        return response()->json([
            'bg' => 'bg-success',
            'message' => 'User created successfully.'
        ], 201);

    }

    public function update(Request $request, User $user)
    {
        // Define validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|max:50',
            'pass' => 'nullable|string|min:8',
        ];

        // Custom validation messages (optional)
        $messages = [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.unique' => 'Email is already taken.',
            'role.required' => 'Role is required.',
            'pass.required' => 'Password is required.',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'bg' => 'bg-danger',
                'message' => $validator->errors()->first()
            ], 400);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->role == 'guru') {
            $user->is_guru = true;
            $user->is_siswa = false;
        } else {
            $user->is_siswa = true;
            $user->is_guru = false;
        }

        // Only update the password if it was provided
        if ($request->pass) {
            $user->password = Hash::make($request->pass);
        }

        $user->save();

        if ($request->role == 'siswa') {
            Siswa::create(['user_id'   => $user->id, 'status' => true]);
        } else {
            if ($user->siswa) {
                $siswa = $user->siswa;
                $siswa->delete();
            }
        }

        return response()->json([
            'bg' => 'bg-success',
            'message' => 'User berhasil di-update'
        ], 200);
    }

    public function destroy(User $user)
    {
        if ($user->siswa) {
            if ($user->with('siswa')->delete()) {
                return response()->json(['bg' => 'bg-success', 'message' => 'Users berhasil dihapus']);
            } else {
                return response()->json(['bg' => 'bg-danger', 'message' => 'User not found'], 404);
            }
        } else {
            if ($user->delete()) {
                return response()->json(['bg' => 'bg-success', 'message' => 'Users berhasil dihapus']);
            } else {
                return response()->json(['bg' => 'bg-danger', 'message' => 'User not found'], 404);
            }
        }
    }
}
