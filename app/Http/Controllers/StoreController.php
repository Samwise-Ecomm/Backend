<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Page;
use App\Catalog;
use Cache;


class StoreController extends Controller
{
	public function home() 
	{
		return view('store');
	}

	public function getMenus()
	{
		$menus = Cache::rememberForever('menus', function() { 
			return array_merge(Page::getMenus(), Catalog::getMenu());
		});

		return $menus;
	}
}