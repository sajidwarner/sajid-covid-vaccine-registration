<?php

namespace Tests\Feature;

use App\Models\Registration;
use App\Models\User;
use App\Models\VaccineCenter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RegistrationTest extends TestCase
{


    /** @test */
    public function test_registration_page_is_accessible()
    {
        // Simulate a GET request to the registration index route
        $response = $this->get(route('registration.index'));

        // Assert that the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the title "Registration" appears on the page
        $response->assertSee('Registration');
    }

    /** @test */
    public function test_user_can_register_with_valid_data()
    {
        // Create a vaccine center for testing
        $vaccineCenter = VaccineCenter::factory()->create();

        // Simulate a POST request to the registration store route with valid data
        $response = $this->post(route('registration.store'), [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'nid' => '1234567890',
            'vaccine_center_id' => $vaccineCenter->id,
        ]);

        // Assert the user is created in the users table
        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com',
        ]);

        // Assert the registration is created in the registrations table
        $user = User::where('email', 'johndoe@example.com')->first();
        $this->assertDatabaseHas('registrations', [
            'user_id' => $user->id,
            'vaccine_center_id' => $vaccineCenter->id,
        ]);

        // Assert the response contains the success message
        $response->assertSessionHas('success', 'You have successfully registered for the vaccine.');
    }

    /** @test */
    public function test_registration_fails_with_invalid_data()
    {
        // Simulate a POST request to the registration store route with invalid data (missing NID)
        $response = $this->post(route('registration.store'), [
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'nid' => '', // Invalid NID
            'vaccine_center_id' => 1, // Assuming 1 is a valid ID
        ]);

        // Assert the user is not created
        $this->assertDatabaseMissing('users', [
            'email' => 'janedoe@example.com',
        ]);

        // Assert validation errors in the session
        $response->assertSessionHasErrors(['nid']);
    }

    /** @test */
    public function test_search_schedule_page_is_accessible()
    {
        // Simulate a GET request to the search schedule route
        $response = $this->get(route('search.index'));

        // Assert that the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the title "Search Schedule" appears on the page
        $response->assertSee('Search Schedule');
    }

    /** @test */
    public function test_ajax_search_schedule_with_valid_nid()
    {
        // Create a user and registration with a future scheduled date
        $user = User::factory()->create(['nid' => '1234567890']);
        Registration::factory()->create([
            'user_id' => $user->id,
            'scheduled_date' => now()->addDays(7),
        ]);

        // Simulate an AJAX GET request to search schedule with a valid NID
        $response = $this->getJson(route('search.schedule'), [
            'nid' => '1234567890',
        ]);

        // Assert the response contains the scheduled status
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'Scheduled',
            ]);
    }

    /** @test */
    public function test_ajax_search_schedule_with_invalid_nid()
    {
        // Simulate an AJAX GET request to search schedule with an invalid NID
        $response = $this->getJson(route('search.schedule'), [
            'nid' => '', // Invalid NID
        ]);

        // Assert the response contains validation errors
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nid']);
    }

    /** @test */
    public function test_ajax_search_schedule_when_user_not_registered()
    {
        // Simulate an AJAX GET request to search schedule with a non-existent NID
        $response = $this->getJson(route('search.schedule'), [
            'nid' => '9999999999',
        ]);

        // Assert the response contains "Not registered" status
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'Not registered',
                'message' => 'No registration found for the provided NID.',
            ]);
    }
}
