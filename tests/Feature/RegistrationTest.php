<?php

use App\Models\VaccineCenter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\VaccineCenterSeeder;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(VaccineCenterSeeder::class);
});

test('can register a user with valid data', function () {
    $nid = '7897897897';

    $vaccineCenter = VaccineCenter::query()->first();

    $response = $this->post('/register', [
        'name'           => 'Siddik',
        'nid'            => $nid,
        'email'          => 'absiddik@gmail.com',
        'phone'          => '01789789789',
        'vaccine_center' => $vaccineCenter->id,
    ]);

    $response->assertStatus(302);
    $response->assertRedirect('/success/' . $nid);
    $this->assertDatabaseHas('users', ['nid' => $nid]);
});

test('cannot register a user with duplicate NID', function () {
    $nid = '7897897897';

    $vaccineCenter = VaccineCenter::query()->first();

    $this->post('/register', [
        'name'           => 'Siddik',
        'nid'            => $nid,
        'email'          => 'absiddik@gmail.com',
        'phone'          => '01789789789',
        'vaccine_center' => $vaccineCenter->id,
    ]);

    $response = $this->post('/register', [
        'name'           => 'Another User',
        'nid'            => $nid,
        'email'          => 'anotheruser@gmail.com',
        'phone'          => '01812345678',
        'vaccine_center' => $vaccineCenter->id,
    ]);

    $response->assertSessionHasErrors(['nid']);
    $this->assertDatabaseCount('users', 1);
});

test('cannot register a user with an invalid vaccine center', function () {
    $nid = '7897897898';

    $response = $this->post('/register', [
        'name'           => 'Invalid Center User',
        'nid'            => $nid,
        'email'          => 'invalidcenter@gmail.com',
        'phone'          => '01812345679',
        'vaccine_center' => 999,
    ]);

    $response->assertSessionHasErrors(['vaccine_center']);
    $this->assertDatabaseMissing('users', ['nid' => $nid]);
});
