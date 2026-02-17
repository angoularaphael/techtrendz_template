<?php

function getArticleById(PDO $pdo, int $id):array|bool
{
    $query = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
    $query->bindValue(":id", $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function getArticles(PDO $pdo, ?int $limit = null, ?int $page = null):array|bool
{
    $sql = "SELECT * FROM articles ORDER BY id DESC";
    
    // If limit is provided, add LIMIT clause
    if ($limit !== null) {
        if ($page !== null) {
            // With pagination: calculate offset
            $offset = ($page - 1) * $limit;
            $sql .= " LIMIT :limit OFFSET :offset";
            $query = $pdo->prepare($sql);
            $query->bindValue(":limit", $limit, PDO::PARAM_INT);
            $query->bindValue(":offset", $offset, PDO::PARAM_INT);
        } else {
            // Just limit, no pagination
            $sql .= " LIMIT :limit";
            $query = $pdo->prepare($sql);
            $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        }
    } else {
        // No limit
        $query = $pdo->prepare($sql);
    }
    
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function getTotalArticles(PDO $pdo):int|bool
{
    $query = $pdo->prepare("SELECT COUNT(*) as total FROM articles");
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}

function saveArticle(PDO $pdo, string $title, string $content, ?string $image, int $category_id, ?int $id = null):bool 
{
    if ($id === null) {
        // Insert new article
        $query = $pdo->prepare("INSERT INTO articles (title, content, image, category_id) VALUES (:title, :content, :image, :category_id)");
    } else {
        // Update existing article
        $query = $pdo->prepare("UPDATE articles SET title = :title, content = :content, image = :image, category_id = :category_id WHERE id = :id");
        $query->bindValue(':id', $id, PDO::PARAM_INT);
    }

    // Bind common values
    $query->bindValue(':title', $title, PDO::PARAM_STR);
    $query->bindValue(':content', $content, PDO::PARAM_STR);
    $query->bindValue(':image', $image, PDO::PARAM_STR);
    $query->bindValue(':category_id', $category_id, PDO::PARAM_INT);

    return $query->execute();  
}

function deleteArticle(PDO $pdo, int $id):bool
{
    $query = $pdo->prepare("DELETE FROM articles WHERE id = :id");
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    if ($query->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}