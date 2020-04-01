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
Route::post('/searchDocumentation','HomeController@getDocumentation');
//VER ENCUESTA DINAMICA
Route::get('questionary/{data}','Survey\QuestionaryController@index');
//REGISTRAR ENCUESTA DINAMICA
Route::post('/create_questionary','Survey\QuestionaryController@create_now');
Route::post('/create_questionaryb','Survey\QuestionaryController@create_now_email');
//Genero 10 link nuevos de los primeros 10 usuarios - ENCUESTA DINAMICA
// Route::get('create','Survey\QuestionaryController@create');
// Route::get('create2','QuestionaryController@create2');

Route::group(['middleware' => 'auth'], function () {
  Route::post('/vtc_generar','HomeController@vtc_generar');
  Route::post('/vtc_real_generar','HomeController@vtc_real_generar');
  //Dashboard
  Route::get('/', 'HomeController@index')->name('/');
  Route::post('/data_get_payment_all_week','HomeController@show_payment');
  Route::post('/data_summary_info_nps' , 'HomeController@show_summary_info_nps');
  Route::post('/get_graph_pais_distribution' , 'HomeController@show_apps');
  //Dashboard -Tesoreria
  Route::get('/dash_finan', 'Treasury\DashFinancieroController@index');
  Route::get('/get_info_banks/{date}/{type}', 'Treasury\DashFinancieroController@get_table_banks_mx');
  Route::post('/get_info_banks_mxn', 'Treasury\DashFinancieroController@get_bank_movements_mxn');
  Route::post('/get_info_banks_usd', 'Treasury\DashFinancieroController@get_bank_movements_usd');
  Route::post('/get_info_banks_ex', 'Treasury\DashFinancieroController@get_bank_movements_ext');
  Route::post('/get_info_banks_cred_rev', 'Treasury\DashFinancieroController@get_info_banks_cred_rev');
  Route::post('/get_all_banks', 'Treasury\DashFinancieroController@get_top_banks');
  Route::post('/get_cxc_cxp', 'Treasury\DashFinancieroController@get_cxc_cxp');
  Route::post('/get_table_bankvals', 'Treasury\DashFinancieroController@get_validaciones');
  Route::post('/get_cxc_vencidas_306090','Treasury\DashFinancieroController@get_cxc_vencidas_306090');
  Route::post('/save_comment_by_contract','Treasury\DashFinancieroController@save_comment_by_contract');
  Route::post('/get_contract_comment','Treasury\DashFinancieroController@get_contract_comment');
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
  Route::post('/activeassistant','ProfileController@activeassistant');
  Route::post('/disableassistant','ProfileController@disableassistant');
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
  Route::get('/getApsAllSites','Inventory\DistributionController@getApsAllSites');
  Route::get('/getApsSitesByCadena/cadena/{cadena}','Inventory\DistributionController@getApsSitesByCadena');
  Route::get('/getApsBySite/hotel/{hotel}','Inventory\DistributionController@getApsBySite');

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
  Route::post('/get_user_month_cadena', 'Report\Basic@user_month_cadena');
  Route::post('/get_gb_month', 'Report\Basic@gb_month');
  Route::post('/get_gb_month_cadena', 'Report\Basic@gb_month_cadena');
  Route::post('/get_mostAP_top5', 'Report\Basic@mostAP_top5');
  Route::post('/get_mostAP_top5_cadena', 'Report\Basic@mostAP_top5_cadena');
  Route::post('/get_comparative', 'Report\Basic@tab_comparativa');
  Route::post('/get_comparative_cadena', 'Report\Basic@tab_comparativa_cadena');
  Route::post('/view_reports_band' , 'Report\Basic@view_band');
  Route::post('/view_reports_device' , 'Report\Basic@view_device');

  //Modulo de reportes - ver reporte concatenado
  Route::get('/viewreportscont' , 'Report\Concatenated@index');
  //- Equipos-ALTAS
  Route::get('/up_equipment', 'Equipments\AddEquipmentController@index');
  Route::post('/search_key_group', 'Equipments\AddEquipmentController@search');
  Route::post('/search_provider', 'Equipments\AddEquipmentController@search_provider');
  Route::post('/insertModel', 'Equipments\AddEquipmentController@create_Model');
  Route::post('/search_modelo', 'Equipments\AddEquipmentController@search_modelo');

  Route::post('/create_equipament_n', 'Equipments\AddEquipmentController@create_equipament_n');
  Route::post('/create_equipament_nd', 'Equipments\AddEquipmentController@create_equipament_nd');
  Route::post('/create_equipament_n_massive','Equipments\AddEquipmentController@create_equipament_n_massive');
  Route::post('/create_equipament_nd_massive','Equipments\AddEquipmentController@create_equipament_nd_massive');

  Route::post('/insertMarca', 'Equipments\AddEquipmentController@create_marca');
  Route::post('/search_marcas', 'Equipments\AddEquipmentController@search_marca');
  Route::post('/search_marca_all', 'Equipments\AddEquipmentController@search_marca_all');
  Route::post('/insertGrupo', 'Equipments\AddEquipmentController@create_group');
  Route::post('/search_grupo', 'Equipments\AddEquipmentController@search_grupo');
  Route::post('/insertProveedor', 'Equipments\ProviderController@insertnewprovider');
  //Equipos-BAJAS
  Route::get('/down_equipment', 'Equipments\RemovedEquipmentController@index');
  Route::post('/send_item_drops_hotels', 'Equipments\RemovedEquipmentController@edit');
  //Equipos-BUSCADOR
  Route::get('/detailed_search', 'Equipments\SearchEquipmentController@index');
  Route::post('/search_range_equipament_all', 'Equipments\SearchEquipmentController@search_range');
  Route::post('/get_equip_departure', 'Equipments\SearchEquipmentController@get_equip_departure');
  Route::post('/search_infoeq_fact', 'Equipments\SearchEquipmentController@search_infoeq_fact');
  Route::post('/search_infoeq_model', 'Equipments\SearchEquipmentController@search_infoeq_model');
  //Movimiento de equipos
  Route::get('/move_equipment', 'Equipments\MoveEquipmentController@index');
  Route::post('/search_item_descript_hotels', 'Equipments\MoveEquipmentController@descrip');
  Route::post('/save_description_move_hotels', 'Equipments\MoveEquipmentController@update');
  Route::post('/send_item_move_hotels', 'Equipments\MoveEquipmentController@edit');
  Route::post('/search_rem_equipament_hotel', 'Equipments\RemovedEquipmentController@show');
  Route::post('/search_excel_equipament', 'Equipments\RemovedEquipmentController@show2');
  Route::post('/get_mac_res', 'Equipments\SearchEquipmentController@search_mac');

  //Grupos
  Route::get('/group_equipment', 'Equipments\GroupEquipmentController@index');
  Route::post('/group_insert', 'Equipments\GroupEquipmentController@insertNewGroup');
  Route::post('/get_new_groups', 'Equipments\GroupEquipmentController@update_select');
  Route::post('/get_table_group', 'Equipments\GroupEquipmentController@table_group');
  Route::post('/update_group_equipment', 'Equipments\GroupEquipmentController@update_group');
  Route::post('/move_group', 'Equipments\GroupEquipmentController@update_move_group');

  Route::get('/noc_tools','Noc\NocToolsController@index');
  Route::get('/checklist','Noc\NocToolsController@cl_diario');
  Route::get('/dash_operacion','Noc\NocToolsController@dash_operacion');
  Route::post('/dash_operacion_nps','Noc\NocToolsController@dash_operacion_nps');
  Route::post('/dash_operacion_tickets','Noc\NocToolsController@dash_operacion_tickets');
  Route::post('/graph_operacion_tickets','Noc\NocToolsController@graph_operacion_tickets');
  Route::post('/all_disponibilidad','Noc\NocToolsController@all_disponibilidad');
  Route::post('/dash_operacion_eq_act_mon','Noc\NocToolsController@dash_operacion_eq_act_mon');
  Route::post('/get_cl_diario','Noc\NocToolsController@get_cl_diario');
  Route::post('get_cl_instalaciones', 'Noc\NocToolsController@get_cl_instalaciones');
  Route::post('/get_cl_5_dia','Noc\NocToolsController@get_cl_5_dia');
  Route::post('/get_cl_20_dia','Noc\NocToolsController@get_cl_20_dia');
  //Carátula de entrega
  Route::get('/cover_equipment_delivery', 'Equipments\CoverDeliveryEquipmentController@index');
  Route::post('/cover_delivery_header', 'Equipments\CoverDeliveryEquipmentController@getHeader');
  Route::post('/cover_delivery_groups', 'Equipments\CoverDeliveryEquipmentController@table_group');
  Route::post('/cover_dist_groups_disp', 'Equipments\CoverDeliveryEquipmentController@getCoverDistEquipos');
  Route::post('/cover_dist_groups_models', 'Equipments\CoverDeliveryEquipmentController@getCoverDistModelos');

  //Licencias Sonic Wall
  Route::get('/licences_equipment', 'Equipments\LicencesEquipmentController@index');
  Route::post('/get_licences', 'Equipments\LicencesEquipmentController@licences');
  Route::post('/get_licence_mac', 'Equipments\LicencesEquipmentController@licence_mac');
  Route::post('/update_date', 'Equipments\LicencesEquipmentController@update_date');
  //Dashboard nps
  Route::post('/summary_info_nps' , 'Survey\DashboardSurveyController@show_summary_info_nps');
  Route::post('/show_comparative_year' , 'Survey\DashboardSurveyController@compare_year');
  Route::post('/get_graph_nps' , 'Survey\DashboardSurveyController@percent_graph_nps');
  Route::post('/get_graph_ppd' , 'Survey\DashboardSurveyController@cant_graph_ppd');
  Route::post('get_graph_week','Survey\DashboardSurveyController@cant_graph_week');
  Route::post('/get_graph_uvsr' , 'Survey\DashboardSurveyController@graph_uvsr');
  Route::post('/get_graph_avgcal' , 'Survey\DashboardSurveyController@graph_avgcal');
  Route::post('/get_table_vert' , 'Survey\DashboardSurveyController@table_vert');
  Route::post('/get_table_results', 'Survey\DashboardSurveyController@table_results_full');
  Route::post('/get_table_comments_nps', 'Survey\DashboardSurveyController@table_comments_nps');
  Route::post('/get_table_comments_nps_full', 'Survey\DashboardSurveyController@table_commentsNPS_full');
  Route::post('/box_total', 'Survey\DashboardSurveyController@box_total');
  Route::post('/box_con', 'Survey\DashboardSurveyController@box_contestadas');
  Route::post('/box_sin', 'Survey\DashboardSurveyController@box_sin_contestar');
  Route::post('/box_promo', 'Survey\DashboardSurveyController@box_promotor');
  Route::post('/box_pas', 'Survey\DashboardSurveyController@box_pasivo');
  Route::post('/box_detra', 'Survey\DashboardSurveyController@box_detractor');
  //- Herramientas
  Route::get('/detailed_guest_review', 'Tools\GuestToolsController@index');
  Route::get('/detailed_server_review', 'Tools\ServerToolsController@index');
  Route::get('/testzone', 'Tools\ZoneToolsController@index');
  Route::post('/getInfoZD', 'Tools\ZoneToolsController@getInfo');
  Route::post('/testzonedir', 'Tools\ZoneToolsController@testRequest');
  Route::get('/detailed_paquetes','Tools\GuestToolsController@hacienda_view');
  Route::post('/get_paquetes_month','Tools\GuestToolsController@getPaquetesMonth');
  Route::post('/get_paquetes_all','Tools\GuestToolsController@getPaquetesAll');

  Route::post('/existenceUsers', 'Tools\GuestToolsController@getUsersHC');
  Route::post('/existenceUsersAll', 'Tools\GuestToolsController@getPortalUsers');

  Route::get('/DiagHuespedAjax','Tools\GuestToolsController@checkGuest');
  Route::post('/DiagHuespedAjax2', 'Tools\GuestToolsController@checkWebSer');

  Route::get('/DiagServidorAjax', 'Tools\ServerToolsController@checkRad');
  Route::get('/DiagServidorAjax2','Tools\ServerToolsController@checkWB');

  Route::get('/testWebSer', 'Tools\GuestToolsController@checkWebSer');

//MODULO DE COMPRAS - Documento P / M
  Route::resource('documentp', 'Projects\DocumentpController', ['only' => [
  'store'
  ]]);
  Route::get('/documentp_cart', 'Projects\DocumentpCartController@index');
  Route::get('items/ajax/{type}/{aps}/{api}/{ape}/{firewalls}/{switches}/{switch_cant}',
  ['uses'  => 'Projects\DocumentpCartController@getItemType'])->where('type', 'first');
  Route::get('items/ajax/{type}/{api}/{ape}/{switch_cant}/{gabinetes}/{material}/{medida}',
  ['uses'  => 'Projects\DocumentpCartController@getItemTypeMaterials'])->where('type', 'second');
  Route::get('items/ajax/third/{category}/{material}/{type}/{medida}', ['uses'  => 'Projects\DocumentpCartController@getCategories']);
  Route::get('items/ajax/third/{category}/{description}/{material}/{type}/{medida}',
          ['uses'  => 'Projects\DocumentpCartController@getCategoriesDescription']);
  Route::get('items/ajax/four/{api}/{ape}', ['uses'  => 'Projects\DocumentpCartController@getMoProducts']);
  Route::get('items/ajax/four/{api}/{ape}/{id_doc}', ['uses'  => 'Projects\DocumentpCartController@getMoProductsCart']);
  Route::get('items/ajax/five/{api}/{ape}', ['uses'  => 'Projects\DocumentpCartController@getViaticsProducts']);
  Route::get('getProductsCart/{aps}/{firewalls}/{switches}/{gabinetes}', 'Projects\DocumentpCartController@getProductsCart');
  // Route::get('items/ajax/third/{category}/{description}', ['uses'  => 'Projects\DocumentpCartController@getCategoriesDescription']);
  Route::post('/deleteProductsShoppingCart', 'Projects\DocumentpCartController@deleteProductsShoppingCart');
  Route::get('/getTypeMaterial/material/{id}', function ($id) {
  $result = DB::table('product_type_material')->select('id', 'name')->where('product_material_id', $id)->get();
  return $result;
  });
  Route::get('/documentp_invoice/{id_documentp}/{id_cart}', 'Projects\DocumentpController@export_invoice');
  Route::get('/update_cant_cart/{id}/{cant}/{porcentaje_compra}', 'Projects\DocumentpController@update_cantidad_recibida');
  Route::get('/update_fecha_entrega/{id}/{date}', 'Projects\DocumentpController@update_fecha_entrega');
  Route::get('/update_status_product/{id}/{status}', 'Projects\DocumentpController@update_status_product');
  Route::get('/update_motive_project/{id}/{motive}', 'Projects\DocumentpController@update_motive_project');
  Route::get('/update_purchase_order/{id}/{order}', 'Projects\DocumentpController@update_purchase_order');
  Route::get('/get_comment_documentp_advance/id_doc/{id}', 'Projects\DocumentpHistoryController@get_comment_project');
  Route::post('/set_comment_documentp_advance', 'Projects\DocumentpHistoryController@update_comment_project');
  Route::post('/set_comment_compras_documentp', 'Projects\DocumentpHistoryController@set_comment_compras_documentp');
  //Historial documento P | M
  Route::get('/view_history_documentm', 'Projects\DocumentpHistoryController@index');
  Route::get('/view_history_documentp', 'Projects\DocumentpHistoryController@history_docp')->name('view_history_documentp');
  Route::get('/view_history_auth_documentp', 'Projects\DocumentpHistoryController@view_auth');
  Route::get('/view_doc_delivery', 'Projects\DocumentpHistoryController@view_delivery');
  Route::get('/view_project_doc_p', 'Projects\DocumentpHistoryController@view_project_advance');
  Route::get('/view_project_docp_success', 'Projects\DocumentpHistoryController@view_project_advance_success');
  Route::get('/documentp_table_products/{id_documentp}/{id_cart}', 'Projects\DocumentpHistoryController@get_table_products');
  Route::get('/documentp_table_project_advance/id_doc/{id_documentp}', 'Projects\DocumentpHistoryController@get_table_project_advance');
  Route::post('/update_advace_project', 'Projects\DocumentpHistoryController@update_project_advance');
  Route::get('/documentp_header/data/{id}', 'Projects\DocumentpHistoryController@get_header');
  Route::get('/documentp_header/data_deny/{id}', 'Projects\DocumentpHistoryController@get_deny_comment');
  Route::get('/documentp_header/data_status_user/{id}', 'Projects\DocumentpHistoryController@get_status_user');
  Route::post('/view_request_documentp_zero', 'Projects\DocumentpHistoryController@get_history_documentp');
  Route::post('/get_documentp_auth', 'Projects\DocumentpHistoryController@get_history_auth_documentp');
  Route::post('/get_documentp_advance', 'Projects\DocumentpHistoryController@get_history_project_advance');
  Route::post('/get_documentp_delivery', 'Projects\DocumentpHistoryController@get_history_delivery_documentp');
  Route::get('/documentp_table_logs/data/{id_documentp}', 'Projects\DocumentpHistoryController@get_history_logs');
  Route::get('/documentp_table_logs_advance_projects/data/{id_documentp}', 'Projects\DocumentpHistoryController@get_history_logs_project_advance');
  Route::post('/get_hotel_cadena_doc', 'Projects\DocumentpController@hotel_cadena');
  Route::get('/get_vertical_anexo/anexo/{id}', 'Projects\DocumentpController@get_vertical_anexo');
  Route::get('/estimation_site_table/id_anexo/{anexo}', 'Projects\DocumentpHistoryController@get_estimation_site_by_site');
  Route::get('/estimation_site_data/id_anexo/{anexo}', 'Projects\DocumentpHistoryController@get_estimation_site_by_site_data');
  Route::get('/budget_site_table/{id_anexo}/{tipo_cambio}/{date}', 'Projects\DocumentpHistoryController@get_budgettable_site');
  Route::post('/uploadActaEntrega', 'Projects\DocumentpController@uploadActaEntrega');
  Route::post('/downloadActaEntrega', 'Projects\DocumentpController@downloadActaEntrega');
  Route::get('/checkActaEntregaUpload/{id_documentp}', 'Projects\DocumentpController@checkActaEntregaUpload');
  //Editar Documento P
  Route::post('/edit_cart', 'Projects\EditDocumentPController@index'); //Vista del formulario para editar
  Route::get('/get_shopping_cart/id/{id}', 'Projects\EditDocumentPController@getShoppingCart');
  Route::post('/edit_documentp', 'Projects\EditDocumentPController@edit');
  Route::post('/get_data_project', 'Projects\EditDocumentPController@get_data_project');
  Route::get('/view_edit_projects', 'Projects\EditDocumentPController@edit_project');
  Route::post('/edit_form_docp', 'Projects\EditDocumentPController@update_form_project');
  Route::post('/set_servmensual_documentp', 'Projects\EditDocumentPController@update_servicio_mensual');
  Route::post('/set_priority_documentp', 'Projects\EditDocumentPController@update_priority');
  Route::post('/set_alert_documentp_advance', 'Projects\EditDocumentPController@update_alert');
  Route::post('/set_statusfact_documentp_advance', 'Projects\EditDocumentPController@update_status_fact');
  //Documento P Autorizaciones
  Route::post('/send_item_doc_new', 'Projects\DocumentpHistoryController@approval_one');
  Route::post('/send_item_doc_auth', 'Projects\DocumentpHistoryController@approval_two');
  Route::post('/send_item_doc_delivery', 'Projects\DocumentpHistoryController@delivery_doc');
  Route::post('/deny_documentp', 'Projects\DocumentpHistoryController@deny_docp');
  //Dashboard Documento
  Route::get('/view_dashboard_project', 'Projects\DocumentpDashboardController@index');
  Route::get('/get_count_all_doctype', 'Projects\DocumentpDashboardController@get_count_all_doctype');
  Route::get('/get_status_project', 'Projects\DocumentpDashboardController@get_status_project');
  Route::get('/get_delay_projects_ejecucion', 'Projects\DocumentpDashboardController@get_delay_projects_ejecucion');
  Route::get('/get_delay_projects_instalado', 'Projects\DocumentpDashboardController@get_delay_projects_instalado');
  Route::get('/get_delay_motives_ejecucion', 'Projects\DocumentpDashboardController@get_delay_motives_ejecucion');
  Route::get('/get_delay_motives_instalado', 'Projects\DocumentpDashboardController@get_delay_motives_instalado');
  Route::get('/get_rentas_perdidas', 'Projects\DocumentpDashboardController@get_rentas_perdidas');
  Route::get('/get_rentas_perdidas_instalado', 'Projects\DocumentpDashboardController@get_rentas_perdidas_instalado');
  Route::get('/get_presupuesto_ejercido_prom', 'Projects\DocumentpDashboardController@get_presupuesto_ejercido_prom');
  Route::get('/get_table_atraso_filterby_motivo/id/{id}', 'Projects\DocumentpDashboardController@get_table_atraso_filterby_motivo');
  Route::get('/get_table_atraso_filterby_motivo_instalado/id/{id}', 'Projects\DocumentpDashboardController@get_table_atraso_filterby_motivo_instalado');
  Route::get('/get_table_atraso_filterby_servicio/{tipo_servicio}/{atraso}', 'Projects\DocumentpDashboardController@get_table_atraso_filterby_servicio');
  Route::get('/get_table_atraso_filterby_servicio_instalado/{tipo_servicio}/{atraso}', 'Projects\DocumentpDashboardController@get_table_atraso_filterby_servicio_instalado');
  Route::post('/get_documentp_project_xstatus','Projects\DocumentpDashboardController@project_xstatus');
  //Presupuesto proyectos.
  Route::get('/view_budget','Projects\BudgetController@index');
  Route::post('/get_annual_table', 'Projects\BudgetController@get_annual_budget');
  Route::post('/refresh_tablebudget','Projects\BudgetController@refresh_budget_sites');
  Route::post('/edit_presupuesto', 'Projects\BudgetController@update_budget');
  Route::get('/view_budget_report','Projects\BudgetController@index_budget_report');
  Route::post('/get_budget_report_table','Projects\BudgetController@get_budget_report');
  Route::post('get_desglose_payments_id','Projects\BudgetController@get_desglose_payments');
  //COTIZADOR
  Route::get('/quoting', 'Projects\QuotingController@index');
  Route::post('/quoating_create', 'Projects\QuotingController@store');
  Route::get('/view_quotig_history', 'Projects\QuotingController@index_history');
  Route::get('/view_history_quoting_out_parameters', 'Projects\QuotingController@get_history_quoting_out_parameters');
  Route::get('/view_history_quoting_kickoff', 'Projects\QuotingController@get_history_quoting_kickoff');
  Route::get('/view_history_quoting_signature', 'Projects\QuotingController@get_history_signature_kickoff');
  Route::get('/view_auth_history_quoting', 'Projects\QuotingController@view_auth');
  Route::get('/view_history_quoting_inreview', 'Projects\QuotingController@view_review');
  Route::post('/set_status_quoting', 'Projects\QuotingController@set_status_quoting');
  Route::get('/quoting_table_products/{id_documentp}/{id_cart}', 'Projects\QuotingController@get_table_products');
  Route::get('/quoting_invoice/{id_documentp}/{id_cart}', 'Projects\QuotingController@export_invoice');
  Route::post('/view_request_quoting', 'Projects\QuotingController@get_history_quoting');
  Route::post('/get_quoting_auth', 'Projects\QuotingController@get_history_auth_quoting');
  Route::post('/edit_cart_quoting', 'Projects\QuotingEditController@index'); //Vista del formulario para editar
  Route::post('/edit_quoting', 'Projects\QuotingEditController@edit');
  Route::post('/quoting_approval_directive', 'Projects\QuotingController@quoting_approval_directive');
  Route::get('/get_quoting_objetives/{id_doc}', 'Projects\QuotingController@get_quoting_objetives');
  Route::get('/get_approvals_propuesta_comercial/{id_doc}', 'Projects\QuotingController@get_approvals_propuesta_comercial');
  Route::post('/approval_directives_propuesta_comercial', 'Projects\QuotingController@approval_directives_propuesta_comercial');

  //KICK-OFF
  Route::post('/edit_kickoff', 'Projects\KickoffController@index');
  Route::post('/update_kickoff', 'Projects\KickoffController@update');
  Route::post('/update_kickoff_comision', 'Projects\KickoffController@update_kickoff_comision');
  Route::post('/update_kickoff_comisionByDefault', 'Projects\KickoffController@setComision');
  Route::post('/update_kickoff_contract_comision', 'Projects\KickoffController@update_kickoff_contract_comision');
  Route::get('/approval_administracion/id_doc/{id}', 'Projects\KickoffController@approval_administracion');
  Route::get('/approval_comercial/id_doc/{id}', 'Projects\KickoffController@approval_comercial');
  Route::get('/approval_proyectos/id_doc/{id}', 'Projects\KickoffController@approval_proyectos');
  Route::get('/approval_soporte/id_doc/{id}', 'Projects\KickoffController@approval_soporte');
  Route::get('/approval_planeacion/id_doc/{id}', 'Projects\KickoffController@approval_planeacion');
  Route::get('/approval_itconcierge/id_doc/{id}', 'Projects\KickoffController@approval_itconcierge');
  Route::get('/approval_servicio_cliente/id_doc/{id}', 'Projects\KickoffController@approval_servicio_cliente');
  Route::get('/approval_facturacion/id_doc/{id}', 'Projects\KickoffController@approval_facturacion');
  Route::get('/approval_legal/id_doc/{id}', 'Projects\KickoffController@approval_legal');
  Route::get('/approval_vendedor/id_doc/{id}', 'Projects\KickoffController@approval_vendedor');
  Route::get('/approval_investigacion/id_doc/{id}', 'Projects\KickoffController@approval_investigacion');
  Route::get('/approval_director_operaciones/id_doc/{id}', 'Projects\KickoffController@approval_director_operaciones');
  Route::get('/approval_director_general/id_doc/{id}', 'Projects\KickoffController@approval_director_general');
  Route::get('/notificaciones_read_doc/{id}', 'Auth\NotificationController@read_docp');
  Route::get('/view_pdf_propuesta_comercial/{id_doc}', 'Projects\KickoffController@generate_pdf_propuesta');
  Route::post('/send_pdf_propuesta_comercial/', 'Projects\KickoffController@send_mail_pdf_propuesta');
  Route::post('/save_comision_kickoff', 'Projects\KickoffController@save_comision_kickkoff');
  //Notificaciones viaticos
  Route::get('/notificaciones', 'Auth\NotificationController@vue_index')->name('notification.vue_index');
  Route::get('/notificaciones_read/{id}', 'Auth\NotificationController@read');

  //- Viaticos Dashboard
  Route::get('/dashboard_viaticos', 'Viatics\DashboardViaticController@index');
  Route::post('/search_info_dash_viat', 'Viatics\DashboardViaticController@info');
  //- Viaticos Solicitud
  Route::get('/add_request_via', 'Viatics\AddViaticController@index');
  Route::post('/viat_find_hotel', 'Viatics\AddViaticController@find_hotel');
  Route::post('/create_viatic_new', 'Viatics\AddViaticController@create_viatic');
  Route::post('/search_beneficiary', 'Viatics\AddViaticController@find_user');
  Route::post('/viat_find_concept', 'Viatics\AddViaticController@find_concept');
  //Denegar Viaticos
      Route::post('/deny_viatic', 'Viatics\RequestsViaticController@deny_viatic');
    //- Viaticos Solicitud
    Route::get('/view_request_via', 'Viatics\RequestsViaticController@index')->name('view_request_via');
    //- Todos los vitaticos
    Route::get('/view_request_all_via', 'Viatics\RequestViaticAllController@index');
    Route::get('/view_request_all_via_edit', 'Viatics\RequestViaticAllController@edit');
    Route::post('/view_request_via_all', 'Viatics\RequestViaticAllController@history_all');
    //Anexo a tiempo de respuesta y solucion
		Route::post('/update_conceptable', 'Viatics\RequestsViaticController@upd_datostab');
    //- Reporte semanal viaticos
    Route::get('/view_viatic_weekly', 'Viatics\ViaticWeeklyController@index');
    Route::post('/view_request_via_weekly', 'Viatics\ViaticWeeklyController@viatic_historic_weekly');
    //Timeline Viaticos
    Route::post('/search_data_timeline', 'Viatics\RequestViaticAllController@timeline');
    Route::post('/view_request_total_concept_viatic', 'Viatics\RequestViaticAllController@totales');

    Route::post('/update_data_conp', 'Viatics\RequestsViaticController@ndatos');
    //Viaticos Historial N0
    Route::post('/view_request_via_zero','Viatics\RequestsViaticController@history_zero');
    Route::post('/view_request_show_viatic_up', 'Viatics\RequestsViaticController@show_viatic_up');
    Route::post('/view_request_show_viatic_down', 'Viatics\RequestsViaticController@show_viatic_down');
    Route::post('/view_request_via_btns', 'Viatics\RequestsViaticController@get_prvnext');
    //Viaticos Historial N1
    Route::post('/view_request_via_one', 'Viatics\RequestsViaticController@history_one');
    Route::post('/view_pertain_viatic_ur', 'Viatics\RequestsViaticController@pertain_viatic');
    Route::post('/send_item_nuevo', 'Viatics\RequestsViaticController@edit_status_one');
    Route::post('/view_concept_via_one', 'Viatics\RequestsViaticController@find_concept_all');
    Route::post('/search_all_status_concep', 'Viatics\RequestsViaticController@find_concept');
    Route::post('/insert_request_1_data', 'Viatics\RequestsViaticController@insert_data_1');
    //Viaticos Historial N2
    Route::post('/view_request_via_two', 'Viatics\RequestsViaticController@history_two');
    Route::post('/view_pertain_viatic_ur_n2', 'Viatics\RequestsViaticController@pertain_viatic_two');
    Route::post('/send_item_pendientes', 'Viatics\RequestsViaticController@edit_status_two');

    //Viaticos Historial N3
    Route::post('/view_request_via_three', 'Viatics\RequestsViaticController@history_three');
    Route::post('/view_pertain_viatic_ur_n3', 'Viatics\RequestsViaticController@pertain_viatic_three');
    Route::post('/send_item_verifica', 'Viatics\RequestsViaticController@edit_status_three');
    //Viaticos Historial N4
    Route::post('/view_request_via_four', 'Viatics\RequestsViaticController@history_four');
    Route::post('/view_pertain_viatic_ur_n4', 'Viatics\RequestsViaticController@pertain_viatic_four');
    Route::post('/send_item_aprueba', 'Viatics\RequestsViaticController@edit_status_four');

    //Pagos
    Route::get('/provider', 'Equipments\ProviderController@index');
    Route::post('/getTableProvider', 'Equipments\ProviderController@getTableProviders');
    Route::post('/delete_provider', 'Equipments\ProviderController@deleteprov');
    Route::post('/show_updateinfo', 'Equipments\ProviderController@showUpdate');
    Route::post('/update_provider', 'Equipments\ProviderController@updateprov');

    //- Dashboard pagos
    Route::get('/view_dashboard_req_pay', 'Payments\DashboardPayController@index');
    Route::post('/search_data_payment_genral' , 'Payments\DashboardPayController@data_header');
    //Route::post('/search_data_payment_applicat' , 'Payments\DashboardPayController@data_application');
    Route::post('/search_data_payment_waypay' , 'Payments\DashboardPayController@data_waypay');
    Route::post('/search_data_payment_current' , 'Payments\DashboardPayController@data_current');
    //Route::post('/search_data_payment_classifications' , 'Payments\DashboardPayController@data_classifications');
    //Route::post('/search_data_payment_options' , 'Payments\DashboardPayController@data_options');
    Route::post('/search_data_payment_six_months' , 'Payments\DashboardPayController@data_month');

    //Solicitud de pagos
    Route::get('/view_add_req_pay', 'Payments\PayAddController@index3');
    Route::post('/get_hotel_cadena', 'Payments\PayAddController@hotel_cadena');
    Route::post('/get_idubication_pay', 'Payments\PayAddController@sitio_ubication');
      // Cuentas contables.
    Route::post('/get_class_serv', 'Payments\PayAddController@get_classxservice');
    Route::post('/get_serv_concept', 'Payments\PayAddController@get_cxconcepts');
    Route::post('/get_concept_desc', 'Payments\PayAddController@get_cxdescriptions');
    Route::post('/get_chainxclassif', 'Payments\PayAddController@classif_vertical_chain');
    Route::post('/get_data_bank', 'Payments\PayAddController@get_bank');
    Route::post('/get_account_clabe', 'Payments\PayAddController@get_data_account');

    Route::get('/view_providers', 'Payments\ProvidersController@index');
    Route::post('/providers-show', 'Payments\ProvidersController@show');
    Route::post('/providers-create', 'Payments\ProvidersController@create');
    Route::post('/providers-update', 'Payments\ProvidersController@update');

    //Pagos solicitud
    Route::post('get_data_accw', 'Payments\PayAddController@info_account');
    Route::post('/getStateFactura', 'Payments\PayImportController@getStateFactura');

    //Alta datos bancarios
    Route::post('/setdata_bank', 'Payments\PayAddController@set_data_bank');

    //- Pagos Historial
    Route::get('/view_history_req_pay', 'Payments\PayHistoryController@index');
    Route::post('/edit_pay_ways', 'Payments\PayHistoryController@edit_pay_ways');
    Route::post('/get_proveedor_banks', 'Payments\PayHistoryController@get_proveedor_banks');
    Route::post('/export_pay', 'Payments\PayHistoryController@export_pay');

    //- Pagos Historial N0
    Route::post('/view_request_pay_zero', 'Payments\PayHistoryController@history_zero');
    //- Pagos Historial N1
    Route::post('/send_item_pay_new', 'Payments\PayHistoryController@approval_one');
    //- Pagos Historial N2
    Route::post('/send_item_pay_revised', 'Payments\PayHistoryController@approval_two');

    //- Pagos Historial All
    Route::get('/view_history_all_req_pay', 'Payments\PayHistoryAllController@index');
    Route::post('/history_all_filter', 'Payments\PayHistoryAllController@solicitudes_historic');

    //Historial Pagos
    Route::post('/cc_account', 'Payments\PayHistoryController@cc_account');
    Route::post('/get_coins', 'Payments\PayHistoryController@get_coins');
    Route::post('/view_gen_sol_pay', 'Payments\PayHistoryController@data_basic');
    Route::post('/view_gen_sol_venues', 'Payments\PayHistoryController@data_basic_venues');
    Route::post('/view_gen_sol_pay_bank', 'Payments\PayHistoryController@data_basic_bank');
    Route::post('/view_gen_sol_firmas','Payments\PayHistoryController@data_basic_firmas');
    Route::post('/update_pay', 'Payments\PayHistoryController@update_pay');
    //Crear pagos
    Route::post('/create_pay', 'Payments\PayAddController@create_pay_test');
    //Filtrar pagos
    Route::get('/view_filter_req_pay', 'Payments\FilterPayController@index');
    Route::post('/get_payment_by_folio', 'Payments\FilterPayController@get_payment_by_folio');
    Route::post('/search_folio', 'Payments\FilterPayController@autocomplete_folio');
    Route::post('/get_payment_by_id', 'Payments\FilterPayController@get_paymentId');
    Route::post('/get_payment_folios', 'Payments\FilterPayController@get_folios');
    Route::post('/get_payment_by_proveedor', 'Payments\FilterPayController@get_payments_proveedor');
    Route::post('/get_payment_by_cuenta', 'Payments\FilterPayController@get_payments_cuentacontable');
    Route::post('/downloadInvoicePay', 'Payments\PayHistoryController@getInvoice');
    Route::post('/downloadInvoicePdf','Payments\PayHistoryController@getInvoicePdf');

    //Ver pagados
    Route::get('/view_history_all_status_paid', 'Payments\PayHistoryPaidController@index');
    Route::post('/history_status_paid_month', 'Payments\PayHistoryPaidController@payments_paid');
    Route::post('/history_status_paid_month_period', 'Payments\PayHistoryPaidController@payments_paid_period');
    Route::post('/history_status_paid_month_sumas', 'Payments\PayHistoryPaidController@payments_paid_sums');
    Route::get('/view_facturas_pend', 'Payments\PayHistoryPaidController@index_facturapendiente');
    // Route::post('/get_data_fact_by_drive', 'Payments\PayHistoryPaidController@get_data_fact_by_drive');

    //Programar pagos
    Route::get('/program_date_pay', 'Payments\PayHistoryController@index2');
    Route::post('/get_program_table', 'Payments\PayHistoryController@program_payment');
    Route::post('/get_date_pay_program', 'Payments\PayHistoryController@get_date_pay_program');
    Route::post('/deny_payment', 'Payments\PayHistoryController@deny_payment_act');
    Route::post('/send_item_pay_program', 'Payments\PayHistoryController@approval_program');
    Route::post('/send_item_pay_program_check', 'Payments\PayHistoryController@approval_program_all');
    //Registro de multiples pagos
		Route::get('/view_add_req_pay_mult', 'Payments\PayImportController@index');//RUTAS
    Route::post('/getDataExcel', 'Payments\PayImportController@getDataExcel');
    Route::post('create_pay_import', 'Payments\PayImportController@create_payment_from_excel');
    //Confirmar Pagos
    Route::get('/confirm_pay', 'Payments\PayHistoryController@index3');
    Route::post('/get_confirm_pay_table', 'Payments\PayHistoryController@confirm_payment_table');
    Route::post('/get_confirm_pay_table_period', 'Payments\PayHistoryController@confirm_payment_table_period');
    Route::post('/get_confirm_pay_table_sums', 'Payments\PayHistoryController@confirm_pay_sums');
    Route::post('/get_fact_idpay', 'Payments\PayHistoryController@get_fact_name');
    Route::post('/send_item_pay_authorized', 'Payments\PayHistoryController@approval_three');
    //Route::post('/send_item_pay_authorized_indv', 'Payments\PayHistoryController@approval_three_ind');
    // Edit cuentas contables pagos.
    Route::get('/edit_paycc','Payments\PayHistoryAllController@index_paycc');
    Route::post('/edit_paymov_cc','Payments\PayHistoryAllController@send_items_editcc');
  //- Modulo de definir cuentas por default
    Route::get('/view_pay_bank', 'Payments\BankAccountsController@index');
    Route::post('/get_table_bk', 'Payments\BankAccountsController@generate_table');
    Route::post('/get_provbco_data','Payments\BankAccountsController@get_prov_bco_cta');
    Route::post('/edit_prov_cta','Payments\BankAccountsController@edit_prov_bco_cta');
    Route::post('/reasign_cta_bk', 'Payments\BankAccountsController@set_bank');
    //Dashboard Contratos
    Route::get('cont_dashboard', 'Contracts\ContratoController@index');

    Route::post('show_dashboard_states', 'Contracts\ContratoController@show_dashboard_states');
    Route::post('show_table_news_contracts', 'Contracts\ContratoController@show_table_news_contracts');
    Route::post('show_table_active_contracts', 'Contracts\ContratoController@show_table_active_contracts');
    Route::post('show_table_expired_contracts', 'Contracts\ContratoController@show_table_expired_contracts');
    Route::post('downloadInvoiceContract', 'Contracts\ContratoController@getInvoiceContract');

    Route::post('/show_table_active_contracts_master', 'Contracts\ContratoController@info_act_cont_master');
		Route::post('/show_table_active_anexo_contracts', 'Contracts\ContratoController@info_act_cont_anexo');

		Route::post('/show_table_active_contracts_master_now', 'Contracts\ContratoController@info_act_cont_master_now');
		Route::post('/show_table_active_anexo_contracts_now', 'Contracts\ContratoController@info_act_cont_anexo_now');

		Route::post('/show_table_expired_contracts_master', 'Contracts\ContratoController@info_exp_cont_master_now');
		Route::post('/show_table_expired_anexo_contracts', 'Contracts\ContratoController@info_exp_cont_anexo_now');

		Route::post('/show_table_exp_nov_anexo_contracts', 'Contracts\ContratoController@info_expnov_cont_anexo_now');
		Route::post('/show_table_exp_year_anexo_contracts', 'Contracts\ContratoController@info_expyear_cont_anexo_now');

		Route::post('/show_table_pause_contracts_master', 'Contracts\ContratoController@info_pause_cont_master');
		Route::post('/show_table_pause_anexo_contracts', 'Contracts\ContratoController@info_pause_cont_anexo');

    Route::post('/show_datavert_contracts_master', 'Contracts\ContratoController@info_datavert_cont_master');
    Route::post('/show_datavert_anexo_contracts', 'Contracts\ContratoController@info_datavert_cont_anexo');


    Route::post('/show_grap_ap_x_vertical', 'Contracts\ContratoController@grap_ap_x_vertical');
    Route::post('/show_table_ap_x_vertical', 'Contracts\ContratoController@table_ap_x_vertical');

    Route::post('/gen_table_vert_cont', 'Contracts\ContratoController@table_ap_x_vertical');
    Route::post('/gen_table_cad_cont', 'Contracts\ContratoController@fact_contrat_coin');

    Route::post('/getdata_infomaster_byanexo', 'Contracts\ContratoController@get_data_info_master_anexo');

		Route::post('/idproy_search_key_one', 'Contracts\IdProyectoController@search_key_one');
		Route::post('/idproy_search_vertical_by_class', 'Contracts\IdProyectoController@vertical_by_class');

		Route::post('/idproy_search_key_two', 'Contracts\IdProyectoController@search_key_two');
		Route::post('/idproy_search_cadena_by_vert', 'Contracts\IdProyectoController@cadena_by_vert');


		Route::post('/idproy_search_key_three', 'Contracts\IdProyectoController@search_key_three');
		Route::post('/idproy_search_hotel_by_cadena', 'Contracts\IdProyectoController@hotel_by_cadena');

		Route::post('/idproy_search_key_four', 'Contracts\IdProyectoController@search_key_four');

		Route::post('/idproy_search_key_five', 'Contracts\IdProyectoController@search_key_five');
		Route::post('/idproy_search_id_hotel', 'Contracts\IdProyectoController@search_idproyect');

		Route::post('/verf_idproyect', 'Contracts\IdProyectoController@verf_idproyect');
    //Crear id ubicacion-Contratos
    Route::get('cont_create_idubic', 'Contracts\IdUbicacionController@index');
		Route::post('find_new_idubication', 'Contracts\IdUbicacionController@find_new_idubication');
		Route::post('search_info_site_idubicacion', 'Contracts\IdUbicacionController@search_info_site_idubicacion');

		Route::post('cont_create_newidubic', 'Contracts\IdUbicacionController@cont_create_newidubic');
		Route::post('cont_edit_idubic', 'Contracts\IdUbicacionController@cont_edit_idubic');
    //Crear Contrato
    Route::get('cont_create_cont', 'Contracts\ContratoController@index_add');
    Route::post('/count_hotel_by_cadena', 'Contracts\ContratoController@count_hotel_by_cadena');
    Route::post('/count_cont_by_cadena', 'Contracts\ContratoController@count_cont_by_cadena');
    Route::post('getcoinname', 'Contracts\ContratoController@getcoinname');
    Route::post('/get_bankdata_zipcode', 'Contracts\ContratoController@get_bankdata_zipcode');
    Route::post('/idproy_search_by_cadena', 'Contracts\ContratoController@idproy_search_by_cadena');
    Route::post('/search_n_master_cadena', 'Contracts\ContratoController@search_n_master_cadena');
    Route::post('/search_idubicacion', 'Contracts\ContratoController@search_idubicacion');
    //Crear cadena
		Route::post('/create_group_by_contract', 'Contracts\ContratoController@create_group_by_contract');
		Route::post('/find_cadena_by_contract', 'Contracts\ContratoController@find_cadena_by_contract');
    //Crear Razon social de clientes
    Route::post('/find_rfc_by_contract', 'Contracts\ContratoController@find_rfc_by_contract');
    Route::post('/find_namerfc_by_contract', 'Contracts\ContratoController@find_namerfc_by_contract');
    Route::post('/create_rzcliente_by_contract', 'Contracts\ContratoController@create_rzcliente_by_contract');
    Route::post('/view_rzcliente_by_contract', 'Contracts\ContratoController@view_rzcliente_by_contract');
    //Crear Contrato Maestro
    Route::post('/create_contract_master', 'Contracts\ContratoController@create_contract_master');
    //Crear Anexo del Contrato Maestro
    Route::post('/count_anexo_by_cont_maestro', 'Contracts\ContratoController@count_anexo_by_cont_maestro');
    Route::post('/create_contract_annexes', 'Contracts\ContratoController@create_contract_annexes');
    //Editar contratos-contratos--------------------------------
    Route::get('cont_edit_cont', 'Contracts\ContratoController@index_edit');
    //Editar contratos maestros
    Route::post('get_digit_contract_master', 'Contracts\ContratoController@get_digit_contract_master');
    Route::post('get_data_contract_master', 'Contracts\ContratoController@get_data_contract_master');
    Route::post('get_data_rz_selected', 'Contracts\ContratoController@get_data_rz_selected');
    Route::post('update_contract_master', 'Contracts\ContratoController@update_contract_master');
    //Editar contratos key_anexo_sitio
    Route::post('get_ids_contract_anexo', 'Contracts\ContratoController@get_ids_contract_anexo');
    Route::post('get_ids_contract_anexo_v2', 'Contracts\ContratoController@get_ids_contract_anexo_v2');
    Route::post('get_data_anexos', 'Contracts\ContratoController@get_data_anexos');
    Route::post('get_data_master_anexo', 'Contracts\ContratoController@get_data_master_anexo');
    Route::post('update_contract_anexo', 'Contracts\ContratoController@update_contract_anexo');
    Route::post('getRfcSitesAnnexes', 'Contracts\ContratoController@getRfcSitesAnnexes');
    Route::post('getContractsPaymentsDataById', 'Contracts\ContratoController@getContractsPaymentsDataById');

    Route::post('/data_contractsite', 'Contracts\ContratoController@all_site_anexo');
    Route::post('/data_editcontractsite', 'Contracts\ContratoController@edit_site_anexo');
    Route::post('/addsiteanexocont', 'Contracts\ContratoController@add_site_anexo');
    Route::post('/delete_hotel_anexo', 'Contracts\ContratoController@delete_site_anexo');

    Route::post('/data_contractcoin', 'Contracts\ContratoController@all_coin_anexo');
    Route::post('/addcoinanexocont', 'Contracts\ContratoController@add_new_coin_anexo');
    Route::post('/delete_coin_anexo', 'Contracts\ContratoController@delete_coin_anexo');
    Route::post('/editcoinanexocont', 'Contracts\ContratoController@edit_coin_anexo');
    //Contratos
    Route::get('cont_filemanager', 'Contracts\CFilemanagerController@index');
    Route::post('find_fact_pend', 'Contracts\CFilemanagerController@find_fact_pend');
    Route::post('get_data_fact_by_drive', 'Contracts\CFilemanagerController@get_data_fact_by_drive');
    Route::post('add_fact_pend_by_drive', 'Contracts\CFilemanagerController@add_fact_pend_by_drive');
    //Vencimiento de contratos
    Route::get('/contract_expiration', 'Contracts\ContratoController@index_contract_expiration');
    Route::post('/contract_expiration_notvenue', 'Contracts\ContratoController@contract_expiration_notvenue');
    Route::post('/contract_expiration_venue', 'Contracts\ContratoController@contract_expiration_venue');
    Route::post('/contract_expiration_info', 'Contracts\ContratoController@contract_expiration_info');
    Route::post('/vigencia_contratos_12meses', 'Contracts\ContratoController@vigencia_contratos_12meses');
    Route::post('/vigencia_contratos_vencidos_12meses', 'Contracts\ContratoController@vigencia_contratos_vencidos_12meses');

    //Lista por facturar
    Route::get('/view_payauto', 'Contracts\PruebasController@index_pagos');
    Route::post('/recordmens', 'Contracts\PruebasController@record_a')->name('recordmens');
    Route::post('/recordmens_data', 'Contracts\PruebasController@creat_payauto');
    Route::post('/idproyanexo_search_by_cadena', 'Contracts\PruebasController@idproyanexo_search_by_cadena');
    Route::post('/createtc_gen', 'Contracts\PruebasController@creat_tc_general');
    Route::post('update_ivacxc','Contracts\PruebasController@create_iva_general');
    Route::post('/createf_compromise', 'Contracts\PruebasController@create_fc_payauto');
    Route::post('/send_dates_cxp', 'Contracts\PruebasController@create_fc_payauto_dt');
    Route::post('/delrecord_data', 'Contracts\PruebasController@delete_payauto');
    Route::post('/send_conceptsat', 'Contracts\PruebasController@upd_multiple_conceptsat');
    Route::post('/send_contracts_fact', 'Contracts\PruebasController@create_items_fact');
    Route::post('/upd_monthly', 'Contracts\PruebasController@update_monthly');
    Route::post('/upd_conceptsat', 'Contracts\PruebasController@upd_conceptsat');

    //Confirmación de cobro
    Route::get('/view_facturados', 'Contracts\ContractFactController@index');
    Route::post('/cxc_mont_fact_uniq', 'Contracts\ContractFactController@monto_fact');
    Route::post('/recordmens_fact_all', 'Contracts\ContractFactController@table_facts_all');
    Route::post('/send_contracts_confirm', 'Contracts\ContractFactController@create_items_confirm');
    Route::post('/cxc_mont_fact_uniq_all', 'Contracts\ContractFactController@monto_fact_all');
    Route::get('/view_facturados_cxc', 'Contracts\ContractFactController@index_cxc');
    Route::post('/recordmens_fact_all_cxc', 'Contracts\ContractFactController@table_facts_all_cxc');
    Route::post('/cxc_mont_fact_uniq_all_cxc', 'Contracts\ContractFactController@monto_fact_all_cxc');
    //Antigüedad CXC
    Route::get('/view_cobrados', 'Contracts\ContractCobController@index');
    Route::post('/cxc_mont_fact', 'Contracts\ContractCobController@monto_fact');
    Route::post('/cxc_mont_cob', 'Contracts\ContractCobController@monto_cob');
    Route::post('/recordmens_cobs_all', 'Contracts\ContractCobController@tabla_cobs_all');
    Route::post('/recordmens_cobs_date', 'Contracts\ContractCobController@tabla_cobs_date');

    // Encuestas hoteles
    Route::get('/view_dashboard_survey_nps','Survey\DashboardSurveyController@index');
    Route::post('/get_dashboard_survey','Survey\DashboardSurveyController@get_headers_survey');
    Route::post('/add_hotel_survey','Survey\DashboardSurveyController@create_hotel_survey');
    Route::post('/get_dashboard_surveydinamic','Survey\ResultsSurveyController@get_headers_graf');
    Route::post('/get_pregunta_abierta','Survey\ResultsSurveyController@pregunta_abierta');
    Route::post('/get_pregunta_multiple','Survey\ResultsSurveyController@pregunta_multiple');
    Route::post('/get_header_option','Survey\ResultsSurveyController@name_option');
    Route::get('/configure_survey_admin_nps','Survey\ConfigurationSurveyController@index');
    Route::post('/data_create_client_config', 'Survey\ConfigurationSurveyController@create_client_nps');
    Route::post('/creat_assign_surveyed', 'Survey\ConfigurationSurveyController@creat_assign_client_ht');
    Route::post('/show_assign_surveyed', 'Survey\ConfigurationSurveyController@show_assign_client_nps');
    Route::post('/delete_assign_surveyed', 'Survey\ConfigurationSurveyController@delete_assign_client_nps');
    Route::post('/data_delete_client_config', 'Survey\ConfigurationSurveyController@delete_client_nps');
    Route::post('/user_vertical' , 'Survey\ConfigurationSurveyController@show_nps');
    Route::post('/create_data_client', 'Survey\ConfigurationSurveyController@capture_individual');
    Route::post('/show_survey_table_month', 'Survey\ConfigurationSurveyController@show_table_resend');
    //Encuestas apartado interface
    Route::get('/configure_survey_admin_sit' , 'Survey\ConfigurationITController@index');
    Route::post('/configure_survey_admin_sit_show' , 'Survey\ConfigurationITController@show');
    Route::post('/send_survey_mail' , 'Survey\ConfigurationITController@send_surveyitc');
    Route::post('/search_hotel_u' , 'Survey\ConfigurationITController@search_hotel_user');
    //Post Survey_results.
    Route::post('/survey_viewresults' , 'Survey\ResultsSurveyController@result_survey');
    Route::post('/get_modal_comments' , 'Survey\ResultsSurveyController@comment_survey');
    Route::post('/add_survey_nps_manual' , 'Survey\SurveyAddController@store');
    Route::get('/configure_survey_admin' , 'Survey\ConfigurationSurveyController@index');
    Route::post('/assign_survey' , 'Survey\ConfigurationSurveyController@create');
    Route::get('/survey_results' , 'Survey\ResultsSurveyController@index');
    Route::get('/survey_results_client' , 'Survey\ResultsSurveyController@index2');
    Route::post('/survey_viewresults_modal' , 'Survey\ResultsSurveyController@survey_viewresults_modal');
    Route::post('/sent_survey_client' , 'Survey\ResultsSurveyController@sent_survey_client');
    Route::post('get_history_surveyresult_modal','Survey\ResultsSurveyController@get_history_surveyresult_modal');
    //Crear encuestas
    Route::get('/create_survey_admin' , 'Survey\CreateSurveyController@index');
    Route::post('/store_new_survey_admin' , 'Survey\CreateSurveyController@store');

    Route::get('dash_sabana', 'Sabanas\SabanaController@index');
    Route::post('informacionCliente', 'Sabanas\SabanaController@informacionCliente');
    Route::post('informacionCadena', 'Sabanas\SabanaController@informacionCadena');
    Route::post('get_all_contracts_by_hotel', 'Sabanas\SabanaController@get_all_contracts_by_hotel');
    Route::post('get_all_contracts_by_cadena', 'Sabanas\SabanaController@get_all_contracts_by_cadena');
    Route::post('get_all_annexes_by_master', 'Sabanas\SabanaController@get_all_annexes_by_master');
    Route::post('get_all_equipmentsbyhotel', 'Sabanas\SabanaController@get_table_equipments');
    Route::post('get_all_equipmentsbycadena', 'Sabanas\SabanaController@get_table_equipments_cadena');
    Route::post('get_nps_hotel', 'Sabanas\SabanaController@get_nps_hotel');
    Route::post('get_nps_cadena', 'Sabanas\SabanaController@get_nps_cadena');
    Route::post('get_nps_comment_hotel', 'Sabanas\SabanaController@get_nps_comment_hotel');
    Route::post('get_nps_comment_cadena', 'Sabanas\SabanaController@get_nps_comment_cadena');
    Route::post('get_graph_equipments','Sabanas\SabanaController@get_graph_equipments');
    Route::post('get_graph_equipments_cadena','Sabanas\SabanaController@get_graph_equipments_cadena');
    Route::post('get_budget_annual_hotel','Sabanas\SabanaController@get_budget_annual_hotel');
    Route::post('get_budget_annual_cadena','Sabanas\SabanaController@get_budget_annual_cadena');
    Route::post('get_payment_folios_gastos','Sabanas\SabanaController@get_payment_folios_gastos');
    Route::post('get_payment_folios_gastos_cadena','Sabanas\SabanaController@get_payment_folios_gastos_cadena');
    Route::post('get_viatics_gastos','Sabanas\SabanaController@get_viatics_gastos');
    Route::post('get_viatics_gastos_cadena','Sabanas\SabanaController@get_viatics_gastos_cadena');
    Route::post('get_tickets_by_hotel','Sabanas\SabanaController@get_tickets_by_hotel');
    Route::post('get_tickets_by_cadena','Sabanas\SabanaController@get_tickets_by_cadena');
    Route::post('get_ticketsxtipo_hotel','Sabanas\SabanaController@get_ticketsxtype_hotel');
    Route::post('get_ticketsxtipo_cadena','Sabanas\SabanaController@get_ticketsxtype_cadena');
    Route::post('get_ticketsxstatus_hotel','Sabanas\SabanaController@get_ticketsxstatus_hotel');
    Route::post('get_ticketsxstatus_cadena','Sabanas\SabanaController@get_ticketsxstatus_cadena');
    Route::post('get_graph_equipments_status','Sabanas\SabanaController@get_graph_equipments_status');
    Route::post('get_graph_equipments_status_cadena','Sabanas\SabanaController@get_graph_equipments_status_cadena');
    Route::post('sabana_modal_encuestas','Sabanas\SabanaController@sabana_modal_encuestas');
    Route::post('sabana_modal_encuestas_cadena','Sabanas\SabanaController@sabana_modal_encuestas_cadena');

    //SábanaITC
    Route::get('dash_sabana_itc', 'Sabanas\SabanaITController@index');
    Route::post('informacionITC', 'Sabanas\SabanaITController@informacionITC');
    Route::post('antenasITC', 'Sabanas\SabanaITController@antenasITC');
    Route::post('tabla_antenas_ITC', 'Sabanas\SabanaITController@tabla_antenas_ITC');
    Route::post('tabla_antenas_sitio', 'Sabanas\SabanaITController@tabla_antenas_sitio');
    Route::post('viaticos_x_mes', 'Sabanas\SabanaITController@viaticos_x_mes');
    Route::post('get_tickets_by_itc','Sabanas\SabanaITController@get_tickets_by_itc');
    Route::post('get_ticketsxtipo_itc','Sabanas\SabanaITController@get_ticketsxtype_itc');
    Route::post('get_ticketsxstatus_itc','Sabanas\SabanaITController@get_ticketsxstatus_itc');
    Route::post('get_viatics_gastos_itc','Sabanas\SabanaITController@get_viatics_gastos_itc');
    Route::post('get_projects_itc','Sabanas\SabanaITController@get_projects_itc');
    Route::post('get_graph_docx','Sabanas\SabanaITController@docs_x');
    Route::post('get_nps_itc', 'Sabanas\SabanaITController@get_nps_itc');
    Route::post('get_nps_itc_mensual', 'Sabanas\SabanaITController@get_nps_itc_mensual');
    Route::post('sabana_itc_modal_encuestas','Sabanas\SabanaITController@sabana_itc_modal_encuestas');
    Route::post('get_nps_comment_itc', 'Sabanas\SabanaITController@get_nps_comment_itc');
    Route::post('sabana_itc_modal_encuestas_hover', 'Sabanas\SabanaITController@sabana_itc_modal_encuestas_hover');
    Route::post('cl_diario_itc', 'Sabanas\SabanaITController@cl_diario_itc');
    Route::post('search_client_itc', 'Sabanas\SabanaITController@search_client_itc');
    Route::post('cl_inst_add', 'Sabanas\SabanaITController@ck_inst_add');
    Route::post('cl_5dia_itc', 'Sabanas\SabanaITController@cl_5dia_itc');
    Route::post('cl_20dia_itc', 'Sabanas\SabanaITController@cl_20dia_itc');
    //Sabana Directiva
    Route::get('dash_sabana_directiva', 'Sabanas\SabanaDirectivaController@index');
    Route::post('getAllCadena','Sabanas\SabanaDirectivaController@getAllCadena');
    Route::post('getAllSites','Sabanas\SabanaDirectivaController@getAllSites');
    Route::post('getAllDocM_Ejer', 'Sabanas\SabanaDirectivaController@getAllDocM_Ejer');
    Route::post('getAllCadenaBudget', 'Sabanas\SabanaDirectivaController@getAllCadenaBudget');
    Route::post('getBudgetSiteMonth', 'Sabanas\SabanaDirectivaController@getBudgetSiteMonth');

    //- Viaticos Dashboard General
    Route::get('/dashboard_viaticos_gen', 'Viatics\DashboardViaticController@index_gen');
    Route::post('/search_info_gen', 'Viatics\DashboardViaticController@info_gen');
    Route::post('/search_info_gen_solicitud', 'Viatics\DashboardViaticController@info_gen_sol');
    Route::post('/search_info_gen_montos', 'Viatics\DashboardViaticController@info_gen_montos');

    Route::post('/create_rza_by_contract', 'Contracts\ContratoController@create_rza_by_contract');
    Route::post('/reset_rza_by_contract', 'Contracts\ContratoController@reset_rza_by_contract');
    Route::post('/search_client_contract', 'Contracts\ContratoController@search_client_contract');
    Route::get('/qualification_itc', 'QualificationItcController@index');
    //Comisiones
    Route::post('/search_politica', 'Contracts\ContratoController@search_politica');
    Route::post('/totalLinesContact', 'Contracts\ContratoController@totalLinesContact');
    Route::post('/totalLinesCierre', 'Contracts\ContratoController@totalLinesCierre');
    Route::post('/totalLinesVendedor', 'Contracts\ContratoController@totalLinesVendedor');
    Route::post('/totalLinesColaborador', 'Contracts\ContratoController@totalLinesColaborador');

    Route::post('/info_kickoff', 'Contracts\ContratoController@info_kickoff');
    Route::post('/info_kickoff_comision', 'Contracts\ContratoController@info_kickoff_comision');
    Route::post('/info_kickoff_cierre', 'Contracts\ContratoController@info_kickoff_cierre');
    Route::post('/info_kickoff_contact', 'Contracts\ContratoController@info_kickoff_contact');

    Route::post('get_commission_anexo', 'Contracts\ContratoController@get_commission_anexo');
    Route::post('get_contact_commission_anexo', 'Contracts\ContratoController@get_contact_anexo');
    Route::post('get_cierre_commission_anexo', 'Contracts\ContratoController@get_cierre_anexo');

    //NodeJS Views
    Route::get('/site_view', 'Sockets\SiteController@index');
    Route::post('/savesite', 'Sockets\SiteController@savesite');

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
    Route::post('/taxes-integration_cc', 'Catalogs\TaxController@save_integration_cc_tax');
    Route::post('/get_integration_cc_tax', 'Catalogs\TaxController@get_integration_cc_tax');
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
    Route::post('/save_integration_cc_products', 'Catalogs\ProductController@save_integration_cc_products');
    Route::post('/get_cc_products', 'Catalogs\ProductController@get_cc_by_product');
    Route::post('/delete_cc_product', 'Catalogs\ProductController@delete_cc_product');

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

    //Facturacion
    Route::get('/customer-invoice-pdf/{id}', 'Sales\CustomerInvoiceController@generate_invoice');

    Route::get('/customer-invoice-pdfs/{id}', 'Sales\CustomerInvoiceController@generate_invoice_pdfs');
    Route::get('/customer-credit-notes-pdfs/{id}', 'Sales\CustomerInvoiceController@generate_ntc_pdf');

    Route::get('/customer-invoices', 'Sales\CustomerInvoiceController@index');
    Route::post('/customer-invoices-create', 'Sales\CustomerInvoiceController@create');
    Route::post('/customer-invoices-store', 'Sales\CustomerInvoiceController@store');
    Route::post('/customer-invoices-edit', 'Sales\CustomerInvoiceController@edit');
    Route::post('/customer-invoices-sendmail-fact', 'Sales\CustomerInvoiceController@sendmail_facts_customers');
    //
    Route::post('/customer-invoices-store-cont', 'Sales\CustomerInvoiceController@store_cont');

    //
    Route::get('/products/get-product', 'Sales\CustomerInvoiceController@getproduct');
    Route::post('/customer-invoices/total-lines', 'Sales\CustomerInvoiceController@totallines');
    Route::post('/customer-invoices/currency_now', 'Sales\CustomerInvoiceController@get_currency');
    Route::get('/customers/get-customer', 'Sales\CustomerController@getCustomer')->name('customers/get-customer');
    Route::get('/view_contracts', 'Sales\CustomerInvoiceController@view_contracts');

    Route::get('/customer-invoices-cont', 'Sales\CustomerInvoiceController@index2');
    Route::post('/customer-invoices-cont-search', 'Sales\CustomerInvoiceController@search_cont');
    Route::post('/customer-data-annexes', 'Sales\CustomerInvoiceController@getDataContractAnnexes');
    Route::post('/customer-data-rzcustomer','Sales\CustomerInvoiceController@getrzcustomerid');

    //Notas de credito
    Route::get('/customer-credit-notes', 'Sales\CustomerCreditNoteController@index');
    Route::get('/credit-notes-history', 'Sales\CustomerCreditNoteController@view_egresos');
    Route::post('/credit-notes-search', 'Sales\CustomerCreditNoteController@search');
    Route::get('/customer-invoices/balances', 'Sales\CustomerInvoiceController@balances')->name('customer-invoices/balances');
    Route::post('customer-credit-notes/total-reconciled-lines', 'Sales\CustomerCreditNoteController@totalReconciledLines')->name('customer-credit-notes/total-reconciled-lines');

    Route::post('/customer-credit-notes/total-lines', 'Sales\CustomerCreditNoteController@totalLines');
    Route::post('/customer-credit-notes-store', 'Sales\CustomerCreditNoteController@store');

    Route::get('customer-credit-notes/get-customer-credit-note', 'Sales\CustomerCreditNoteController@getCustomerCreditNote')->name('customer-credit-notes/get-customer-credit-note');
    Route::get('/customer-credit-notes-show', 'Sales\CustomerCreditNoteController@show');
    Route::post('/customer-credit-notes-searchfilter', 'Sales\CustomerCreditNoteController@searchfilter');
    Route::get('/customer-credit-notes/download-xml/{id}', 'Sales\CustomerCreditNoteController@downloadXml');
    Route::post('/customer-credit-notes/mark-sent', 'Sales\CustomerCreditNoteController@markSent');
    Route::post('/customer-credit-notes/mark-open', 'Sales\CustomerCreditNoteController@markOpen');
    Route::post('/customer-credit-notes/mark-reconciled', 'Sales\CustomerCreditNoteController@markReconciled');
    Route::post('/customer-credit-notes/modal-status-sat', 'Sales\CustomerCreditNoteController@modalStatusSat');
    Route::post('/customer-credit-notes/modal-send-mail', 'Sales\CustomerCreditNoteController@modalSendMail');
    Route::post('get_note_credit_mov_data_cfdi', 'Sales\CustomerCreditNoteController@get_note_credit_mov_data_cfdi');
    Route::post('get_note_credit_mov_data', 'Sales\CustomerCreditNoteController@get_note_credit_mov_data');
 // Route::post('/customer-credit-notes-sendmail-fact', 'Sales\CustomerInvoiceController@sendmail_notecredit_customers');
    //Notas de credito -cambio
    Route::post('/customer-credit-notes/destroy', 'Sales\CustomerCreditNoteController@destroy');
    Route::get('/customer-credit-notes/get-product', 'Sales\CustomerCreditNoteController@getproduct');
    Route::post('/customer-credit-notes/get-accounting-account-product', 'Sales\CustomerCreditNoteController@getAccountingAccountProduct');
    Route::post('/customer-credit-notes-sendmail-fact', 'Sales\CustomerInvoiceController@sendmail_notecredit_customers');
    Route::post('/customer-polizas-save-movs-egresos', 'Sales\CustomerCreditNoteController@save_poliza_movs');

    Route::get('/customer-invoices/autocomplete-cfdi', 'Sales\CustomerInvoiceController@autocompleteCfdi');
    Route::get('customer-invoices/get-customer-invoice', 'Sales\CustomerInvoiceController@getCustomerInvoice')->name('customer-invoices/get-customer-invoice');

    Route::get('customer-invoices-show', 'Sales\CustomerInvoiceController@show');
    Route::post('customer-invoices-search', 'Sales\CustomerInvoiceController@search');

    Route::post('/customer-invoices/mark-sent', 'Sales\CustomerInvoiceController@markSent');
    Route::post('/customer-invoices/mark-paid', 'Sales\CustomerInvoiceController@markPaid');
    Route::post('/customer-invoices/mark-open', 'Sales\CustomerInvoiceController@markOpen');
    Route::post('/customer-invoices/cancel-authorized', 'Sales\CustomerInvoiceController@cancelAuthorized');
    Route::post('/customer-invoices/cancel-rejected', 'Sales\CustomerInvoiceController@cancelRejected');

    Route::post('/customer-invoices/modal-payment-history-head', 'Sales\CustomerInvoiceController@modalPaymentHistoryhead');
    Route::post('/customer-invoices/modal-payment-history', 'Sales\CustomerInvoiceController@modalPaymentHistory');
    Route::post('/customer-invoices/modal-status-sat', 'Sales\CustomerInvoiceController@modalStatusSat');
    Route::post('/customer-invoices/modal-cancel', 'Sales\CustomerInvoiceController@modalCancel');
    Route::post('/customer-invoices/destroy', 'Sales\CustomerInvoiceController@destroy');
    Route::get('/customer-invoices/download-xml/{id}', 'Sales\CustomerInvoiceController@downloadXml');
    Route::post('/customer-invoices/modal-send-mail', 'Sales\CustomerInvoiceController@modalSendMail');
    Route::get('/customer-invoices/test', 'Sales\CustomerInvoiceController@verfact');
    Route::get('/reset_t', 'Sales\CustomerInvoiceController@store_reset');

    Route::post('/search_view_contracts', 'Sales\CustomerInvoiceController@search_view_contracts');
    Route::post('/view_contracts_info', 'Sales\CustomerInvoiceController@view_contracts_info');
    Route::post('/search_currency_contract', 'Sales\CustomerInvoiceController@search_currency_contract');
    Route::post('/view_contracts_create', 'Sales\CustomerInvoiceController@view_contracts_create');
    Route::post('/set_cliente_contrato', 'Sales\CustomerInvoiceController@set_cliente_contrato');

    //Complementos de pago
    Route::get('/customer-invoices-complement', 'Sales\CustomerComplementController@complement');
    Route::post('/get_data_complements', 'Sales\CustomerComplementController@get_complement');
    Route::post('/store_complement', 'Sales\CustomerComplementController@store_complement');

    //Cuentas bancarias Clientes
    Route::get('/customer-banks', 'Sales\CustomerBanksController@index');
    Route::post('/load-data-customer', 'Sales\CustomerBanksController@load_data_customer');
    Route::post('/edit_data_customer', 'Sales\CustomerBanksController@edit_data_customer');

    Route::get('/cz', 'Sales\CustomerInvoiceController@tes');

    //Complemento de pagos
    //Crear complemento
    Route::get('customer-payments', 'Sales\CustomerPaymentController@index');
    Route::get('customer-payments/autocomplete-cfdi', 'Sales\CustomerPaymentController@autocompleteCfdi');
    Route::get('customer-payments/get-customer-payment', 'Sales\CustomerPaymentController@getCustomerPayment');
    Route::get('/customer-payments/balances', 'Sales\CustomerPaymentController@balances');//Buscar las facturas
    Route::post('customer-payments/total-reconciled-lines', 'Sales\CustomerPaymentController@totalReconciledLines');
    Route::post('customer-payments/customer-payments-store', 'Sales\CustomerPaymentController@store');

    Route::post('/customer-payments/check_currency_bank', 'Sales\CustomerPaymentController@check_currency_bank');
    Route::post('/customer-payments/get_cuentaOrdenante', 'Sales\CustomerPaymentController@getCuentasOrdenantes');

    //Historial de los complemento
    Route::get('customer-payments-show', 'Sales\CustomerPaymentController@show');
    Route::post('customer-payments-search', 'Sales\CustomerPaymentController@search');
    Route::post('customer-payments/mark-sent', 'Sales\CustomerPaymentController@markSent');
    Route::post('customer-payments/mark-open', 'Sales\CustomerPaymentController@markOpen');
    Route::post('customer-payments/mark-reconciled', 'Sales\CustomerPaymentController@markReconciled');
    Route::post('customer-payments/modal-status-sat', 'Sales\CustomerPaymentController@modalStatusSat');
    Route::post('customer-payments/modal-cancel', 'Sales\CustomerPaymentController@modalCancel');
    Route::post('customer-payments/modal-send-mail', 'Sales\CustomerPaymentController@modalSendMail');
    Route::post('/customer-payments-sendmail-fact', 'Sales\CustomerPaymentController@sendmail_facts_customers');
    Route::post('customer-payments/destroy', 'Sales\CustomerPaymentController@destroy');
    Route::get('/customer-payments/download-xml/{id}', 'Sales\CustomerPaymentController@downloadXml');
    Route::get('/customer-payments-pdf/{id}', 'Sales\CustomerPaymentController@generatePdf');
    Route::post('/customer-invoices/send_invoice_to_poliza', 'Sales\CustomerInvoiceController@send_invoice_to_poliza');

    Route::post('/customer-invoices-cont-rz', 'Sales\CustomerInvoiceController@getDataContractRz');
    Route::get('customers/get-customer-bank-accounts', 'Sales\CustomerController@getCustomerBankAccounts')->name('customers/get-customer-bank-accounts');
    Route::post('customer-payments/total-item-manual-reconciled', 'Sales\CustomerPaymentController@totalItemManualReconciled')->name('customer-payments/total-item-manual-reconciled');
    Route::get('customer-payments-show', 'Sales\CustomerPaymentController@show');
    Route::post('customer-payments-poliza-movs', 'Sales\CustomerPaymentController@get_facts_mov_data');
    Route::post('customer-payments-poliza-save', 'Sales\CustomerPaymentController@save_poliza_ingreso_movs');
    Route::post('get_exchange_rate_by_date', 'Sales\CustomerPaymentController@get_exchange_rate_by_date');
});

