<?php

namespace Tests\Feature;

use App\Filament\Resources\ServiceRequests\Pages\EditServiceRequest;
use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Galleries\Pages\CreateGallery;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Tests\TestCase;

class ServiceRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_detail_offers_consultation_with_the_selected_service()
    {
        $product = $this->createProduct();

        $this->get(route('products.show', $product->slug))
            ->assertOk()
            ->assertSee('Konsultasi layanan')
            ->assertSee('class="button button-primary product-consult-link"', false)
            ->assertSee(route('contact', ['product_id' => $product->id]), false)
            ->assertDontSee('Ajukan Permintaan');

        $this->get(route('contact', ['product_id' => $product->id]))
            ->assertOk()
            ->assertSee('value="'.$product->id.'" selected', false)
            ->assertSee('id="contact-name-field"', false)
            ->assertSee('id="contact-email-field"', false);
    }

    public function test_product_category_is_shown_on_service_cards_and_detail()
    {
        $category = Category::create([
            'name' => 'Cloud Computing',
            'slug' => 'cloud-computing',
        ]);
        $product = $this->createProduct([
            'category_id' => $category->id,
        ]);

        $this->get(route('products.index'))
            ->assertOk()
            ->assertSee('Cloud Computing');

        $this->get(route('products.show', $product->slug))
            ->assertOk()
            ->assertSee('Cloud Computing');
    }

    public function test_products_and_galleries_are_shown_without_visibility_flags()
    {
        $product = $this->createProduct();
        $gallery = Gallery::factory()->create([
            'title' => 'Dokumentasi Fasilitas',
        ]);

        $this->get(route('products.index'))
            ->assertOk()
            ->assertSee($product->name);

        $this->get(route('gallery'))
            ->assertOk()
            ->assertSee($gallery->title);

    }

    public function test_the_general_contact_form_still_stores_a_contact_without_a_service_request()
    {
        $user = User::factory()->create([
            'name' => 'Pelanggan Uji',
            'email' => 'customer@example.com',
        ]);

        $this->actingAs($user)->post(route('contact.submit'), [
            'sender_name' => 'Pengunjung',
            'sender_email' => 'visitor@example.com',
            'sender_phone' => '08123456789',
        ])->assertRedirect(route('contact'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('contacts', [
            'sender_name' => 'Pelanggan Uji',
            'sender_email' => 'customer@example.com',
            'product_id' => null,
            'message' => null,
        ]);
        $this->assertDatabaseCount('contacts', 1);
        $this->assertFalse(Schema::hasTable('service_requests'));
    }

    public function test_deleting_a_product_preserves_contacts_and_clears_the_product_reference()
    {
        $productId = DB::table('products')->insertGetId([
            'name' => 'Layanan untuk dihapus',
            'slug' => 'layanan-untuk-dihapus',
            'short_description' => 'Deskripsi layanan.',
        ]);
        $contactId = DB::table('contacts')->insertGetId([
            'product_id' => $productId,
            'sender_name' => 'Pengunjung',
            'sender_email' => 'visitor@example.com',
        ]);

        DB::table('products')->where('id', $productId)->delete();

        $this->assertDatabaseHas('contacts', [
            'id' => $contactId,
            'product_id' => null,
        ]);
        $this->assertDatabaseMissing('products', ['id' => $productId]);
    }

    public function test_a_guest_cannot_send_a_contact_message_or_service_request()
    {
        User::factory()->create([
            'email' => 'customer@example.com',
            'password' => 'password',
        ]);
        $product = $this->createProduct();

        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('name="product_id"', false)
            ->assertSee('Pesan (opsional)')
            ->assertSee('Kirim Pesan')
            ->assertDontSee('Masuk untuk mengirim');

        $this->post(route('contact.submit'), [
            'sender_name' => 'Pengunjung',
            'sender_email' => 'visitor@example.com',
            'message' => 'Saya ingin mengirim pesan umum.',
        ])->assertRedirect(route('login'));

        $this->post(route('contact.submit'), [
            'product_id' => $product->id,
            'sender_phone' => '08123456789',
            'message' => 'Saya ingin mengajukan layanan ini.',
        ])->assertRedirect(route('login'));

        $this->assertDatabaseCount('contacts', 0);

        $this->post(route('login.store'), [
            'email' => 'customer@example.com',
            'password' => 'password',
        ])->assertRedirect(route('contact'));
    }

    public function test_an_authenticated_user_can_submit_a_service_request_from_the_contact_form()
    {
        $user = User::factory()->create([
            'name' => 'Pelanggan Uji',
            'email' => 'customer@example.com',
        ]);
        $product = $this->createProduct();

        $this->actingAs($user)->post(route('contact.submit'), [
            'product_id' => $product->id,
            'sender_phone' => '08123456789',
            'message' => '',
            'sender_name' => 'Nama yang dikirim dari browser',
            'sender_email' => 'palsu@example.com',
        ])->assertRedirect(route('contact'))
            ->assertSessionHas('success', 'Permintaan layanan berhasil dikirim.');

        $this->assertDatabaseHas('contacts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'sender_name' => 'Pelanggan Uji',
            'sender_email' => 'customer@example.com',
            'sender_phone' => '08123456789',
            'message' => null,
            'status' => ServiceRequest::STATUS_WAITING,
        ]);
        $this->assertDatabaseCount('contacts', 1);
    }

    public function test_the_contact_form_accepts_a_service_without_a_visibility_flag()
    {
        $user = User::factory()->create();
        $product = $this->createProduct();

        $this->actingAs($user)->post(route('contact.submit'), [
            'product_id' => $product->id,
            'sender_phone' => '08123456789',
            'message' => 'Mohon informasi layanan ini.',
        ])->assertRedirect(route('contact'))
            ->assertSessionHas('success', 'Permintaan layanan berhasil dikirim.');

        $this->assertDatabaseHas('contacts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'status' => ServiceRequest::STATUS_WAITING,
        ]);
        $this->assertDatabaseCount('contacts', 1);
    }

    public function test_service_request_statuses_use_colored_labels_in_contact_history()
    {
        $user = User::factory()->create();
        $product = $this->createProduct();

        foreach ([
            ServiceRequest::STATUS_APPROVED,
            ServiceRequest::STATUS_WAITING,
            ServiceRequest::STATUS_DECLINED,
        ] as $status) {
            ServiceRequest::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'sender_name' => $user->name,
                'sender_email' => $user->email,
                'sender_phone' => '08123456789',
                'status' => $status,
            ]);
        }

        $this->actingAs($user)
            ->get(route('contact'))
            ->assertOk()
            ->assertSee('<table', false)
            ->assertSee('<th scope="col"', false)
            ->assertSee('background: #eee8ff', false)
            ->assertSee('border-radius: 18px', false)
            ->assertSee('Disetujui')
            ->assertSee('Menunggu')
            ->assertSee('Ditolak')
            ->assertSee('color: #166534; background: #dcfce7;', false)
            ->assertSee('color: #92400e; background: #fef3c7;', false)
            ->assertSee('color: #b91c1c; background: #fee2e2;', false);
    }

    public function test_an_admin_can_update_the_request_status_in_filament()
    {
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]);
        $serviceRequest = ServiceRequest::create([
            'user_id' => User::factory()->create()->id,
            'product_id' => $this->createProduct()->id,
            'sender_name' => 'Pelanggan Uji',
            'sender_email' => 'customer@example.com',
            'sender_phone' => '08123456789',
            'message' => 'Mohon informasi lebih lanjut.',
            'status' => ServiceRequest::STATUS_WAITING,
        ]);

        Livewire::actingAs($admin, 'admin')
            ->test(EditServiceRequest::class, ['record' => $serviceRequest->getRouteKey()])
            ->fillForm(['status' => ServiceRequest::STATUS_APPROVED])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('contacts', [
            'id' => $serviceRequest->id,
            'status' => ServiceRequest::STATUS_APPROVED,
        ]);
    }

    public function test_product_and_gallery_forms_do_not_show_sort_order()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        Livewire::actingAs($admin, 'admin')
            ->test(CreateProduct::class)
            ->assertDontSee('Sort order');

        Livewire::actingAs($admin, 'admin')
            ->test(CreateGallery::class)
            ->assertDontSee('Sort order');
    }

    public function test_product_form_saves_the_entered_price()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        Livewire::actingAs($admin, 'admin')
            ->test(CreateProduct::class)
            ->fillForm([
                'name' => 'Layanan dengan harga',
                'slug' => 'layanan-dengan-harga',
                'price' => 'Rp 12.500.000 per bulan',
                'server_specs' => '4 vCPU, 8GB RAM',
                'short_description' => 'Layanan dengan harga khusus.',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('products', [
            'slug' => 'layanan-dengan-harga',
            'price' => 'Rp 12.500.000 per bulan',
        ]);
    }

    private function createProduct(array $attributes = [])
    {
        return Product::create(array_merge([
            'name' => 'Cloud Enterprise',
            'slug' => 'cloud-enterprise',
            'short_description' => 'Layanan cloud untuk bisnis.',
        ], $attributes));
    }
}
