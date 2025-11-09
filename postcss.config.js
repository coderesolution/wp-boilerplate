import postcssImportExtGlob from 'postcss-import-ext-glob';
import postcssImport from 'postcss-import';
import postcssSizeClamp from 'postcss-size-clamp';
import postcssPxtorem from 'postcss-pxtorem';
import postcssPresetEnv from 'postcss-preset-env';

export default ({ env, options }) => {
  const isDev = env === 'development' || options?.mode === 'development';

  return {
    map: isDev
      ? {
          inline: false,
          annotation: true,
          sourcesContent: true,
        }
      : false,
    plugins: [
      postcssImportExtGlob,
      postcssImport,
      postcssSizeClamp({
        range: [420, 1440],
        unit: 'vw',
      }),
      postcssPxtorem({
        rootValue: 16,
        replace: true,
      }),
      postcssPresetEnv({
        stage: 1,
        features: {
          'cascade-layers': false,
          'nesting-rules': false,
        },
      }),
    ],
  };
};
