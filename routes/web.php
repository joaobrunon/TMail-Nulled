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

Route::get('/', 'HomeController@index')->name('home');

//Installer Routes
Route::get('/install', 'InstallController@install')->name('Install');
Route::get('/install/license', 'InstallController@licenseDetail')->name('InstallLicense');
Route::post('/install/license/submit', 'InstallController@licenseDetailSubmit')->name('InstallLicenseSubmit');
Route::get('/install/app', 'InstallController@appDetail')->name('InstallApp');
Route::post('/install/app/submit', 'InstallController@appDetailSubmit')->name('InstallAppSubmit');
Route::get('/install/database', 'InstallController@databaseDetail')->name('InstallDatabase');
Route::post('/install/database/submit', 'InstallController@databaseDetailSubmit')->name('InstallDatabaseSubmit');
Route::get('/install/database/run', 'InstallController@databaseRun')->name('InstallDatabaseRun');
Route::get('/install/mail', 'InstallController@mailDetail')->name('InstallMail');
Route::post('/install/mail/submit', 'InstallController@mailDetailSubmit')->name('InstallMailSubmit');
Route::get('/install/admin', 'InstallController@adminDetail')->name('InstallAdmin');
Route::post('/install/admin/submit', 'InstallController@adminDetailSubmit')->name('InstallAdminSubmit');
Route::get('/install/final', 'InstallController@final')->name('InstallFinal');

Route::get('/mailbox', 'HomeController@app')->name('App');
Route::get('/mailbox/{id?}', 'HomeController@app')->name('App');

Route::post('/mailbox/create/random', 'HomeController@createMailID')->name('MailIDCreateRandom');
Route::post('/mailbox/create/custom', 'HomeController@createMailID')->name('MailIDCreateCustom');
Route::post('/mailbox/delete', 'HomeController@deleteMailID')->name('MailIDDelete');

Route::get('/ads/{id}', 'HomeController@showAds');

Route::post('/locale', 'HomeController@changeLocale')->name('ChangeLocale');

Route::get('/mail/fetch', 'HomeController@fetchMails')->name('MailFetch');
Route::post('/mail/delete', 'HomeController@deleteMail')->name('MailDelete');

//API Routes
Route::get('/api/domains', 'HomeController@getDomains')->name('APIDomains');
Route::get('/api/create', 'HomeController@createMailID')->name('APICreate');
Route::get('/api/fetch', 'HomeController@fetchMails')->name('APIFetch');

Route::get('/css/custom.css', 'HomeController@customCss')->name('CustomCss');

Auth::routes();

//Admin Routes
Route::get('/admin', function () {
    return redirect('/admin/configuration');
})->name('Admin');
Route::get('/admin/configuration','AdminController@configuration')->name('AdminConfiguration');
Route::post('/admin/configuration/submit', 'AdminController@configurationSubmit')->name('AdminConfigurationSubmit');

Route::get('/admin/pages', 'AdminController@pages')->name('AdminPages');

Route::get('/admin/page/edit', 'AdminController@pageEdit')->name('AdminPageEdit');
Route::post('/admin/page/edit/submit', 'AdminController@pageEditSubmit')->name('AdminPageEditSubmit');
Route::post('/admin/page/add', 'AdminController@pageAdd')->name('AdminPageAdd');
Route::get('/admin/page/delete', 'AdminController@pageDelete')->name('AdminPageDelete');

Route::get('/admin/menu', 'AdminController@menu')->name('AdminMenu');
Route::post('/admin/menu/submit', 'AdminController@menuSubmit')->name('AdminMenuSubmit');

Route::get('/admin/update', 'AdminController@update')->name('AdminUpdate');
Route::get('/admin/update/apply', 'AdminController@applyUpdate')->name('AdminApplyUpdate');
Route::post('/admin/update/manual', 'AdminController@manualUpdate')->name('AdminUpdateManual');

Route::get('/admin/account', 'AdminController@account')->name('AdminAccount');
Route::post('/admin/account/update', 'AdminController@accountUpdate')->name('AdminAccountUpdate');

Route::get('/cron/deletemails', 'CronController@deleteEmails');

Route::post('/passwordreset', 'HomeController@passwordReset')->name('PasswordReset');

//Version
Route::get('/version', function(){
    return env('APP_VERSION');
})->name('Version');

Route::get('{slug}', [
    'uses' => 'HomeController@page'
])->where('slug', '([A-Za-z0-9\-\/]+)');
