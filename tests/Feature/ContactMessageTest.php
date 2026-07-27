<?php

namespace Tests\Feature;

use App\Mail\NewContactMessage;
use App\Models\ContactMessage;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_form_stores_message_and_sends_notification(): void
    {
        Mail::fake();

        $this->post(route('contact.submit'), [
            'name' => 'Persona solicitante',
            'email' => 'persona@example.test',
            'phone' => '8888-8888',
            'subject' => 'Consulta de prueba',
            'message' => 'Necesito información institucional adicional.',
            'privacy_consent' => '1',
            'website' => '',
        ])->assertRedirect()->assertSessionHas('contact_success');

        $message = ContactMessage::firstOrFail();
        $this->assertSame('new', $message->status);
        $this->assertNotNull($message->consented_at);
        Mail::assertSent(NewContactMessage::class, fn ($mail) => $mail->hasTo('ctp.robertogamboa@mep.go.cr'));
    }

    public function test_public_form_validates_consent_and_rejects_honeypot(): void
    {
        $payload = [
            'name' => 'Persona',
            'email' => 'persona@example.test',
            'subject' => 'Consulta',
            'message' => 'Mensaje suficientemente largo.',
        ];

        $this->post(route('contact.submit'), $payload)->assertSessionHasErrors('privacy_consent');
        $this->post(route('contact.submit'), $payload + ['privacy_consent' => '1', 'website' => 'spam'])
            ->assertSessionHasErrors('website');
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_editor_can_review_and_handle_messages(): void
    {
        $editor = User::factory()->create();
        $editor->roles()->attach(Role::where('name', 'editor')->firstOrFail());
        $message = ContactMessage::create([
            'name' => 'Persona',
            'email' => 'persona@example.test',
            'subject' => 'Seguimiento',
            'message' => 'Consulta registrada para seguimiento.',
            'consented_at' => now(),
        ]);

        $this->actingAs($editor)
            ->get(route('admin.contact-messages.index'))
            ->assertOk()
            ->assertSee('Consultas recibidas')
            ->assertSee('Seguimiento');

        $this->actingAs($editor)
            ->get(route('admin.contact-messages.show', $message))
            ->assertOk()
            ->assertSee('Consulta registrada para seguimiento');
        $this->assertSame('read', $message->fresh()->status);

        $this->actingAs($editor)
            ->put(route('admin.contact-messages.update', $message), ['status' => 'handled'])
            ->assertSessionHas('success');
        $this->assertSame('handled', $message->fresh()->status);
        $this->assertNotNull($message->fresh()->handled_at);
    }
}
