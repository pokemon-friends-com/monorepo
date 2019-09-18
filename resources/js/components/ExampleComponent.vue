<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  mounted() {
    // eslint-disable-next-line
    console.log('Component mounted.');
    // eslint-disable-next-line
    // axios.get('api/v1/user').then(response => {});
    // eslint-disable-next-line
    // axios.get('ajax/timezones').then(response => {});
  },
};
</script>
