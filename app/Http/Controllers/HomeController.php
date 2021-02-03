<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = Product::latest()->get();
        $contact = User::where('id', 1)->get('contact')->first();
        return view('admin.v_product', compact('data', 'contact'));
    }

    public function detail($id)
    {
        return $id;
    }

    public function search()
    {
        return 'Welcome to search';
    }

    public function admin()
    {
        $data = Product::latest()->get();

        return view('home', compact('data'));
    }
}
