<?php

namespace Bits\MmShopBundle\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\DBAL\Connection;

class InstallMmShop extends AbstractMigration
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getName(): string
    {
        return 'MM Shop: Install MetaModels-Tables and MM Shop Tables';
    }

    public function run(): MigrationResult
    {
        
        $filesystem = new Filesystem();

        $sqlFiles = [ __DIR__ . '/Migration/Sql/metamodels.sql'
        , __DIR__ . '/Migration/Sql/mm_shop_1.sql'
        , __DIR__ . '/Migration/Sql/mm_shop_2.sql'];
        
        foreach($sqlFiles as $sqlFile){
            if ($filesystem->exists($sqlFile)) {
                $sql = file_get_contents($sqlFile);
                $statements = array_filter(array_map('trim', explode(';', $sql)));

                foreach ($statements as $statement) {
                    if ($statement !== '') {
                        $this->connection->execute($statement);
                    }
                }
                
            }
        }
     

        return $this->createResult(true, "Tabellen erstellt und Inhalte migriert.");
    }

    private function tableExists(string $table): bool
    {
        $schemaManager = method_exists($this->connection, 'createSchemaManager')
            ? $this->connection->createSchemaManager()
            : $this->connection->getSchemaManager();

        return $schemaManager->tablesExist([$table]);
    }

    public function shouldRun(): bool
    {
        $run = false;
        if(!$this->tableExists('mm_shop')){
                 $run = true;
        }
        
        return $run;
    }
}
