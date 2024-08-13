<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Log;
use App\Models\Role;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use \Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('master.user.user');
    }
    public function GetData(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->setTransformer(function ($user) {
                    $editUrl = route('master.user.edit', $user->id);
                    $editButton = '<a href="' . $editUrl . '" class="edit btn btn-success btn-sm">Edit</a>';
                    // delete button with onclick event

                    $deleteButton = '<button class="delete btn btn-danger btn-sm" onclick="deleteData(' . $user->id . ' )">Delete</button>';

                    $buttonList = $editButton . ' ' . $deleteButton;
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role,
                        'action' => $buttonList,
                    ];
                })
                ->make(true);
        }
    }

    public function Create(Request $request)
    {
        $list_role = Role::all();
        return view('master.user.user_create', compact('list_role'));
    }

    public function CreateSubmit(Request $request)
    {
        if (!$request->name) {
            return redirect()->back()->with('error', 'Name must be filled');
        } else if (!$request->email) {
            return redirect()->back()->with('error', 'Email must be filled');
        } else if (!$request->password) {
            return redirect()->back()->with('error', 'Password must be filled');
        } else if (!$request->confirm_password) {
            return redirect()->back()->with('error', 'Confirm Password must be filled');
        } else if ($request->password != $request->confirm_password) {
            return redirect()->back()->with('error', 'Password and Confirm Password must be same');
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->new_password);
        $user->role = $request->role;

        $user->save();
        $user->assignRole($request->role);
        return redirect()->route('master.user.index');
    }

    public function Update(Request $request)
    {
        $id = $request->id;

        $detail = User::where('id', $id)->first();
        $list_role = Role::all();
        return view('master.user.user_detail', compact('detail', 'list_role'));
    }

    public function UpdateSubmit(Request $request)
    {
        if (!$request->name) {
            return redirect()->back()->with('error', 'Name must be filled');
        } else if (!$request->email) {
            return redirect()->back()->with('error', 'Email must be filled');
        } else if ($request->password != $request->confirm_password) {
            return redirect()->back()->with('error', 'Password and Confirm Password must be same');
        }

        $id_user = $request->id;
        $find = User::where('id', $id_user)->first();
        $find->name = $request->name;
        $find->email = $request->email;
        if ($request->password) {
            $find->password = Hash::make($request->password);
        }
        $find->role = $request->role;
        $find->save();
        $find->syncRoles($request->role);
        return redirect()->route('master.user.index');
    }

    public function Delete(Request $request)
    {
        $id = $request->id;
        $deleted = User::where('id', $id)->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    // public function Import(Request $request)
    // {
    //     Excel::import(new UserImport, request()->file('file'));
    //     return response()->json([
    //         'success' => 'Record imported successfully!'
    //     ]);
    // }
}
