# Pomelo Productions

> Make Wordpress theme development great again.

## Features

- Modern JavaScript through Webpack
- Live reload via BrowserSync
- SCSS support
- Helpful HTML5 Router for firing JS based on Wordpress page slug.
- Nothing else.

## Requirements

- Node.js <= 14
- Yarn

## Getting Started
```bash
yarn install

```

Also make sure to copy the .env.example file over to .env before you can serve the site.

## Developing Locally
To work on the theme locally, open another window/tab in terminal and run:

```bash
yarn start
```

This will open a browser, watch all files (php, scss, js, etc) and reload the 
browser when you press save. 

## Building for Production
To create an optimized production build, run:

```bash
yarn build
```

This will minify assets, bundle and uglify javascript, and compile scss to css.
It will also add cachebusting names to then ends of the compiled files, so you
do not need to bump any enqueued asset versions in `functions.php`.


#### Author
- Help from Jared Palmer [@jaredpalmer](https://twitter.com/jaredpalmer)
