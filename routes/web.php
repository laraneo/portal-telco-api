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

Route::prefix('api/v1')->group(function () {
    Route::post('/auth/login', 'PassportController@login');
    Route::post('/auth/register', 'PassportController@register');
    Route::get('/parameter-logo', 'ParameterController@getLogo');
    Route::middleware('auth:api')->group(function () {

        

        /*
        |--------------------------------------------------------------------------
        | Master Tables
        |--------------------------------------------------------------------------
        */
        Route::resource('/bank', 'BankController');
        Route::get('/bank-search', 'BankController@search');
        Route::get('/bank-list', 'BankController@getList');

        Route::resource('/sport', 'SportController');
        Route::get('/sport-search', 'SportController@search');

        Route::resource('/profession', 'ProfessionController');
        Route::get('/profession-search', 'ProfessionController@search');

        Route::resource('/country', 'CountryController');
        Route::get('/country-search', 'CountryController@search');

        Route::resource('/status-person', 'StatusPersonController');
        Route::get('/status-person-search', 'StatusPersonController@search');

        Route::resource('/marital-status', 'MaritalStatusController');
        Route::get('/marital-status-search', 'MaritalStatusController@search');

        Route::resource('/gender', 'GenderController');
        Route::get('/gender-search', 'GenderController@search');

        Route::resource('/relation-type', 'RelationTypeController');
        Route::get('/relation-type-list', 'RelationTypeController@getList');
        Route::get('/relation-type-search', 'RelationTypeController@search');

        Route::resource('/role', 'RoleController');
        Route::get('/role-search', 'RoleController@search');

        Route::resource('/permission', 'PermissionController');
        Route::get('/permission-search', 'PermissionController@search');

        Route::resource('/payment-method', 'PaymentMethodController');
        Route::get('/payment-method-search', 'PaymentMethodController@search');

        Route::resource('/card-type', 'CardTypeController');
        Route::get('/card-type-search', 'CardTypeController@search');

        Route::resource('/person-relation', 'PersonRelationController');
        Route::resource('/person', 'PersonController');

        Route::resource('/currency', 'CurrencyController');
        Route::get('/currency-search', 'CurrencyController@search');
        Route::get('/currency-list', 'CurrencyController@getList');

        Route::resource('/share-type', 'ShareTypeController');
        Route::get('/share-type-list', 'ShareTypeController@getList');
        Route::get('/share-type-search', 'ShareTypeController@search');

        Route::resource('/location', 'LocationController');
        Route::get('/location-list', 'LocationController@getList');
        Route::get('/location-search', 'LocationController@search');

        Route::resource('/parameter', 'ParameterController');
        Route::get('/parameter-list', 'ParameterController@getList');
        Route::get('/parameter-search', 'ParameterController@search');
        

        Route::resource('/locker', 'LockerController');
        Route::get('/locker-list', 'LockerController@getList');
        Route::get('/locker-search', 'LockerController@search');
        Route::get('/locker-by-location', 'LockerController@getByLocation');

        Route::resource('/locker-location', 'LockerLocationController');
        Route::get('/locker-location-list', 'LockerLocationController@getList');
        Route::get('/locker-location-search', 'LockerLocationController@search');

        Route::resource('/record', 'RecordController');
        Route::get('/record-list', 'RecordController@getList');
        Route::get('/record-search', 'RecordController@search');
        Route::get('/record-by-person', 'RecordController@getByPerson');
        Route::get('/record-statistics', 'RecordController@getRecordsStatistics');

        Route::resource('/record-type', 'RecordTypeController');
        Route::get('/record-type-list', 'RecordTypeController@getList');
        Route::get('/record-type-search', 'RecordTypeController@search');

        Route::resource('/department', 'DepartmentController');
        Route::get('/department-list', 'DepartmentController@getList');
        Route::get('/department-search', 'DepartmentController@search');

        Route::resource('/note', 'NoteController');
        Route::get('/note-list', 'NoteController@getList');
        Route::get('/note-search', 'NoteController@search');
        Route::get('/note-by-person', 'NoteController@getByPerson');

        /* |-------------------------------------------------------------------------- |*/    

        Route::get('/person-search', 'PersonController@search');
        Route::get('/search-person-to-assign-family', 'PersonController@searchPersonsToAssign');
        Route::get('/search-family-by-person', 'PersonController@searchFamilyByPerson');
        Route::get('/report-by-partner', 'PersonController@getReportByPartner');
        Route::post('/assign-person', 'PersonController@assignPerson');
        Route::get('/person-report', 'PersonController@report');
        Route::get('/search-person-to-assign', 'PersonController@searchToAssign');
        Route::get('/get-families-partner-by-card', 'PersonController@getFamiliesPartnerByCard');
        Route::get('/get-guest-by-partner', 'PersonController@getGuestByPartner');
        Route::get('/person-filter', 'PersonController@filter');
        Route::get('/person-filter-report', 'PersonController@filterReport');
        Route::get('/person-lockers-by-location', 'PersonController@getLockersByLocation');
        Route::get('/person-lockers', 'PersonController@getLockersByPartner');
        Route::get('/person-count-by-ispartner', 'PersonController@getCountPersonByIsPartner');
        Route::get('/person-count-all', 'PersonController@getCountPersons');
        Route::get('/person-statistics-exception', 'PersonController@getExceptionStatistics');
        Route::get('/person-statistics-birthday', 'PersonController@getCountBirthdays');
        Route::get('/person-families-partner', 'PersonController@getFamilyByPartner');
        Route::get('/person-partners', 'PersonController@getPartners');
        Route::get('/person-search-partners', 'PersonController@searchByPartners');
        Route::post('/store-payment-report', 'PersonController@createPaymentReport');

        Route::get('/check-login', 'UserController@checkLogin');
        Route::resource('/user', 'UserController');
        Route::get('/user-search', 'UserController@search');
        Route::post('/user-update-password', 'UserController@updatePassword');

        Route::resource('/transaction-type', 'TransactionTypeController');
        Route::get('/transaction-type-list', 'TransactionTypeController@getList');
        Route::get('/transaction-type-search', 'TransactionTypeController@search');

        Route::resource('/share', 'ShareController');
        Route::get('/share-by-partner/{id}', 'ShareController@getByPartner');
        Route::get('/share-filter', 'ShareController@filter');
        Route::get('/share-filter-report', 'ShareController@filterReport');

        Route::resource('/card-person', 'CardPersonController');
        Route::get('/card-person-statistics', 'CardPersonController@getCardStatistics');

        Route::resource('/share-movement', 'ShareMovementController');
        Route::get('/share-movement-list', 'ShareMovementController@getList');
        Route::get('/share-movement-search', 'ShareMovementController@search');
        Route::get('/share-movement-last', 'ShareMovementController@getLastMovement');
       
        Route::get('/search-to-assign', 'ShareController@searchToAssign');

        Route::resource('/access-control', 'AccessControlController');
        Route::get('/access-control-list', 'AccessControlController@getList');
        Route::get('/access-control-search', 'AccessControlController@search');
        Route::get('/access-control-filter', 'AccessControlController@filter');
        Route::get('/access-control-filter-report', 'AccessControlController@filterReport');
        Route::get('/access-control-partner-family-statistics', 'AccessControlController@getPartnersFamilyStatistics');
        Route::get('/access-control-guest-statistics', 'AccessControlController@getGuestStatistics');

        
        Route::get('/banco-emisor', 'BancoEmisorController@index');
        Route::get('/banco-receptor', 'BancoReceptorController@index');
        Route::get('/monedas', 'MonedasController@index');

        Route::resource('/menu', 'MenuController');
        Route::get('/menu-list', 'MenuController@getList');
        Route::get('/menu-list-search', 'MenuController@search');
        Route::get('/get-menu-list', 'MenuController@getMenuList');

        Route::resource('/menu-item', 'MenuItemController');
        Route::get('/menu-item-list', 'MenuItemController@getList');
        Route::get('/menu-item-search', 'MenuItemController@search');
        Route::get('/menu-item-parents', 'MenuItemController@getParents');

        Route::resource('/menu-item-icon', 'MenuItemIconController');
        Route::get('/menu-item-icon-search', 'MenuItemIconController@search');
        Route::get('/menu-item-icon-list', 'MenuItemIconController@getList');

        Route::resource('/branch-company', 'BranchCompanyController');
        Route::get('/branch-company-list', 'BranchCompanyController@getList');
        Route::get('/branch-company-search', 'BranchCompanyController@search');


        Route::resource('/widget', 'WidgetController');
        Route::get('/widget-list', 'WidgetController@getList');
        Route::get('/widget-search', 'WidgetController@search');

        Route::resource('/notificacion', 'NotificacionesController');
        
        //Route::resource('/process', 'ProcessController');
        Route::get('/process-list', 'ProcessController@getList');

        //Route::resource('/client', 'ClientController');
        Route::get('/client-list', 'ClientController@getList');

        Route::resource('/process-request', 'ProcessRequestController');
        Route::get('/process-request-by-manager', 'ProcessRequestController@allByManager');
        
    });
});

/* Reports */
Route::get('/person-report', 'PersonController@report');
Route::get('/partner-report', 'PersonController@getReportByPartner');
Route::get('/person-filter-report', 'PersonController@filterReport');
Route::get('/login-token', 'LoginTokenController@find');
Route::get('/get-saldo', 'WebServiceController@getSaldo');

Route::get('/forced-login', 'UserController@forcedLogin');

Route::get('/', function () {
    return view('welcome');
});
