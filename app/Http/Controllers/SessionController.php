<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SessionController extends Controller
{  //hier organisieren wir unseren Log in
    public function create() //wir wollen eine session beginnen also wollen wir in den log in
    {
        return view('auth.login');
    }

    public function store(Request $request) 
    //um eingeloggt zu werden und die datenbank abzufragen, müssen wir anfragen und speichern
    {   //anfragen an datenbank immer validieren
        $request->validate([
            'email'     => ['required', 'email'],
            'password'  => ['required'] // Password::default() auch möglich laravel service
        ]);
         //wir wollen uns einloggen, mit e mail und passwort
        $credentials = $request->only('email', 'password');
        // wir wollen verschiedene fehlermeldungen bekommen je nachdem was nicht stimmt
        // attempt ist die funktion zum einloggen, versuch 
        if(! Auth::attempt($credentials)) { // Selbe nachricht für falsches Password und falsche Emailadresse
           //wenn falsches passwort wird eine meldung ausgegeben und zurückgebracht auf seite, deshalb return back 
        return back()->withErrors([ 
                'email'     => 'Keine Übereinstimmung gefunden',
            ])->withInput($request->only('email')); // eingabe e mail
        }
              // session regenerate recykelt die sessions id  verhindert aber das leute alte tokens verwenden
        $request->session()->regenerate();
        // wir leiten weiter weil der log in geklappt hat
        return redirect()->route('tasks.index');
    }
  public function destroy(Request $request)
    {   // auth funktion sagt session guard bescheid, status wird gewechselt
        auth()->logout();
        // wir werden aus dem log in status rausgeworfen, session gelöscht
        $request->session()->invalidate(); // Session Informationen löschen
        // wir bekommen eine neue sessions id weil wir nicht mehr eingeloggt sind -> sicherheit
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'Erfolgreich ausgeloggt');
    }
}
