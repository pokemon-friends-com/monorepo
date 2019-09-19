describe('bootstrap.js', () => {

  before(function () {
    document.getElementsByTagName("head")[0].innerHTML = "<meta name='csrf-token' content='CSRF_TOKEN'>";
    // Define alias at webpack.mix.js.
    require('@/bootstrap.js');
  });

  it('validate initialization', () => {
    assert.equal(window._, require('lodash'));
    assert.equal(window.Popper, require('popper.js').default);
    assert.equal(window.jQuery, require('jquery'));
    assert.equal(window.$, require('jquery'));
    // Test if Bootstrap Js is loaded.
    assert.equal(typeof window.$().modal, 'function');
    assert.equal(window.axios, require('axios'));
    assert.equal(window.axios.defaults.headers.common['X-CSRF-TOKEN'], 'CSRF_TOKEN');
  });

});
