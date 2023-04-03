<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ProjectMediaController ;
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
/****************
 * Frontend routes
 * ****************/
Route::get('/', [HomeController::class, 'home'])->name('frontend.home');
Route::get('/sustainability', [HomeController::class, 'sustainability'])->name('frontend.sustainability');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('frontend.privacy');
Route::get('/point-of-purchase-displays', [HomeController::class, 'pointOfSale'])->name('frontend.pos');
Route::get('/projects', [ProjectController::class, 'index'])->name('frontend.projects');
Route::get('/instagramFeed', [HomeController::class, 'instagramFeed']);
Route::get('/virtualTours', [HomeController::class, 'virtualTours']);
Route::get('/teamImages', [HomeController::class, 'teamImages']); 
Route::get('blogs', function(){ 
    return Redirect::to('/blog', 301); 
});
Route::redirect('blogs/{any}', url('blog', Request::segment(2)), 301);
Route::get('blog/10', function(){ 
    return Redirect::to('/blog/brands', 301); 
});
Route::get('blog/8', function(){ 
    return Redirect::to('/blog/design', 301); 
});
Route::get('blog/15', function(){ 
    return Redirect::to('/blog/company', 301); 
});
Route::get('/blog/{slug?}', [ArticleController::class, 'index'])->name('frontend.blog');

Route::get('/blog-detail/{slug}', [ArticleController::class, 'show'])->name('frontend.blog.detail');
Route::redirect('frontend-blog-detail/{any}', url('blog-detail', Request::segment(2)), 301);

Route::get('404', [ArticleController::class, 'pageNotFound'])->name('frontend.pageNotFound');
Route::get('/reload-captcha', [HomeController::class, 'reloadCaptcha'])->name('frontend.reloadCaptcha');
Route::get('frontend-blog', function(){
    return Redirect::to('/blog', 301);
});
//---------------------------------- Contact Form -------------------------------
Route::post('/sendMail',  [HomeController::class,'sendEmail'])->name('frontend.contact');

//------------------login/regitser route------------------------------------------
Route::get('/login',  [UserController::class,'login']);

Route::post('/login',  [LoginController::class,'login'])->name('login');

Route::get('/logout',  [LoginController::class,'logout'])->name('admin.logout');

Route::get('/register',  [UserController::class,'register']);

Route::post('/register',  [RegisterController::class,'register']);

//------------Auth route-------------------

Auth::routes();

/**************
 * Admin Routes
 * ****************/

// //--------------- Category-------------------------
// Route::prefix('admin')->namespace('Admin')->group(static function() {

