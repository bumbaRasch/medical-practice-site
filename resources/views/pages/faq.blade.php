@extends('layouts.app')

@section('title', __('messages.faq.page_title') . ' - ' . __('messages.common.practice_name'))
@section('description', __('messages.faq.page_meta_description'))

@section('content')
<!-- Page Header -->
<section class="relative bg-gradient-to-br from-gentle-blue via-medical-light-blue to-gentle-mint py-20 overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 opacity-10">
        <svg class="absolute top-12 right-12 w-28 h-28 text-warm-green animate-pulse" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 7.5V9M15 11.5L21 12V14L15 13.5V15.5L21 16V18L15 17.5V19.5L21 20V22H3V20L9 19.5V17.5L3 18V16L9 15.5V13.5L3 14V12L9 11.5V9.5L3 10V8L9 7.5V5.5L3 6V4H21V6L15 5.5V7.5L21 8V10L15 9.5V11.5Z"></path>
        </svg>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 bg-white bg-opacity-90 rounded-full text-sm font-medium text-trust-blue mb-6 shadow-gentle">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ __('messages.faq.header_badge') }}
            </div>
            
            <h1 class="text-4xl md:text-5xl font-bold text-warm-gray-900 mb-6">
                {{ __('messages.faq.page_title') }}
            </h1>
            <p class="text-xl text-warm-gray-700 max-w-3xl mx-auto leading-relaxed">
                {{ __('messages.faq.page_subtitle') }}
            </p>
        </div>
    </div>
</section>

