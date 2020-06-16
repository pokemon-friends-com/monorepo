describe('bootstrap.js', () => {
  before(() => {
    document.getElementsByTagName("head")[0].innerHTML = "<meta name='csrf-token' content='CSRF_TOKEN'>";
    // Define alias at webpack.mix.js.
    require('@/bootstrap.js');
  });

  it('validate initialization', () => {
    assert.ok(_);
    assert.strictEqual(window.jQuery, window.$);
  });
});
