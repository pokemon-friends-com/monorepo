global.requestAnimationFrame = function(callback) {
  setTimeout(callback, 0);
};

describe('app.js', () => {
  before(() => {
    document.getElementsByTagName("head")[0].innerHTML = "<meta name='csrf-token' content='CSRF_TOKEN'>"
      + "<meta name='locale' content='en'>";
    document.body.innerHTML = "<div id='app'></div>";
    // Define alias at webpack.mix.js.
    require('@/app.js');
  });

  it('validate initialization', () => {
    assert.ok(true);
  });
});
