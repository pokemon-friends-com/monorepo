import { shallowMount } from '@vue/test-utils';
// Define alias at webpack.mix.js.
import PaginatorComponent from '@/components/PaginatorComponent.vue';

describe('PaginatorComponent.vue', () => {

  it('show pagination for page 2 and go to previous page', async () => {
    const wrapper = shallowMount(PaginatorComponent, {
      propsData: {
        data: {
          current_page: 2,
          prev_page_url: '/endpoint?page=1',
          next_page_url: '/endpoint?page=3',
        },
      },
      mocks: {
        $t: (key) => key,
      },
    });

    await wrapper.vm.$nextTick();
    // todo xABE : why should i forced to call manually the `watch` event on `data` ?
    wrapper.vm.$options.watch.data.call(wrapper.vm);
    await wrapper.vm.$nextTick();

    const subButton = wrapper.find('button.sub');
    const eventChanged = wrapper.emitted('changed');
    expect(wrapper.vm.$data.page).toEqual(2);
    expect(subButton.exists()).toBeTruthy();
    expect(wrapper.contains('button.add')).toBeTruthy();
    subButton.trigger('click.prevent');

    expect(wrapper.vm.$data.page).toEqual(1);
    expect(eventChanged).toBeTruthy();
    expect(eventChanged.length).toBe(1);

    // todo xABE : is watcher correctly dispatched ? why `page` do not change in emitted event ?
    //expect(eventChanged[0]).toEqual([wrapper.vm.$data.page]);
  });
});
