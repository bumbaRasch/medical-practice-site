<?php

namespace App\Http\Controllers;

use App\Services\CacheService;
use Illuminate\View\View;

class ServicesController extends Controller
{
    public function __construct(
        private readonly CacheService $cacheService
    ) {
    }

    /**
     * Display the services page with cached content.
     */
    public function index(): View
    {
        /** @var array<int, array<string, string>> $services */
        $services = $this->cacheService->getPracticeServices();
        
        return view('pages.services.index', compact('services'));
    }
}
