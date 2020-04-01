describe('bootstrap.js', () => {

  before(() => {
    document.getElementsByTagName("head")[0].innerHTML = "<meta name='csrf-token' content='CSRF_TOKEN'>";
    // Define alias at webpack.mix.js.
    require('@/bootstrap.js');
  });

  it('validate initialization', () => {
    assert.ok(window._);
    assert.ok(window.Popper);
    assert.strictEqual(window.jQuery, window.$);
    // Test if Bootstrap Js is loaded.
    assert.ok(typeof window.$().modal, 'function');
    assert.ok(window.axios);
    assert.ok(window.axios.defaults.headers.common['X-CSRF-TOKEN'], 'CSRF_TOKEN');
  });

});
