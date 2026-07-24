<?php

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=oncoid1_stayhub",
        "oncoid1_stayhubuser",
        "@stayhub123"
    );

    echo "PDO MySQL BERHASIL";
} catch (PDOException $e) {
    echo $e->getMessage();
}