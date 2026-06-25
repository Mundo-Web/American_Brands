<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\ClientLogos;
use App\Models\Products;
use App\Models\SubCategory;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $baseUrl = rtrim(config('app.url'), '/');

        // ── Páginas estáticas ────────────────────────────────────────
        $staticPages = [
            ['url' => '/',                          'changefreq' => 'daily',   'priority' => '1.0'],
            ['url' => '/catalogo',                  'changefreq' => 'daily',   'priority' => '0.9'],
            ['url' => '/ofertas',                   'changefreq' => 'daily',   'priority' => '0.9'],
            ['url' => '/nosotros',                  'changefreq' => 'monthly', 'priority' => '0.7'],
            ['url' => '/contacto',                  'changefreq' => 'monthly', 'priority' => '0.7'],
            ['url' => '/comentario',                'changefreq' => 'weekly',  'priority' => '0.5'],
            ['url' => '/blog/0',                    'changefreq' => 'weekly',  'priority' => '0.8'],
            ['url' => '/libro-de-reclamaciones',    'changefreq' => 'yearly',  'priority' => '0.3'],
            ['url' => '/politicas-de-devolucion',   'changefreq' => 'yearly',  'priority' => '0.3'],
            ['url' => '/terminos-y-condiciones',    'changefreq' => 'yearly',  'priority' => '0.3'],
            ['url' => '/ayuda',                     'changefreq' => 'monthly', 'priority' => '0.5'],
        ];

        // ── Productos ────────────────────────────────────────────────
        $products = Products::where('status', 1)
            ->where('visible', 1)
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->select('slug', 'updated_at')
            ->get();

        // ── Categorías (para filtro de catálogo) ─────────────────────
        $categories = Category::where('status', 1)
            ->where('visible', 1)
            ->select('id', 'updated_at')
            ->get();

        // ── Subcategorías (para filtro de catálogo) ──────────────────
        $subcategories = SubCategory::where('visible', 1)
            ->select('id', 'updated_at')
            ->get();

        // ── Marcas (para filtro de catálogo) ─────────────────────────
        $brands = ClientLogos::where('status', 1)
            ->where('visible', 1)
            ->select('id', 'updated_at')
            ->get();

        // ── Blog posts ───────────────────────────────────────────────
        $posts = Blog::where('status', 1)
            ->where('visible', 1)
            ->select('id', 'updated_at')
            ->get();

        // ── Construir XML ────────────────────────────────────────────
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Páginas estáticas
        foreach ($staticPages as $page) {
            $xml .= $this->buildUrl(
                $baseUrl . $page['url'],
                now()->toW3cString(),
                $page['changefreq'],
                $page['priority']
            );
        }

        // Productos
        foreach ($products as $product) {
            $xml .= $this->buildUrl(
                $baseUrl . '/producto/' . $product->slug,
                $product->updated_at->toW3cString(),
                'weekly',
                '0.8'
            );
        }

        // Categorías
        foreach ($categories as $category) {
            $xml .= $this->buildUrl(
                $baseUrl . '/catalogo?category=' . $category->id,
                $category->updated_at->toW3cString(),
                'weekly',
                '0.7'
            );
        }

        // Subcategorías
        foreach ($subcategories as $subcategory) {
            $xml .= $this->buildUrl(
                $baseUrl . '/catalogo?subcategoria=' . $subcategory->id,
                $subcategory->updated_at->toW3cString(),
                'weekly',
                '0.6'
            );
        }

        // Marcas
        foreach ($brands as $brand) {
            $xml .= $this->buildUrl(
                $baseUrl . '/catalogo?marcas=' . $brand->id,
                $brand->updated_at->toW3cString(),
                'weekly',
                '0.6'
            );
        }

        // Blog posts
        foreach ($posts as $post) {
            $xml .= $this->buildUrl(
                $baseUrl . '/post/' . $post->id,
                $post->updated_at->toW3cString(),
                'monthly',
                '0.7'
            );
        }

        $xml .= '</urlset>';

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    /**
     * Construye un bloque <url> del sitemap.
     */
    private function buildUrl(string $loc, string $lastmod, string $changefreq, string $priority): string
    {
        return "  <url>\n"
             . "    <loc>" . htmlspecialchars($loc, ENT_XML1, 'UTF-8') . "</loc>\n"
             . "    <lastmod>{$lastmod}</lastmod>\n"
             . "    <changefreq>{$changefreq}</changefreq>\n"
             . "    <priority>{$priority}</priority>\n"
             . "  </url>\n";
    }
}