<!-- FAQ Content -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(count($faqData) > 0)
            @foreach($faqData as $categoryIndex => $categoryData)
            <!-- Category Section -->
            <div class="mb-12 {{ $loop->last ? '' : 'border-b border-gray-100 pb-12' }}">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-warm-gray-900 mb-4">
                        {{ $categoryData['category'] }}
                    </h2>
                    <div class="w-16 h-1 bg-gradient-to-r from-medical-blue to-trust-blue mx-auto rounded-full"></div>
                </div>

                <!-- Questions in this category -->
                <div class="space-y-4">
                    @foreach($categoryData['questions'] as $questionIndex => $question)
                    <div class="bg-gradient-to-br from-gentle-blue to-medical-light-blue rounded-2xl overflow-hidden shadow-soft hover:shadow-warm transition-all duration-500 ease-out">
                        <!-- Question Header (Clickable) -->
                        <button 
                            class="w-full px-6 py-5 text-left focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-80 group"
                            onclick="toggleFAQ('faq-{{ $categoryIndex }}-{{ $questionIndex }}')"
                            aria-expanded="false"
                            aria-controls="faq-{{ $categoryIndex }}-{{ $questionIndex }}-content"
                        >
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-warm-gray-900 group-hover:text-medical-blue transition-colors pr-4">
                                    {{ $question['question'] }}
                                </h3>
                                <div class="flex-shrink-0">
                                    <svg 
                                        class="w-6 h-6 text-trust-blue transform transition-transform duration-300 ease-out" 
                                        id="faq-{{ $categoryIndex }}-{{ $questionIndex }}-icon"
                                        fill="none" 
                                        stroke="currentColor" 
                                        viewBox="0 0 24 24"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </button>
                        
                        <!-- Answer Content (Collapsible) -->
                        <div 
                            id="faq-{{ $categoryIndex }}-{{ $questionIndex }}-content"
                            class="faq-content hidden"
                            role="region"
                            aria-labelledby="faq-{{ $categoryIndex }}-{{ $questionIndex }}"
                        >
                            <div class="px-6 pb-6">
                                <div class="bg-white bg-opacity-70 rounded-xl p-6 shadow-gentle">
                                    <p class="text-warm-gray-700 leading-relaxed">
                                        {{ $question['answer'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        @else
            <div class="text-center py-16">
                <div class="bg-gradient-to-br from-medical-light-blue to-blue-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-medical-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">
                    {{ __('messages.faq.no_results') }}
                </h3>
                <p class="text-gray-600 max-w-md mx-auto">
                    {{ __('messages.faq.contact_cta_text') }}
                </p>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-br from-medical-light-blue to-gentle-mint relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <svg class="absolute top-16 left-16 w-40 h-40 text-trust-blue" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 7.5V9M15 11.5L21 12V14L15 13.5V15.5L21 16V18L15 17.5V19.5L21 20V22H3V20L9 19.5V17.5L3 18V16L9 15.5V13.5L3 14V12L9 11.5V9.5L3 10V8L9 7.5V5.5L3 6V4H21V6L15 5.5V7.5L21 8V10L15 9.5V11.5Z"></path>
        </svg>
        <svg class="absolute bottom-16 right-16 w-32 h-32 text-warm-green" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
        </svg>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
        <div class="bg-white bg-opacity-90 backdrop-blur-sm rounded-3xl p-12 shadow-warm">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-medical-blue to-trust-blue rounded-2xl mb-8">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            
            <h2 class="text-4xl font-bold text-warm-gray-900 mb-6">
                {{ __('messages.faq.contact_cta_title') }}
            </h2>
            <p class="text-xl text-warm-gray-600 mb-10 max-w-3xl mx-auto leading-relaxed">
                {{ __('messages.faq.contact_cta_text') }}
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ route('contact') }}" 
                   class="group bg-gradient-to-r from-medical-blue-dark to-trust-blue text-white px-10 py-4 rounded-2xl font-bold text-lg hover:shadow-warm transform hover:-translate-y-1 transition-all duration-500 ease-out flex items-center justify-center focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-80">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    {{ __('messages.faq.contact_cta_button') }}
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-400 ease-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                
                <a href="tel:+49123456789" 
                   class="group bg-white border-2 border-trust-blue text-trust-blue px-10 py-4 rounded-2xl font-bold text-lg hover:bg-trust-blue hover:text-white transition-all duration-500 ease-out flex items-center justify-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Jetzt anrufen
                </a>
            </div>
        </div>
    </div>
</section>

<script>
/**
 * Enhanced FAQ System with Accessibility and Deep Linking
 * Medical practice optimized with keyboard navigation and screen reader support
 */
class MedicalFAQ {
    constructor() {
        this.faqItems = document.querySelectorAll('[id^="faq-"]');
        this.openItems = new Set();
        this.liveRegion = document.getElementById('live-region');
        this.isInitialized = false;
        
        this.init();
    }
    
    init() {
        if (this.isInitialized) return;
        
        this.setupInitialState();
        this.setupKeyboardNavigation();
        this.setupDeepLinking();
        this.setupReducedMotion();
        this.isInitialized = true;
        
        // Check URL for deep linking on load
        this.handleDeepLink();
    }
    
    setupInitialState() {
        const faqContents = document.querySelectorAll('.faq-content');
        faqContents.forEach(content => {
            content.style.transition = 'max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease-out';
            content.style.maxHeight = '0px';
            content.style.overflow = 'hidden';
            content.style.opacity = '0';
        });
    }
    
    setupKeyboardNavigation() {
        document.addEventListener('keydown', (e) => {
            const target = e.target;
            
            // Handle FAQ button keyboard navigation
            if (target.matches('button[aria-controls]')) {
                switch(e.key) {
                    case 'Enter':
                    case ' ':
                        e.preventDefault();
                        this.toggleFAQ(target);
                        break;
                    case 'ArrowDown':
                        e.preventDefault();
                        this.focusNextFAQ(target);
                        break;
                    case 'ArrowUp':
                        e.preventDefault();
                        this.focusPreviousFAQ(target);
                        break;
                    case 'Home':
                        e.preventDefault();
                        this.focusFirstFAQ();
                        break;
                    case 'End':
                        e.preventDefault();
                        this.focusLastFAQ();
                        break;
                    case 'Escape':
                        if (this.isFAQOpen(target)) {
                            this.closeFAQ(target);
                        }
                        break;
                }
            }
        });
    }
    
    setupDeepLinking() {
        // Update URL when FAQ is opened
        window.addEventListener('popstate', () => {
            this.handleDeepLink();
        });
    }
    
    setupReducedMotion() {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            const faqContents = document.querySelectorAll('.faq-content');
            faqContents.forEach(content => {
                content.style.transition = 'none';
            });
        }
    }
    
    handleDeepLink() {
        const hash = window.location.hash;
        if (hash && hash.startsWith('#faq-')) {
            const faqId = hash.substring(1);
            const button = document.querySelector(`button[aria-controls="${faqId}-content"]`);
            if (button) {
                setTimeout(() => {
                    this.openFAQ(button);
                    button.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    button.focus();
                }, 100);
            }
        }
    }
    
    toggleFAQ(buttonOrId) {
        const button = typeof buttonOrId === 'string' ? 
            document.querySelector(`button[onclick*="${buttonOrId}"]`) : buttonOrId;
        
        if (!button) return;
        
        const isOpen = this.isFAQOpen(button);
        
        if (isOpen) {
            this.closeFAQ(button);
        } else {
            this.openFAQ(button);
        }
    }
    
    openFAQ(button) {
        const contentId = button.getAttribute('aria-controls');
        const content = document.getElementById(contentId);
        const icon = button.querySelector('svg');
        const faqId = contentId.replace('-content', '');
        
        if (!content) return;
        
        // Close other FAQs in same category (optional - uncomment for accordion behavior)
        // this.closeOthersInCategory(button);
        
        // Open this FAQ
        content.classList.remove('hidden');
        content.style.maxHeight = content.scrollHeight + 'px';
        content.style.opacity = '1';
        
        // Update button state
        button.setAttribute('aria-expanded', 'true');
        if (icon) icon.style.transform = 'rotate(180deg)';
        
        // Track open state
        this.openItems.add(faqId);
        
        // Update URL for deep linking
        this.updateURL(faqId);
        
        // Announce to screen readers
        const questionText = button.querySelector('h3')?.textContent || 'FAQ';
        this.announceToScreenReader(`${questionText} geöffnet`);
        
        // Analytics tracking
        this.trackFAQInteraction('open', faqId, questionText);
    }
    
    closeFAQ(button) {
        const contentId = button.getAttribute('aria-controls');
        const content = document.getElementById(contentId);
        const icon = button.querySelector('svg');
        const faqId = contentId.replace('-content', '');
        
        if (!content) return;
        
        // Close this FAQ
        content.style.maxHeight = '0px';
        content.style.opacity = '0';
        
        // Update button state
        button.setAttribute('aria-expanded', 'false');
        if (icon) icon.style.transform = 'rotate(0deg)';
        
        // Hide after animation
        setTimeout(() => {
            if (!this.isFAQOpen(button)) {
                content.classList.add('hidden');
            }
        }, 400);
        
        // Track open state
        this.openItems.delete(faqId);
        
        // Update URL
        if (window.location.hash === `#${faqId}`) {
            history.replaceState(null, null, window.location.pathname);
        }
        
        // Announce to screen readers
        const questionText = button.querySelector('h3')?.textContent || 'FAQ';
        this.announceToScreenReader(`${questionText} geschlossen`);
        
        // Analytics tracking
        this.trackFAQInteraction('close', faqId, questionText);
    }
    
    closeOthersInCategory(currentButton) {
        const currentCategory = currentButton.closest('.mb-12');
        if (!currentCategory) return;
        
        const otherButtons = currentCategory.querySelectorAll('button[aria-expanded="true"]');
        otherButtons.forEach(button => {
            if (button !== currentButton) {
                this.closeFAQ(button);
            }
        });
    }
    
    isFAQOpen(button) {
        return button.getAttribute('aria-expanded') === 'true';
    }
    
    focusNextFAQ(currentButton) {
        const allButtons = Array.from(document.querySelectorAll('button[aria-controls]'));
        const currentIndex = allButtons.indexOf(currentButton);
        const nextButton = allButtons[currentIndex + 1] || allButtons[0];
        nextButton.focus();
    }
    
    focusPreviousFAQ(currentButton) {
        const allButtons = Array.from(document.querySelectorAll('button[aria-controls]'));
        const currentIndex = allButtons.indexOf(currentButton);
        const prevButton = allButtons[currentIndex - 1] || allButtons[allButtons.length - 1];
        prevButton.focus();
    }
    
    focusFirstFAQ() {
        const firstButton = document.querySelector('button[aria-controls]');
        if (firstButton) firstButton.focus();
    }
    
    focusLastFAQ() {
        const buttons = document.querySelectorAll('button[aria-controls]');
        const lastButton = buttons[buttons.length - 1];
        if (lastButton) lastButton.focus();
    }
    
    updateURL(faqId) {
        const newURL = `${window.location.pathname}#${faqId}`;
        history.replaceState(null, null, newURL);
    }
    
    announceToScreenReader(message) {
        if (this.liveRegion) {
            this.liveRegion.textContent = message;
        }
    }
    
    trackFAQInteraction(action, faqId, questionText) {
        // Google Analytics tracking
        if (typeof gtag !== 'undefined') {
            gtag('event', 'faq_interaction', {
                event_category: 'engagement',
                event_label: faqId,
                action: action,
                question: questionText
            });
        }
    }
    
    // Public API methods
    openAll() {
        const allButtons = document.querySelectorAll('button[aria-controls]');
        allButtons.forEach(button => this.openFAQ(button));
    }
    
    closeAll() {
        const allButtons = document.querySelectorAll('button[aria-controls]');
        allButtons.forEach(button => this.closeFAQ(button));
    }
    
    searchFAQs(query) {
        const results = [];
        const allButtons = document.querySelectorAll('button[aria-controls]');
        
        allButtons.forEach(button => {
            const questionText = button.querySelector('h3')?.textContent || '';
            const contentId = button.getAttribute('aria-controls');
            const content = document.getElementById(contentId);
            const answerText = content?.textContent || '';
            
            if (questionText.toLowerCase().includes(query.toLowerCase()) ||
                answerText.toLowerCase().includes(query.toLowerCase())) {
                results.push({
                    button,
                    question: questionText,
                    answer: answerText
                });
            }
        });
        
        return results;
    }
}

