<?php

namespace App\Http\Controllers;

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
        return 'hello';
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
        return view('home');
    }
}
