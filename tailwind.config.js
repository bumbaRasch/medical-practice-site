/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './app/**/*.php',
    './resources/views/**/*.php',
    './resources/views/components/**/*.php',
    './resources/views/pages/**/*.php',
    './resources/views/layouts/**/*.php',
  ],
  darkMode: 'class', // Enable class-based dark mode switching
  safelist: [
    // Dynamic classes that might be generated programmatically
    'text-medical-blue',
    'text-trust-blue', 
    'text-soft-green',
    'bg-medical-blue',
    'bg-trust-blue',
    'bg-medical-light-blue',
    'bg-gentle-blue',
    'bg-healing-mint',
    'bg-warm-gray-50',
    'bg-warm-gray-100',
    'border-medical-blue',
    'border-trust-blue',
    'hover:bg-trust-blue',
    'hover:text-white',
    'shadow-card',
    'shadow-floating',
    'shadow-soft',
    'rounded-2xl',
    'rounded-3xl',
    // Animation classes
    'animate-pulse',
    'animate-gentle-pulse',
    'transform',
    'hover:-translate-y-1',
    'hover:-translate-y-2',
    'hover:-translate-y-3',
    'transition-all',
    'duration-300',
    'duration-500',
    // Focus states
    'focus:ring-4',
    'focus:ring-medical-blue',
    'focus:ring-white',
    'focus:outline-none',
  ],
  theme: {
    extend: {
      colors: {
        // Dark theme colors for medical practice
        'dark-bg': {
          'primary': '#0f172a',    // Deep navy background
          'secondary': '#1e293b',  // Secondary dark surface  
          'tertiary': '#334155',   // Card backgrounds
        },
        'dark-surface': '#475569',       // Elevated surfaces
        'dark-text': {
          'primary': '#f1f5f9',    // Primary text - soft white
          'secondary': '#cbd5e1',  // Secondary text 
          'muted': '#94a3b8',      // Muted text
        },
        'dark-medical': {
          'blue': '#60a5fa',       // Lighter blue for dark backgrounds
          'blue-light': '#93c5fd', // Even lighter for accents
        },
        'dark-accent': {
          'teal': '#22d3ee',       // Healing teal accent
          'mint': '#6ee7b7',       // Soft mint for health indicators
        },
        'dark-border': '#475569',        // Subtle borders
        'dark-border-light': '#64748b',  // Lighter borders
      },
    },
  },
  corePlugins: {
    // Enable JIT mode features
    preflight: true,
  },
}