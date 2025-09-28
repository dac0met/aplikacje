<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

/**
 * Kontroler obsługujący stronę startową.
 *
 * Zwraca widok `home`, w którym zostanie zamontowany komponent Livewire.
 */

class HomeController extends Controller
{
     /**
     * Renderuje widok startowy.
     */
    public function __invoke(): View
    {
        // Jeżeli chcesz wymusić logowanie, odkomentuj poniższą linię:
        // return view('home')->middleware(['auth', 'verified']);

        return view('home');
    }
}
