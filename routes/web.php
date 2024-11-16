<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\GreetingController;
use App\Http\Controllers\NodeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoteController;
use App\Models\Election;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/ayam', function () {
    return view('ayam');
});

Route::get('/hello', function () {
    return view('helloworld');
});

// Route to get the greeting from Node.js
Route::get('/fetch-greeting', [GreetingController::class, 'fetchGreeting']);

// Route to set a new greeting on Node.js
Route::post('/set-greeting', [GreetingController::class, 'setGreeting']);


Route::get('/data', [NodeController::class, "getNodeData"]);

Route::get('/fetch-candidates', [ElectionController::class, "fetchCandidates"]);


Route::get('/addcandidateview', [ElectionController::class, "addCandidateView"]);
Route::post('/addcandidate', [ElectionController::class, "addCandidate"]);

Route::get('/registervoterview', [ElectionController::class, "registerVoterView"]);
Route::post('/registervoter', [ElectionController::class, "registerVoter"]);


Route::get('/voteview', [ElectionController::class, 'castVoteView']);
Route::post('/vote', [ElectionController::class, 'castVote']);
Route::get('/votestatus', [ElectionController::class, 'getVoteStatus']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/elections', [VoteController::class, "electionIndex"])->middleware(['auth', 'verified'])->name('elections');

Route::get('/votes/{id}', [VoteController::class, "voteView"])->middleware(['auth', 'verified'])->name('votes.show');
Route::post('/votes/{id}/submit', [VoteController::class, "castVote"])->middleware(['auth', 'verified'])->name('votes.store');

// ADMIN COY
Route::get('/admin/manage', [AdminController::class, "manageView"])->middleware(['auth', 'verified'])->name('admin.manage');
Route::post('/admin/manage', [AdminController::class, "electionPost"])->middleware(['auth', 'verified'])->name('admin.manage.electionpost');
Route::get('/admin/manage/{id}', [AdminController::class, "manageElectionView"])->middleware(['auth', 'verified'])->name('admin.manage.election');
Route::post('/admin/manage/{id}', [AdminController::class, "addCandidate"])->middleware(['auth', 'verified'])->name('admin.manage.addcandidate');
Route::post('/admin/manage/{id}/voter', [AdminController::class, "addAllVoterId"])->middleware(['auth', 'verified'])->name('admin.manage.addvoter');





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';