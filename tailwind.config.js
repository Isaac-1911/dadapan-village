/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/views/**/*.blade.php",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#f0fdfa',
          600: '#0d9488',
          700: '#0f766e',
        },
      },
      fontFamily: {
        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
