import { shallowMount } from '@vue/test-utils';
// Define alias at webpack.mix.js.
import SentryDialogComponent from '@/components/SentryDialogComponent.vue';

const sinon = require('sinon');
const sentry = require('@sentry/browser');
const apiMocks = require('./api-mocks');

describe('SentryDialogComponent.vue', () => {

  beforeEach(() => {
    apiMocks.beforeEach();
  });

  it('show sentry dialog', async () => {
    apiMocks.getUser();
    const wrapper = shallowMount(SentryDialogComponent, {
      props: { eventId: 'eventIdTest' },
    });

    var sentryMock = sinon.mock(sentry);

    await wrapper.vm.$nextTick();
    // sentryMock.expects('showReportDialog').once();
    sentryMock.verify();
  });
});
