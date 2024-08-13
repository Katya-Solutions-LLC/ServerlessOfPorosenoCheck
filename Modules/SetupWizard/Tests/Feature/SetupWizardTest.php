<?php

namespace Modules\SetupWizard\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SetupWizardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test SetupWizard.
     *
     * @return void
     */
    public function test_backend_setup_wizard_page()
    {
        $this->signInAsAdmin();

        $response = $this->get('setup');

        $response->assertStatus(200);
    }
}