//     Route::middleware('auth')->group(static function () {
Route::group(['middleware' => ['auth:web'],"prefix"=>"admin"], function () {
    //Route::group(['middleware' => ['adminUser','activeUser']], function () {
        /****** Dashboard *****/
        Route::get('/dashboard',  [AdminHomeController::class,'index'])->name('dashboard');

        //--------------------------Category------------------------------------------------

        Route::get('/category',  [CategoryController::class,'index'])->name('category.index');

        Route::get('/add-category',  [CategoryController::class,'add'])->name('category.add');

        Route::post('/viewcategory',  [CategoryController::class,'insert'])->name('category.insert');

        Route::post('/category/delete', [CategoryController::class,'delete'])->name('category.delete');

        Route::get('edit/{id}', [CategoryController::class,'edit'])->name('edit');

        Route::post('/update-data/{id}',[CategoryController::class,'update'])->name('category.update');

        Route::post('/changeStatus', [CategoryController::class,'status'])->name('category.status');

        //---------------------------Blogs---------------------------------------

        Route::get('blog',[BlogController::class,'index'])->name('blog.index');

        Route::get('/blogform',  [BlogController::class,'categoryList'])->name('blog.add');

        Route::post('/blogsave',  [BlogController::class,'blogsave'])->name('blog.save');

        Route::post('/blog/delete',[BlogController::class,'delete'])->name('blog.delete');

        Route::get('blogedit/{id}', [BlogController::class,'edit'])->name('blog.edit');

        Route::post('/update-blog/{id}',[BlogController::class,'update'])->name('blog.update');

        Route::post('/blogstatus',[BlogController::class,'changeBlog'])->name('blog.status');

        //-------------- blogmedia-------------------

        Route::get('blog/media/{id}', [MediaController::class,'blogmedia'])->name('media.get');

        // Route::get('/mediaform',  [MediaController::class,'blogList']);

        Route::post('/savemedia/{id}',  [MediaController::class,'savemedia'])->name('media.save');

        // Route::get('/media/delete/{id}', [MediaController::class,'delete'])->name('media.delete');

        Route::post('/media/delete/', [MediaController::class,'delete'])->name('media.delete');

        Route::post('/mediastatus',[MediaController::class,'status'])->name('media.status');

        Route::post('show-media-above-desc',[MediaController::class,'showMediaAboveDesc'])->name('media.showMediaAboveDesc');

        //----------------Client-------------------------------------------------

        Route::get('client', [ClientController::class,'index'])->name('client.index');

        Route::get('clientform', [ClientController::class,'clientform'])->name('client.add');

        Route::post('/saveclient',  [ClientController::class,'saveclient'])->name('client.save');

        Route::post('/client/delete',[ClientController::class,'delete'])->name('client.delete');

        Route::get('clientedit/{id}', [ClientController::class,'edit'])->name('client.edit');

        Route::post('/update-client/{id}',[ClientController::class,'update'])->name('client.update');

        Route::post('/clientstatus', [ClientController::class,'clientstatus'])->name('client.status');

        //--------------------------video towards------------------------------------------------

        Route::get('/video',  [VideoController::class,'index'])->name('video.index');

        Route::get('/videoform',  [VideoController::class,'videoform'])->name('videoform.add');

        Route::post('/videosave',  [VideoController::class,'videosave']);

        Route::post('/video/delete',[VideoController::class,'delete'])->name('video.delete');

        Route::post('/videostatus', [VideoController::class,'status'])->name('video.status');

        Route::get('video/{id}', [VideoController::class,'edit'])->name('video.edit');

        Route::post('/update-video/{id}',[VideoController::class,'update'])->name('video.update');

        // Route::get('/download/{id}',[VideoController::class,'download'])->name('video.download');

        //-------------------------- Projects --------------------------------------
        // Route::resource('projects', AdminProjectController::class)
        // ->missing(function (Request $request) {
        //     return Redirect::route('projects.index');
        // });

        Route::get('projects', [AdminProjectController::class,'index'])->name('projects.index');

        Route::get('create', [AdminProjectController::class,'create'])->name('projects.create');

        Route::post('/saveproject',  [AdminProjectController::class,'store'])->name('projects.store');

        Route::post('/project/delete',[AdminProjectController::class,'destroy'])->name('projects.delete');

        Route::get('projectedit/{id}', [AdminProjectController::class,'edit'])->name('projects.edit');

        Route::post('/update-project/{id}',[AdminProjectController::class,'update'])->name('projects.update');

        Route::post('/projectstatus',[AdminProjectController::class,'statusProject'])->name('projects.status');

        Route::post('/sortOrder',[AdminProjectController::class,'changeOrder'])->name('projects.sortorder');

        Route::post('/sortPrevOrder',[AdminProjectController::class,'changePreviousOrder'])->name('projects.sortPrevOrder');

        //-------------------------- Project Medias --------------------------------------
        // Route::get('blog/media/{id}', [MediaController::class,'blogmedia'])->name('media.get');
        Route::get('project/media/{id}', [ProjectMediaController::class,'projectMedia'])->name('projectmedia.get');

        Route::post('save-project-media/{id}',  [ProjectMediaController::class,'saveProjectMedia'])->name('projectmedia.save');

        Route::post('/project-media/delete', [ProjectMediaController::class,'delete'])->name('projectmedia.delete');

        Route::post('/project-media-status',[ProjectMediaController::class,'status'])->name('projectmedia.status');
    //});
});
