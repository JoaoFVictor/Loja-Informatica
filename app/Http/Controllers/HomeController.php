<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Menu;
use App\Models\Carousel;

use App\Utils\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isEmpty;

class HomeController extends Controller
{

    public function index()
    {
        $menuModel = Menu::where('status', true)->where('pai', null)->get();
        if ($menuModel->isEmpty()) {
            return null;
        }
        $carousel = Carousel::where('status', true)->get();
        $helpers = new Helpers();
        $menu = $helpers->gerarMenu($menuModel);
        // return response()->json(['menu' => $this->arr]);
        return view('home', ['menu' => $menu, 'carousel' => $carousel]);
    }
}
