<?php

namespace App\Http\Controllers;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\User\UserRepository;

use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\User;


class UserController extends Controller
{

    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    public function login() {
        return view('login');
    }
    public function register() {
        return view('register');
    }
    public function managerUser() {
        return view('Admin.index');
    }

    public function createUser(){
        return view('Admin.create');
    }
    public function postRegister(Request $req) {
        $rules = [
            'name' => 'required|min:6',
            'email' => 'required|min:6',
            'password' => 'required|min:6',

        ];
        $messages = [
            'required' => 'Trường :attribute bắt buộc phải nhập',
            'min' => 'Trường :attribute không được nhỏ hơn :min ký tự',
        ];
        $req->validate($rules, $messages);
        
        $req->merge(['password'=>Hash::make($req->password)]);
       
        try {
            $imageBlob = '';
            $role = '';
            User::create([
                'name' => $req->name,
                'email' => $req->email,
                'password' => $req->password,
                'gender' => $req->gender,
                'role' => $role,
                'img' => $imageBlob,
            ]);
            return redirect()->route('login');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function loginApi(Request $req) {
        try {
            $user = User::where('email', $req->email)->first();
            if($user && Hash::check($req->password, $user->password)){
                $credentials = ['email' => $req->email, 'password' => $req->password];
                // dd(auth('api')->attempt($credentials));
                if (! $token = auth('api')->attempt($credentials)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
                
                return $this->respondWithToken($token);
    
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            


            // if(Auth::attempt(['email' => $req->email, 'password' => $req->password])){
            //     $credentials = request(['email', 'password']);

            //     if (! $token = auth()->attempt($credentials)) {
            //         return response()->json(['error' => 'Unauthorized'], 401);
            //     }

            //     return $this->respondWithToken($token);
            //     // return redirect()->route('home');
            // } 
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function profile() {
        $user = auth('api')->user();
        $user->img = base64_encode($user->img);
        return response()->json($user);
    }

    public function getAllUser(){
        // $message = exampleHelperFunction();
        // dd($message);
        $user = $this->userRepo->getUser();
        // return view('Admin.index', compact('user'))->with('i', (request()->input('page', 1) -1));
        // $user = User::paginate(4);
        return view('Admin.index', compact('user'))->with('i');
    }

    public function createUserApi(Request $req){
        $req->merge(['password'=>Hash::make($req->password)]);
        
        $req->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $imageBlob = file_get_contents($req->file('img')->getRealPath());
            User::create([
                'name' => $req->name,
                'email' => $req->email,
                'password' => $req->password,
                'gender' => $req->gender,
                'role' => $req->role,
                'img' => $imageBlob,
            ]);
            return redirect()->route('manager-user');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    // public function edit(User $user) {
    //     return view('edit', compact('sinhvien'));
    // }
    public function editUserApi($id) {
        try {
            $user = User::find($id);
            return view('Admin.create', compact('user'));
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function updateUserApi(Request $req, $id){
        $req->merge(['password'=>Hash::make($req->password)]);
        
        $req->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $user = User::find($id);
            $imageBlob = file_get_contents($req->file('img')->getRealPath());
            $user->name = $req->name;
            $user->email = $req->email;
            $user->password = $req->password;
            $user->gender = $req->gender;
            $user->role = $req->role;
            if ($req->hasFile('img')) {
                $imageBlob = file_get_contents($req->file('img')->getRealPath());
                $user->img = $imageBlob;
            }
            $user->save();
            return redirect()->route('manager-user');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function deleteUserApi($id) {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('manager-user');
    }
}
