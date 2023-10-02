<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * @param string $lang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function language(string $lang)
    {
        if (!in_array($lang, ['ja', 'en'])) {
            return back();
        }

        Session::put('lang', $lang);
        return back();
    }
}
