module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                primary: '#F5F5F5',
                secondary: '#2D3047',
                accent: '#E6B89C',
                sage: '#A8C686',
                darkgray: '#3A3A3A'
            },
            fontFamily: {
                playfair: ['Playfair Display', 'serif'],
                montserrat: ['Montserrat', 'sans-serif'],
                lora: ['Lora', 'serif']
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};
