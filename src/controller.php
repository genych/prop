<?php declare(strict_types=1);

namespace Pr\Controller;

use Pr\Api\Client;
use Pr\Persistence\Persistence;

require_once __DIR__.'/persistence.php';
require_once __DIR__.'/client.php';

function controller(array $request): ?string {
    $p = new Persistence();
    $f = new Client(getenv('DEFINITELY_NOT_API_KEY'));

    if ($request['populate'] ?? false) {
        $stream = $f->fetchProperties();
        foreach ($stream['data'] ?? [] as $item) {
            $p->insertProperty([
                'uuid' => (string)$item['uuid'],
                'town' => (string)$item['town'],
                'description' => (string)$item['description'],
                'bedrooms' => (int)$item['num_bedrooms'],
                'price' => (int)$item['price'],
                'property_type' => (string)$item['property_type']['title'],
                'deal_type' => (string)$item['type']
            ]);
        }

        return $stream['next_page_url'];
    }

    if ($request['search'] ?? false) {
        $results = $p->findProperties(
            (string)($request['name'] ?? null),
            (int)($request['beds'] ?? null),
            (int)($request['price'] ?? null),
            (string)($request['type'] ?? null),
            (string)($request['sr'] ?? null),
        );

        return var_export($results, true);
    }

    return null;
}
