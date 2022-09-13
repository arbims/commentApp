<script>
import Comments from '../components/Comments.vue'

export default {
    components: {
      comments: Comments
    }
}
</script>

<template>
    <comments :id="1" :model="'post'" ></comments>
</template>
