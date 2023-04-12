<?php

use App\Http\Livewire\QBank;
use App\Http\Livewire\FlipCard;
use App\Http\Livewire\HomeScript;

use App\Http\Livewire\HomeScripts;
use App\Http\Livewire\Invitations;
use App\Http\Livewire\ManageTeams;
use App\Http\Livewire\SupportPage;
use App\Http\Livewire\TenantUsers;
use App\Http\Livewire\UserProfile;
use App\Http\Livewire\ViewCategory;
use App\Http\Livewire\ManageBilling;
use App\Http\Livewire\ManageSettings;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiController;
use App\Http\Livewire\TeamInvitations;
use App\Http\Livewire\TemplateLibrary;
use App\Http\Controllers\PageController;
use App\Http\Livewire\ManageEnvironment;
use App\Http\Livewire\Courses\EditCourse;
use App\Http\Livewire\Courses\ShowCourse;
use App\Http\Livewire\Pathway\ShowPathway;
use App\Http\Livewire\Courses\CoursePlayer;
use App\Http\Livewire\Courses\CreateCourse;
use App\Http\Livewire\Courses\ManageCourses;
use App\Http\Controllers\DashboardController;
use App\Http\Livewire\Courses\CourseContents;
use App\Http\Livewire\Pathway\ManagePathways;
use App\Http\Livewire\Pathway\PathwayBuilder;
use App\Http\Controllers\InvitationController;
use App\Http\Livewire\Pathway\PathwayContents;
use App\Http\Controllers\EnvironmentController;
use App\Http\Livewire\Courses\ModuleItemPreview;
use App\Http\Controllers\SocialiteLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'login');

Route::get('login/{provider}', [SocialiteLoginController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback', [SocialiteLoginController::class, 'handleProviderCallback']);
Route::get('login/facebook/delete/callback', [SocialiteLoginController::class, 'deleteFacebookData']);
Route::get('login/facebook/delete/status', [SocialiteLoginController::class, 'checkIfFacebookUserIsDeleted']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});



Route::group(['middleware' => ['auth']], function(){
    Route::get('flip', FlipCard::class);
    Route::get('scripts', HomeScripts::class);
    Route::get('/category/{id}/{slug?}', ViewCategory::class)->name('category.show');

    Route::get('support', SupportPage::class)->name('support');
    Route::get('qbank/{flashCardId}', QBank::class)->name('qbank');
});

