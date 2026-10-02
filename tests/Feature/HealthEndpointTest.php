<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthEndpointTest extends TestCase
{
    public function test_root_endpoint_reports_baseline_health(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertExactJson([
                'status' => 'ok',
                'service' => 'laravel-postgres-docker-baseline',
            ]);
    }
}
