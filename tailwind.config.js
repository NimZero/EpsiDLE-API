const plugin = require('tailwindcss/plugin')

/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    './assets/**/*.js',
    './templates/**/*.html.twig',
    './node_modules/flowbite/**/*.js',
  ],
  plugins: [
    require('flowbite/plugin'),
    plugin(
      ({ addVariant }) => {
        addVariant('glow', '.glow-capture .glow-overlay &')
      },
      {
        theme: {
          extend: {
            colors: {
              glow: 'color-mix(in srgb, var(--glow-color) calc(<alpha-value> * 100%), transparent)',
            },
          },
        },
      },
    ),
  ],
  theme: {
    extend: {},
  },
}
