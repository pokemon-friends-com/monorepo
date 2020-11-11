import { shallowMount } from '@vue/test-utils';
// Define alias at webpack.mix.js.
import SentryDialogComponent from '@/components/SentryDialogComponent.vue';

const sinon = require('sinon');
const apiMocks = require('./api-mocks');

describe('SentryDialogComponent.vue', () => {
  beforeEach(() => {
    apiMocks.beforeEach();
  });

  it('watch user variable', async () => {
    apiMocks.getUser();

    const user = sinon.stub();
    const wrapper = shallowMount(SentryDialogComponent, {
      props: { eventId: 'eventIdTest' },
      watch: { user },
    });

    await wrapper.vm.$nextTick();
    expect(user.called).toBeTruthy();
  });
});
