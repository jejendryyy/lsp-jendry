<?php

namespace Tests\Feature;

use App\Filament\Resources\Profiles\ProfileResource;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_keeps_default_content_when_no_profile_record_exists(): void
    {
        $this->get('/profil')
            ->assertOk()
            ->assertSeeText('Menjadi mitra terpercaya dalam transformasi infrastruktur digital Indonesia.')
            ->assertSeeText('Menyediakan layanan konektivitas dan teknologi sesuai kebutuhan pelanggan.');
    }

    public function test_profile_content_is_loaded_from_the_profile_record(): void
    {
        $profile = Profile::query()->create([
            'deskripsi' => 'Deskripsi profil yang dapat diubah.',
            'visi' => 'Visi profil yang dapat diubah.',
            'misi' => 'Misi profil yang dapat diubah.',
        ]);

        $this->get('/profil')
            ->assertOk()
            ->assertSeeText('Deskripsi profil yang dapat diubah.')
            ->assertSeeText('Visi profil yang dapat diubah.')
            ->assertSeeText('Misi profil yang dapat diubah.');

        $profile->update(['deskripsi' => 'Deskripsi terbaru.']);

        $this->assertSame('Deskripsi terbaru.', $profile->fresh()->deskripsi);
        $this->assertFalse(ProfileResource::canCreate());

        $this->get('/profil')->assertSeeText('Deskripsi terbaru.');

        $profile->delete();

        $this->assertDatabaseMissing('profiles', ['deskripsi' => 'Deskripsi terbaru.']);
        $this->assertTrue(ProfileResource::canCreate());
    }

    public function test_profile_missions_are_displayed_as_separate_list_items(): void
    {
        Profile::query()->create([
            'deskripsi' => 'Deskripsi profil.',
            'visi' => 'Visi profil.',
            'misi' => 'Misi pertama. - Misi kedua. - Misi ketiga.',
        ]);

        $response = $this->get('/profil')->assertOk();

        $this->assertSame(3, substr_count($response->getContent(), '<li>'));
    }
}
