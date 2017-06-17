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

Route::get('/', 'HomeController@getIndex');
Route::get('/home', 'HomeController@getIndex');
Route::get('/about', 'HomeController@getAbout');

Auth::routes();

Route::get('/user/{user}', 'HomeController@getUserArticle');
Route::get('/category/{category}', 'HomeController@getCategory');
Route::get('/article/{article}', 'HomeController@getArticle');
Route::post('/search', 'HomeController@postSearch');
Route::get('/archive/{date}', 'HomeController@getArchive');

Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function() {
    Route::get('/settings', 'UserController@getSettings');
    Route::post('/settings/changepassword', 'UserController@postChangePassword');
    Route::post('settings/user/edit/', 'UserController@postEditAboutMe');

    Route::group(['prefix' => 'article'], function() {
        Route::post('/add', 'ArticleController@postAddNews');
        Route::get('/myarticles', 'ArticleController@userArticles');
    });
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth']], function() {
    
    Route::group(['prefix' => 'dashboard', 'middleware' => ['admin']], function() {
        Route::get('/', 'DashboardController@index');
    });

    Route::get('/article/trash', 'ArticleController@getTrash');

    Route::group(['prefix' => 'homepage'], function () {
        Route::post('/spotlight', 'HomepageController@postEditSpotlight');
        Route::post('/highlight', 'HomepageController@postEditHighlight');
        Route::post('/editorpick', 'HomepageController@postEditeditorpick');
        Route::post('/category', 'HomepageController@postEditCategory');
    });

    Route::get('homepage', 'HomepageController@index');

    Route::get('newsletter', 'SubscriberController@getNewsletter');
    Route::get('newsletter/today', 'SubscriberController@getNewsletterToday');
    Route::get('newsletter/{id}', 'SubscriberController@getNewsletterFromArticle');
    Route::post('newsletter', 'SubscriberController@postNewsletter');
    Route::get('newsletter/send', 'SubscriberController@getSendNewsletter');

    Route::group(['prefix' => 'article'], function() {
        Route::get('/published', 'ArticleController@index');
        Route::get('/unpublished', 'ArticleController@getUnpublished');
        Route::get('/mysubmission', 'ArticleController@getMySubmission');
        Route::get('/usersubmission', 'ArticleController@getUserSubmission');
        Route::get('/add', 'ArticleController@getAddNews');
        Route::get('/edit/{id}', 'ArticleController@getEditNews');
        Route::post('/edit/{id}', 'ArticleController@postEditNews');
        Route::get('/delete/{id}', 'ArticleController@getDeleteNews');
        Route::post('/publish/{id}', 'ArticleController@postPublishNews');
        Route::post('/unpublish/{id}', 'ArticleController@postUnpublishNews');
        Route::post('/approve/{id}', 'ArticleController@postApproveNews');
    });

    Route::group(['prefix' => 'category'], function() {
        Route::get('/', 'CategoryController@index');
        Route::get('/add', 'CategoryController@getAddCategory');
        Route::post('/add', 'CategoryController@postAddCategory');
        Route::get('/edit/{id}', 'CategoryController@getEditCategory');
        Route::post('/edit/{id}', 'CategoryController@postEditCategory');
        Route::get('/delete/{id}', 'CategoryController@getDeleteCategory');
    });

    Route::group(['prefix' => 'user'], function() {
        Route::get('/', 'UserController@index');
        Route::get('/edit/{id}', 'UserController@getEditUser');
        Route::post('/edit/{id}', 'UserController@postEditUser');
        Route::get('/ban/{id}', 'UserController@getbanUser');
        Route::get('/active', 'UserController@getActiveUsers');
        Route::get('/inactive', 'UserController@getActiveUsers');
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