Route::group(['prefix' => 'accounting', 'middleware' => 'auth'], function(){
   //Administrador Contabilidad
   Route::get('/view_accounting_configuration','Accounting\AccountingConfigurationController@index');
   Route::post('/get_periodo_actual','Accounting\AccountingConfigurationController@get_periodo_actual');
   // Contabilidad
   Route::get('/view_balance_accounting','Accounting\BalanceController@index');
   Route::get('/balance_general_pdf/{periodo}','Accounting\BalanceController@generate_balace_pdf');
   Route::post('/get_balance_by_month','Accounting\BalanceController@getBalanceByMonth');
   Route::post('/get_balance_data','Accounting\BalanceController@get_balance');
   Route::get('/view_balance_general_mayor','Accounting\BalanceController@view_balance_general_mayor');
   Route::get('/view_balance_general_filter','Accounting\BalanceController@view_balance_general_mayor_filter');
   Route::post('/get_balance_general_mayor_data','Accounting\BalanceController@get_balance_general_mayor');
   Route::post('/save_integration_cc_customer_provider','Sales\CustomerController@save_integration_cc_customer_provider');
   Route::post('/get_integration_cc_customer_provider','Sales\CustomerController@get_integration_cc_customer_provider');

   Route::get('/view_diario_general', 'Accounting\DiaryPoliceController@view_diary_general');
   Route::get('/view_diario_detalle', 'Accounting\DiaryPoliceController@view_diary_detail');
   Route::post('/get_diario_general', 'Accounting\DiaryPoliceController@get_diary_general_data');
   Route::post('/get_diario_detalle', 'Accounting\DiaryPoliceController@get_diary_detail_data');

  //POLIZAS
  Route::get('/view-create-polizas', 'Accounting\CustomerPolizaController@index');
  Route::post('/customer-polizas-create-movs', 'Accounting\CustomerPolizaController@create_poliza_without_invoice');
  Route::get('/customer-polizas-show', 'Accounting\CustomerPolizaController@show');
  Route::post('/customer-polizas-search', 'Accounting\CustomerPolizaController@search');
  Route::post('/customer-polizas-cancel', 'Accounting\CustomerPolizaController@cancel_poliza');
  Route::post('/customer-polizas-getdata', 'Accounting\CustomerPolizaController@get_data_poliza');
  Route::post('/customer-polizas-report', 'Accounting\CustomerPolizaController@get_report_poliza');
  Route::post('/customer-polizas-get-movs', 'Accounting\CustomerPolizaController@get_facts_mov_data');
  Route::post('/customer-polizas-save-movs', 'Accounting\CustomerPolizaController@save_poliza_movs');
  Route::post('/customer-polizas-delete', 'Accounting\CustomerPolizaController@delete_poliza');
  Route::post('/get-movs-by-poliza', 'Accounting\CustomerPolizaController@get_movtos_by_poliza');
  Route::post('/update-poliza-movs', 'Accounting\CustomerPolizaController@update_poliza_movs');
 //POLIZAS INGRESO
  Route::get('/view_poliza_ingresos', 'Accounting\CustomerPolizaController@view_poliza_ingreso');
  Route::post('/facturas_contabilizadas_data', 'Accounting\CustomerPolizaController@facturas_contabilizadas_data');
  //REPORTES FACTURACION Y CONTABILIDAD
  Route::get('/billing_report', 'Sales\BillingReportController@index');
  Route::post('/get_billing_report','Sales\BillingReportController@get_billing_report');
  Route::get('/estado_resultados', 'Accounting\EstadoResultadoController@index');
  Route::post('/estado_resultados_search', 'Accounting\EstadoResultadoController@estado_resultados_search');
  //CXC
  Route::get('/view_cxc_history', 'Accounting\CustomerPolizaController@view_cxc');
  Route::post('/cxc_data', 'Accounting\CustomerPolizaController@cxc_data');
  // Poliza de compras
  Route::get('/view_purchases_poliza', 'Purchases\HistoryPurchasesController@index_poliza');
  Route::post('/purchase_polizas_movs_save', 'Purchases\HistoryPurchasesController@purchase_polizas_movs_save');
  Route::post('/polizas_compras_search', 'Purchases\HistoryPurchasesController@search_poliza');
  Route::post('get_purchase_mov_data', 'Purchases\HistoryPurchasesController@get_purchase_mov_data');
  Route::get('/view_purchase_poliza_pay', 'Purchases\HistoryPurchasesController@index_poliza_pay');
  Route::post('/polizas_pay_search','Purchases\HistoryPurchasesController@search_poliza_pay');

  Route::post('/purchase_polizas_movs_save_pay', 'Purchases\HistoryPurchasesController@purchase_polizas_movs_save_pay');
  Route::post('get_purchase_mov_pay_data', 'Purchases\HistoryPurchasesController@get_purchase_mov_pay_data');
});

