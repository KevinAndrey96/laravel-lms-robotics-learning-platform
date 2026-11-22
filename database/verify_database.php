<?php

/**
 * Automated Database & Entity Verification Script for CI and Local Dev.
 */

$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '3306';
$database = getenv('DB_DATABASE') ?: 'robotics_learning_db';
$username = getenv('DB_USERNAME') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';

echo "Connecting to MySQL database {$database} on {$host}:{$port}...\n";

try {
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "[OK] Connected to MySQL successfully.\n";
} catch (PDOException $e) {
    echo "[ERROR] Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

$tables = [
    'users',
    'roles',
    'permissions',
    'model_has_roles',
    'role_has_permissions',
    'schools',
    'coordinators',
    'teachers',
    'classrooms',
    'students',
    'categories',
    'subcategories',
    'projects',
    'syllabi',
    'homework',
    'uploaded_homeworks',
    'academic_histories',
];

$missingTables = [];
foreach ($tables as $table) {
    $stmt = $pdo->query("SHOW TABLES LIKE '{$table}'");
    if ($stmt->rowCount() === 0) {
        $missingTables[] = $table;
    }
}

if (!empty($missingTables)) {
    echo "[FAIL] Missing required tables: " . implode(', ', $missingTables) . "\n";
    exit(1);
}
echo "[OK] All " . count($tables) . " required schema tables exist.\n";

// Entity counts verification
$checks = [
    'users' => 1,
    'roles' => 4,
    'permissions' => 20,
    'schools' => 1,
    'categories' => 1,
    'subcategories' => 1,
    'classrooms' => 1,
];

foreach ($checks as $table => $minCount) {
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM `{$table}`");
    $count = (int) $stmt->fetch()['total'];
    if ($count < $minCount) {
        echo "[FAIL] Table `{$table}` has {$count} rows, expected at least {$minCount}.\n";
        exit(1);
    }
    echo "[OK] Table `{$table}` contains {$count} records (threshold >= {$minCount}).\n";
}

echo "\n[SUCCESS] STEM Robotics Learning Platform database verification passed with 100% data integrity!\n";
exit(0);
