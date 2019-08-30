<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

class ticketxmonthly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticket:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busqueda de tickets, actualiza y registra nuevos tickets del mes.';

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
    public function handle()
    {   
        $url_test = "https://sitwifi.zendesk.com/api/v2/tickets.json?page=10";
        $url = "https://sitwifi.zendesk.com/api/v2/tickets.json";
        $response = $this->curlZen($url_test);

        $metric_history = "https://sitwifi.zendesk.com/api/v2/tickets/";
        $apijson = "/metrics.json";

        if (empty($response)) {
            $this->error('cURL responded empty');
            
        }else{
            $this->info('cURL successful.');
            $next_page = $response->next_page;
            $regnum = count($response->tickets);
            DB::beginTransaction();

            while (!empty($regnum)) {
                for ($i=0; $i < $regnum; $i++) { 
                    $this->line('Current Iteration: '. $i);
                    if (empty($response->tickets[$i]->via->channel)) {
                        $channel = "";
                    }else{
                        $channel = $response->tickets[$i]->via->channel;
                    }
                    
                    
                    if (empty($response->tickets[$i]->id)) {
                        $id_ticket = "";
                    }else{
                        $id_ticket = $response->tickets[$i]->id;
                    }

                    $tagcount = count($response->tickets[$i]->tags);
                    $tags = "";
                    $collaboratorcount = count($response->tickets[$i]->collaborator_ids);
                    $collaborator_ids = "";
                    $customcount = count($response->tickets[$i]->custom_fields);
                    $custom_fields = "";

                    for ($j=0; $j < $tagcount; $j++) { 
                        $tags = $tags . $response->tickets[$i]->tags[$j] . "&";
                    }

                    for ($k=0; $k < $collaboratorcount; $k++) { 
                        $collaborator_ids = $collaborator_ids . $response->tickets[$i]->collaborator_ids[$k] . "&";
                    }

                    for ($l=0; $l < $customcount; $l++) { 
                        $custom_fields = $custom_fields . $response->tickets[$i]->custom_fields[$l]->value . "&";
                    }

                    if (empty($response->tickets[$i]->via->source->from->address)) {
                        $viafromaddress = "";
                    }else{
                        $viafromaddress = $response->tickets[$i]->via->source->from->address;
                    }

                    if (empty($response->tickets[$i]->via->source->from->name)) {
                        $viafromname = "";
                    }else{
                        $viafromname = $response->tickets[$i]->via->source->from->name;
                    }

                    if (empty($response->tickets[$i]->via->source->to->name)) {
                        $viatoname = "";
                    }else{
                        $viatoname = $response->tickets[$i]->via->source->to->name;
                    }

                    if (empty($response->tickets[$i]->via->source->to->address)) {
                        $viatoaddress = "";
                    }else{
                        $viatoaddress = $response->tickets[$i]->via->source->to->address;
                    }

                    if (empty($response->tickets[$i]->external_id)) {
                        $external_id = "";
                    }else{
                        $external_id = $response->tickets[$i]->external_id;
                    }

                    if (empty($response->tickets[$i]->type)) {
                        $tipo = "";
                    }else{
                        $tipo = $response->tickets[$i]->type;
                    }

                    if (empty($response->tickets[$i]->status)) {
                        $status = "";
                    }else{
                        $status = $response->tickets[$i]->status;
                    }

                    if (empty($response->tickets[$i]->priority)) {
                        $priority = "";
                    }else{
                        $priority = $response->tickets[$i]->priority;
                    }

                    if (empty($response->tickets[$i]->recipient)) {
                        $recipient = "";
                    }else{
                        $recipient =$response->tickets[$i]->recipient;
                    }

                    if (empty($response->tickets[$i]->organization_id)) {
                        $organization_id = "";
                    }else{
                        $organization_id = $response->tickets[$i]->organization_id;
                    }

                    if (empty($response->tickets[$i]->forum_topic_id)) {
                        $forum_topic_id = "";
                    }else{
                        $forum_topic_id = $response->tickets[$i]->forum_topic_id;
                    }

                    if (empty($response->tickets[$i]->problem_id)) {
                        $problem_id = "";
                    }else{
                        $problem_id = $response->tickets[$i]->problem_id;
                    }

                    if (empty($response->tickets[$i]->due_at)) {
                        $due_at = "";
                    }else{
                        $due_at = $response->tickets[$i]->due_at;
                    }

                    if (empty($response->tickets[$i]->satisfaction_rating->score)) {
                        $score = "";
                    }else{
                        $score = $response->tickets[$i]->satisfaction_rating->score;
                    }
                                    

                    $tags = substr($tags, 0, -1);
                    $collaborator_ids = substr($collaborator_ids, 0, -1);
                    $custom_fields = substr($custom_fields, 0, -1);

                    $checkticket = DB::connection('zendesk')->table('tickets')->where('id_ticket', $id_ticket)->first();
                    //Check if ticket exists already in DB.
                    if (empty($checkticket)) {
                    //Insert new DB record.
                        if ($channel == "email") {
                            DB::connection('zendesk')->table('tickets')->insert([
                                [
                                    'id_ticket' => $id_ticket,
                                    'url' => $response->tickets[$i]->url,
                                    'external_id' => $external_id,
                                    'type' => $tipo,
                                    'subject' => $response->tickets[$i]->subject,
                                    'raw_subject' => $response->tickets[$i]->raw_subject,
                                    'description' => $response->tickets[$i]->description,
                                    'status' => $status,
                                    'priority' => $priority,
                                    'recipient' => $recipient,
                                    'requester_id' => $response->tickets[$i]->requester_id,
                                    'submitter_id' => $response->tickets[$i]->submitter_id,
                                    'assignee_id' => $response->tickets[$i]->assignee_id,
                                    'organization_id' => $organization_id,
                                    'group_id' => $response->tickets[$i]->group_id,

                                    'collaboraor_ids' => $collaborator_ids,

                                    'forum_topic_id' => $forum_topic_id,
                                    'problem_id' => $problem_id,
                                    'has_incidents' => $response->tickets[$i]->has_incidents,
                                    'due_at' => $due_at,

                                    'tags' => $tags,

                                    'via_channel' => $channel,
                                    'via_from_address' => $viafromaddress,
                                    'via_from_name' => $viafromname,
                                    'via_to_name' => $viatoname,
                                    'via_to_address' => $viatoaddress,

                                    'custom_fields' => $custom_fields,

                                    'satisfaction_rating' => $score,
                                    'created_at' => $response->tickets[$i]->created_at,
                                    'updated_at' => $response->tickets[$i]->updated_at,
                                    //'agentes_id_user' => $response->tickets[$i]->assignee_id,
                                ]
                            ]);
                            $this->line('New ticket record inserted, id_ticket: ' . $id_ticket);
                        }else{
                            DB::connection('zendesk')->table('tickets')->insert([
                                [
                                    'id_ticket' => $id_ticket,
                                    'url' => $response->tickets[$i]->url,
                                    'external_id' => $external_id,
                                    'type' => $tipo,
                                    'subject' => $response->tickets[$i]->subject,
                                    'raw_subject' => $response->tickets[$i]->raw_subject,
                                    'description' => $response->tickets[$i]->description,
                                    'status' => $status,
                                    'priority' => $priority,
                                    'recipient' => $recipient,
                                    'requester_id' => $response->tickets[$i]->requester_id,
                                    'submitter_id' => $response->tickets[$i]->submitter_id,
                                    'assignee_id' => $response->tickets[$i]->assignee_id,
                                    'organization_id' => $organization_id,
                                    'group_id' => $response->tickets[$i]->group_id,

                                    'collaboraor_ids' => $collaborator_ids,

                                    'forum_topic_id' => $forum_topic_id,
                                    'problem_id' => $problem_id,
                                    'has_incidents' => $response->tickets[$i]->has_incidents,
                                    'due_at' => $due_at,

                                    'tags' => $tags,

                                    'via_channel' => $channel,

                                    'custom_fields' => $custom_fields,

                                    'satisfaction_rating' => $score,
                                    'created_at' => $response->tickets[$i]->created_at,
                                    'updated_at' => $response->tickets[$i]->updated_at,
                                    //'agentes_id_user' => $response->tickets[$i]->assignee_id,
                                ]
                            ]);
                            $this->line('New ticket record inserted, id_ticket: ' . $id_ticket);
                        }
                    }else{
                        //Update existing DB record.
                        if ($channel == "email") {
                            DB::connection('zendesk')->table('tickets')->where('id_ticket', $id_ticket)->update([
                                    'external_id' => $external_id,
                                    'type' => $tipo,
                                    'subject' => $response->tickets[$i]->subject,
                                    'raw_subject' => $response->tickets[$i]->raw_subject,
                                    'description' => $response->tickets[$i]->description,
                                    'status' => $status,
                                    'priority' => $priority,
                                    'recipient' => $recipient,
                                    'requester_id' => $response->tickets[$i]->requester_id,
                                    'submitter_id' => $response->tickets[$i]->submitter_id,
                                    'assignee_id' => $response->tickets[$i]->assignee_id,
                                    'organization_id' => $organization_id,
                                    'group_id' => $response->tickets[$i]->group_id,

                                    'collaboraor_ids' => $collaborator_ids,

                                    'forum_topic_id' => $forum_topic_id,
                                    'problem_id' => $problem_id,
                                    'has_incidents' => $response->tickets[$i]->has_incidents,
                                    'due_at' => $due_at,

                                    'tags' => $tags,

                                    'via_channel' => $channel,
                                    'via_from_address' => $viafromaddress,
                                    'via_from_name' => $viafromname,
                                    'via_to_name' => $viatoname,
                                    'via_to_address' => $viatoaddress,

                                    'custom_fields' => $custom_fields,

                                    'satisfaction_rating' => $score,
                                    'created_at' => $response->tickets[$i]->created_at,
                                    'updated_at' => $response->tickets[$i]->updated_at,
                                    //'agentes_id_user' => $response->tickets[$i]->assignee_id,
                            ]);
                            $this->line('Updated ticket record, id_ticket: ' . $id_ticket);
                        }else{
                            DB::connection('zendesk')->table('tickets')->where('id_ticket', $id_ticket)->update([
                                    'external_id' => $external_id,
                                    'type' => $tipo,
                                    'subject' => $response->tickets[$i]->subject,
                                    'raw_subject' => $response->tickets[$i]->raw_subject,
                                    'description' => $response->tickets[$i]->description,
                                    'status' => $status,
                                    'priority' => $priority,
                                    'recipient' => $recipient,
                                    'requester_id' => $response->tickets[$i]->requester_id,
                                    'submitter_id' => $response->tickets[$i]->submitter_id,
                                    'assignee_id' => $response->tickets[$i]->assignee_id,
                                    'organization_id' => $organization_id,
                                    'group_id' => $response->tickets[$i]->group_id,

                                    'collaboraor_ids' => $collaborator_ids,

                                    'forum_topic_id' => $forum_topic_id,
                                    'problem_id' => $problem_id,
                                    'has_incidents' => $response->tickets[$i]->has_incidents,
                                    'due_at' => $due_at,

                                    'tags' => $tags,

                                    'via_channel' => $channel,

                                    'custom_fields' => $custom_fields,

                                    'satisfaction_rating' => $score,
                                    'created_at' => $response->tickets[$i]->created_at,
                                    'updated_at' => $response->tickets[$i]->updated_at,
                                    //'agentes_id_user' => $response->tickets[$i]->assignee_id,
                            ]);
                            $this->line('Updated ticket record, id_ticket: ' . $id_ticket);
                        }
                    } //end else channel

                    //Insertion of current ticket metric.
                    $urlmetric = $metric_history . $id_ticket . $apijson;
                    $metricResponse = $this->curlZen($urlmetric);
                    $this->info('Metric URL: ' . $urlmetric);
                    if (empty($metricResponse)) {
                        $this->error('cURL(metric) responded empty');
                        continue;
                    }elseif (!empty($metricResponse->error)) {
                        $this->error('No Ticket Metric' . $metricResponse->error);
                        continue;
                    }else{
                        $id_metric = $metricResponse->ticket_metric->id;

                        if (empty($metricResponse->ticket_metric->reopens)) {
                            $reopens = "";
                        }else{
                            $reopens = $metricResponse->ticket_metric->reopens;
                        }

                        if (empty($metricResponse->ticket_metric->assignee_updated_at)) {
                            $assignee_updated_at = "";
                        }else{
                            $assignee_updated_at = $metricResponse->ticket_metric->assignee_updated_at;
                        }

                        if (empty($metricResponse->ticket_metric->requester_updated_at)) {
                            $requester_updated_at = "";
                        }else{
                            $requester_updated_at = $metricResponse->ticket_metric->requester_updated_at;
                        }

                        if (empty($metricResponse->ticket_metric->status_updated_at)) {
                            $status_updated_at = "";
                        }else{
                            $status_updated_at = $metricResponse->ticket_metric->status_updated_at;
                        }

                        if (empty($metricResponse->ticket_metric->initially_assigned_at)) {
                            $initially_assigned_at = "";
                        }else{
                            $initially_assigned_at = $metricResponse->ticket_metric->initially_assigned_at;
                        }

                        if (empty($metricResponse->ticket_metric->assigned_at)) {
                            $assigned_at = "";
                        }else{
                            $assigned_at = $metricResponse->ticket_metric->assigned_at;
                        }

                        if (empty($metricResponse->ticket_metric->solved_at)) {
                            $solved_at = "";
                        }else{
                            $solved_at = $metricResponse->ticket_metric->solved_at;
                        }

                        if (empty($metricResponse->ticket_metric->latest_comment_added_at)) {
                            $latest_comment_added_at = "";
                        }else{
                            $latest_comment_added_at = $metricResponse->ticket_metric->latest_comment_added_at;
                        }

                        if (empty($metricResponse->ticket_metric->reply_time_in_minutes->calendar)) {
                            $reply_time_in_minutes_calendar = "";
                        }else{
                            $reply_time_in_minutes_calendar = $metricResponse->ticket_metric->reply_time_in_minutes->calendar;
                        }

                        if (empty($metricResponse->ticket_metric->reply_time_in_minutes->business)) {
                            $reply_time_in_minutes_business = "";
                        }else{
                            $reply_time_in_minutes_business = $metricResponse->ticket_metric->reply_time_in_minutes->business;
                        }
                                                             
                        if (empty($metricResponse->ticket_metric->first_resolution_time_in_minutes->calendar)) {
                            $first_resolution_time_in_minutes_calendar = "";
                        }else{
                            $first_resolution_time_in_minutes_calendar = $metricResponse->ticket_metric->first_resolution_time_in_minutes->calendar;
                        }

                        if (empty($metricResponse->ticket_metric->first_resolution_time_in_minutes->business)) {
                            $first_resolution_time_in_minutes_business = "";
                        }else{
                            $first_resolution_time_in_minutes_business = $metricResponse->ticket_metric->first_resolution_time_in_minutes->business;
                        }                    

                        if (empty($metricResponse->ticket_metric->full_resolution_time_in_minutes->calendar)) {
                            $full_resolution_time_in_minutes_calendar = "";
                        }else{
                            $full_resolution_time_in_minutes_calendar = $metricResponse->ticket_metric->full_resolution_time_in_minutes->calendar;
                        }

                        if (empty($metricResponse->ticket_metric->full_resolution_time_in_minutes->business)) {
                            $full_resolution_time_in_minutes_business = "";
                        }else{
                            $full_resolution_time_in_minutes_business = $metricResponse->ticket_metric->full_resolution_time_in_minutes->business;
                        }

                        if (empty($metricResponse->ticket_metric->agent_wait_time_in_minutes->calendar)) {
                            $agent_wait_time_in_minutes_calendar = "";
                        }else{
                            $agent_wait_time_in_minutes_calendar = $metricResponse->ticket_metric->agent_wait_time_in_minutes->calendar;
                        }

                        if (empty($metricResponse->ticket_metric->agent_wait_time_in_minutes->business)) {
                            $agent_wait_time_in_minutes_business = "";
                        }else{
                            $agent_wait_time_in_minutes_business = $metricResponse->ticket_metric->agent_wait_time_in_minutes->business;
                        }

                        if (empty($metricResponse->ticket_metric->requester_wait_time_in_minutes->calendar)) {
                            $requester_wait_time_in_minutes_calendar = "";
                        }else{
                            $requester_wait_time_in_minutes_calendar = $metricResponse->ticket_metric->requester_wait_time_in_minutes->calendar;
                        }

                        if (empty($metricResponse->ticket_metric->requester_wait_time_in_minutes->business)) {
                            $requester_wait_time_in_minutes_business = "";
                        }else{
                            $requester_wait_time_in_minutes_business = $metricResponse->ticket_metric->requester_wait_time_in_minutes->business;
                        }

                        if (empty($metricResponse->ticket_metric->on_hold_time_in_minutes->calendar)) {
                            $on_hold_time_in_minutes_calendar = "";
                        }else{
                            $on_hold_time_in_minutes_calendar = $metricResponse->ticket_metric->on_hold_time_in_minutes->calendar;
                        }

                        if (empty($metricResponse->ticket_metric->on_hold_time_in_minutes->business)) {
                            $on_hold_time_in_minutes_business = "";
                        }else{
                            $on_hold_time_in_minutes_business = $metricResponse->ticket_metric->on_hold_time_in_minutes->business;
                        }

                        if (empty($metricResponse->ticket_metric->updated_at)) {
                            $updated_at = "";
                        }else{
                            $updated_at = $metricResponse->ticket_metric->updated_at;
                        }

                        if (empty($metricResponse->ticket_metric->group_stations)) {
                            $group_stations = "";
                        }else{
                            $group_stations = $metricResponse->ticket_metric->group_stations;
                        }

                        if (empty($metricResponse->ticket_metric->assignee_stations)) {
                            $assignee_stations = "";
                        }else{
                            $assignee_stations = $metricResponse->ticket_metric->assignee_stations;
                        }

                        if (empty($metricResponse->metricResponse->ticket_metric->replies)) {
                            $replies = "";
                        }else{
                            $replies = $metricResponse->ticket_metric->replies;
                        }

                        $check = DB::connection('zendesk')->table('metricas')->where('id_tickets_metric', $id_metric)->first();
                        if (empty($check)) {
                            // Metric does not exist, insert new record.
                            DB::connection('zendesk')->table('metricas')->insert([
                                [
                                    'url' => $metricResponse->ticket_metric->url,
                                    'id_tickets_metric' => $id_metric,
                                    'ticket_id' => $metricResponse->ticket_metric->ticket_id,
                                    'created_at' => $metricResponse->ticket_metric->created_at,
                                    'updated_at' => $metricResponse->ticket_metric->updated_at,
                                    'group_stations' => $metricResponse->ticket_metric->group_stations,
                                    'assignee_stations' => $metricResponse->ticket_metric->assignee_stations,
                                    'reopens' => $reopens,
                                    'replies' => $replies,
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
                                    'tickets_id_ticket' => $metricResponse->ticket_metric->ticket_id,
                                ]
                            ]);
                            $this->line('New metric record inserted, id_metric: ' . $id_metric . ' associated with id_ticket: ' . $id_ticket);
                            
                        }else{
                            // Metric exists, update record.
                            DB::connection('zendesk')->table('metricas')->where('id_tickets_metric', $id_metric)->update([
                                    'updated_at' => $updated_at,
                                    'group_stations' => $group_stations,
                                    'assignee_stations' => $assignee_stations,
                                    'reopens' => $reopens,
                                    'replies' => $replies,
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
                            ]);
                            $this->line('Updated metric record: ' . $id_metric . ' associated with id_ticket: ' . $id_ticket);
                            
                        }// end if check metric

                    } //end if metric response.

                } // end for.

                $response = $this->curlZen($next_page);
                if (empty($response->next_page)) {
                    $next_page = NULL;
                }else{
                    $next_page = $response->next_page;
                }
                if (empty($response->tickets)) {
                    $regnum = NULL;
                }else{
                    $regnum = count($response->tickets);
                }
                
                $this->info('Current cURL Page: ' . $next_page);
                $this->info('Number of tickets on request: ' . $regnum);
            } // end While
            DB::commit();
        }
        $this->info('Command ended successfuly.');
    }

    // Funcion cURL para consultas a la API de zendesk.
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
        return $decoded;
    }

    // Funcion para actualizar e insertar todos los registros historicos(metricas) de zendesk.

    public function historicMetric()
    {
        $metric_history = "https://sitwifi.zendesk.com/api/v2/tickets/";
        $apijson = "/metrics.json";
        //$response = $this->curlZen($history);
        // Empieza de cero
        $result = DB::connection('zendesk')->table('tickets')->pluck('id_ticket');
        //Para empezar en algun número determinado.
        // $result = DB::connection('zendesk')->table('tickets')->where('id_ticket', '>', 14742)->pluck('id_ticket');
        $resCount = count($result);

        DB::beginTransaction();

        for ($i=0; $i < $resCount; $i++) { 
            $url = $metric_history . $result[$i] . $apijson;
            $response = $this->curlZen($url);
            $this->info('Current Iteration and URL: ' . $i . ' & ' . $url);

            if (empty($response)) {
                $this->error('cURL responded empty');
                continue;
            }elseif (!empty($response->error)) {
                $this->error('No Ticket Metric' . $response->error);
                continue;
            }else{
                //$this->info();
                $id_metric = $response->ticket_metric->id;

                if (empty($response->ticket_metric->reopens)) {
                    $reopens = "";
                }else{
                    $reopens = $response->ticket_metric->reopens;
                }

                if (empty($response->ticket_metric->assignee_updated_at)) {
                    $assignee_updated_at = "";
                }else{
                    $assignee_updated_at = $response->ticket_metric->assignee_updated_at;
                }

                if (empty($response->ticket_metric->requester_updated_at)) {
                    $requester_updated_at = "";
                }else{
                    $requester_updated_at = $response->ticket_metric->requester_updated_at;
                }

                if (empty($response->ticket_metric->status_updated_at)) {
                    $status_updated_at = "";
                }else{
                    $status_updated_at = $response->ticket_metric->status_updated_at;
                }

                if (empty($response->ticket_metric->initially_assigned_at)) {
                    $initially_assigned_at = "";
                }else{
                    $initially_assigned_at = $response->ticket_metric->initially_assigned_at;
                }

                if (empty($response->ticket_metric->assigned_at)) {
                    $assigned_at = "";
                }else{
                    $assigned_at = $response->ticket_metric->assigned_at;
                }

                if (empty($response->ticket_metric->solved_at)) {
                    $solved_at = "";
                }else{
                    $solved_at = $response->ticket_metric->solved_at;
                }

                if (empty($response->ticket_metric->latest_comment_added_at)) {
                    $latest_comment_added_at = "";
                }else{
                    $latest_comment_added_at = $response->ticket_metric->latest_comment_added_at;
                }

                if (empty($response->ticket_metric->reply_time_in_minutes->calendar)) {
                    $reply_time_in_minutes_calendar = "";
                }else{
                    $reply_time_in_minutes_calendar = $response->ticket_metric->reply_time_in_minutes->calendar;
                }

                if (empty($response->ticket_metric->reply_time_in_minutes->business)) {
                    $reply_time_in_minutes_business = "";
                }else{
                    $reply_time_in_minutes_business = $response->ticket_metric->reply_time_in_minutes->business;
                }
                                                     
                if (empty($response->ticket_metric->first_resolution_time_in_minutes->calendar)) {
                    $first_resolution_time_in_minutes_calendar = "";
                }else{
                    $first_resolution_time_in_minutes_calendar = $response->ticket_metric->first_resolution_time_in_minutes->calendar;
                }

                if (empty($response->ticket_metric->first_resolution_time_in_minutes->business)) {
                    $first_resolution_time_in_minutes_business = "";
                }else{
                    $first_resolution_time_in_minutes_business = $response->ticket_metric->first_resolution_time_in_minutes->business;
                }                    

                if (empty($response->ticket_metric->full_resolution_time_in_minutes->calendar)) {
                    $full_resolution_time_in_minutes_calendar = "";
                }else{
                    $full_resolution_time_in_minutes_calendar = $response->ticket_metric->full_resolution_time_in_minutes->calendar;
                }

                if (empty($response->ticket_metric->full_resolution_time_in_minutes->business)) {
                    $full_resolution_time_in_minutes_business = "";
                }else{
                    $full_resolution_time_in_minutes_business = $response->ticket_metric->full_resolution_time_in_minutes->business;
                }

                if (empty($response->ticket_metric->agent_wait_time_in_minutes->calendar)) {
                    $agent_wait_time_in_minutes_calendar = "";
                }else{
                    $agent_wait_time_in_minutes_calendar = $response->ticket_metric->agent_wait_time_in_minutes->calendar;
                }

                if (empty($response->ticket_metric->agent_wait_time_in_minutes->business)) {
                    $agent_wait_time_in_minutes_business = "";
                }else{
                    $agent_wait_time_in_minutes_business = $response->ticket_metric->agent_wait_time_in_minutes->business;
                }

                if (empty($response->ticket_metric->requester_wait_time_in_minutes->calendar)) {
                    $requester_wait_time_in_minutes_calendar = "";
                }else{
                    $requester_wait_time_in_minutes_calendar = $response->ticket_metric->requester_wait_time_in_minutes->calendar;
                }

                if (empty($response->ticket_metric->requester_wait_time_in_minutes->business)) {
                    $requester_wait_time_in_minutes_business = "";
                }else{
                    $requester_wait_time_in_minutes_business = $response->ticket_metric->requester_wait_time_in_minutes->business;
                }

                if (empty($response->ticket_metric->on_hold_time_in_minutes->calendar)) {
                    $on_hold_time_in_minutes_calendar = "";
                }else{
                    $on_hold_time_in_minutes_calendar = $response->ticket_metric->on_hold_time_in_minutes->calendar;
                }

                if (empty($response->ticket_metric->on_hold_time_in_minutes->business)) {
                    $on_hold_time_in_minutes_business = "";
                }else{
                    $on_hold_time_in_minutes_business = $response->ticket_metric->on_hold_time_in_minutes->business;
                }

                if (empty($response->ticket_metric->updated_at)) {
                    $updated_at = "";
                }else{
                    $updated_at = $response->ticket_metric->updated_at;
                }

                if (empty($response->ticket_metric->group_stations)) {
                    $group_stations = "";
                }else{
                    $group_stations = $response->ticket_metric->group_stations;
                }

                if (empty($response->ticket_metric->assignee_stations)) {
                    $assignee_stations = "";
                }else{
                    $assignee_stations = $response->ticket_metric->assignee_stations;
                }

                if (empty($response->response->ticket_metric->replies)) {
                    $replies = "";
                }else{
                    $replies = $response->ticket_metric->replies;
                }

                $check = DB::connection('zendesk')->table('metricas')->where('id_tickets_metric', $id_metric)->first();

                if (empty($check)) {
                    //no existe proceder a insertar.

                    DB::connection('zendesk')->table('metricas')->insert([
                        [
                            'url' => $response->ticket_metric->url,
                            'id_tickets_metric' => $id_metric,
                            'ticket_id' => $response->ticket_metric->ticket_id,
                            'created_at' => $response->ticket_metric->created_at,
                            'updated_at' => $response->ticket_metric->updated_at,
                            'group_stations' => $response->ticket_metric->group_stations,
                            'assignee_stations' => $response->ticket_metric->assignee_stations,
                            'reopens' => $reopens,
                            'replies' => $replies,
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
                    $this->line('New record inserted, id_metric: ' . $id_metric);
                }else{
                    //si existe revisar si necesita actualizarse.
                    $this->line('Updated record: ' . $id_metric);



                    DB::connection('zendesk')->table('metricas')->where('id_tickets_metric', $id_metric)->update([
                        
                            'updated_at' => $updated_at,
                            'group_stations' => $group_stations,
                            'assignee_stations' => $assignee_stations,
                            'reopens' => $reopens,
                            'replies' => $replies,
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
                        
                    ]);
                    
                }
            }

        }
        DB::commit();
        $this->info('Command Completed.');
    }

}
