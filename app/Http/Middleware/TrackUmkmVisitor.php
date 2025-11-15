<?php

namespace App\Http\Middleware;

use App\Models\UmkmBusiness;
use App\Models\UmkmVisitor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackUmkmVisitor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track GET requests
        if (!$request->isMethod('GET')) {
            return $response;
        }

        // Skip tracking for admin routes
        if ($request->is('admin/*')) {
            return $response;
        }

        // Get UMKM business from request
        $umkmBusiness = $this->getUmkmBusiness($request);

        if (!$umkmBusiness) {
            return $response;
        }

        // Track visitor
        $this->trackVisitor($request, $umkmBusiness);

        // Update visits_count on UmkmBusiness
        $umkmBusiness->increment('visits_count');

        return $response;
    }

    /**
     * Get UMKM business from request
     */
    protected function getUmkmBusiness(Request $request): ?UmkmBusiness
    {
        $host = $request->getHost();
        $subdomain = null;
        
        // Extract subdomain from host
        if (strpos($host, '.') !== false) {
            $parts = explode('.', $host);
            $subdomain = $parts[0];
        }
        
        if ($subdomain) {
            return UmkmBusiness::where('subdomain', $subdomain)
                ->where('status', 'active')
                ->first();
        }

        return null;
    }

    /**
     * Track visitor
     */
    protected function trackVisitor(Request $request, UmkmBusiness $umkmBusiness): void
    {
        // Detect page type
        $pageType = $this->detectPageType($request);
        $pagePath = $request->path();
        $productId = null;

        // Extract product ID if viewing product detail
        if ($pageType === 'product_detail' && $request->route('id')) {
            $product = \App\Models\UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
                ->where(function($query) use ($request) {
                    $id = $request->route('id');
                    if (is_numeric($id)) {
                        $query->where('id', $id);
                    } else {
                        $query->where('slug', $id);
                    }
                })
                ->first();
            
            if ($product) {
                $productId = $product->id;
            }
        }

        // Detect source from referrer
        $referrer = $request->header('referer');
        $sourceData = UmkmVisitor::detectSource($referrer);

        // Create visitor record
        UmkmVisitor::create([
            'umkm_business_id' => $umkmBusiness->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referrer' => $referrer,
            'source' => $sourceData['source'],
            'source_detail' => $sourceData['source_detail'],
            'page_path' => $pagePath,
            'page_type' => $pageType,
            'product_id' => $productId,
            'visited_at' => now(),
        ]);
    }

    /**
     * Detect page type from request
     */
    protected function detectPageType(Request $request): string
    {
        $path = $request->path();

        if ($path === 'umkm' || $path === '') {
            return 'home';
        }

        if (str_contains($path, 'product')) {
            if ($request->route('id')) {
                return 'product_detail';
            }
            return 'product';
        }

        if (str_contains($path, 'about')) {
            return 'about';
        }

        return 'other';
    }
}
