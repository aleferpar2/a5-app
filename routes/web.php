<?php

use App\Models\Fichero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    $ficheros = Fichero::all();
    return view('welcome', compact('ficheros'));
});
Route::get('/login', function(){
    return view('login');
});
Route::post('/upload', function(Request $request){
    $fichero = new Fichero();
    $fichero->path = $request->file('uploaded_file')->store();
    $fichero->name = $request->file('uploaded_file')->getClientOriginalName();
    $fichero->user_id = Auth::user()->id;
    $fichero->save();
    return redirect('/');
});

//Download
Route::get('/download/{file}', function(Fichero $file){
    return Storage::download($file->path, $file->name);
});

//DELETE
Route::get('/delete/{file}', function(Fichero $file){
    Storage::delete($file->path);
    Fichero::destroy(($file->id));
    return redirect('/');

})->can('delete', 'file');

//LOGIN LOGOUT
Route::post('/login', function(Request $request){
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
});
Route::get('/logout', function(Request $request){
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
});
