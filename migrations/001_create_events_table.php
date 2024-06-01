<?php

class CreateEventsTable
{
    public function up()
    {
        $config = require '../config/config.php';
        $db = new PDO(
            "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
            $config['db']['user'],
            $config['db']['password']
        );
        $db->exec("
            CREATE TABLE events (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;
        ");
    }

    public function down()
    {
        $config = require '../config/config.php';
        $db = new PDO(
            "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
            $config['db']['user'],
            $config['db']['password']
        );
        $db->exec("DROP TABLE events");
    }
}
?>