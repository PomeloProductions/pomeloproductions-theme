export default class PageState {

    /**
     * Takes the user to the page url without reloading the page
     * @param path
     * @param event
     */
    goToPageUrl(path) {
        if (window.location.pathname !== path) {
            window.history.pushState({}, "", path);
        }
    }
}