// Setup JSDOM.
require('jsdom-global')();
// Make assert available globally.
global.assert = require('assert');
// Make expect available globally.
global.expect = require('expect');
// https://github.com/vuejs/vue/issues/9698 `ReferenceError: performance is not defined`
global.performance = window.performance;

// @see https://github.com/vuejs/vue-cli/issues/2128
window.Date = Date;
