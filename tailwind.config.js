module.exports = {
  purge: [
    './resources/views/**/*.blade.php',
    './resources/css/**/*.css',
  ],
  theme: {
    extend: {
        backgroundImage: {
            'hero': "url('/public/pictures/yacht.jpeg')",
        },
    }
  },
  variants: {},
  plugins: [
    require('@tailwindcss/ui'),
      require('flowbite/plugin'),
  ],
    content: [
        "./node_modules/flowbite/**/*.js"
    ]
}
