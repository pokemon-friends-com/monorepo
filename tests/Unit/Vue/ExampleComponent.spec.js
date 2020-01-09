import { shallowMount } from '@vue/test-utils';
import MockEcho from 'mock-echo';
// Define alias at webpack.mix.js.
import ExampleComponent from '@/components/ExampleComponent.vue';

const apiMocks = require('./api-mocks');

describe('ExampleComponent.vue', () => {

  let mockEcho;

  beforeEach(() => {
    apiMocks.beforeEach();

    mockEcho = new MockEcho();
    window.Echo = mockEcho;
  });

  afterEach(() => {
    delete window.Echo;
  });

  it('display correctly the card with user information', async () => {
    apiMocks.getUser();
    const wrapper = shallowMount(ExampleComponent);

    await wrapper.vm.$nextTick();
    expect(wrapper.find('div.card-header').text())
      .toBe(apiMocks.userData.civility_name);
    expect(wrapper.find('div.card-body').text())
      .toBe(apiMocks.userData.role.trans);
  });

  it('display correctly the success toast', async () => {
    apiMocks.getUser();
    const wrapper = shallowMount(ExampleComponent);
    // const message = 'Hello World!';

    // wrapper.vm.$data.toast.update({ target: 'div.card' });

    await wrapper.vm.$nextTick();
    expect(mockEcho.channelExist('my-channel')).toBeTruthy();
    expect(mockEcho.getChannel('my-channel').eventExist('.my-event')).toBeTruthy();

    // await mockEcho
    //   .getChannel('my-channel')
    //   .broadcast('.my-event', { message });

    // await wrapper.vm.$nextTick();
    // expect(wrapper.find('h2.swal2-title').html()).toBe(message);
  });
});
