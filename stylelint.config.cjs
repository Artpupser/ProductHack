module.exports = {
  plugins: [
    "stylelint-stylus",
  ],

  overrides: [
    {
      files: ["*.stylus", "*.styl", "**/*.stylus", "**/*.styl"],
      customSyntax: "postcss-styl",
    },
  ],
  rules: {
    "stylus/declaration-colon": "never",
    "stylus/pythonic": "always",
    "stylus/selector-list-comma": "never",
    "stylus/semicolon": "never",
    "stylus/single-line-comment": "always",
  },
};
