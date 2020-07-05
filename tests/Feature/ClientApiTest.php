<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     *
     * @return void
     */
    public function testCanCreateClient()
    {
        $user = factory(User::class)->create();
        $client = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phones' => [
                '+79321260999'
            ],
            'emails' => [
                $this->faker->email
            ]
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->api_token,
        ])->json('POST', '/api/client', $client);
        $response
            ->assertStatus(202)
            ->assertJsonPath('data.client.id', 1);
    }

    /**
     * @test
     *
     * @return void
     */
    public function testCanNotCreateClient()
    {
        $user = factory(User::class)->create();
        $client = [
            'first_name' => $this->faker->firstName,
            'phones' => [
                'asdfasfsadfsafd'
            ],
            'emails' => [
                $this->faker->email
            ]
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->api_token,
        ])->json('POST', '/api/client', $client);
        $response->assertStatus(422);
    }

    /**
     * @test
     *
     * @return void
     */
    public function testCanUpdateClient()
    {
        $user = factory(User::class)->create();
        $client = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phones' => [
                '+79321260999'
            ],
            'emails' => [
                $this->faker->email
            ]
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->api_token,
        ])->json('POST', '/api/client', $client);
        $response
            ->assertStatus(202)
            ->assertJsonPath('data.client.id', 1);
        $client['first_name'] = 'Test';
        $client['client_id'] = 1;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->api_token,
        ])->json('PUT', '/api/client', $client);
        $response
            ->assertStatus(202)
            ->assertJsonPath('data.client.id', 1)
            ->assertJsonPath('data.client.first_name', 'Test');
    }

    /**
     * @test
     *
     * @return void
     */
    public function testCanNotUpdateClient()
    {
        $user = factory(User::class)->create();
        $client = [
            'client_id' => 1000,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phones' => [
                '+79321260999'
            ],
            'emails' => [
                $this->faker->email
            ],
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->api_token,
        ])->json('PUT', '/api/client', $client);
        $response->assertStatus(404);
    }

    /**
     * @test
     *
     * @return void
     */
    public function testUserCanShowClient()
    {
        $user = factory(User::class)->create();
        $client = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phones' => [
                '+79321260999'
            ],
            'emails' => [
                $this->faker->email
            ],
        ];
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->api_token,
        ])->json('POST', '/api/client', $client);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->api_token,
        ])->json('GET', '/api/client/1', $client);
        $response->assertStatus(200);
    }

    /**
     * @test
     *
     * @return void
     */
    public function testUserCanSearchClients()
    {
        $user = factory(User::class)->create();

        $client = [
            'first_name' => 'Ivanov',
            'last_name' => 'Ivan',
            'phones' => [
                '+79321260999'
            ],
            'emails' => [
                'testiven@mail.me'
            ],
        ];
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->api_token,
        ])->json('POST', '/api/client', $client);

        $client = [
            'first_name' => 'Ivanov',
            'last_name' => 'Ivan',
            'phones' => [
                '+79321260888'
            ],
            'emails' => [
                'testiven2@mail.me'
            ],
        ];
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->api_token,
        ])->json('POST', '/api/client', $client);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->api_token,
        ])->json('GET', '/api/client/search', $client);
        $response->assertStatus(422);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->api_token,
        ])->json('GET', '/api/client/search?type=name&query=Ivan', $client);
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->api_token,
        ])->json('GET', '/api/client/search?type=phone&query=60888', $client);
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->api_token,
        ])->json('GET', '/api/client/search?type=all&query=testiven', $client);
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }
}
