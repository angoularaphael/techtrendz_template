<?php

function addUser(PDO $pdo, string $first_name, string $last_name, string $email, string $password, $role = "user")
{
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $query = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (:first_name, :last_name, :email, :password, :role)");
    $query->bindValue(":first_name", $first_name, PDO::PARAM_STR);
    $query->bindValue(":last_name", $last_name, PDO::PARAM_STR);
    $query->bindValue(":email", $email, PDO::PARAM_STR);
    $query->bindValue(":password", $hashedPassword, PDO::PARAM_STR);
    $query->bindValue(":role", $role, PDO::PARAM_STR);
    return $query->execute();
}

function verifyUserLoginPassword(PDO $pdo, string $email, string $password)
{
    $query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindValue(":email", $email, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    } else {
        return false;
    }
}

