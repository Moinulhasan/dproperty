<?php

namespace Tests\Feature;

use App\Models\AppSettings;
use App\Models\CompanyRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

/**
 * Guards the "must fix" security changes. SQLite in-memory (phpunit.xml):
 * never touches the production database.
 */
class SecurityFixesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        AppSettings::create(['site_name' => 'dproperty']);
    }

    /**
     * Laravel already rejects "*.php"-named uploads, but not ".pht" (run as PHP by
     * some cPanel handlers) or ".html" (a page on our domain). An image with code
     * appended passes the content check, so the saved name must come from content.
     */
    public function test_upload_keeps_extension_from_content_not_from_visitor_file_name(): void
    {
        foreach (['shell.pht', 'page.html'] as $i => $clientName) {
            $png = tempnam(sys_get_temp_dir(), 'png');
            imagepng(imagecreatetruecolor(10, 10), $png);
            file_put_contents($png, "<?php echo 'pwned'; ?><script>alert(1)</script>", FILE_APPEND);

            $this->post('/company-register', [
                'company_name' => 'Acme', 'contact_person_name' => 'A', 'email' => "a$i@example.com",
                'mobile_number' => '01700000000',
                'declare_accurate' => '1', 'declare_authorize' => '1', 'declare_terms' => '1',
                'company_logo' => new UploadedFile($png, $clientName, 'image/png', null, true),
            ])->assertRedirect()->assertSessionHasNoErrors();

            $saved = CompanyRequest::where('email', "a$i@example.com")->firstOrFail()->company_logo;
            @unlink(public_path($saved));
            $this->assertStringEndsWith('.png', $saved, "$clientName was saved as $saved");
        }
    }

    public function test_admin_delete_and_logout_reject_get_requests(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/admin/properties/delete/1')->assertStatus(405);
        $this->get('/admin/user/user-delete/1')->assertStatus(405);
        $this->get('/admin/logout')->assertStatus(405);
    }

    public function test_public_form_is_rate_limited(): void
    {
        $form = ['name' => 'Spam', 'email' => 'spam@example.com', 'message' => 'hi'];
        for ($i = 0; $i < 5; $i++) {
            $this->post('/contact-us', $form)->assertRedirect();
        }
        $this->post('/contact-us', $form)->assertStatus(429);
    }

    public function test_admin_login_is_rate_limited(): void
    {
        $login = ['email' => 'nobody@example.com', 'password' => 'wrong-password'];
        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/post-login', $login)->assertRedirect();
        }
        $this->post('/admin/post-login', $login)->assertStatus(429);
    }

    public function test_contact_message_length_is_capped(): void
    {
        $this->post('/contact-us', ['name' => 'A', 'email' => 'a@example.com', 'message' => str_repeat('x', 5001)])
            ->assertSessionHasErrors('message');
    }
}
