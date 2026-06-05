/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      // ===== COLORS =====
      colors: {
        // Off-white/Cream Base
        'cream': '#FAFAF8',
        'sand': '#F5F3F0',
        'linen': '#F0EDE8',
        
        // Soft Beige/Taupe
        'taupe': '#E8DDD2',
        'beige': '#D4C5B8',
        'warm': '#C4B5A8',
        
        // Soft Accents (optional - use sparingly)
        'soft-gold': '#D4A574',
        'rose-gold': '#C18A6B',
        
        // Text & Borders
        'dark': '#3D3D3D',
        'dark-light': '#4A4A4A',
        'gray-light': '#C0C0C0',
        'gray-lighter': '#B0B0B0',
        'gray-lightest': '#A0A0A0',
        'gray-ultra-light': '#E5E5E5',
      },

      // ===== TYPOGRAPHY =====
      fontFamily: {
        // Use system fonts for now (we can upgrade to premium fonts later)
        serif: ['Georgia', 'Garamond', 'serif'],
        sans: ['Segoe UI', 'Roboto', 'sans-serif'],
      },
      fontSize: {
        'xs': ['12px', { lineHeight: '16px' }],
        'sm': ['14px', { lineHeight: '20px' }],
        'base': ['16px', { lineHeight: '24px' }],
        'lg': ['18px', { lineHeight: '28px' }],
        'xl': ['20px', { lineHeight: '28px' }],
        '2xl': ['24px', { lineHeight: '32px' }],
        '3xl': ['30px', { lineHeight: '36px' }],
        '4xl': ['36px', { lineHeight: '40px' }],
        '5xl': ['48px', { lineHeight: '48px' }],
      },

      // ===== SPACING (8px base unit) =====
      spacing: {
        '0': '0',
        '1': '8px',
        '2': '16px',
        '3': '24px',
        '4': '32px',
        '5': '40px',
        '6': '48px',
        '7': '56px',
        '8': '64px',
        '9': '72px',
        '10': '80px',
      },

      // ===== SHADOWS (subtle, luxury) =====
      boxShadow: {
        'xs': '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
        'sm': '0 1px 3px 0 rgba(0, 0, 0, 0.1)',
        'md': '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
        'lg': '0 10px 15px -3px rgba(0, 0, 0, 0.1)',
        'xl': '0 20px 25px -5px rgba(0, 0, 0, 0.1)',
        'elevation': '0 12px 24px rgba(0, 0, 0, 0.08)',
      },

      // ===== ANIMATIONS =====
      animation: {
        'fade-in': 'fadeIn 0.6s ease-out',
        'slide-up': 'slideUp 0.6s ease-out',
        'slide-down': 'slideDown 0.3s ease-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { opacity: '0', transform: 'translateY(10px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        slideDown: {
          '0%': { opacity: '0', transform: 'translateY(-10px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
      },

      // ===== TRANSITIONS =====
      transitionDuration: {
        '300': '300ms',
        '400': '400ms',
        '500': '500ms',
      },
      transitionTimingFunction: {
        'smooth': 'cubic-bezier(0.4, 0, 0.2, 1)',
      },
    },
  },
  plugins: [],
}