<script>
import axios from 'axios';

  export default {
    data() {
      return {
        post: {}
      }
    },
    mounted() {
      axios.get('http://localhost:8000/posts/1.json').then((response) => {
        this.post = response.data
      })
    }
  }
</script>

<template>
  <h2>{{ post.name }}</h2>
  <p>{{post.description}}</p>
</template>