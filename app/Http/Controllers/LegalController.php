<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Controller for legal pages (Privacy Policy, Imprint, Terms of Service).
 * 
 * Handles static legal content display with proper localization support.
 * All content is stored in translation files for multilingual support.
 */
class LegalController extends Controller
{
    /**
     * Display the privacy policy (Datenschutzerklärung).
     */
    public function privacy(): View
    {
        return view('pages.legal.privacy', [
            'title' => __('messages.legal.privacy.title'),
            'meta_description' => __('messages.legal.privacy.meta_description'),
        ]);
    }

    /**
     * Display the imprint (Impressum).
     */
    public function imprint(): View
    {
        return view('pages.legal.imprint', [
            'title' => __('messages.legal.imprint.title'),
            'meta_description' => __('messages.legal.imprint.meta_description'),
        ]);
    }

    /**
     * Display the terms of service (AGB).
     */
    public function terms(): View
    {
        return view('pages.legal.terms', [
            'title' => __('messages.legal.terms.title'),
            'meta_description' => __('messages.legal.terms.meta_description'),
        ]);
    }
}