// Global function for onclick compatibility
function toggleFAQ(faqId) {
    if (window.medicalFAQ) {
        window.medicalFAQ.toggleFAQ(faqId);
    }
}

// Initialize FAQ system
document.addEventListener('DOMContentLoaded', function() {
    window.medicalFAQ = new MedicalFAQ();
    
    // Add visual focus indicators for better accessibility
    const style = document.createElement('style');
    style.textContent = `
        .faq-content {
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                       opacity 0.3s ease-out !important;
        }
        
        @media (prefers-reduced-motion: reduce) {
            .faq-content {
                transition: none !important;
            }
        }
        
        button[aria-controls]:focus {
            outline: 3px solid var(--color-medical-blue);
            outline-offset: 2px;
            border-radius: 8px;
        }
        
        button[aria-controls]:focus-visible {
            box-shadow: 0 0 0 4px rgba(59, 123, 184, 0.2);
        }
        
        .faq-content:focus-within {
            outline: 2px solid var(--color-medical-blue);
            outline-offset: 4px;
        }
    `;
    document.head.appendChild(style);
});

// FAQ search functionality (if search is added later)
function initFAQSearch() {
    const searchInput = document.getElementById('faq-search');
    if (!searchInput) return;
    
    let searchTimeout;
    searchInput.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const query = e.target.value.trim();
            if (query.length > 2) {
                const results = window.medicalFAQ.searchFAQs(query);
                highlightFAQResults(results);
            } else {
                clearFAQHighlights();
            }
        }, 300);
    });
}

function highlightFAQResults(results) {
    // Hide all FAQ items first
    const allFAQItems = document.querySelectorAll('[id^="faq-"]');
    allFAQItems.forEach(item => {
        item.style.display = 'none';
    });
    
    // Show matching items
    results.forEach(result => {
        const faqItem = result.button.closest('[id^="faq-"]');
        if (faqItem) {
            faqItem.style.display = 'block';
        }
    });
    
    // Announce results
    if (window.medicalFAQ) {
        window.medicalFAQ.announceToScreenReader(`${results.length} FAQ-Ergebnisse gefunden`);
    }
}

function clearFAQHighlights() {
    const allFAQItems = document.querySelectorAll('[id^="faq-"]');
    allFAQItems.forEach(item => {
        item.style.display = 'block';
    });
}
</script>
@endsection