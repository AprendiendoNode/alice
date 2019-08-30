<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class ticketsxhistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticket:agents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'insercion de agentes y tambien metricas.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    // llamar handle a la funcion que se quiera utilizar.
    //Nombre correcto de funcion: handle. /esta funcion mete metricas.
    public function insercionAgentes()
    {
        $urlmetric = "https://sitwifi.zendesk.com/api/v2/ticket_metrics.json";
        $response = $this->curlZen($urlmetric);

        if (empty($response)) {
            $this->info('cURL responded empty');
        }else{
            $next_page = $response->next_page;
            $regnum = count($response->ticket_metrics);
            //dd($next_page);
            DB::beginTransaction();
            while (!empty($next_page)) {
                for ($i=0; $i < $regnum; $i++) {
                    $this->info('Current Iteration: '. $i);

                    if (empty($response->ticket_metrics[$i]->reopens)) {
                        $reopens = "";
                    }else{
                        $reopens = $response->ticket_metrics[$i]->reopens;
                    }

                    if (empty($response->ticket_metrics[$i]->assignee_updated_at)) {
                        $assignee_updated_at = "";
                    }else{
                        $assignee_updated_at = $response->ticket_metrics[$i]->assignee_updated_at;
                    }

                    if (empty($response->ticket_metrics[$i]->requester_updated_at)) {
                        $requester_updated_at = "";
                    }else{
                        $requester_updated_at = $response->ticket_metrics[$i]->requester_updated_at;
                    }

                    if (empty($response->ticket_metrics[$i]->status_updated_at)) {
                        $status_updated_at = "";
                    }else{
                        $status_updated_at = $response->ticket_metrics[$i]->status_updated_at;
                    }

                    if (empty($response->ticket_metrics[$i]->initially_assigned_at)) {
                        $initially_assigned_at = "";
                    }else{
                        $initially_assigned_at = $response->ticket_metrics[$i]->initially_assigned_at;
                    }

                    if (empty($response->ticket_metrics[$i]->assigned_at)) {
                        $assigned_at = "";
                    }else{
                        $assigned_at = $response->ticket_metrics[$i]->assigned_at;
                    }

                    if (empty($response->ticket_metrics[$i]->solved_at)) {
                        $solved_at = "";
                    }else{
                        $solved_at = $response->ticket_metrics[$i]->solved_at;
                    }

                    if (empty($response->ticket_metrics[$i]->latest_comment_added_at)) {
                        $latest_comment_added_at = "";
                    }else{
                        $latest_comment_added_at = $response->ticket_metrics[$i]->latest_comment_added_at;
                    }

                    if (empty($response->ticket_metrics[$i]->reply_time_in_minutes->calendar)) {
                        $reply_time_in_minutes_calendar = "";
                    }else{
                        $reply_time_in_minutes_calendar = $response->ticket_metrics[$i]->reply_time_in_minutes->calendar;
                    }

                    if (empty($response->ticket_metrics[$i]->reply_time_in_minutes->business)) {
                        $reply_time_in_minutes_business = "";
                    }else{
                        $reply_time_in_minutes_business = $response->ticket_metrics[$i]->reply_time_in_minutes->business;
                    }
                                                         
                    if (empty($response->ticket_metrics[$i]->first_resolution_time_in_minutes->calendar)) {
                        $first_resolution_time_in_minutes_calendar = "";
                    }else{
                        $first_resolution_time_in_minutes_calendar = $response->ticket_metrics[$i]->first_resolution_time_in_minutes->calendar;
                    }

                    if (empty($response->ticket_metrics[$i]->first_resolution_time_in_minutes->business)) {
                        $first_resolution_time_in_minutes_business = "";
                    }else{
                        $first_resolution_time_in_minutes_business = $response->ticket_metrics[$i]->first_resolution_time_in_minutes->business;
                    }                    

                    if (empty($response->ticket_metrics[$i]->full_resolution_time_in_minutes->calendar)) {
                        $full_resolution_time_in_minutes_calendar = "";
                    }else{
                        $full_resolution_time_in_minutes_calendar = $response->ticket_metrics[$i]->full_resolution_time_in_minutes->calendar;
                    }

                    if (empty($response->ticket_metrics[$i]->full_resolution_time_in_minutes->business)) {
                        $full_resolution_time_in_minutes_business = "";
                    }else{
                        $full_resolution_time_in_minutes_business = $response->ticket_metrics[$i]->full_resolution_time_in_minutes->business;
                    }

                    if (empty($response->ticket_metrics[$i]->agent_wait_time_in_minutes->calendar)) {
                        $agent_wait_time_in_minutes_calendar = "";
                    }else{
                        $agent_wait_time_in_minutes_calendar = $response->ticket_metrics[$i]->agent_wait_time_in_minutes->calendar;
                    }

                    if (empty($response->ticket_metrics[$i]->agent_wait_time_in_minutes->business)) {
                        $agent_wait_time_in_minutes_business = "";
                    }else{
                        $agent_wait_time_in_minutes_business = $response->ticket_metrics[$i]->agent_wait_time_in_minutes->business;
                    }

                    if (empty($response->ticket_metrics[$i]->requester_wait_time_in_minutes->calendar)) {
                        $requester_wait_time_in_minutes_calendar = "";
                    }else{
                        $requester_wait_time_in_minutes_calendar = $response->ticket_metrics[$i]->requester_wait_time_in_minutes->calendar;
                    }

                    if (empty($response->ticket_metrics[$i]->requester_wait_time_in_minutes->business)) {
                        $requester_wait_time_in_minutes_business = "";
                    }else{
                        $requester_wait_time_in_minutes_business = $response->ticket_metrics[$i]->requester_wait_time_in_minutes->business;
                    }

                    if (empty($response->ticket_metrics[$i]->on_hold_time_in_minutes->calendar)) {
                        $on_hold_time_in_minutes_calendar = "";
                    }else{
                        $on_hold_time_in_minutes_calendar = $response->ticket_metrics[$i]->on_hold_time_in_minutes->calendar;
                    }

                    if (empty($response->ticket_metrics[$i]->on_hold_time_in_minutes->business)) {
                        $on_hold_time_in_minutes_business = "";
                    }else{
                        $on_hold_time_in_minutes_business = $response->ticket_metrics[$i]->on_hold_time_in_minutes->business;
                    }
                    
                    $varid = $response->ticket_metrics[$i]->id;
                    $this->info('Current Iteration ID: ' . $varid);

                    DB::connection('zendesk')->table('metricas')->insert([
                        [
                            'url' => $response->ticket_metrics[$i]->url,
                            'id_tickets_metric' => $varid,
                            'ticket_id' => $response->ticket_metrics[$i]->ticket_id,
                            'created_at' => $response->ticket_metrics[$i]->created_at,
                            'updated_at' => $response->ticket_metrics[$i]->updated_at,
                            'group_stations' => $response->ticket_metrics[$i]->group_stations,
                            'assignee_stations' => $response->ticket_metrics[$i]->assignee_stations,
                            'reopens' => $reopens,
                            'replies' => $response->ticket_metrics[$i]->replies,
                            'assignee_updated_at' => $assignee_updated_at,
                            'requester_updated_at' => $requester_updated_at,
                            'status_updated_at' => $status_updated_at,
                            'initially_assigned_at' => $initially_assigned_at,
                            'assigned_at' => $assigned_at,
                            'solved_at' => $solved_at,
                            'latest_comment_added_at' => $latest_comment_added_at,
                            'reply_time_in_minutes_calendar' => $reply_time_in_minutes_calendar,
                            'reply_time_in_minutes_business' => $reply_time_in_minutes_business,
                            'first_resolution_time_in_minutes_calendar' => $first_resolution_time_in_minutes_calendar,
                            'first_resolution_time_in_minutes_business' => $first_resolution_time_in_minutes_business,
                            'full_resolution_time_in_minutes_calendar' => $full_resolution_time_in_minutes_calendar,
                            'full_resolution_time_in_minutes_business' => $full_resolution_time_in_minutes_business,
                            'agent_wait_time_in_minutes_calendar' => $agent_wait_time_in_minutes_calendar,
                            'agent_wait_time_in_minutes_business' => $agent_wait_time_in_minutes_business,
                            'requester_wait_time_in_minutes_calendar' => $requester_wait_time_in_minutes_calendar,
                            'requester_wait_time_in_minutes_business' => $requester_wait_time_in_minutes_business,
                            'on_hold_time_in_minutes_calendar' => $on_hold_time_in_minutes_calendar,
                            'on_hold_time_in_minutes_business' => $on_hold_time_in_minutes_business,
                        ]
                    ]);
                }
                $response = $this->curlZen($next_page);
                $next_page = $response->next_page;
                $this->info('Current cURL Page: ' . $next_page);
                DB::commit();   
            }
            
            $this->info('Metrics Inserted Correctly');
        }
        $this->info('Terminated Command.');
    }
    //Nombre correcto de funcion: insercionAgentes /esta funcion mete agentes.
    public function handle()
    {
        //$url = "https://sitwifi.zendesk.com/api/v2/search.json?query=created>2012-12-26&sort_by=created_at&sort_order=asc";
        $url2 = "https://sitwifi.zendesk.com/api/v2/users.json";
        $response = $this->curlZen($url2);

        if (empty($response)) {
            $this->info('cURL responded empty');
        }else{
            $count = $response->count;
            $next_page = $response->next_page;
            $regnum = count($response->users);
            //dd($next_page);
            DB::beginTransaction();
            while (!empty($regnum)) {
                for ($i=0; $i < $regnum; $i++) {
                    if (empty($response->users[$i]->id)) {
                        $id_user = "";
                    }else{
                        $id_user = $response->users[$i]->id;
                    }
                    if (empty($response->users[$i]->phone)) {
                        $phone = "";
                    }else{
                        $phone = $response->users[$i]->phone;
                    }
                    if (empty($response->users[$i]->shared_phone_number)) {
                        $shared_phone_number = "";
                    }else{
                        $shared_phone_number = $response->users[$i]->shared_phone_number;
                    }
                    $checkagent = DB::connection('zendesk')->table('agentes')->where('id_user', $id_user)->first();
                    if(empty($checkagent)) {
                        DB::connection('zendesk')->table('agentes')->insert([
                            [
                                'id_user' => $response->users[$i]->id,
                                'url' => $response->users[$i]->url,
                                'name' => $response->users[$i]->name,
                                'email' => $response->users[$i]->email,
                                'created_at' => $response->users[$i]->created_at,
                                'updated_at' => $response->users[$i]->updated_at,
                                'time_zone' => $response->users[$i]->time_zone,
                                'phone' => $phone,
                                'shared_phone_number' => $shared_phone_number,
                                'role' => $response->users[$i]->role,
                                'verified' => $response->users[$i]->verified,
                                'active' => $response->users[$i]->active,

                            ]
                        ]);
                        $this->info('Agent Inserted Correctly ' . 'id: '. $id_user . ' row: ' . $i);
                    }else{
                        DB::connection('zendesk')->table('agentes')->where('id_user', $id_user)->update([                            
                            'name' => $response->users[$i]->name,
                            'email' => $response->users[$i]->email,
                            'created_at' => $response->users[$i]->created_at,
                            'updated_at' => $response->users[$i]->updated_at,
                            'time_zone' => $response->users[$i]->time_zone,
                            'phone' => $phone,
                            'shared_phone_number' => $shared_phone_number,
                            'role' => $response->users[$i]->role,
                            'verified' => $response->users[$i]->verified,
                            'active' => $response->users[$i]->active,
                        ]);
                        $this->info('Agent updated Correctly'  . ' id: '. $id_user . ' row: ' . $i);
                    }
                }
                $response = $this->curlZen($next_page);

                if (empty($response->next_page)) {
                    $next_page = NULL;
                }else{
                    $next_page = $response->next_page;
                }
                if (empty($response->users)) {
                    $regnum = NULL;
                }else{
                    $regnum = count($response->users);
                }


                $this->info('Current cURL Page: ' . $next_page);
                DB::commit();
            }

        }
        $this->info('Terminated Command.');
    }

    public function curlZen($url)
    {
        $ch = curl_init();
        //echo "Inicializa la funcion .. ";
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false );
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, "jesquinca@sitwifi.com/token:f4qs3fDR9b9J635IcP6Ce5cGXxKx32ewexk3qmvz");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");

        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        //echo ".. Termina la funcion ..";
        $output = curl_exec($ch);

        $curlerr = curl_error($ch);
        $curlerrno = curl_errno($ch);

        if ($curlerrno != 0) {
            // Retornar un num de error
            return 0;
        }
        curl_close($ch);
        $decoded = json_decode($output);
        $this->info('cURL Successful...');
        return $decoded;
    }
}
