<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return view('index');
    }


    public function getAdmin(User $user)
    {
        // $products = Product::where('user_id', $user->id)->get();
        $products = Product::all();
        return view('admin_page', ['products' => $products]);
    }

    public function editProduct(Request $request, Product $product)
    {
        return view('edit_product', ['product' => $product]);
    }

    public function updateProduct(ProductRequest $request, User $user, Product $product)
    {


        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('public/images');
            $imageName = basename($imagePath);

            $product->image = $imageName;
        }
        $product->name = $request->nama;
        $product->stock = $request->stok;
        $product->weight = $request->berat;
        $product->price = $request->harga;
        $product->description = $request->deskripsi;
        $product->condition = $request->kondisi;
        $product->save();


        return redirect()->route('admin_page')->with('message', 'Berhasil update data');
    }

    public function deleteProduct(Request $request, User $user, Product $product)
    {
        // if ($product->user_id === $user->id) {
        //     $product->delete();
        // }
        $product->delete();
        return redirect()->back()->with('status', 'Berhasil menghapus data');
    }


    public function getFormRequest()
    {
        return view('form_request');
    }


    public function handleRequest(Request $request, User $user)
    {
        return view('handle_request');
    }

    public function postRequest(ProductRequest $request, User $user)
    {

        $imagePath = $request->file('image')->store('public/images');
        $imageName = basename($imagePath);
        Product::create([
            'image' => $imageName,
            'name' => $request->nama,
            'weight' => $request->berat,
            'price' => $request->harga,
            'condition' => $request->kondisi,
            'stock' => $request->stok,
            'description' => $request->deskripsi,
        ]);

        return redirect()->route('admin_page');
    }

    public function getProduct(Request $request, User $user)
    {
        $user = Auth::user();
        // $userAuth = User::find($user->id);
        // dd($user->roles[1]->name);
        // $user = User::find(1);
        // $data = $user->products;
        $data = Product::all();

        return view('products')->with('products', $data);
    }


    public function getProfile(Request $request, User $user)
    {
        $user = User::with('summarize')->find($user->id);

        return view('profile', ['user' => $user]);
    }

    public function login()
    {
        return view('login');
    }
    public function register()
    {
        return view('register');
    }

    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:superadmin,user',
            'gender' => 'required',
            'age' => 'required|integer|min:1',
            'birth' => 'required|date',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'age' => $request->age,
            'birth' => $request->birth,
            'address' => $request->address,

        ]);

        // assign role
        $user->assignRole($request->role);

        if ($user) {
            return redirect()->route('register')
                ->with('success', 'User created successfully');
        } else {
            return redirect()->route('register')
                ->with('error', 'Failed to create user');
        }
    }

    public function loginUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('get_product');
        } else {
            return redirect()->route('login')
                ->with('error', 'Login failed email or password is incorrect');
        }
    }


    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    public function formUser(Request $request, User $user)
    {
        return view('form_add_user');
    }

    public function postUser(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:superadmin,user',
            'gender' => 'required',
            'age' => 'required|integer|min:1',
            'birth' => 'required|date',
            'address' => 'required',
        ]);

        $user->assignRole($request->role);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'age' => $request->age,
            'birth' => $request->birth,
            'address' => $request->address,
        ]);

        return redirect()->route('manage_user');
    }

    public function manageUsers()
    {
        $data = User::all();

        return view('manage_user')->with('users', $data);
    }

    public function edit(User $user)
    {
        return view('edit_user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->age = $request->age;
        $user->birth = $request->birth;
        $user->address = $request->address;
        $user->save();


        return redirect()->route('manage_user')->with('success', 'Berhasil update data users');
    }

    public function deleteUser(Request $request, User $user)
    {

        $user->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
}
