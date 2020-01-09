import { shallowMount } from '@vue/test-utils';
// Define alias at webpack.mix.js.
import AppComponent from '@/components/AppComponent.vue';

const apiMocks = require('./api-mocks');

describe('AppComponent.vue', () => {

  beforeEach(() => {
    apiMocks.beforeEach();
  });

  it('display current user information', async () => {
    apiMocks.getUser();
    const wrapper = shallowMount(AppComponent);

    await wrapper.vm.$nextTick();
    expect(wrapper.vm.$data.user)
      .toHaveProperty('identifier', apiMocks.userData.identifier);
    expect(wrapper.find('div').text())
      .toBe(apiMocks.userData.civility_name);
  });
});
