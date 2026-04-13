<?php
try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $hash = password_hash('password', PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE name = 'ronin'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, updated_at, created_at) VALUES ('ronin', 'admin@ronin.com', :pw, datetime('now'), datetime('now'))");
        $stmt->execute(['pw' => $hash]);
        echo "Admin inserted successfully.\n";
    } else {
        echo "Admin already exists.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
