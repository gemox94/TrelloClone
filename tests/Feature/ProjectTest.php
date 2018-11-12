<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{

    private $client_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjIyNjJlM2JjMmFiNDc5NzRmZDI2ZDNkNGE0ZDUzNDU0ZGM3YTg2YmI1MWM1NTRmMjU0NDVhZjcxMGIxMjliODY0MTYxZjhiZDg2YmNhOWNlIn0.eyJhdWQiOiIyIiwianRpIjoiMjI2MmUzYmMyYWI0Nzk3NGZkMjZkM2Q0YTRkNTM0NTRkYzdhODZiYjUxYzU1NGYyNTQ0NWFmNzEwYjEyOWI4NjQxNjFmOGJkODZiY2E5Y2UiLCJpYXQiOjE1NDEyOTQ0MzMsIm5iZiI6MTU0MTI5NDQzMywiZXhwIjoxNTcyODMwNDMzLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.B48SpASbZQO3d7QzyTFbbidRLhNj87ZPCr1WNXY4u5yc439jB8UtMbIc6Zz3v1CKw1q6zTgbOr366vIU1gW_lbXyv7LrKtOzgplRBqz9Fkp_xPoFA3aL9pzIaEoMQyu47rAIwyKm3bFasGpXkBtXYmYbN0gLncH75LeVpekgOA5pnlj5N4PhfoRQXHz0wbwoBA-WnHgjEGv_tOrAkHYCYzsye5WlfSXa5F-CoSrlBL6OSpD2_5S_LQjv9Jg_Vp5pf3jMqXzpyVkimyqbumg_0rRb3UZjeK8u1rAjrg2k_wJfIcuwCkT2JVXlUoobzDFK3J7iuabNDz5wT0bXRRWRBJvHWQq-KAgecvVx5OIB83Oh3G7AbhIsPfK1ldfRetJMEJCqHeTdlpHr0K43O-SszwHJdZSvOHT01v9nrxjihNvXCrS_-Z8jua4YHHtS5GOuRMalyu1X-kkchJ9uRF4fbyRsRKBpss1e4Xzv4vGth1yiOaY2ssEMqVWrQS8ofX2kwwlJvgsSKkf6TrqPQRDrsQ1qlN9nKHE_J85z26Ndm8-_9T4v4S1RgyTjwUzuTyMnJieyUGOcLymw1k-i49us7nrNFwMjJSyGSlO2HdLFy90OtAzDALxXxb5ZAiSRC6Nu6mHA10F83DHiNicvZtLAmewX_2J1cQY7jiAZkP_ri1E';

    /**
     * Get projects without access token.
     */
    public function testGetProjectsUnauthorized()
    {
        $response = $this->json('GET', '/api/projects');
        $response->assertStatus(401);
    }

    /**
     * Get projects with access token
     */
    public function testGetProjectsAuthorized() {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->client_token
        ])->json('GET', '/api/projects');
        $response->assertStatus(200)->assertJson(['projects' => []]);
    }

    /**
     * Get single project passing an invalid ID to get 404
     */
    public function testNotFoundProject() {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->client_token
        ])->json('GET', '/api/projects/1000');
        $response->assertStatus(404)->assertJson(['error' => 'Project not found!']);
    }

    /**
     * Create a new Project
     */
    public function testCreateNewProject() {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->client_token
        ])->json('POST', '/api/projects', ['name' => 'Project Test']);
        $response->assertStatus(200)->assertJson(['project' => []]);
    }


}
