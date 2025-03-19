<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Models\Landing;
use App\Models\User;
use App\Mail\FormSent;
use Illuminate\Support\Facades\Mail;
use App\Filament\Pages\EditorPage;
use App\Filament\Pages\PreviewPage;
use App\Http\Controllers\ImageUploadController;


// Inicio
Route::get('/', function () {
    return redirect()->to('/admin');
})->name('home');

// Visitar landing page
Route::get('/{slug}', function ($slug) {
    $landing = App\Models\Landing::where('subdomain', $slug)->first();
    if (!$landing || !$landing->is_published) {
        return redirect()->route('filament.admin.pages.dashboard');
    }
    return view('porsche.porsche_template', ['landing' => $landing]);
})->name('visit');

// Guardar formulario
Route::post('/formulario', function () {
    $form_data = collect(request()->all())->except('_token')->all();
    $users = User::all();
    foreach ($users as $user) {
        
        // Mail::to($user->email)->send(new FormSent($form_data, $user));
        Mail::to('juanchr0407@gmail.com')->send(new FormSent($form_data, $user));
    }
    return response()->json(['success' => true]);
})->name('formulario');

// Obtener cuerpo de landing
Route::get('obtener-proyecto/{id}', function ($id) {
    $landing = App\Models\Landing::find($id);
    if (!$landing->body) {
        return view('porsche.porsche_default_body');
    }
    return $landing->body;
})->name('obtener-proyecto');

// Upload landing image
Route::post('/upload-landing-image/{id}', [ImageUploadController::class, 'uploadToLanding']); 

// Paginas editor y preview
Route::get('/admin/page-editor/{id}', EditorPage::class)->middleware(['web', 'auth'])->name('page-editor');
Route::get('/admin/page-preview/{id}', PreviewPage::class)->middleware(['web', 'auth'])->name('page-preview');

// Página Actualizar
Route::get('/actualizar-cuerpo/{id}', function ($id) {
    $landing = App\Models\Landing::find($id);
    return view('porsche.editor', [
        'landing' => $landing,
    ]);
})->name('content');

// Actualizar cuerpo
Route::post('/actualizar-cuerpo/{id}', function ($id) {
    $landing = App\Models\Landing::find($id);
    $landing->update([
        // 'body_json' => request()->project,
        'body' => request()->html,
    ]);
    return response()->json(['success' => true]);
})->name('content.update');

require __DIR__.'/auth.php';
