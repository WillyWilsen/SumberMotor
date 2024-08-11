<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Log;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use \Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function index(Request $request)
    {
        return view('setting.reset_password.reset_password');
    }

    public function Submit(Request $request)
    {
        if (!$request->current_password) {
            return redirect()->back()->with('error', 'Current Password must be filled');
        } else if (!$request->new_password) {
            return redirect()->back()->with('error', 'New Password must be filled');
        } else if (!$request->confirm_password) {
            return redirect()->back()->with('error', 'Confirm Password must be filled');
        } else if ($request->new_password != $request->confirm_password) {
            return redirect()->back()->with('error', 'New Password and Confirm Password must be same');
        } else if (!password_verify($request->current_password, auth()->user()->password)) {
            return redirect()->back()->with('error', 'Current Password is wrong');
        }

        $user = User::find(auth()->user()->id);
        $user->password = Hash::make($request->new_password);

        $user->save();

        $log = new Log();
        $log->message = 'Change Password';
        $log->created_by = auth()->user()->id;

        $log->save();
        return redirect()->back()->with('success', 'Password has been changed');
    }
}
