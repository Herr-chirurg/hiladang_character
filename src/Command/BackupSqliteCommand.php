<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Process\Process;

#[AsCommand(
    name: 'BackupSqlite',
    description: 'Add a short description for your command',
)]
class BackupSqliteCommand extends Command
{

    private $params;

    public function __construct(ParameterBagInterface $params)
    {

        $this->params  = $params;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dbPath = $this->params->get('kernel.project_dir') . '/var/data.db'; // Ajustez ce chemin
        $backupDir = $this->params->get('kernel.project_dir') . '/var/backup/'; // Créez ce dossier

        $dateTime = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
        $timestamp = $dateTime->format('Ymd_His');
        
        $backupPath = $backupDir . 'database_backup_' . $timestamp . '.sqlite';

        // Utilisation de la commande shell pour la copie
        $command = "cp $dbPath $backupPath";
        
        // Exécuter la commande (via le composant Process)
        $process = Process::fromShellCommandline($command);
        $process->run();

        if (!$process->isSuccessful()) {
            $output->writeln('<error>La sauvegarde SQLite a échoué.</error>');
            return Command::FAILURE;
        }

        $output->writeln('<info>Sauvegarde SQLite réussie : ' . $backupPath . '</info>');
        return Command::SUCCESS;
    }
}
