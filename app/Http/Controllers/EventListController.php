<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventListController extends Controller
{
    public function index()
    {
        return Event::all();
    }
}
