<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\Currency;

class AppController extends Controller
{
	public function getCurrency()
	{
		return Currency::first();
	}
}
