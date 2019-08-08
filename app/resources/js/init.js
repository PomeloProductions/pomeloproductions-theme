import smoothscroll from 'smoothscroll-polyfill';

import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';

export default function init(childRoutes = {}) {

    let routeConfig = childRoutes;

    if (!routeConfig.common) {
        routeConfig.common = common;
    }
    if (!routeConfig.home) {
        routeConfig.home = home;
    }
    /**
     * Populate Router instance with DOM routes
     * @type {Router} routes - An instance of our router
     */
    const routes = new Router(routeConfig);

    smoothscroll.polyfill();

    /** Load Events */
    document.addEventListener("DOMContentLoaded", (event) => {
        routes.loadEvents();
    });
}
