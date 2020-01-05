import { shallowMount } from '@vue/test-utils';
// Define alias at webpack.mix.js.
import CollapseSidebarComponent from '@/components/CollapseSidebarComponent.vue';

const apiMocks = require('./api-mocks');

describe('CollapseSidebarComponent.vue', () => {

  beforeEach(() => {
    apiMocks.beforeEach();
  });

  it('collapse on click', async () => {
    apiMocks.getUser();
    const isSidebarPined = false;
    apiMocks.putUserProfile({ is_sidebar_pined: isSidebarPined });
    const wrapper = shallowMount(CollapseSidebarComponent);

    await wrapper.vm.$nextTick();
    expect(wrapper.contains('a.nav-link>i.fas.fa-bars')).toBeTruthy();
    expect(wrapper.vm.$data.user)
      .toHaveProperty('is_sidebar_pined', apiMocks.userData.is_sidebar_pined);

    // Click collapse button.
    await wrapper.find('a.nav-link').trigger('click');

    await wrapper.vm.$nextTick();
    expect(wrapper.contains('a.nav-link>i.fas.fa-bars')).toBeTruthy();
    expect(wrapper.vm.$data.user)
      .toHaveProperty('is_sidebar_pined', isSidebarPined);
  });

  it('un-collapse on click', async () => {
    const isSidebarPined = false;
    apiMocks.getUser({ is_sidebar_pined: isSidebarPined });
    apiMocks.putUserProfile();
    const wrapper = shallowMount(CollapseSidebarComponent);

    await wrapper.vm.$nextTick();
    expect(wrapper.contains('a.nav-link>i.fas.fa-bars')).toBeTruthy();
    expect(wrapper.vm.$data.user)
      .toHaveProperty('is_sidebar_pined', isSidebarPined);

    // Click un-collapse button.
    await wrapper.find('a.nav-link').trigger('click');

    await wrapper.vm.$nextTick();
    expect(wrapper.contains('a.nav-link>i.fas.fa-bars')).toBeTruthy();
    expect(wrapper.vm.$data.user)
      .toHaveProperty('is_sidebar_pined', apiMocks.userData.is_sidebar_pined);
  });
});
