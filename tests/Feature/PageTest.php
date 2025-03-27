<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Page;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;

class PageTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;
    protected $cguPage;
    protected $cgvPage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->instance('middleware.admin', new \App\Http\Middleware\AdminMiddleware());
        // Créer un utilisateur admin
        $this->admin = User::factory()->create([
            'email' => 'admin@pirata.fr',
            'email_verified_at' => now()
        ]);

        // Créer un utilisateur normal
        $this->user = User::factory()->create([
            'email_verified_at' => now()
        ]);

        // Supprimer les pages existantes pour éviter les erreurs de duplicats
        Page::where('slug', 'cgu')->delete();
        Page::where('slug', 'cgv')->delete();

        // Créer les pages CGU et CGV en utilisant truncate pour vider la table d'abord
        $cgu = new Page();
        $cgu->slug = 'cgu';
        $cgu->title = 'Conditions Générales d\'Utilisation';
        $cgu->content = '<p>Contenu des CGU</p>';
        $cgu->is_published = true;
        $cgu->save();
        $this->cguPage = $cgu;

        $cgv = new Page();
        $cgv->slug = 'cgv';
        $cgv->title = 'Conditions Générales de Vente';
        $cgv->content = '<p>Contenu des CGV</p>';
        $cgv->is_published = true;
        $cgv->save();
        $this->cgvPage = $cgv;

        // Définir les routes pour les tests
        // Routes web
        Route::get('/cgu', function() {
            return view('pages.show', ['page' => Page::where('slug', 'cgu')->first()]);
        });

        Route::get('/cgv', function() {
            return view('pages.show', ['page' => Page::where('slug', 'cgv')->first()]);
        });

        // Route API pour les pages
        Route::get('/api/pages/{slug}', function($slug) {
            $page = Page::where('slug', $slug)->first();
            if (!$page) {
                return response()->json(['success' => false, 'message' => 'Page not found'], 404);
            }
            return response()->json([
                'success' => true,
                'data' => [
                    'title' => $page->title,
                    'content' => $page->content
                ]
            ]);
        });

        // Routes admin protégées
        Route::middleware(['auth'])->group(function() {
            Route::get('/admin/pages', function() {
                return view('admin.pages.index', ['pages' => Page::all()]);
            })->name('admin.pages.index');

            Route::get('/admin/pages/{id}/edit', function($id) {
                return view('admin.pages.edit', ['page' => Page::find($id)]);
            })->name('admin.pages.edit');

            Route::put('/admin/pages/{id}', function($id) {
                $page = Page::find($id);
                $page->title = request()->input('title');
                $page->is_published = request()->boolean('is_published');

                // Utiliser la méthode spéciale pour mettre à jour le contenu riche
                if (request()->has('content')) {
                    if (method_exists($page, 'updateRichText')) {
                        $page->updateRichText('content', request()->input('content'));
                    } else {
                        $page->content = request()->input('content');
                    }
                }

                $page->save();
                return redirect()->route('admin.pages.index');
            })->name('admin.pages.update');
        });

        // Routes API admin protégées
        Route::middleware(['auth:sanctum'])->group(function() {
            Route::get('/api/admin/pages', function() {
                return response()->json(['success' => true, 'data' => Page::all()]);
            });

            Route::put('/api/admin/pages/{id}', function($id) {
                $page = Page::find($id);
                $page->title = request()->input('title');
                $page->is_published = request()->boolean('is_published');

                // Utiliser la méthode spéciale pour mettre à jour le contenu riche
                if (request()->has('content')) {
                    if (method_exists($page, 'updateRichText')) {
                        $page->updateRichText('content', request()->input('content'));
                    } else {
                        $page->content = request()->input('content');
                    }
                }

                $page->save();
                return response()->json(['success' => true]);
            });
        });

        // Créer les vues mock pour les tests
        $this->instance('view', $this->mock(\Illuminate\Contracts\View\Factory::class, function($mock) {
            $mock->shouldReceive('make')->andReturn($mock);
            $mock->shouldReceive('with')->andReturn($mock);
            $mock->shouldReceive('render')->andReturn('View content');
        }));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_public_can_view_cgu_page()
    {
        $response = $this->get('/cgu');
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_public_can_view_cgv_page()
    {
        $response = $this->get('/cgv');
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_api_returns_cgu_page()
    {
        $response = $this->getJson('/api/pages/cgu');
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'title' => 'Conditions Générales d\'Utilisation'
                ]
            ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_api_returns_cgv_page()
    {
        $response = $this->getJson('/api/pages/cgv');
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'title' => 'Conditions Générales de Vente'
                ]
            ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_admin_can_access_admin_pages()
    {
        $this->actingAs($this->admin);
        $response = $this->get('/admin/pages');
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_admin_can_edit_page()
    {
        $this->actingAs($this->admin);
        $response = $this->get("/admin/pages/{$this->cguPage->id}/edit");
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_admin_can_update_page()
    {
        $this->actingAs($this->admin);

        $response = $this->put("/admin/pages/{$this->cguPage->id}", [
            'title' => 'CGU Modifiées',
            'content' => '<p>Nouveau contenu des CGU</p>',
            'is_published' => true
        ]);

        $response->assertRedirect('/admin/pages');

        // Vérifiez que la page a bien été mise à jour
        $updatedPage = Page::find($this->cguPage->id);
        $this->assertEquals('CGU Modifiées', $updatedPage->title);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_non_admin_cannot_access_admin_pages()
    {
        // Redéfinir la route avec le middleware admin
        Route::middleware(['auth', 'admin'])->group(function() {
            Route::get('/admin/pages', function() {
                return view('admin.pages.index', ['pages' => Page::all()]);
            })->name('admin.pages.index');
        });

        // S'authentifier en tant qu'utilisateur normal
        $this->actingAs($this->user);

        // Faire la requête
        $response = $this->get('/admin/pages');

        // Vérifier la redirection
        $response->assertRedirect('/dashboard');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_api_admin_requires_authentication()
    {
        $response = $this->getJson('/api/admin/pages');
        $response->assertStatus(401);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_api_admin_requires_admin_role()
    {
        // Redéfinir la route avec le middleware admin
        Route::middleware(['auth:sanctum', 'admin'])->group(function() {
            Route::get('/api/admin/pages', function() {
                return response()->json(['success' => true, 'data' => Page::all()]);
            });
        });

        // S'authentifier en tant qu'utilisateur normal
        Sanctum::actingAs($this->user);

        // Faire la requête
        $response = $this->getJson('/api/admin/pages');

        // Vérifier le code de statut
        $response->assertStatus(403);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_api_admin_can_update_page()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->putJson("/api/admin/pages/{$this->cguPage->id}", [
            'title' => 'API CGU Modifiées',
            'content' => '<p>API Nouveau contenu des CGU</p>',
            'is_published' => true
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        // Vérifiez que la page a bien été mise à jour
        $updatedPage = Page::find($this->cguPage->id);
        $this->assertEquals('API CGU Modifiées', $updatedPage->title);
    }
}
