describe('app.js', () => {

  before(function () {
    document.getElementsByTagName("head")[0].innerHTML = "<meta name='csrf-token' content='CSRF_TOKEN'>";
    document.body.innerHTML = "<div id='obsessioncity'></div>";
    // Define alias at webpack.mix.js.
    require('@/app.js');
  });

  it('validate initialization', () => {
    assert.equal(window.Vue, require('vue'));
  });

});
