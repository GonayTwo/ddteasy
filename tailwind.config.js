/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
    "./app/Livewire/**/*.php",
    './app/Filament/**/*.php',
    './vendor/filament/**/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        'orange-ddteasy': '#F28A20',
        'full-transparent': 'transparent !important',
        'calendar': '#F28A20 !important',
        'color-opac': 'rgb(var(--color-opac) / 0.5)',
        'whatsapp': '#25D366'
      },
      boxShadow: {
        'personal': '0 25px 50px rgba(0,0,0,0.26)'
      },
      maxWidth: {
        'max600': '600px'
      }
    },
    flex: {
      'card': '1 0 20%'
    },
    fontFamily: {
      'poppins': ['Poppins']
    },
    backgroundImage: {
      'cta': "url('/public/images/display-cta.webp')",
      'parceiro': "url('/public/images/minibanner.webp')",
      'home-cta': "url('/public/images/home-cta.webp')"
    },
  },
  plugins: [
    require('flowbite/plugin'),
  ],
}

