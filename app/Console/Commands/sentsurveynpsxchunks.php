<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class sentsurveynpsxchunks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'survey:chunks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando que ejecuta el envio de encuestas por partes.';

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
        $sql = DB::select('CALL List_User_NPS(?)', array(6));
        $chunks = array_chunk($sql, 70);

        $this->info('Begin chunk 1');
        $this->call('survey:nps1', ['result' => $chunks[0]]);
        $this->info('Command Chunk 1 completed.');
        usleep(30000000);
        $this->info('Begin chunk 2');
        $this->call('survey:nps1', ['result' => $chunks[1]]);
        $this->info('Command Chunk 2 completed.');
        usleep(30000000);
        $this->info('Begin chunk 3');
        $this->call('survey:nps1', ['result' => $chunks[2]]);
        $this->info('Command Chunk 3 completed.');
        $this->info('Finished');
    }
}
