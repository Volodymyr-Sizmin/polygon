<?php

namespace App\Command;

use Carbon\Carbon;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class BackupDbCommand extends Command
{
    private const BACKUP_FOLDER = 'tools/database/backups';
    private const USER_NAME = 'api-user';
    private const USER_PASSWORD = 'api-user-password';
    private const DB_HOST = '10.10.14.22';
    private const DB_PORT = '3303';
    private const DATABASE_NAME = 'api';
    private const ARCHIVE_DAYS = 3;

    protected static $defaultName = 'backup:db';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->backupDbTask();
        $this->purgeOldBackups();

        return Command::SUCCESS;
    }

    private function backupDbTask(): void
    {
        $time = Carbon::now();
        $filename =
            self::BACKUP_FOLDER .
            '/backup-' .
            $time->toDateString() .
            '.sql';
        $backupCommandTemplate  = 'mysqldump --skip-lock-tables --column-statistics=0 --routines --disable-keys --extended-insert --no-tablespaces -u %s --password=%s --host=%s --port=%s %s>%s';

        $backupCommand = sprintf(
            $backupCommandTemplate,
            self::USER_NAME,
            self::USER_PASSWORD,
            self::DB_HOST,
            self::DB_PORT,
            self::DATABASE_NAME,
            $filename);

        exec($backupCommand);
    }

    private function purgeOldBackups(): void
    {
        $purgeCommandTemplate = 'find %s -mtime +%s -delete';
        $purgeCommand = sprintf(
            $purgeCommandTemplate,
            self::BACKUP_FOLDER,
            self::ARCHIVE_DAYS
        );

        exec($purgeCommand);
    }
}
