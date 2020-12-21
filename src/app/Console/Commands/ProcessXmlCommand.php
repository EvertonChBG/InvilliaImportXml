<?php

namespace App\Console\Commands;

use App\Repositories\ImportXmlRepository;
use Illuminate\Console\Command;

class ProcessXmlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xml:processImport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Responsible for processing the import of xml files people and shiporders ';

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
     * @return int
     */
    public function handle()
    {
        try {
            $this->info('Starting search for files to import! ' . date('Y-m-d H:i:s'));

            // Retrieve only no processed files:
            $oImportsXmlAsync = new ImportXmlRepository();
            $oImportsXmlAsync->processFile();

            foreach (session()->get('errors') as $sErro) {
                $this->alert($sErro);
            }

            $iTimeExecution = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
            $this->info('Finished search for files to import! ' . date('Y-m-d H:i:s') .
                ' Time: '. $iTimeExecution);

        } catch (\Exception $oError) {
            $this->error($oError->getMessage());
        }
    }
}
