/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 * ======================================================================== */

import camelCase from './camelCase';

// The routing fires all common scripts, followed by the page specific scripts.
// Add additional events for more control over timing e.g. a finalize event
export default class Router {
  constructor(routes) {
    this.routes = routes;
    this.loadedPages = [];
  }

  fire(route, fn = 'init', args) {
    const fire = route !== '' &&
        this.routes[route];
    if (fire) {
      let page = this.loadedPages[route] ? this.loadedPages[route] : new this.routes[route]();
      page[fn](args);
    }
  }

  loadEvents() {

    // Fire page-specific init JS, and then finalize JS
    document.body.className
        .toLowerCase()
        .replace(/-/g, '_')
        .split(/\s+/)
        .map(camelCase)
        .forEach(className => {
          this.fire(className);
          this.fire(className, 'finalize');
        });
  }
}
