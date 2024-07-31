<template>
    <div>
        <h1>{{ message }}</h1>
        <p>Vuex Store State: {{ testState }}</p>
    </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
    name: 'HelloWorld',
    data() {
        return {
            message: 'Hello, World!'
        };
    },
    computed: {
        ...mapState({
            testState: state => state.test,
        })
    }
}
</script>

<style scoped>
h1 {
    color: #42b983;
}
</style>
