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

Route::get('/', 'HomeController@welcome');

Route::get('/policies', 'PoliceController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
  //Dashboard
  Route::get('/', 'HomeController@index');
  Route::post('/data_get_payment_all_week','HomeController@show_payment');
  Route::post('/data_summary_info_nps' , 'HomeController@show_summary_info_nps');
  Route::post('/get_graph_pais_distribution' , 'HomeController@show_apps');
  //- Configuración - Mostrar
  Route::get('/Configuration', 'ConfigurationController@index')->name('Configuration');
  Route::post('/data_config', 'ConfigurationController@show');
  Route::post('/data_edit_config', 'ConfigurationController@store');
  Route::post('/data_menu_config', 'ConfigurationController@showMenu');
  //- Configuración - Actualizar
  Route::post('/data_edit_user_config_nuevos', 'ConfigurationController@update_index3');
  Route::post('/data_edit_user_config', 'ConfigurationController@edit');
  Route::post('/data_create_user_config', 'ConfigurationController@create');
  Route::post('/data_delete_config', 'ConfigurationController@destroy');

  //Profile
  Route::get('/profile', 'ProfileController@index')->name('profile');
  Route::post('/data_config', 'ProfileController@show');
  Route::post('/profile_up', 'ProfileController@update');
  Route::post('/profile_up_pass', 'ProfileController@updatepass');

  //Classification
  Route::get('/Classification', 'ClassificationController@index')->name('Classification');
  Route::post('/create_master', 'ClassificationController@create_master');
  Route::post('/show_master', 'ClassificationController@show_master');
  Route::post('/create_junior', 'ClassificationController@create_junior');
  Route::post('/show_junior', 'ClassificationController@show_junior');

  //Workstation
  Route::post('/workstation_show', 'WorkstationController@show');
  Route::post('/workstation_create', 'WorkstationController@create');

  Route::post('/workstation_edit', 'WorkstationController@edit');
  Route::post('/workstation_update', 'WorkstationController@update');
  Route::post('/workstation_destroy', 'WorkstationController@destroy');
  //Workstation - user
  Route::post('/workstation_show_user', 'WorkstationController@show_user');
  Route::post('/workstation_create_user', 'WorkstationController@create_user');

  //Department
  Route::post('/department_show', 'DepartmentController@show');
  Route::post('/department_create', 'DepartmentController@create');
  //Department - user
  Route::post('/department_show_user', 'DepartmentController@show_user');
  Route::post('/department_create_user', 'DepartmentController@create_user');

  Route::post('/department_edit', 'DepartmentController@edit');
  Route::post('/department_update', 'DepartmentController@update');
  Route::post('/department_destroy', 'DepartmentController@destroy');

  //- Reportes - Asignacion de reportes
  Route::get('/type_report' , 'TypereportController@index');
  Route::post('/reg_user_type' , 'TypereportController@create');
  Route::post('/get_user_type' , 'TypereportController@show');
  Route::post('/delete_assign_hotel_cl' , 'TypereportController@destroy');

  //Facturación Electronica - Folder Base
  Route::get('/dashboard_cfdi', 'Base\DashboardCFDIController@dashboard');
  Route::get('/settings_pac', 'Base\DashboardCFDIController@settings_pac');


  Route::get('/settings_bank', function () {
    return view('permitted.invoicing.settings_bank');
  });
  Route::get('/settings_product', function () {
    return view('permitted.invoicing.settings_product');
  });

  Route::prefix('catalogs')->group(function () {
      Route::get('products/get-product', 'Catalogs\ProductController@getProduct')->name('products/get-product');
  });

  //- Modulo de zendesk - Dashboard
  Route::get('/dashboardcust', 'Support\Dashboard@index');
  // Modulo de zendesk - Peticion - Grafica 1
	Route::post('/dataTicketYearNowP', 'Support\Dashboard@showTicketYearP');
	Route::post('/dataTicketYearLastP', 'Support\Dashboard@showTicketLastYearP');
	// Modulo de zendesk - Peticion - Grafica 2
	Route::post('/dataTicketAgent', 'Support\Dashboard@showTicketAgente');
  // Modulo de zendesk - Peticion - Grafica 3
  Route::post('/dataTicketTimes2', 'Support\Dashboard@showTiempoRespuesta2');
  Route::post('/historical_average_time', 'Support\Dashboard@history_averagetime');
  // Modulo de zendesk - Peticion - Grafica 4
  Route::post('/dataTicketFirstRespMonth2', 'Support\Dashboard@showTiempoRespuestaMensual2');
  // Modulo de zendesk - Peticion - Grafica 5
  Route::post('/dataTicketWeekFRP', 'Support\Dashboard@showTiempoRespuestaSemanalP');
  // Modulo de zendesk - Peticion - Grafica 6 & 7
  Route::post('/dataTagsP', 'Support\Dashboard@showTagsP');
  // Modulo de zendesk - Peticion - Grafica 8
  Route::post('/dataDominio', 'Support\Dashboard@showDominios');
  // Modulo de zendesk - Peticion - Grafica 9
  Route::post('/getHorario', 'Support\Dashboard@getHorarioTicket');
  // Modulo de zendesk - Peticion - Grafica 10
  Route::post('/getHorario24p', 'Support\Dashboard@getHorarioTicketRangeP');
  // Modulo de zendesk - Peticion - Grafica 11
  Route::post('/getDomTagM','Support\Dashboard@getDominioTagMesPost');
  // Modulo de zendesk - Peticion - Grafica 12
  Route::post('/getDomTagA','Support\Dashboard@getDominioTagAnioPost');
  // Modulo de zendesk - Mis tickets
  Route::get('/mytickets', 'Support\MyTickets@index');
  // Modulo de zendesk - Mis tickets - Opciones flex
  Route::post('/search_data_traf_tickets', 'Support\MyTickets@showheader');
  // Modulo de zendesk - Mis tickets - Table
  Route::post('/get_table_ticket', 'Support\MyTickets@showtable');
  // Modulo de zendesk - Mis tickets - Grafica
  Route::post('/get_graph_time_ticket', 'Support\MyTickets@showgraph');
  // Modulo de zendesk - Mis tickets - Modal
  Route::post('/get_info_reg_ticket', 'Support\MyTickets@showinfoticket');
  Route::post('/update_ticket_sc', 'Support\MyTickets@update_ticket');
  //- Modulo de zendesk - Estadisticas
  Route::get('/statistics_tickets', 'Support\Statistics@index');
  //- Modulo de zendesk - Estadisticas - Tabla
  Route::post('/get_table_allticket', 'Support\Statistics@show');

  //- Zendesk PACKAGE TEST
  Route::get('/testzendesk', 'Support\Zendesk@index');
  Route::get('/testzendesk2', 'Support\Zendesk@index2');

  //Modulo de inventario - Reporte Detallado por hotel
  Route::get('/detailed_hotel', 'Inventory\Byhotel@index');
  //Modulo de inventario - Reporte Detallado por proyecto
  Route::get('/detailed_proyect', 'Inventory\Project@index');
  //Modulo de inventario - Carta de entrega
  Route::get('/detailed_cover', 'Inventory\Entry_letter@index');
  //Modulo de inventario - Reporte Distribucion
  Route::get('/detailed_distribution', 'Inventory\Distribution@index');

});
