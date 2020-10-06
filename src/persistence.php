<?php declare(strict_types=1);

namespace Pr\Persistence;

use Exception;
use PDO;

class Persistence
{
    private PDO $handle;

    public function __construct()
    {
        $name = getenv('MYSQL_DATABASE');
        $user = getenv('MYSQL_USER');
        $password = getenv('MYSQL_PASSWORD');
        $this->handle = new PDO("mysql:host=db;dbname=$name;charset=utf8mb4", $user, $password);
    }

    /**
     * @param array $raw
     * @return string uuid
     * @throws Exception
     */
    public function insertProperty(array $raw): string
    {
        $result = $this->handle->exec(
            'CREATE TABLE IF NOT EXISTS prop (
                uuid char(36) not null,
                town varchar(255),
                description text,
                bedrooms int,
                price int,
                property_type varchar(255),
                deal_type varchar(255),
                
                unique(uuid),
                index town(town), index bedrooms(bedrooms), index price(price), index ptype(property_type), index dtype(deal_type)
            ) ENGINE=InnoDB;'
        );

        if ($result === false) {
            throw new Exception('failed to create');
        }

        $statement = $this->handle->prepare(
            'replace into prop (
                uuid,
                town,
                description,
                bedrooms,
                price,
                property_type,
                deal_type) 
            values (
                :uuid,
                :town,
                :description,
                :bedrooms,
                :price,
                :property_type,
                :deal_type)
            '
        );

        $result = $statement->execute(
            [
                'uuid'          => $raw['uuid'],
                'town'          => $raw['town'],
                'description'   => $raw['description'],
                'bedrooms'      => $raw['bedrooms'],
                'price'         => $raw['price'],
                'property_type' => $raw['property_type'],
                'deal_type'     => $raw['deal_type'],
            ]);

        if ($result === false) {
            throw new Exception('failed to insert');
        }

        return $raw['uuid'];
    }

    public function findProperties(
        ?string $name = null,
        ?int $bedrooms = null,
        ?int $price = null,
        ?string $propertyType = null,
        ?string $dealType = null
    ): array {
        $statement = $this->handle->prepare(
            'select
                uuid,
                town,
                description,
                bedrooms,
                price,
                property_type,
                deal_type
            from prop
            where 1 ' .
            ' and ' . ($name ? 'town like :name' : 1) .
            ' and ' . ($bedrooms ? 'bedrooms = :bedrooms' : 1) .
            ' and ' . ($price ? 'price < :price' : 1) .
            ' and ' . ($propertyType ? 'property_type = :property_type' : 1) .
            ' and ' . ($dealType ? 'deal_type = :deal_type' : 1)
        );

        $bindings = [];

// TODO: avoids number of bindings mismatch. this is twisted.
        if ($name) {
            $bindings['name'] = "%$name%";
        }
        if ($bedrooms) {
            $bindings['bedrooms'] = $bedrooms;
        }
        if ($price) {
            $bindings['price'] = $price;
        }
        if ($propertyType) {
            $bindings['property_type'] = $propertyType;
        }
        if ($dealType) {
            $bindings['deal_type'] = $dealType;
        }

        $statement->execute($bindings);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
