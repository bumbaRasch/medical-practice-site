<?php

namespace App\Http\Controllers;

use App\Services\CacheService;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function __construct(
        private readonly CacheService $cacheService
    ) {
    }

    /**
     * Display the team page with cached content.
     */
    public function index(): View
    {
        $locale = app()->getLocale();
        
        /** @var array<int, array<string, string|null>> $team */
        $team = $this->cacheService->getPracticeTeamLocalized($locale);
        
        return view('pages.team', compact('team'));
    }
}
