<?php

$relationships = getenv("PLATFORM_RELATIONSHIPS");

if (!$relationships) {
        return;
}

$relationships = json_decode(base64_decode($relationships), true);

foreach ($relationships['database'] as $endpoint) {
    if (empty($endpoint['query']['is_master'])) {
      continue;
    }

    $url = sprintf('%s://%s:%s@%s/%s', $endpoint['scheme'], $endpoint['username'], $endpoint['password'], $endpoint['host'], $endpoint['path']);

    $container->setParameter('database_url', $url);
}

# Store session into /tmp.
ini_set('session.save_path', '/tmp/sessions');
