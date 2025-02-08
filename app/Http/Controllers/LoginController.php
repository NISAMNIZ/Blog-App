<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Validator;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function saveRegistration(Request $request)
    {
        // dd($request->all());
        $rules = [
            'name' => 'required|unique:users',
            'email' => 'required|unique:users|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()], 422);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        return response()->json(['status' => true]);
    }

    public function Dashboardlogin(Request $request)
    {
        // dd($request->all());
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()], 422);
        $input = request()->only(['email', 'password']);

        if (auth()->guard('web')->attempt($input)) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['errors' => 'Invalid Credentials', 'status' => false], 422);
        }
    }

    public function home()
    {
        $data = [
            'blogs' => Blog::paginate(3),
        ];
        return view('user.home', $data);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.login');
    }

    public function withoutLoginBlog()
    {
        $data = [
            'blogs' => Blog::paginate(3),
        ];
        return view('user.withoutLoginBlog', $data);
    }


    public function withoutLoginreadMore($id)
    {
        $blog = Blog::with('user', 'likes')->findOrFail($id);
        return view('user.readMorewithoutLogin', compact('blog'));
    }
}
