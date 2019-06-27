<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Cost;
use App\Income;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(5);
        $adminCount = User::where('access', 1)->count();
        $operatorCount = User::where('access', 2)->count();
        $managerCount = User::where('access', 3)->count();
        
        return view('content.user.index', [
            'users' => $users,
            'adminCount' => $adminCount,
            'operatorCount' => $operatorCount,
            'managerCount' => $managerCount,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->access = $request->access;
        $user->username = $request->username;
        $user->password = Hash::make("rahasia");
        $user->status = true;
        $user->photo  = asset('/images/users/userdefault.png');
        

        if ($request->hasFile('photo')) {
            $filename = 'user' . strval($user->id) . '-' . time() . '.' . $request->photo->extension();
            $path = $request->photo->storeAs('images/users', $filename, 'public');
            $user->photo = asset('/' . $path);
        }

        $user->save();

        return redirect()->route('pengguna.index')->with('success', 'Penambahan pengguna baru berhasil!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::withCount('projects', 'weights')->find($id);

        $projects = $user->projects->pluck('id');

        $costs = Cost::whereIn('project_id', $projects)->get()->pluck('id');

        $incomes = Income::whereIn('cost_id', $costs)->get()->pluck('quantity');

        $sum = $incomes->reduce(function($carry, $item) {
            return $carry + $item;
        });

        return view('content.user.show', ['user' => $user, 'sum' => $sum]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('content.user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);


        // return response()->json($request->all());
        // kalau yang diubah adalah user yang login, maka cek ganti pass atau engga
        // kalau user yang login gak bisa ganti status dirinya sendiri
        // kalau admin ganti user lain, gak bisa ganti password user itu
        // admin juga gak bisa ganti akses dia sendiri

        if ($user->id === Auth::id()) {
            if (!Hash::check($request->password, $user->password)) {
                return back()->with('warning', 'Anda tidak memasukkan password saat ini yang sesuai!!');
            }
    
            if (!empty($request->new_password)) {
                if (!empty($request->retype_new_password)) {
                    if (!($request->new_password === $request->retype_new_password)) {
                        return back()->with('warning', 'Konfirmasi password baru tidak sesuai dengan password baru Anda!');
                    }
                    $user->password = Hash::make($request->new_password);
                }
                else {
                    return back()->with('warning', 'Masukkan konfirmasi password baru!');
                }
            }
        }
        // selain itu, berarti yang ngeganti adalah admin, dia bisa ganti status sama hak akses user tsb
        else {
            $user->status = $request->has('status') ? intval($request->status) === 1 : 0;
            $user->access = $request->access;
        }

        $user->name = $request->name;
        $user->phone_number = $request->phone_number;

        $user->username = $request->username;

        if ($request->hasFile('photo')) {
            $filename = 'user' . strval($user->id) . '-' . time() . '.' . $request->photo->extension();
            $path = $request->photo->storeAs('images/users', $filename, 'public');
            $user->photo = asset('/' . $path);
        }

        $user->save();

        return redirect()->route('pengguna.show', $id)->with('success', 'Berhasil melakukan perubahan!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('pengguna.index')->with('success', 'Berhasil menghapus user!');
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->password = Hash::make('rahasia');

        $user->save();

        return back()->with('success', 'Password berhasil diatur ulang!');
    }
}
