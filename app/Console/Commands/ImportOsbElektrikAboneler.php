<?php

namespace App\Console\Commands;

use App\Services\Import\HizliTeknoloji\ImportMukellefler;
use App\Services\Import\Osb\ImportElektrikAboneNo;
use Illuminate\Console\Command;
use League\Csv\Exception;

class ImportOsbElektrikAboneler extends Command
{
    const ARGUMENT_FILE_PATH    = 'filePath';
    const OPTION_DELIMITER      = 'delimiter';
    const OPTION_HEADER_OFFSET  = 'headerOffset';


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:osb-elektrik-aboneler'
                            . ' {' . self::ARGUMENT_FILE_PATH . '}'
                            . ' {--' . self::OPTION_DELIMITER . '=}'
                            . ' {--' . self::OPTION_HEADER_OFFSET . '=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports the aboneler from osb csv file';

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
     * @throws Exception
     */
    public function handle()
    {
        /** @var ImportMukellefler $importService */
        $importService = app(ImportElektrikAboneNo::class);

        $this->info('İçe aktarma işlemi başlatılıyor');

        $importService->import(
            $this->argument(self::ARGUMENT_FILE_PATH),
            $this->option(self::OPTION_DELIMITER),
            $this->option(self::OPTION_HEADER_OFFSET)
        );

        $this->info('İçe aktarma işlemi tamamlandı');

        return 0;
    }
}
