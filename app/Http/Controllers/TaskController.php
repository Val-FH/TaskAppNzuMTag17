<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Notifications\PullFromTask;
use App\Notifications\PushToTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function index(Request $request)
    {     
        $tasks = Task::latest()
        ->when($request->filled('q'), function ($query) use($request){
           $query->search($request->input('q'));
        })
        ->when($request->input('status') === 'open', function($query){
            $query->where('done', false);
        })
        ->when($request->input('status') === 'done', function($query){
            $query->where('done', true);
        })
        ->paginate(5)->withQueryString();
      
        return view('tasks.index', ['tasks' => $tasks]); //pfadstrukturen mit . nicht mit /
    }

    public function show(Task $task)
    {  // $users = $task->users();  //wir ziehen uns für den passenden task auch die users mit der users() funktion. Weil hier wir uns den eizelnen task ziehen
       // return view('tasks.show', compact('task', 'users'));  //return view('tasks.show', ['task' => $task]); 
        return view('tasks.show', compact('task'));  //return view('tasks.show', ['task' => $task]); 
    }

    public function create()
    {   
        $users = User::all();
        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => ['required', 'string', 'max:50'],
            'description'   => ['required', 'string', 'max:500'],
            'user'          =>['required'],
        ]);
        
        $validated['done'] = false;
       //neuen task ersellen in task tabelle, weil mehrere schritte kommt es in eine variable
       $task = Task::create($validated);
       //wir schreiben in die zwischentabelle, deswegen attach.
       // Um die user festzuhalten zu dem task
       $task->users()->attach($request->user);

       // Benachrichtigung an die User ,die der Aufgabe zugewiesen wurden,verschicken(notification)
       foreach($task->users as $user)
        {
            $user->notify(new PushToTask($task));
        }

        return redirect()->route('dashboard')->with('success', 'Aufgabe erfolgreich angelegt');
    }

    public function edit(Task $task)
    {
       //nur user sollen den view sehen
        Gate::authorize('task-view', $task);
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        Gate::authorize('task-view', $task);
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:500'],
            'user' => ['required'],
        ]);
        // update nur in der Task tabelle
        $task->update($validated);
        // aktualisieren in der zwischen tabelle task_user, sync weil daten auch bestehen 
        // bleiben können, wichtig für zwischentabellen weil sonst id kombis sich überschreiben
        // abgewählte löschen und neue anlegen == sync!
       $users =  $task->users()->sync($request->user);
        // Benachrichtigung an die neu dazugekommenden User, in attached
        foreach($users['attached'] as $userid)
        {   // wir haben nur die id und suchen den user raus 
            $user = User::find($userid);
            // die user erhalten die notifikation 
            $user->notify(new PushToTask($task));
        }
        // Benachrichtigung an die weggelöschten User
        foreach($users['detached'] as $userid)
        {   // wir haben nur die id und suchen den user raus 
            $user = User::find($userid);
            // die user erhalten die notifikation 
            $user->notify(new PullFromTask($task));
            //user bei nachricht als gelesen packen
           // $user->unreadNotifications->update(['read_at'=>now($task->title)]);
        }

        return redirect()->route('tasks.show', $task)->with('success', 'Aufgabe aktualisiert');
    }

    public function destroy(Task $task)
    {
       Gate::authorize('task-view', $task);
        $task->delete();

        return redirect()->route('dashboard')->with('success', 'Aufgabe gelöscht');
    }



    public function toggle(Task $task)
    {
        Gate::authorize('task-view', $task);
        $task->done = !$task->done;
        $task->save();

        $message = $task->done ? 'Aufgabe erledigt' : 'Aufgabe wieder geöffnet';

        return back()->with('success', $message);

    }
}
