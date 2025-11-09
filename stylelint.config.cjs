module.exports = {
  extends: ['stylelint-config-sass-guidelines'],
  plugins: ['@stylistic/stylelint-plugin'],
  rules: {
    'block-no-empty': true,
    'color-named': null,
    'color-no-invalid-hex': true,
    'max-nesting-depth': 6,
    'no-descending-specificity': null,
    'property-no-unknown': [
      true,
      {
        ignoreProperties: [
          'font-range',
          'size',
          'position',
          'fluid-range',
          'fluid-unit',
        ],
      },
    ],
    'property-no-vendor-prefix': null,
    'selector-class-pattern': '^([a-z0-9-:_\\\\]+)$',
    'selector-max-compound-selectors': 5,
    'selector-no-qualifying-type': null,
    '@stylistic/indentation': null,
    'scss/at-rule-no-unknown': [
      true,
      {
        ignoreAtRules: ['import-glob', 'source'],
      },
    ],
    'selector-max-id': null,
  },
};
