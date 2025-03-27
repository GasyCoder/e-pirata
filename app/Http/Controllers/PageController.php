<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;

class PageController extends Controller
{
    /**
     * Affiche une page spécifique en frontend.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function show($slug = null)
    {
        // Si le slug est fourni via le paramètre route::defaults
        if (!$slug) {
            $slug = request()->route()->defaults['slug'] ?? null;
        }

        // Convertir en minuscules pour standardiser
        $slug = strtolower($slug);

        // Logging pour débogage
        \Log::info("Tentative d'accès à la page avec slug: " . $slug);

        $page = Page::where('slug', $slug)->first();

        if (!$page) {
            \Log::warning("Page non trouvée pour le slug: " . $slug);
            if (request()->expectsJson()) {
                return ApiResource::error('Page non trouvée', null, 404);
            }
            abort(404, 'Page non trouvée');
        }

        if (!$page->is_published) {
            \Log::warning("Tentative d'accès à une page non publiée: " . $slug);
            if (request()->expectsJson()) {
                return ApiResource::error('Cette page n\'est pas disponible', null, 403);
            }
            abort(403, 'Cette page n\'est pas disponible');
        }

        // Si la requête attend du JSON, renvoyer une réponse API
        if (request()->expectsJson()) {
            return ApiResource::success([
                'title' => $page->title,
                'content' => $page->content,
                'updated_at' => $page->updated_at
            ]);
        }

        // Sinon, renvoyer une vue
        return view('pages.show', compact('page'));
    }

    /**
     * Affiche la liste des pages dans l'administration.
     * Cette méthode doit être protégée par un middleware admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pages = Page::all();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Affiche le formulaire de modification d'une page.
     * Cette méthode doit être protégée par un middleware admin.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Met à jour une page.
     * Cette méthode doit être protégée par un middleware admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'is_published' => 'boolean'
        ]);

        $page = Page::findOrFail($id);
        $page->title = $request->title;
        $page->content = $request->content; // Le contenu de Trix est du HTML
        $page->is_published = $request->boolean('is_published');
        $page->save();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page mise à jour avec succès');
    }
}
