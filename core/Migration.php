<?php

class Migration
{
    protected $db;

    public function __construct()
    {
        $config = require '../config/config.php';
        $this->db = new PDO(
            "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
            $config['db']['user'],
            $config['db']['password']
        );
        $this->createMigrationsTable();
    }

    protected function createMigrationsTable()
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;
        ");
    }

    public function getExecutedMigrations()
    {
        $stmt = $this->db->query("SELECT migration FROM migrations");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function saveMigration($migration)
    {
        $stmt = $this->db->prepare("INSERT INTO migrations (migration) VALUES (:migration)");
        $stmt->execute(['migration' => $migration]);
    }

    public function migrate()
    {
        $executedMigrations = $this->getExecutedMigrations();
        $files = scandir('../migrations');

        $migrationsToRun = array_diff($files, $executedMigrations);

        foreach ($migrationsToRun as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }
            require_once "../migrations/$migration";
            $className = $this->convertFileNameToClassName($migration);
            $instance = new $className();
            $instance->up();
            $this->saveMigration($migration);
            echo "Migrated: $migration\n";
        }
    }
    private function convertFileNameToClassName($fileName)
    {
        $baseName = pathinfo($fileName, PATHINFO_FILENAME);
        $baseName = preg_replace('/^\d+_/', '', $baseName); 
        $className = str_replace('_', ' ', $baseName);
        $className = str_replace(' ', '', ucwords($className));
        return $className;
    }

    public function rollback()
    {
        $executedMigrations = $this->getExecutedMigrations();
        $lastMigration = end($executedMigrations);
        if ($lastMigration) {
            require_once "../migrations/$lastMigration";
            $className = $this->convertFileNameToClassName($lastMigration);
            $instance = new $className();
            $instance->down();
            $this->db->exec("DELETE FROM migrations WHERE migration = '$lastMigration'");
            echo "Rolled back: $lastMigration\n";
        }
    }
}
?>