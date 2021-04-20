<?php

namespace App\DataProvider;

use App\Entity\CheckIn;
use App\Entity\Product;
use App\Entity\User;
use App\Hydrator\EntityHydrator;
use PDO;

class DatabaseProvider
{
    private \PDO $dbh;

    public function __construct()
    {
        try {
            $this->dbh = new PDO(
                'mysql:dbname=project;host=mysql',
                $_ENV['DBUSERNAME'],
                $_ENV['DBPASSWD']
            );

            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            // We could log this!
            die('Unable to establish a database connection');
        }
    }

    public function getProducts(string $searchTerm): array
    {
        $stmt = $this->dbh->prepare('SELECT id, title, artist, genre FROM product WHERE title LIKE :searchTerm');
        $stmt->execute([
            'searchTerm' => '%' . $searchTerm . '%'
        ]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, Product::class);
    }

    public function getProduct(int $productId): ?Product
    {
        $stmt = $this->dbh->prepare(
            'SELECT
            p.id AS product_id, p.title, p.artist, p.image_path, p.genre,
            c.id, c.name, c.rating, c.review, c.posted,
            (
                SELECT AVG(checkin.rating)FROM checkin WHERE product_id = p.id
            ) as average_rating
             FROM product AS p
             LEFT JOIN checkin c ON c.product_id = p.id
             WHERE p.id = :id'
        );
        $stmt->execute([
            'id' => $productId //$productID = 1
        ]);

        $productAndCheckInData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $hydrator = new EntityHydrator();
        return $hydrator->hydrateProductWithCheckIns($productAndCheckInData);

    }

    public function createProduct(Product $product): Product
    {
        $stmt = $this->dbh->prepare(
            'INSERT INTO product(title, artist, genre, image_path)
            VALUES (:title, :artist, :genre, :imagePath)'
        );

        $stmt->execute([
            'title' => $product->title,
            'artist' => $product->artist,
            'genre' => $product->genre,
            'imagePath' => $product->imagePath,
        ]);

        $lastInsertId = $this->dbh->lastInsertId();
        $newProduct = $this->getProduct($lastInsertId);
        return $newProduct;
    }


    public function getCheckin(int $checkInId): ?CheckIn
    {
        $stmt = $this->dbh->prepare(
            'SELECT id, product_id, name, rating, review, posted
            FROM checkin
            WHERE id = :id'
        );
        $stmt->execute(['id' => $checkInId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            return null;
        }

        $hydrator = new EntityHydrator();
        return $hydrator->hydrateCheckIn($result);
    }

    public function createCheckin(CheckIn $checkIn): CheckIn
    {
        $stmt = $this->dbh->prepare('
        INSERT INTO checkin (name, rating, review, product_id)
        VALUE (:name, :rating, :review, :productId)
        ');

        $stmt->execute([
            'name' => $checkIn->name,
            'rating' => $checkIn->rating,
            'review' => $checkIn->review,
            'productId' => $checkIn->product_id
        ]);

        $lastInsertId = $this->dbh->lastInsertId();
        $newCheckIn = $this->getCheckIn($lastInsertId);

        return $newCheckIn;

    }

    public function getUser(int $userId): ?User
    {
        $stmt = $this->dbh->prepare(
            'SELECT id, name, email_address, password
            FROM user 
            WHERE id = :id'
        );
        $stmt->execute(['id' => $userId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        $hydrator = new EntityHydrator();
        return $hydrator->hydrateUser($result);
    }

    public function getUserByEmail(string $email): ?User
    {
        $stmt = $this->dbh->prepare(
            'SELECT id, name, email_address, password
            FROM user 
            WHERE email_address = :email'
        );
        $stmt->execute(['email' => $email]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        $hydrator = new EntityHydrator();
        return $hydrator->hydrateUser($result);
    }

    public function createUser(User $user): User
    {
        $stmt = $this->dbh->prepare(
            'INSERT INTO user (`name`, `email_address`, `password`)
        VALUES (:name, :emailAddress, :password)'
        );

        $stmt->execute([
            'name' => $user->name,
            'emailAddress' => $user->emailAddress,
            'password' => $user->password,
        ]);

        $lastInsertId = $this->dbh->lastInsertId();
        $newUser = $this->getUser($lastInsertId);

        return $newUser;
    }
}