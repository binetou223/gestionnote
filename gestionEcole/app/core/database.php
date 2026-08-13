<?php

function connexionDB(): PDO {
    static $pdo = null;

    if ($pdo === null) {
        try {
            $pdo = new PDO(
                "pgsql:host=localhost;dbname=gestionnotewane;port=5432",
                "postgres",
                "postgres"
            );
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {
            die('Erreur : ' . $ex->getMessage());
        }
    }

    return $pdo;
}

function deconnecteDB(?PDO &$pdo = null): void {
    $pdo = null;
}

function query(PDO $pdo, string $sql, bool $single = true): array {
    $query = $pdo->query($sql);
    $result = $single ? $query->fetch() : $query->fetchAll();
    return $result !== false ? $result : [];
}

function prepare(PDO $pdo, string $sql, array $datas): PDOStatement {
    $statement = $pdo->prepare($sql);
    $statement->execute($datas);
    return $statement;
}

function executeQuery(PDO $pdo, string $sql, array $datas, bool $single = true): array {
    $statement = prepare($pdo, $sql, $datas);
    $result = $single ? $statement->fetch() : $statement->fetchAll();
    return $result !== false ? $result : [];
}

function executeUpdate(PDO $pdo, string $sql, array $datas): int {
    $statement = prepare($pdo, $sql, $datas);
    
    if (str_starts_with(strtoupper(trim($sql)), 'INSERT')) {
        return (int) $pdo->lastInsertId();
    }
    
    return $statement->rowCount();
}