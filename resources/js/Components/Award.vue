<template>
    <div
        class="p-2 rounded-md shadow-md"
    >
        <img :src="award.imageUrl" />
        <p class="py-2 text-center">{{ award.name }}</p>
    </div>
</template>

<script>
    export default {
        props: {
            award: Object
        },
    }
</script>
