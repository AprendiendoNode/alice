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

Route::get('/policies', 'PoliceController@index')->name('policies');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
  //Dashboard
  Route::get('/', 'HomeController@index')->name('/');
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

  //Classification
  Route::get('/Classification', 'ClassificationController@index')->name('Classification');
  Route::post('/create_master', 'ClassificationController@create_master');
  Route::post('/show_master', 'ClassificationController@show_master');
  Route::post('/edit_master', 'ClassificationController@edit_master');
  Route::post('/update_master', 'ClassificationController@update_master');
  Route::post('/destroy_master', 'ClassificationController@destroy_master');

  Route::post('/create_junior', 'ClassificationController@create_junior');
  Route::post('/show_junior', 'ClassificationController@show_junior');
  Route::post('/edit_junior', 'ClassificationController@edit_junior');
  Route::post('/update_junior', 'ClassificationController@update_junior');
  Route::post('/destroy_junior', 'ClassificationController@destroy_junior');

  //Workstation
  Route::post('/workstation_show', 'WorkstationController@show');
  Route::post('/workstation_create', 'WorkstationController@create');
  Route::post('/workstation_edit', 'WorkstationController@edit');
  Route::post('/workstation_update', 'WorkstationController@update');
  Route::post('/workstation_destroy', 'WorkstationController@destroy');

  //Workstation - user
  Route::post('/workstation_show_user', 'WorkstationController@show_user');
  Route::post('/workstation_create_user', 'WorkstationController@create_user');
  Route::post('/workstation_edit_user', 'WorkstationController@edit_user');
  Route::post('/workstation_update_user', 'WorkstationController@update_user');
  Route::post('/workstation_destroy_user', 'WorkstationController@destroy_user');

  //Department
  Route::post('/department_show', 'DepartmentController@show');
  Route::post('/department_create', 'DepartmentController@create');
  Route::post('/department_edit', 'DepartmentController@edit');
  Route::post('/department_update', 'DepartmentController@update');
  Route::post('/department_destroy', 'DepartmentController@destroy');

  //Department - user
  Route::post('/department_show_user', 'DepartmentController@show_user');
  Route::post('/department_create_user', 'DepartmentController@create_user');
  Route::post('/department_destroy_user', 'DepartmentController@destroy_user');

  //Facturación Electronica - Folder Base
  Route::get('/dashboard_cfdi', 'Base\DashboardCFDIController@dashboard');

  Route::get('/settings_bank', function () {
    return view('permitted.invoicing.settings_bank');
  });
  Route::get('/settings_product', function () {
    return view('permitted.invoicing.settings_product');
  });

  //- Modulo de zendesk - Dashboard
  Route::get('/dashboardcust', 'Support\Dashboard@index')->name('dashboardcust');
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
  Route::post('/search_data_traf_tickets', 'Support\MyTickets@showheader_mod');
  // Modulo de zendesk - Mis tickets - Table
  Route::post('/get_table_ticket', 'Support\MyTickets@showtable_mod');
  // Modulo de zendesk - Mis tickets - Grafica
  Route::post('/get_graph_time_ticket', 'Support\MyTickets@showgraph_mod');
  // Modulo de zendesk - Mis tickets - Modal
  Route::post('/get_info_reg_ticket', 'Support\MyTickets@showinfoticket');
  Route::post('/update_ticket_sc', 'Support\MyTickets@update_ticket');
  //- Modulo de zendesk - Estadisticas
  Route::get('/statistics_tickets', 'Support\Statistics@index')->name('statistics_tickets');
  //- Modulo de zendesk - Estadisticas - Tabla
  Route::post('/get_table_allticket', 'Support\Statistics@show');

  //- Zendesk PACKAGE TEST
  Route::get('/testzendesk', 'Support\Zendesk@index')->name('testzendesk');
  Route::get('/testzendesk2', 'Support\Zendesk@index2')->name('testzendesk2');

  //Modulo de inventario - Reporte Detallado por hotel
  Route::get('/detailed_hotel', 'Inventory\ByHotelController@index');
  //Modulo de inventario - Reporte Detallado por proyecto
  Route::get('/detailed_proyect', 'Inventory\ProjectController@index');
  Route::post('detailed_pro_head', 'Inventory\HotelPController@getHeaderProject');
  Route::post('detailed_pro_stat', 'Inventory\ProjectController@getStatusProject');
  Route::post('detailed_pro_ap', 'Inventory\ProjectController@getGraphAPS');
  Route::post('detailed_pro_sw', 'Inventory\ProjectController@getGraphSWS');
  Route::post('detailed_pro_dispro', 'Inventory\ProjectController@getDispProject');
  Route::post('detailed_pro_modpro', 'Inventory\ProjectController@getModelProject');
  Route::post('detailed_pro_tab', 'Inventory\ProjectController@getProjectTable');
  Route::post('detailed_pro_gen', 'Inventory\ProjectController@getProjectTableGen');
  //Modulo de inventario - Carta de entrega
  Route::get('/detailed_cover', 'Inventory\EntryLetterController@index');
  //Modulo de inventario - Reporte Distribucion
  Route::get('/detailed_distribution', 'Inventory\DistributionController@index');

  //posts detailed_proyect
  Route::post('/cover_header', 'Inventory\ByHotelController@getHeader');
  Route::post('/cover_dist_equipos', 'Inventory\ByHotelController@getCoverDistEquipos');
  Route::post('/cover_dist_modelos', 'Inventory\ByHotelController@getCoverDistModelos');
  Route::post('/update_reference_by_cover', 'Inventory\ByHotelController@update_reference_by_cover');

  Route::post('/hotel_cadena', 'Inventory\ByHotelController@hotel_cadena');
  /*Distribution*/
  Route::post('/geoHotel', 'Inventory\DistributionController@show');
  Route::post('/detailed_equipament_all', 'Inventory\DistributionController@show_device');
  //posts detailed_hotel
  Route::post('/detailed_hotel_head','Inventory\DistributionController@getHeaders');
  Route::post('/detailed_hotel_sum','Inventory\DistributionController@getSummary');
  Route::post('/detailed_hotel_sw','Inventory\DistributionController@getSwitch');
  Route::post('/detailed_hotel_zd','Inventory\DistributionController@getZone');
  Route::post('/detailed_hotel_pie','Inventory\DistributionController@getSummaryPie');
  Route::post('/detailed_hotel_disqn','Inventory\DistributionController@getDristributionQuantitys');
  Route::post('/detailed_hotel_models','Inventory\DistributionController@getEquipmentModels');
  Route::post('/detailed_hotel_table','Inventory\DistributionController@getDetailedEquipment');


  //Modulo de reportes - Asignacion tipo de reportes
  Route::get('/type_report' , 'TypereportController@index');
  Route::post('/reg_user_type' , 'TypereportController@create');
  Route::post('/get_user_type' , 'TypereportController@show');
  Route::post('/delete_assign_hotel_cl' , 'TypereportController@destroy');
  //Modulo de reportes - Capturar reporte
  Route::get('/individual' , 'Report\Capture@index');
  Route::post('/get_zd_hotel', 'Report\Capture@get_zd_hotel');

  Route::post('/upload_client', 'Report\Capture@upload_client');
  Route::post('/upload_banda', 'Report\Capture@upload_banda');
  Route::post('/upload_gigs', 'Report\Capture@upload_gigs');
  Route::post('/upload_users', 'Report\Capture@upload_users');
  Route::post('/upload_comments', 'Report\Capture@upload_comments');
  Route::post('/upload_mostap', 'Report\Capture@upload_mostap');
  Route::post('/upload_mostwlan', 'Report\Capture@upload_mostwlan');

  //Modulo de reportes - Editar reportes
  Route::get('/edit_report' , 'Report\Edition@index');
  Route::post('/get_user_cont', 'Report\Concatenated@table_user');
  Route::post('/get_gb_cont', 'Report\Concatenated@table_gb');
  Route::post('/get_device_cont', 'Report\Concatenated@table_device');


  Route::post('/search_info_zdhtl', 'Report\Edition@search_zd');
  Route::post('/search_infogb', 'Report\Edition@search_gb');
  Route::post('/update_infogb', 'Report\Edition@update_gb');

  Route::post('/search_info_user','Report\Edition@search_user');
  Route::post('/update_infouser', 'Report\Edition@update_user');

  Route::post('/reupload_client', 'Report\Edition@reupload_client');
  Route::post('/reupload_banda', 'Report\Edition@reupload_banda');

  Route::post('/search_comment_hotel', 'Report\Edition@search_comment');
  Route::post('/update_comment_hotel', 'Report\Edition@update_comment');

  //Modulo de reportes - ver reporte basico
  Route::get('/viewreports' , 'Report\Basic@index');
  Route::post('/typereport','Report\Basic@typerep');
  Route::post('/view_reports_header', 'Report\Basic@report_header');
  Route::post('/get_client_wlan', 'Report\Basic@graph_client_wlan');
  Route::post('/get_client_wlan_top', 'Report\Basic@client_wlan_top');
  Route::post('/get_user_month', 'Report\Basic@user_month');
  Route::post('/get_gb_month', 'Report\Basic@gb_month');
  Route::post('/get_mostAP_top5', 'Report\Basic@mostAP_top5');
  Route::post('/get_comparative', 'Report\Basic@tab_comparativa');
  Route::post('/view_reports_band' , 'Report\Basic@view_band');
  Route::post('/view_reports_device' , 'Report\Basic@view_device');

  //Modulo de reportes - ver reporte concatenado
  Route::get('/viewreportscont' , 'Report\Concatenated@index');

  //- Herramientas
  Route::get('/detailed_guest_review', 'Tools\GuestToolsController@index');
  Route::get('/detailed_server_review', 'Tools\ServerToolsController@index');
  Route::get('/testzone', 'Tools\ZoneToolsController@index');
  Route::post('/getInfoZD', 'Tools\ZoneToolsController@getInfo');
  Route::post('/testzonedir', 'Tools\ZoneToolsController@testRequest');

  Route::post('/existenceUsers', 'Tools\GuestToolsController@getUsersHC');
  Route::post('/existenceUsersAll', 'Tools\GuestToolsController@getPortalUsers');

  Route::get('/DiagHuespedAjax','Tools\GuestToolsController@checkGuest');
  Route::post('/DiagHuespedAjax2', 'Tools\GuestToolsController@checkWebSer');

  Route::get('/DiagServidorAjax', 'Tools\ServerToolsController@checkRad');
  Route::get('/DiagServidorAjax2','Tools\ServerToolsController@checkWB');

  Route::get('/testWebSer', 'Tools\GuestToolsController@checkWebSer');

  //MODULO DE COMPRAS - Documento P / M
	Route::resource('documentp', 'DocumentpController', ['only' => [
	   'store'
	]]);
	Route::get('/documentp_cart', 'ShoppingCart\DocumentpCartController@index');
	Route::get('items/ajax/{type}/{aps}/{api}/{ape}/{firewalls}/{switches}/{switch_cant}',
	['uses'  => 'ShoppingCart\DocumentpCartController@getItemType'])->where('type', 'first|second');
  Route::get('items/ajax/four/{api}/{ape}', ['uses'  => 'ShoppingCart\DocumentpCartController@getMoProducts']);
  Route::get('items/ajax/four/{api}/{ape}/{id_doc}', ['uses'  => 'ShoppingCart\DocumentpCartController@getMoProductsCart']);
	Route::get('items/ajax/third/{category}', ['uses'  => 'ShoppingCart\DocumentpCartController@getCategories']);
	Route::get('items/ajax/third/{category}/{description}', ['uses'  => 'ShoppingCart\DocumentpCartController@getCategoriesDescription']);
	Route::get('/documentp_invoice/{id_documentp}/{id_cart}', 'DocumentpController@export_invoice');
	Route::get('/update_cant_cart/{id}/{cant}/{porcentaje_compra}', 'DocumentpController@update_cantidad_recibida');
	Route::get('/update_status_product/{id}/{status}', 'DocumentpController@update_status_product');
	Route::get('/update_motive_project/{id}/{motive}', 'DocumentpController@update_motive_project');
	Route::get('/update_purchase_order/{id}/{order}', 'DocumentpController@update_purchase_order');

});


