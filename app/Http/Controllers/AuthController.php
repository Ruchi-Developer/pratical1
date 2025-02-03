<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;

use Exception;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
 
    public function dashboard()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login'); // Redirect if not logged in
        }

        if ($user->role == 'admin') {
            $employees = Employee::all(); // Fetch employees for admin
        return view('admin.employee.index', compact('user', 'employees'));
        } else {
            return view('employee.dashboard', compact('user'));
        }
    }


    public function store(Request $request)
    {
     // dd($request->all());
      //  exit();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
            'role' => 'required|in:admin,employee',
        
        ]);
    
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role = $request->role;
           
            $user->save();
           
            
            return redirect()->route('login')->with('success', 'Registration successful!');
        } catch (Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Registration failed. Please try again.',
                'error' => $e->getMessage() 
            ]);
        }
}

 public function logout(Request $request)
    {
        $user = Auth::user();
        
        if ($user) {
          
            if ($user->role == 'admin') {
              
                return redirect()->route('login');
            } elseif ($user->role == 'employee') {
             
                return redirect()->route('login');
            }
        }

        \Session::flush();  
        \Auth::logout();

        return redirect()->route('login');
    }



}
