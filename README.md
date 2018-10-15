# DevCatch.OctoberMix
Support for leveraging [Laravel Mix](https://laravel-mix.com/)'s [`version()`](https://laravel-mix.com/docs/2.1/versioning) cache-busting functionality within [OctoberCMS](https://octobercms.com/).

## Installation

Clone this repo to `/plugins/devcatch`.

## Usage

This plugin provides a [Twig]() filter for including versioned assets that were compiled using the `version()` [(see docs)](https://laravel-mix.com/docs/2.1/versioning) function of [Laravel Mix](https://laravel-mix.com/).

Using `mix.version()` adds a unique hash query string to the compiled files. It also creates a file called `mix-manifest.json` which maps asset paths to their corresponding cache-busted paths (eg. 'some/compiled/asset/path.js?unique-query-hash'). A sample `mix-manifest.json` might look like this:

```json
{
  "/assets/js/app.js": "/assets/js/app.js?id=6115c1733c0acedae231",
  "/assets/css/styles.css": "/assets/css/styles.css?id=21349280c68af7df8d70"
}
```
The `mix` Twig filter allows you to include assets in your theme partials like this:

```html
<link rel="stylesheet" href="{{ '/assets/css/styles.css' | mix }}">
```

By default, the filter will assume that the `mix-manifst.json` is located in the active theme's root directory. If you have stored the manifest in a custom location, you can pass that path as a parameter to the filter, for example:

```html
<link rel="stylesheet" href="{{ '/assets/css/styles.css' | mix('path/to/mix-manifest.json') }}">
``` 

Note that this can be used to include production-compiled assets AND development-compiled assets. This eliminates the need for checking the current environment in your theme partials. As a best practice, you should only call `mix.version()` when compiling for production. You can accomplsh this by including the following in your theme's `webpack.mix.js`:

```javascript
if (mix.inProduction()) {
  mix.version();
}
``` 

See the [Laravel Mix Docs](https://laravel-mix.com/docs) for more mix options.
