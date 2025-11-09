import globals from 'globals';

export default [
  {
    files: ['resources/js/**/*.js', 'resources/blocks/**/*.js'],
    ignores: ['resources/js/vendors/**', 'vendor/**', 'node_modules/**'],
    languageOptions: {
      ecmaVersion: 'latest',
      sourceType: 'module',
      globals: {
        ...globals.browser,
        wp: 'readonly',
        lazySizes: 'readonly',
        process: 'readonly',
        tinymce: 'readonly',
        gsap: 'readonly',
      },
    },
    rules: {
      'no-unused-vars': 'warn',
      'no-console': ['warn', { allow: ['warn', 'error'] }],
      'no-undef': 'error',
      eqeqeq: ['error', 'always'],
      curly: ['error', 'all'],
      'prefer-const': 'warn',
      'no-var': 'warn',
      'arrow-body-style': ['warn', 'as-needed'],
      'no-multiple-empty-lines': ['warn', { max: 2 }],
      quotes: ['warn', 'single'],
      semi: ['warn', 'always'],
      'no-trailing-spaces': 'warn',
      indent: [
        'warn',
        'tab',
        {
          ignoredNodes: [
            'ConditionalExpression',
            'CallExpression[callee.object.name="gsap"]',
            'CallExpression[callee.property.name=/^to$|^fromTo$/]',
            'ObjectExpression',
          ],
          SwitchCase: 1,
          MemberExpression: 'off',
          FunctionDeclaration: { parameters: 'first' },
          FunctionExpression: { parameters: 'first' },
          CallExpression: { arguments: 'first' },
        },
      ],
      'no-eval': 'error',
      'max-len': ['warn', { code: 130 }],
      camelcase: 'warn',
    },
  },
  {
    files: ['resources/js/editor.js'],
    languageOptions: {
      globals: {
        wp: 'readonly',
      },
    },
    // You can add WordPress-specific rules here if needed
  },
];
