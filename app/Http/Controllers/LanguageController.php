<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang($locale)
    {
        // Verifica si el idioma es válido
        if (in_array($locale, ['en', 'es', 'ja'])) {
            // Almacena el idioma en la sesión
            Session::put('locale', $locale);
            // Actualiza la sesión de 'applocale'
            session(['applocale' => $locale]);
        }

        // Redirige a la página anterior
        return redirect()->back();
    }
}
