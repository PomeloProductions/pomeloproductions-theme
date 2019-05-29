import '../styles/style.scss';
import smoothscroll from 'smoothscroll-polyfill';

import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';

/**
 * Populate Router instance with DOM routes
 * @type {Router} routes - An instance of our router
 */
const routes = new Router({
  /** All pages */
  common,
  /** Home page */
  home,
  /** About Us page, note the change from about-us to aboutUs. */
});

smoothscroll.polyfill();

/** Load Events */
document.addEventListener("DOMContentLoaded", (event) => {
  routes.loadEvents();
});