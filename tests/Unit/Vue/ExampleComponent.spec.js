import {shallowMount} from '@vue/test-utils';
// Define alias at webpack.mix.js.
import ExampleComponent from '@/components/ExampleComponent.vue';

describe('ExampleComponent.vue', () => {

  it('my first test', () => {
    const wrapper = shallowMount(ExampleComponent);
    expect(wrapper.html()).toContain('I\'m an example component.');
  });

  it('my second test', () => {
    const wrapper = shallowMount(ExampleComponent);
    expect(wrapper.contains('div.card-body')).toBe(true);
  });

});
