<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ChampionController;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\SubscriberController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// auth routes
Route::get('/', [HomeController::class, 'index'])->name('home.page');

Route::get('/tour-detail/{id}', [HomeController::class, 'tourDetails'])->name('home.tour.detail');
Route::get('/tournament-detail/{id}/{tour_id?}', [HomeController::class, 'tournamentDetail'])->name('home.tournament.detail');
Route::post('/tournament-detail/teeTable', [HomeController::class, 'teeTable'])->name('front.fetch.teeTable');
Route::post('/tournament-detail/touramentScore', [HomeController::class, 'touramentScore'])->name('front.fetch.touramentScore');
Route::get('/tour-book', [HomeController::class, 'tourBook'])->name('home.tourBook');

// facebook login routes
Route::get('auth/facebook', [SocialController::class, 'facebookRedirect'])->name('signup.facebook');
Route::get('facebook/callback', [SocialController::class, 'loginWithFacebook']);

// google login routes
Route::get('auth/google', [SocialController::class, 'redirectToGoogle'])->name('signup.google');
Route::get('auth/google/callback', [SocialController::class, 'handleGoogleCallback']);

// Front User's Routes
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile/edit', [DashboardController::class, 'editProfile'])->name('edit.profile');
    Route::post('/profile/update', [DashboardController::class, 'updateProfile'])->name('update.profile');
    Route::get('/profile/changepassword', [DashboardController::class, 'changePassword'])->name('edit.password');
    Route::post('/fetch/teams', [DashboardController::class, 'fetchTeams'])->name('fetch.teams');

    Route::get('/player-card', [DashboardController::class, 'player_card'])->name('player_card');
    Route::get('/tournament-played', [DashboardController::class, 'tournamentWins'])->name('tournament_wins');
    Route::post('/fetch-scores', [DashboardController::class, 'fetch_completed_tournament_scores'])->name('fetch.scores');
    Route::post('/fetch-tournament-played', [DashboardController::class, 'fetch_tournament_wins'])->name('fetch.tournament.wins');
    Route::post('/fetch-trophy-list', [DashboardController::class, 'trophyFilter'])->name('fetch.trophy.list');
});

// Only Admin Routes
Route::group(['middleware' => ['auth:sanctum', 'verified', 'admin']], function () {
    Route::get('/cms',[DashboardController::class,'cms'])->name('admin.cms');
    Route::get('/cms/testimonial',[TestimonialController::class,'index'])->name('admin.testimonial');
    Route::post('/cms/testimonial/list',[TestimonialController::class,'list'])->name('admin.testimonial.list');
    Route::get('/cms/testimonial/edit/{id}',[TestimonialController::class,'edit'])->name('admin.testimonial.edit');
    Route::get('/cms/testimonial/create',[TestimonialController::class,'create'])->name('admin.testimonial.create');
    Route::post('/cms/testimonial/delete',[TestimonialController::class,'delete'])->name('admin.testimonial.delete');
    Route::post('/cms/testimonial/removeimage',[TestimonialController::class,'removeImage'])->name('admin.cms.remove.testimonial.image');
    Route::post('/cms/testimonial/store',[TestimonialController::class,'store'])->name('admin.testimonial.store');
    Route::post('/cms/testimonial/update',[TestimonialController::class,'update'])->name('admin.testimonial.update');
    Route::post('/cms/testimonial/change/status',[TestimonialController::class,'changeStatus'])->name('admin.testimonial.change.status');

    Route::get('/cms/champions',[ChampionController::class,'index'])->name('admin.champion');
    Route::get('/cms/champions/create',[ChampionController::class,'create'])->name('admin.champion.create');
    Route::post('/cms/champions/store',[ChampionController::class,'store'])->name('admin.champion.store');
    Route::post('/cms/champions/list',[ChampionController::class,'list'])->name('admin.champion.list');
    Route::get('/cms/champions/edit/{id}',[ChampionController::class,'edit'])->name('admin.champion.edit');
    Route::post('/cms/champions/update',[ChampionController::class,'update'])->name('admin.champion.update');
    Route::post('/cms/champions/remove-image',[ChampionController::class,'removeImage'])->name('admin.cms.remove.champion.image');
    Route::post('/cms/champions/change/status',[ChampionController::class,'changeStatus'])->name('admin.champion.change.status');
    Route::post('/cms/champions/delete',[ChampionController::class,'delete'])->name('admin.champion.delete');


    Route::get('/cms/pages/edit/{slug}',[CmsController::class,'edit'])->name('admin.cms.pages');
    Route::post('/cms/pages/update',[CmsController::class,'update'])->name('admin.content.update');

    Route::get('/cms/banners/',[BannerController::class,'index'])->name('admin.cms.banner');
    Route::get('/cms/banners/create',[BannerController::class,'create'])->name('admin.cms.banner.create');
    Route::post('/cms/banners/list',[BannerController::class,'list'])->name('admin.banner.list');
    Route::post('/cms/banners/store',[BannerController::class,'store'])->name('admin.banner.add');
    Route::post('/cms/banners/delete',[BannerController::class,'delete'])->name('admin.banner.delete');
});

// Admin Routes
Route::group(['middleware' => ['auth:sanctum', 'verified', 'access']], function () {
    // tour routes
    Route::get('/tours',[TourController::class, 'index'])->name('admin.tour.list');
    Route::post('/tours/fetch',[TourController::class, 'fetchList'])->name('admin.fetch.tours');
    Route::get('/tours/edit/{id}',[TourController::class, 'editTour'])->name('admin.edit_tour');
    Route::get('/tours/view/{id}',[TourController::class, 'viewTour'])->name('admin.view_tour');
    Route::post('/tours/delete',[TourController::class, 'deleteTour'])->name('admin.delete.tour');

    // tournament routes
    Route::get('/tournaments',[TournamentController::class, 'index'])->name('admin.tournament.list');
    Route::post('/tournaments/fetch',[TournamentController::class, 'fetchList'])->name('admin.fetch.tournaments');
    Route::post('/tournaments/past/fetch',[TournamentController::class, 'fetchPastList'])->name('admin.fetch.past.tournaments');
    Route::get('/tournaments/add',[TournamentController::class, 'addTournament'])->name('admin.add.tournament');
    Route::get('/tournaments/add/{id}',[TournamentController::class, 'addTournament'])->name('admin.add.new.tournament');
    Route::get('/tournaments/edit/{id}',[TournamentController::class, 'editTournament'])->name('admin.edit.tournament');
    Route::post('/tournaments/update',[TournamentController::class, 'updateTournament'])->name('admin.updateTournament');
    Route::get('/tournaments/view/{id}/{tour_id}',[TournamentController::class, 'viewTournament'])->name('admin.view.tournament');
    Route::post('/tournaments/delete',[TournamentController::class, 'deleteTournament'])->name('admin.delete.tournament');
});
