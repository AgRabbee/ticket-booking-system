<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = new User();
        $data = [
            'users'     => $users->company_users(),
            'customers' => $users->customers(),
        ];

        return view('admin.allUser')->with($data);
    }

    public function updateStatus(Request $request, string $status)
    {
        try {
            $user = User::findOrFail($request['user_id']);

            $updatedData = [];
            $msg = "Successfully updated user";

            if ($status == 'active') {
                $updatedData = [ 'user_status' => Status::ACTIVE ];
                $msg = "User activated";
            } elseif ($status == 'pause') {
                $updatedData = [ 'user_status' => Status::PENDING ];
                $msg = "User pause successfully";
            } elseif ($status == 'deny') {
                $updatedData = [ 'user_status' => Status::DENIED ];
                $msg = "User denied successfully";
            }

            $user->update($updatedData);

            $customerRole = Role::where('name', 'Customer')->first();
            if ($status == 'active') {
                $user->roles()->attach($customerRole);
            } else {
                $user->roles()->detach($customerRole);
            }

            return redirect()->back()->withSuccessMessage($msg);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }

    public function show()
    {
        if (Auth::user()->roles[0]->name == 'Super Admin') {
            return view('admin.adminProfile');
        } elseif (Auth::user()->roles[1]->name == 'Admin') {
            return view('company_admin.adminProfile');
        }
        // elseif (Auth::user()->roles[0]->name == 'Customer') {
        //     return view('customer.customerProfile');
        // }
    }

    public function update(UpdateUserRequest $request)
    {
        try {
            $user = User::findOrFail(auth()->id());

            $user->update($request->validated());

            return redirect()->back()->withSuccessMessage('User details updated successfully.');

        } catch (\Exception $e) {
            Log::error('User update failed', [
                'user_id' => auth()->id(),
                'error'   => $e->getMessage(),
            ]);

            return redirect()->back()->withErrors('Something went wrong. Please try again.');
        }
    }

    public function passwordChange(Request $request)
    {
        $this->validate($request, [
            'c_password' => 'required|string',
            'password'   => 'required|string|confirmed',
        ]);

        $current_password = Auth::user()->password;
        if (Hash::check($request['c_password'], $current_password)) {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request['password']);
            $user->save();

            return redirect()->back()->withSuccessMessage('Password Changed Successfully.');
        } else {
            return redirect()->back()->withErrorMessage('Current Password Not matched.');
        }
    }
}
