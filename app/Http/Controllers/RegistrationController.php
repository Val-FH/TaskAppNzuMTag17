<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{  // Hier organisieren wir unsere Registrierungen
  
    public function create() // ein neuer eintrag wird erstallt
    {   //unter resources views im ordner auth liegt die datei register
        return view('auth.register');
    }

    public function store(Request $request) //wir wollen unsere daten speichern, stehen in $request
    {    // wir wollen die abgegebenen daten validieren
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:50'],
            'email'     => ['required', 'email', 'max:100', 'unique:users'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'] //confirmed sucht automatisch nach einem feld mit dem namen "password_confirmation"
        ]);

        // Wir legen unseren User in der Datenbank an. , praktisch weil alles in Variable
        $user = User::create($validated);
        //User wird eingeloggt, der nun neue user wird in das eingeloggt erhoben. 
        Auth::login($user);
        // wir bekommen eine neue sessions id weil wir nun eingeloggt sind. Das ist sicherer weil dann kann uns keiner die session klauen
        $request->session()->regenerate(); // Sicherheitsmaßnahme
        //wir werden auf die nächste seite geleitet, mit willkommensnachricht
        return redirect()->route('tasks.index')->with('success', 'Willkommen zur TaskApp, ' . $user->name . '!');
    }
}