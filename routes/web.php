<?php

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

//Website routes

Route::get('/', 'HomeController@getIndex');
Route::get('/home', 'HomeController@getIndex');
Route::get('/about', 'HomeController@getAbout');
Route::get('/headlines', 'HomeController@getHeadlines');
Route::post('newsletter/subscribe', 'HomeController@postAddSubscriber');
Route::post('newsletter/unsubscribe', 'HomeController@postUnsubscribe');
Route::get('subscriber/confirm/{email}/{token}', 'HomeController@getAddSubscriber');

Route::get('/user/{user}', 'HomeController@getUserArticle');
Route::get('/category/{category}', 'HomeController@getCategory');
Route::get('/article/{article}', 'HomeController@getArticle');
Route::post('/search', 'HomeController@postSearch');
Route::get('/archive/{date}', 'HomeController@getArchive');

//login & register routes
Auth::routes();


//Admin routes for user, editor & admin
Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function() {
    Route::get('/settings', 'UserController@getSettings');
    Route::post('/settings/changepassword', 'UserController@postChangePassword');
    Route::post('settings/user/edit/', 'UserController@postEditAboutMe');

    Route::group(['prefix' => 'admin/article'], function() {
        Route::get('/add', 'ArticleController@getAddNews');
        Route::post('/add', 'ArticleController@postAddNews');
        Route::get('/mysubmission', 'ArticleController@getMySubmission');
    });
});


//Admin routes for editor & admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['editor_admin']], function() {
    Route::group(['prefix' => 'article'], function () {
        Route::get('/published', 'ArticleController@index');
        Route::get('/unpublished', 'ArticleController@getUnpublished');
        Route::get('/usersubmission', 'ArticleController@getUserSubmission');
        Route::get('/edit/{id}', 'ArticleController@getEditNews');
        Route::post('/edit/{id}', 'ArticleController@postEditNews');
        Route::post('/publish/{id}', 'ArticleController@postPublishNews');
        Route::post('/unpublish/{id}', 'ArticleController@postUnpublishNews');
        Route::post('/approve/{id}', 'ArticleController@postApproveNews');
        Route::get('/headlines', 'ArticleController@getHeadlines');
        Route::post('/headlines/add', 'ArticleController@getAddHeadline');
        Route::get('/headlines/remove/{id}', 'ArticleController@getRemoveHeadline');
    });


    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index');
        Route::get('/edit/{id}', 'UserController@getEditUser');
        Route::post('/edit/{id}', 'UserController@postEditUser');
//        Route::get('/ban/{id}', 'UserController@getbanUser');
//        Route::get('/active', 'UserController@getActiveUsers');
//        Route::get('/inactive', 'UserController@getActiveUsers');
    });
});

//Only admin accessible
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['admin']], function() {
    Route::get('/dashboard', 'DashboardController@index');

    Route::group(['prefix' => 'homepage'], function () {
        Route::get('/', 'HomepageController@index');
        Route::post('/spotlight', 'HomepageController@postEditSpotlight');
        Route::post('/highlight', 'HomepageController@postEditHighlight');
        Route::post('/editorpick', 'HomepageController@postEditeditorpick');
        Route::post('/category', 'HomepageController@postEditCategory');
    });

    Route::group(['prefix' => 'article'], function () {
        Route::get('/delete/{id}', 'ArticleController@getDeleteNews');
        Route::get('/deleteall', 'ArticleController@getDeleteAllNews');
        Route::get('/recycle/{id}', 'ArticleController@getRestoreNews');
        Route::get('/trash', 'ArticleController@getTrash');
    });

    Route::get('newsletter', 'SubscriberController@getNewsletter');
    Route::get('newsletter/today', 'SubscriberController@getNewsletterToday');
    Route::get('newsletter/{id}', 'SubscriberController@getNewsletterFromArticle');
    Route::post('newsletter', 'SubscriberController@postNewsletter');
    Route::get('newsletter/send', 'SubscriberController@getSendNewsletter');

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'CategoryController@index');
        Route::get('/add', 'CategoryController@getAddCategory');
        Route::post('/add', 'CategoryController@postAddCategory');
        Route::get('/edit/{id}', 'CategoryController@getEditCategory');
        Route::post('/edit/{id}', 'CategoryController@postEditCategory');
        Route::get('/delete/{id}', 'CategoryController@getDeleteCategory');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/ban/{id}', 'UserController@getbanUser');
    });

    Route::get('/subscriber', 'SubscriberController@index');
    Route::get('/deleteSubscriber/{id}', 'SubscriberController@deleteSubscriber');

    Route::group(['prefix' => 'about'], function () {
        Route::get('/aboutus', 'AboutController@getAboutUs');
        Route::post('/aboutus', 'AboutController@postAboutUs');
        Route::get('/contact', 'AboutController@getContactUs');
        Route::post('/contact', 'AboutController@postContactUs');
        Route::get('/terms', 'AboutController@getTerms');
        Route::post ('/terms', 'AboutController@postTerms');
    });
});
