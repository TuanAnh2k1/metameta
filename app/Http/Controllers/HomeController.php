<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $profile = Auth::user();
        $data = ['profile' => $profile];

        if ($profile->isAdmin()) {
            $total_user = DB::table('users')->whereNull('deleted_at')->count();
            $total_comment = DB::table('comments')->whereNull('deleted_at')->count();
            $data['data_user'] = $total_user;
            $data['data_comment'] = $total_comment;
        }

        return view('pages.home.index', $data);
    }
}
