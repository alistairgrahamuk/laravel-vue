<template>
    <Head title="My App">
    <meta
        type="description"
        content="Information about the main page"
        head-key="description"
        >
    </Head>
    <section class="p-6 bg-gray-200">
        <header class="flex justify-between">
            <div class="flex items-center">
            <h1 class="font-bold text-lg">
                My App
            </h1>

            <p class="text-sm ml-4"
            >Welcome Back, {{ $page.props.auth.user.username }}</p>
            </div>
            <Nav/>

        </header>
    </section>
    <section class="p-6">
        <div class="max-w-3xl mx-auto">
            <slot/>
        </div>
    </section>


</template>

<script>
    import Nav from "./Nav";
    export default {
        components: {Nav}
    }
</script>

<style scoped>

</style>