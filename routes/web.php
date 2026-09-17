<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Arr;
use Illuminate\Support\Facades\DB; //zugriff auf datenbanken
use APP\Models\User; // nun können wir eloquent verwenden
use Illuminate\Support\Arr as SupportArr;

// Route::get('/', function() {
//     return view('welcome');
// });
//Einzige öffentlicher View
Route::view('/', 'welcome')->name('welcome'); // Kurzschreibform

// angemeldete User
Route::middleware('auth')->group(function() {
    //Tasks
    // Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    // Route::get('/tasks/{task}', [TaskController::class,'show'])->whereNumber('task')->name('tasks.show');
    // Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    // Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    // Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    // Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    // Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    Route::resource('tasks', TaskController::class);
    
    Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');
    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Notifications 
    //Wir können unsere notification id weitergeben
    Route::get('/notifications/{id}',function($id){
        // nun suchen wir den user raus über unsere suche in
        // den ungelesenden notifications in der notification tabelle
        $notification = auth()->user()->unreadNotifications->firstWhere('id',$id);
        // jetzt wo wir den datensatz haben können wir die zeile unread auf gelesen an setzten
        $notification->markAsRead();
        //wir werden zurück auf die seite gebracht auf der wir waren
        return back();
    });
});


// nicht angemeldete User 
Route::middleware('guest')->group(function() {
    //Registrierung
    Route::get('/register', [RegistrationController::class, 'create'])->name('register');
    Route::post('/register', [RegistrationController::class, 'store']);

    //Session                                  wichtig weil sonst kein log in möglich, weiterleitung zum login
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});

//Admin seiten spaß
Route::get('/admin', function () {
    // variante Gate::authorized('view-admin')
    return view('admin');
    // can zeigt wer zugriff auf die seite hat
})->name('admin')->can('view-admin');

//datenbank tests
Route::get('/dbtest', function(){
// wir machen eine datenbank abfrage um daten zu holen. Durch JSON wird der datensatz angezeigt
 //$users = DB::select('SELECT * FROM users');
//  return dump($users); einfache anzeige der variablen 
//wir wollen nur einen wert aus dem array
// return dump($users[0]->id);

//anzeigen lassen in einer tabelle
//$users = DB::table('users')->get();
//liefert ein array
//return $users; 
//liefert eine collection
//return dump($users);
//liefert nur die id von user 0 aus der collection
//return dump($users[0]->id);

//zeig uns alle user an, wir erhalten eine collection ->eloquent
// $users = User::all();
//return dump($users);

//datensatz nur mit id
// $users = User::where('id' ,1)->get();
//return dump($users);

 $users = User::get();
 $users_id = $users->pull('id')->toArray();
 $id = Arr::random($users_id); // zufällige id kriegen
});