Route::group(['prefix' => 'purchases', 'middleware' => 'auth'], function(){
  // Compras
  Route::get('/purchases_view', 'Purchases\PurchasesController@index');
  Route::post('/get_exchangeratebydate', 'Purchases\PurchasesController@get_currency');
  Route::post('/purchase-store', 'Purchases\PurchasesController@store');
  Route::post('/total-lines-purchase', 'Purchases\PurchasesController@totallines');
  Route::post('/get_consecutivo','Purchases\PurchasesController@get_consecutivo');
  Route::post('/get_cart_products', 'Purchases\PurchasesController@get_products_cartid');

  //Historial de compras
  Route::get('/view_purchases_show', 'Purchases\HistoryPurchasesController@index');
  Route::post('/view_purchases_search', 'Purchases\HistoryPurchasesController@search');
  Route::post('/modal_purchase', 'Purchases\HistoryPurchasesController@modal_purchase');
  Route::post('/modal_purchase_lines', 'Purchases\HistoryPurchasesController@modal_purchase_lines');

  Route::post('/send_purchase_one', 'Purchases\HistoryPurchasesController@approval_one');
  Route::post('/send_purchase_two', 'Purchases\HistoryPurchasesController@approval_two');
  Route::post('/deny_purchase', 'Purchases\HistoryPurchasesController@deny_purchase_act');

  Route::post('purchase_poliza/contador', 'Purchases\HistoryPurchasesController@GetNextContador');
  //Cuentas bancarias de proveedor
  Route::get('/view_cb_provider', 'Purchases\CbProviderController@index');

  //Cuentas por pagar
  Route::get('/view_account_to_pay', 'Purchases\AccountPayController@index');
  Route::post('/cxp_data','Purchases\AccountPayController@show');

  //Notas de credito - COMPRAS
  Route::get('/customer-credit-notes-cp', 'Purchases\CustomerCreditNoteController@index');
  //Filtra solo las compras de la misma moneda
  Route::get('/customer-credit-notes/balances', 'Purchases\CustomerCreditNoteController@balances');
  Route::post('customer-credit-notes/total-reconciled-lines', 'Purchases\CustomerCreditNoteController@totalReconciledLines');
  Route::get('customer-credit-notes/get-product', 'Purchases\CustomerCreditNoteController@getproduct');
  Route::post('/customer-credit-notes/get-accounting-account-product', 'Purchases\CustomerCreditNoteController@getAccountingAccountProduct');
  Route::post('/customer-credit-notes/total-lines', 'Purchases\CustomerCreditNoteController@totalLines');
  Route::post('/customer-credit-notes-cp-store', 'Purchases\CustomerCreditNoteController@store');

  //Historial de notas de credito
  Route::get('/credit-notes-history', 'Purchases\HistoryCreditNoteController@index');
  Route::post('/credit-notes-history-search', 'Purchases\HistoryCreditNoteController@search');
  Route::post('credit-notes-history/mark-sent', 'Purchases\HistoryCreditNoteController@markSent');
  Route::post('credit-notes-history/destroy', 'Purchases\HistoryCreditNoteController@destroy');
  Route::post('credit-notes-history/poliza', 'Purchases\HistoryCreditNoteController@poliza');
  Route::get('credit-notes-history/{id}', 'Purchases\HistoryCreditNoteController@generate_invoice_pdfs');
  Route::post('credit-notes-history/modal-send-mail', 'Purchases\HistoryCreditNoteController@modalSendMail');
  Route::post('credit-notes-history-sendmail', 'Purchases\HistoryCreditNoteController@sendmail_facts_customers');
  Route::post('/customer_polizas_movs_save', 'Purchases\HistoryCreditNoteController@customer_polizas_movs_save');
  //
  Route::post('get_note_cred_mov_data_dev_desc', 'Purchases\HistoryCreditNoteController@get_note_cred_mov_data_dev_desc');
  Route::post('get_note_cred_mov_data', 'Purchases\HistoryCreditNoteController@get_note_cred_mov_data');
  Route::post('credit-notes-history/contador', 'Purchases\HistoryCreditNoteController@GetNextContador');
  //Ordenes de compra
  Route::get('/view_purchase_order', 'Purchases\PurchaseOrderController@index');
  Route::get('/getProvidersFromProject/doc_id/{doc_id}', 'Purchases\PurchaseOrderController@getProvidersFromProject');
  Route::get('/getProductsFromProjectsByProvider/doc_id/{doc_id}/provider_id/{provider_id}', 'Purchases\PurchaseOrderController@getProductsFromProjectsByProvider');
  Route::post('/store-order', 'Purchases\PurchaseOrderController@store');
  Route::get('/view_history_order_purchases', 'Purchases\PurchaseOrderController@view_history_order_purchases');
  Route::post('/get-history-orders', 'Purchases\PurchaseOrderController@get_history_purchases_order');
  Route::post('/get-products-cart-order', 'Purchases\PurchaseOrderController@get_products_by_cart_order');
  Route::get('/print-order-purchase/{id_order_shop}/{id_cart}', 'Purchases\PurchaseOrderController@print_order_purchase');
  Route::post('/delete-order-purchase', 'Purchases\PurchaseOrderController@destroy');
  Route::post('/add-address-delivery', 'Purchases\PurchaseOrderController@add_address_delivery');
  Route::post('/set-status-order', 'Purchases\PurchaseOrderController@setStatusOrder');
});
Route::group(['prefix' => 'integration', 'middleware' => 'auth'], function(){
  //Integracion contable
  Route::get('/accounting_account', 'Integration\AccountingAccountController@index');
  Route::post('/accounting_account_create', 'Integration\AccountingAccountController@create');
  Route::post('/accounting_account_store', 'Integration\AccountingAccountController@store');
  Route::post('/accounting_account_show', 'Integration\AccountingAccountController@show');
  Route::post('/accounting_account_edit', 'Integration\AccountingAccountController@edit');
  Route::post('/accounting_account_open', 'Integration\AccountingAccountController@open');
  Route::post('/accounting_account_closed', 'Integration\AccountingAccountController@closed');

  Route::get('/rubros', 'Integration\RubrosController@index');
  Route::post('/rubros_create', 'Integration\RubrosController@create');
  Route::post('/rubros_store', 'Integration\RubrosController@store');
  Route::post('/rubros_show', 'Integration\RubrosController@show');
  Route::post('/rubros_edit', 'Integration\RubrosController@edit');

  Route::get('/grouping_code', 'Integration\GroupingCodeController@index');
  Route::post('/grouping_code_create', 'Integration\GroupingCodeController@create');
  Route::post('/grouping_code_store', 'Integration\GroupingCodeController@store');
  Route::post('/grouping_code_show', 'Integration\GroupingCodeController@show');
  Route::post('/grouping_code_edit', 'Integration\GroupingCodeController@edit');
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
      Route::get('/get-all-branch', 'Base\BranchOfficeController@getAllBranchOffice');
      Route::post('/branch-office-show', 'Base\BranchOfficeController@show');
      Route::post('/branch-office-store', 'Base\BranchOfficeController@store');
      Route::post('/branch-office-edit', 'Base\BranchOfficeController@edit');
      Route::post('/branch-office-update', 'Base\BranchOfficeController@update');
      Route::get('/state-country/{id}', function ($id) {
        $query = App\Models\Catalogs\State::where('country_id', '=', $id)->get();
        return $query;
      });
      Route::get('/cities-state/{id}', function ($id) {
        $query = App\Models\Catalogs\City::where('state_id', '=', $id)->get();
        return $query;
      });

});
