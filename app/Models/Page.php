<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;
    use HasRichText;

    /**
     * Les attributs qui doivent être gérés comme du texte riche.
     *
     * @var array
     */
    protected $richTextAttributes = [
        'content'
    ];

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'title',
        'content',
        'is_published'
    ];

    /**
     * Les règles de conversion d'attributs.
     *
     * @var array
     */
    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Récupère une page par son slug
     *
     * @param string $slug
     * @return Page|null
     */
    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)
            ->where('is_published', true)
            ->first();
    }

    /**
     * Accesseur qui garantit que le contenu est correctement décodé
     *
     * @return string
     */
    public function getDecodedContentAttribute()
    {
        return html_entity_decode($this->content);
    }
}
