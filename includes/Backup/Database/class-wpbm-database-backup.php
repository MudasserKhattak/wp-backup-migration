<?php

namespace WPBM\includes\Backup\Database;

use PDO;

class WPBM_Backup_Database
{
    private $db;
    private $backup_dir;
    private $unique_prefix;
    private $chunk_size = 1000; // Number of rows per chunk
    private $backup_session_file;

    public function __construct($host, $username, $password, $database) {
        try {
            // Create a unique prefix for this backup session
            $this->unique_prefix = 'BACKUP_' . uniqid() . '_' . time();

            // Database connection
            $this->db = new PDO("mysql:host=$host;dbname=$database", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false
            ]);

            // Set backup directory
            $this->backup_dir = __DIR__ . '/backups/';
            if (!file_exists($this->backup_dir)) {
                mkdir($this->backup_dir, 0755, true);
            }

            // Create backup session tracking file
            $this->backup_session_file = $this->backup_dir . $this->unique_prefix . '_session.json';
        } catch(PDOException $e) {
            error_log("Connection failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function initiateBackup() {
        // Get all tables in the database
        $tables = $this->getAllTables();

        // Create backup session tracking data
        $backup_session = [
            'unique_prefix' => $this->unique_prefix,
            'total_tables' => count($tables),
            'current_table_index' => 0,
            'tables' => $tables,
            'completed_tables' => [],
            'backup_started_at' => time(),
            'status' => 'in_progress'
        ];

        // Save session data
        file_put_contents($this->backup_session_file, json_encode($backup_session));

        return [
            'unique_prefix' => $this->unique_prefix,
            'total_tables' => count($tables)
        ];
    }

    public function backupNextChunk() {
        // Read current backup session
        $backup_session = json_decode(file_get_contents($this->backup_session_file), true);

        // Check if backup is complete
        if ($backup_session['current_table_index'] >= count($backup_session['tables'])) {
            $backup_session['status'] = 'completed';
            file_put_contents($this->backup_session_file, json_encode($backup_session));
            return [
                'status' => 'completed',
                'message' => 'Backup process completed'
            ];
        }

        // Get current table
        $current_table = $backup_session['tables'][$backup_session['current_table_index']];

        // Create or append to backup file
        $backup_filename = $this->backup_dir . $this->unique_prefix . '_' . $current_table . '.txt';
        $file_mode = file_exists($backup_filename) ? 'a' : 'w';
        $file = fopen($backup_filename, $file_mode);

        // First time writing to this table's backup file
        if ($file_mode === 'w') {
            // Write table structure
            $create_table = $this->getTableStructure($current_table);
            fwrite($file, "TABLE_STRUCTURE_START\n");
            fwrite($file, $create_table . "\n");
            fwrite($file, "TABLE_STRUCTURE_END\n");

            // Write table name and initial metadata
            fwrite($file, "TABLE: $current_table\n");
        }

        // Backup data in chunks
        $offset = $backup_session['completed_tables'][$current_table] ?? 0;
        $data = $this->getTableDataChunk($current_table, $offset, $this->chunk_size);

        // Write data chunk
        if (!empty($data)) {
            fwrite($file, "DATA_CHUNK_START\n");
            foreach ($data as $row) {
                fwrite($file, json_encode($row) . "\n");
            }
            fwrite($file, "DATA_CHUNK_END\n");
        }

        fclose($file);

        // Update backup session
        $new_offset = $offset + count($data);
        $backup_session['completed_tables'][$current_table] = $new_offset;

        // Move to next table if chunk is smaller than chunk_size
        if (count($data) < $this->chunk_size) {
            $backup_session['current_table_index']++;
            unset($backup_session['completed_tables'][$current_table]);
        }

        // Save updated session
        file_put_contents($this->backup_session_file, json_encode($backup_session));

        return [
            'status' => 'in_progress',
            'table' => $current_table,
            'rows_processed' => $new_offset,
            'unique_prefix' => $this->unique_prefix
        ];
    }

    private function getAllTables() {
        $stmt = $this->db->query("SHOW TABLES");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function getTableStructure($table) {
        $stmt = $this->db->query("SHOW CREATE TABLE `$table`");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Create Table'];
    }

    private function getTableDataChunk($table, $offset, $limit) {
        $stmt = $this->db->prepare("SELECT * FROM `$table` LIMIT :offset, :limit");
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Escape and prepare row data
            $escaped_row = array_map(function($value) {
                return is_null($value) ? 'NULL' : $value;
            }, $row);

            $data[] = $escaped_row;
        }

        return $data;
    }

    public function restoreBackup($unique_prefix) {
        // Find all backup files for this session
        $backup_files = glob($this->backup_dir . $unique_prefix . '_*.txt');

        if (empty($backup_files)) {
            throw new Exception("No backup files found for the given prefix");
        }

        // Sort files to ensure correct order
        sort($backup_files);

        foreach ($backup_files as $backup_file) {
            $this->restoreTableFromBackup($backup_file);
        }

        return "Backup restored successfully";
    }

    private function restoreTableFromBackup($backup_file) {
        $file_contents = file($backup_file, FILE_IGNORE_NEW_LINES);

        $current_table = null;
        $table_structure = '';
        $in_structure = false;
        $in_data_chunk = false;

        foreach ($file_contents as $line) {
            if (strpos($line, "TABLE: ") === 0) {
                $current_table = trim(str_replace("TABLE: ", '', $line));
            }

            if ($line === "TABLE_STRUCTURE_START") {
                $in_structure = true;
                continue;
            }

            if ($line === "TABLE_STRUCTURE_END") {
                $in_structure = false;

                // Drop and recreate table
                $this->db->exec("DROP TABLE IF EXISTS `$current_table`");
                $this->db->exec($table_structure);

                continue;
            }

            if ($in_structure) {
                $table_structure .= $line . "\n";
            }

            if ($line === "DATA_CHUNK_START") {
                $in_data_chunk = true;
                continue;
            }

            if ($line === "DATA_CHUNK_END") {
                $in_data_chunk = false;
                continue;
            }

            if ($in_data_chunk) {
                $row_data = json_decode($line, true);

                if ($row_data) {
                    // Prepare insert statement dynamically
                    $columns = array_keys($row_data);
                    $placeholders = implode(',', array_fill(0, count($columns), '?'));
                    $column_names = implode(',', array_map(function($col) { return "`$col`"; }, $columns));

                    $stmt = $this->db->prepare("INSERT INTO `$current_table` ($column_names) VALUES ($placeholders)");

                    // Replace 'NULL' with actual NULL
                    $insert_data = array_map(function($value) {
                        return $value === 'NULL' ? null : $value;
                    }, array_values($row_data));

                    $stmt->execute($insert_data);
                }
            }
        }
    }
}
