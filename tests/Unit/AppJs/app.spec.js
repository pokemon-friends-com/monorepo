describe('app.js', () => {
  before(() => {
    document.getElementsByTagName("head")[0].innerHTML = "<meta name='csrf-token' content='CSRF_TOKEN'>";
    document.body.innerHTML = "<div id='template'></div>";
    // Define alias at webpack.mix.js.
    require('@/app.js');
  });

  it('validate initialization', () => {
    assert.ok(true);
  });
});
