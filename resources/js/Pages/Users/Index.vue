<template>
    <Head title="Users">
    </Head>
    <div class="flex justify-between mb-6">
        <div class="flex items-center">
        <h1 class="text-2xl font-bold">Users</h1>
        <Link
                v-if="can.createUser"
                href="/users/create"
                class="text-blue-500 text-sm ml-4 mt-1"
        > New User
        </Link>
    </div>
        <input v-model="search" type="text" placeholder="Search..." class="border px-2 rounded-lg">
    </div>
    <table class="w-full min-w-[640px] table-auto">

        <tbody>
        <tr v-for="user in users.data" :key="user.id">
            <td class="py-3 px-3 border-b border-blue-gray-50">
                <div class="flex items-center gap-4">
                    <p class="block antialiased  text-sm leading-normal  font-medium">
                        {{ user.name }}
                    </p>
                </div>
            </td>

            <td class="py-3 px-5 border-b border-blue-gray-50">
                <Link
                        v-if="user.can.edit"
                        :href="/users/ + user.id + '/edit'"
                        class="text-indigo-600 hover:text-indigo-900">Edit</Link>
            </td>
        </tr>

        </tbody>
    </table>


    <Pagination :links="users.links" class="mt-6"/>

</template>

<script setup>
    import { ref, watch } from "vue";
    import { router } from '@inertiajs/vue3';
    import debounce from "lodash/debounce";

    let props = defineProps({
        users: Object,
        filters: Object,
        can: Object
    });

    const search = ref(props.filters.search);

    watch(search, debounce(function(value) {
       router.get('/users', {search: value},{preserveState: true, replace: true});
    }, 500));
</script>