Route::group(['prefix' => 'catalogs',  'middleware' => 'auth'], function()
{
    //All the routes that belongs to the group goes here

    //Catalogo - Unidad de medida
    Route::get('/unit-measures', 'Catalogs\UnitMeasureController@index');
    Route::post('/unit-measures-create', 'Catalogs\UnitMeasureController@create');
    Route::post('/unit-measures-edit', 'Catalogs\UnitMeasureController@edit');
    Route::post('/unit-measures-show', 'Catalogs\UnitMeasureController@show');
    Route::post('/unit-measures-store', 'Catalogs\UnitMeasureController@store');
    Route::get('/texts', 'Catalogs\UnitMeasureController@destroy');
    //Catalogo - Paises
    Route::get('/countries', 'Catalogs\CountryController@index');
    Route::post('/countries-create', 'Catalogs\CountryController@create');
    Route::post('/countries-edit', 'Catalogs\CountryController@edit');
    Route::post('/countries-show', 'Catalogs\CountryController@show');
    Route::post('/countries-store', 'Catalogs\CountryController@store');
    //Catalogo - Estados
    Route::get('/states', 'Catalogs\StateController@index');
    Route::post('/states-show', 'Catalogs\StateController@show');
    Route::post('/states-create', 'Catalogs\StateController@create');
    Route::post('/states-edit', 'Catalogs\StateController@edit');
    Route::post('/states-store', 'Catalogs\StateController@store');
    //Catalogo - Ciudades
    Route::get('/cities', 'Catalogs\CityController@index');
    Route::post('/cities-show', 'Catalogs\CityController@show');
    Route::post('/cities-create', 'Catalogs\CityController@create');
    Route::post('/cities-store', 'Catalogs\CityController@store');
    Route::post('/cities-edit', 'Catalogs\CityController@edit');
    //Catalogo - Monedas
    Route::get('/currencies', 'Catalogs\CurrencyController@index');
    Route::post('/currencies-show', 'Catalogs\CurrencyController@show');
    Route::post('/currencies-create', 'Catalogs\CurrencyController@create');
    Route::post('/currencies-store', 'Catalogs\CurrencyController@store');
    Route::post('/currencies-edit', 'Catalogs\CurrencyController@edit');
    //Catalogo - Termino de pago
    Route::get('/payment-terms', 'Catalogs\PaymentTermController@index');
    Route::post('/payment-terms-show', 'Catalogs\PaymentTermController@show');
    Route::post('/payment-terms-create', 'Catalogs\PaymentTermController@create');
    Route::post('/payment-terms-store', 'Catalogs\PaymentTermController@store');
    Route::post('/payment-terms-edit', 'Catalogs\PaymentTermController@edit');
    //Catalogo - Metodo de pago
    Route::get('/payment-methods', 'Catalogs\PaymentMethodController@index');
    Route::post('/payment-methods-show', 'Catalogs\PaymentMethodController@show');
    Route::post('/payment-methods-create', 'Catalogs\PaymentMethodController@create');
    Route::post('/payment-methods-store', 'Catalogs\PaymentMethodController@store');
    Route::post('/payment-methods-edit', 'Catalogs\PaymentMethodController@edit');
    //Catalogo - Impuestos
    Route::get('/taxes', 'Catalogs\TaxController@index');
    Route::post('/taxes-show', 'Catalogs\TaxController@show');
    Route::post('/taxes-create', 'Catalogs\TaxController@create');
    Route::post('/taxes-store', 'Catalogs\TaxController@store');
    Route::post('/taxes-edit', 'Catalogs\TaxController@edit');
    //Catalogo - Bancos
    Route::get('/banks', 'Catalogs\BankController@index');
    Route::post('/banks-show', 'Catalogs\BankController@show');
    Route::post('/banks-create', 'Catalogs\BankController@create');
    Route::post('/banks-store', 'Catalogs\BankController@store');
    Route::post('/banks-edit', 'Catalogs\BankController@edit');
    //Catalogo - Formas de pago
    Route::get('/payment-way', 'Catalogs\PaymentWayController@index');
    Route::post('/payment-way-show', 'Catalogs\PaymentWayController@show');
    Route::post('/payment-way-create', 'Catalogs\PaymentWayController@create');
    Route::post('/payment-way-store', 'Catalogs\PaymentWayController@store');
    Route::post('/payment-way-edit', 'Catalogs\PaymentWayController@edit');
    //Catalogo - Tipos de relación CFDI
    Route::get('/cfdi-relation', 'Catalogs\CfdiRelationController@index');
    Route::post('/cfdi-relation-show', 'Catalogs\CfdiRelationController@show');
    Route::post('/cfdi-relation-create', 'Catalogs\CfdiRelationController@create');
    Route::post('/cfdi-relation-store', 'Catalogs\CfdiRelationController@store');
    Route::post('/cfdi-relation-edit', 'Catalogs\CfdiRelationController@edit');
    //Catalogo - Tipos de comprobantes
    Route::get('/cfdi-types', 'Catalogs\CfdiTypeController@index');
    Route::post('/cfdi-types-show', 'Catalogs\CfdiTypeController@show');
    Route::post('/cfdi-types-create', 'Catalogs\CfdiTypeController@create');
    Route::post('/cfdi-types-store', 'Catalogs\CfdiTypeController@store');
    Route::post('/cfdi-types-edit', 'Catalogs\CfdiTypeController@edit');
    //Catalogo - Productos/Servicios SAT
    Route::get('/sat-products', 'Catalogs\SatProductController@index');
    Route::post('/sat-products-show', 'Catalogs\SatProductController@show');
    Route::post('/sat-products-create', 'Catalogs\SatProductController@create');
    Route::post('/sat-products-store', 'Catalogs\SatProductController@store');
    Route::post('/sat-products-edit', 'Catalogs\SatProductController@edit');
    //Catalogo - Régimen Fiscal
    Route::get('/tax-regimens', 'Catalogs\TaxRegimenController@index');
    Route::post('/tax-regimens-show', 'Catalogs\TaxRegimenController@show');
    Route::post('/tax-regimens-create', 'Catalogs\TaxRegimenController@create');
    Route::post('/tax-regimens-store', 'Catalogs\TaxRegimenController@store');
    Route::post('/tax-regimens-edit', 'Catalogs\TaxRegimenController@edit');
    //Catalogo - Régimen Fiscal
    Route::get('/cfdi-uses', 'Catalogs\CfdiUseController@index');
    Route::post('/cfdi-uses-show', 'Catalogs\CfdiUseController@show');
    Route::post('/cfdi-uses-create', 'Catalogs\CfdiUseController@create');
    Route::post('/cfdi-uses-store', 'Catalogs\CfdiUseController@store');
    Route::post('/cfdi-uses-edit', 'Catalogs\CfdiUseController@edit');

    //Catalogo - Productos
    Route::get('/products', 'Catalogs\ProductController@index');
    Route::post('/products-show', 'Catalogs\ProductController@show');
    Route::post('/products-status-show', 'Catalogs\ProductController@showEstatusProduct');
    Route::post('/products-create', 'Catalogs\ProductController@create');
    Route::post('/products-status-create', 'Catalogs\ProductController@createStatus');
    Route::post('/products-store', 'Catalogs\ProductController@store');
    Route::post('/products-edit', 'Catalogs\ProductController@edit');

    //Catalogo - Category
    Route::get('/categories', 'Catalogs\CategoryController@index');
    Route::post('/categories-show', 'Catalogs\CategoryController@show');
    Route::post('/categories-create', 'Catalogs\CategoryController@create');
    Route::post('/categories-store', 'Catalogs\CategoryController@store');
    Route::post('/categories-edit', 'Catalogs\CategoryController@edit');

    //Catalogo - Marca
    Route::get('/brands', 'Catalogs\MarcaController@index');
    Route::post('/brands-show', 'Catalogs\MarcaController@show');
    Route::post('/brands-create', 'Catalogs\MarcaController@create');
    Route::post('/brands-store', 'Catalogs\MarcaController@store');
    Route::post('/brands-edit', 'Catalogs\MarcaController@edit');

    //Catalogo - Modelo
    Route::get('/models', 'Catalogs\ModeloController@index');
    Route::post('/models-show', 'Catalogs\ModeloController@show');
    Route::post('/models-create', 'Catalogs\ModeloController@create');
    Route::post('/models-store', 'Catalogs\ModeloController@store');
    Route::post('/models-edit', 'Catalogs\ModeloController@edit');

    //Catalogo - Especificacion
    Route::get('/especificacions', 'Catalogs\EspecificacionController@index');
    Route::post('/especificacions-create', 'Catalogs\EspecificacionController@create');
    Route::post('/especificacions-store', 'Catalogs\EspecificacionController@store');
    Route::post('/especificacions-show', 'Catalogs\EspecificacionController@show');
    Route::post('/especificacions-edit', 'Catalogs\EspecificacionController@edit');
    Route::post('/especificacions-show-act', 'Catalogs\EspecificacionController@show_active');
});

