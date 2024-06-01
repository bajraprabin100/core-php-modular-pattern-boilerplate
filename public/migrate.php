<?php

require_once '../core/Migration.php';

$migration = new Migration();

$action = $argv[1] ?? null;

switch ($action) {
    case 'migrate':
        $migration->migrate();
        break;
    case 'rollback':
        $migration->rollback();
        break;
    default:
        echo "Unknown action: $action\n";
        echo "Available actions: migrate, rollback\n";
        break;
}
?>