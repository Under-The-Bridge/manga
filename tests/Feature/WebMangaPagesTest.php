<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WebMangaPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_four_design_pages_render_with_the_shared_layout(): void
    {
        foreach (['/' => 'Коллекции сообщества', '/login' => 'Войти', '/register' => 'Зарегистрироваться', '/manga/fullmetal-alchemist' => 'Hagane no Renkinjutsushi'] as $url => $heading) {
            $this->get($url)->assertOk()->assertSee($heading)->assertSee('lang="ru"', false)->assertSee('© 2026 WebManga · by Ramz');
        }
    }

    public function test_manga_page_excludes_related_and_similar_sections(): void
    {
        $this->get('/manga/fullmetal-alchemist')->assertOk()->assertSee('Оценки пользователей')->assertDontSee('Связанное')->assertDontSee('Похожее');
        $this->get('/manga/not-a-title')->assertNotFound();
    }

    public function test_search_and_genres_filter_titles(): void
    {
        $this->get('/?q='.urlencode('Хеллсинг'))->assertOk()->assertSee('Хеллсинг')->assertDontSee('Стил-Болл-Ран');
        $this->get('/?genre='.urlencode('Ужасы'))->assertOk()->assertSee('Хеллсинг')->assertDontSee('Стил-Болл-Ран');
        $this->get('/?q=not-a-title')->assertOk()->assertSee('Манга не найдена');
    }

    public function test_registration_creates_a_user_with_a_hashed_password(): void
    {
        $this->post('/register', ['name' => 'Reader', 'email' => 'reader@example.com', 'password' => 'password123'])->assertRedirect('/');
        $user = User::where('email', 'reader@example.com')->firstOrFail();
        $this->assertTrue(Hash::check('password123', $user->password));
        $this->assertAuthenticatedAs($user);
        $this->get('/')->assertOk()->assertSee('Выйти');
    }

    public function test_registration_rejects_duplicate_emails_and_short_passwords(): void
    {
        User::factory()->create(['email' => 'reader@example.com']);
        $this->from('/register')->post('/register', ['name' => 'Reader', 'email' => 'reader@example.com', 'password' => 'short'])->assertRedirect('/register')->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }

    public function test_login_and_logout_work(): void
    {
        $user = User::factory()->create(['password' => Hash::make('password123')]);
        $this->post('/login', ['email' => $user->email, 'password' => 'password123'])->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_wrong_credentials_are_rejected_without_exposing_the_password(): void
    {
        $this->from('/login')->post('/login', ['email' => 'missing@example.com', 'password' => 'wrong-password'])->assertRedirect('/login')->assertSessionHasErrors('email')->assertSessionMissing('_old_input.password');
        $this->assertGuest();
    }

    public function test_login_attempts_are_rate_limited(): void
    {
        for ($i = 0; $i < 6; $i++) {
            $this->post('/login', ['email' => 'missing@example.com', 'password' => 'wrong-password'])->assertStatus(302);
        }
        $this->post('/login', ['email' => 'missing@example.com', 'password' => 'wrong-password'])->assertStatus(429);
    }
}
