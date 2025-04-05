<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


class TaskController extends Controller
{

    public function index(Request $request): View
    {
        return view('tasks.index');

    }

    public function create(): View
    {

        return view('tasks.create');
    }

    public function store()
    {

    }


}