Route::group(['prefix' => 'sales',  'middleware' => 'auth'], function()
{
    //All the routes that belongs to the group goes here

    //Ventas - Vendedores
    Route::get('/salespersons', 'Sales\SalespersonController@index');
    Route::post('/salespersons-show', 'Sales\SalespersonController@show');
    Route::post('/salespersons-create', 'Sales\SalespersonController@create');
    Route::post('/salespersons-store', 'Sales\SalespersonController@store');
    Route::post('/salespersons-edit', 'Sales\SalespersonController@edit');
    //Ventas - Clientes
    Route::get('/customers', 'Sales\CustomerController@index');
    Route::post('/customers-show', 'Sales\CustomerController@show');
    Route::post('/customers-create', 'Sales\CustomerController@create');
    Route::post('/customers-store', 'Sales\CustomerController@store');
    Route::post('/customers-edit', 'Sales\CustomerController@edit');
});
Route::group(['prefix' => 'base',  'middleware' => 'auth'], function()
{
      Route::get('/settings_pac', 'Base\PacController@index');
      Route::post('/pacs-show', 'Base\PacController@show');
      Route::post('/pacs-create', 'Base\PacController@create');
      Route::post('/pacs-store', 'Base\PacController@store');
      Route::post('/pacs-edit', 'Base\PacController@edit');

      Route::get('/document-types', 'Base\DocumentTypeController@index');
      Route::post('/document-types-show', 'Base\DocumentTypeController@show');
      Route::post('/document-types-create', 'Base\DocumentTypeController@create');
      Route::post('/document-types-store', 'Base\DocumentTypeController@store');
      Route::post('/document-types-edit', 'Base\DocumentTypeController@edit');

      Route::get('/exchange-rate', 'Base\ExchangeRateController@index');
      Route::post('/exchange-rate-show', 'Base\ExchangeRateController@show');
      Route::post('/exchange-rate-create', 'Base\ExchangeRateController@create');
      Route::post('/exchange-rate-store', 'Base\ExchangeRateController@store');
      Route::post('/exchange-rate-edit', 'Base\ExchangeRateController@edit');

      Route::get('/companies', 'Base\CompanyController@index');
      Route::post('/companies-show', 'Base\CompanyController@show');
      Route::post('/companies-create', 'Base\CompanyController@create');
      Route::post('/companies-store', 'Base\CompanyController@store');
      Route::post('/companies-edit', 'Base\CompanyController@edit');
      //Exchange rate
      Route::get('/exchange_rate', 'Base\ExchangeRateController@index');
      Route::get('/show_rate', 'Base\ExchangeRateController@show');
      Route::post('/edit_rate', 'Base\ExchangeRateController@edit');
      Route::post('/update_rate', 'Base\ExchangeRateController@update');
      //Branch-office
      Route::get('/branch-office', 'Base\BranchOfficeController@index');
      Route::post('/branch-office-show', 'Base\BranchOfficeController@show');
      Route::post('/branch-office-store', 'Base\BranchOfficeController@store');
      Route::post('/branch-office-edit', 'Base\BranchOfficeController@edit');
      Route::get('/state-country/{id}', function ($id) {
        $query = App\Models\Catalogs\State::where('country_id', '=', $id)->get();
        return $query;
      });
      Route::get('/cities-state/{id}', function ($id) {
        $query = App\Models\Catalogs\City::where('state_id', '=', $id)->get();
        return $query;
      });

});
