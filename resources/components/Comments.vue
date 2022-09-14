<script>
import axios from 'axios';
import store from '../js/store/store';
import CommentVue from './Comment.vue';
import commentForm from './Form.vue'
import Post from './Post.vue'
import Loader from './Loader.vue';

export default {
  props: {
    id: Number,
    model: String,
    ip: String
  },
  data() {
    return {
      loading: true
    }
  },
  computed: {
    getComments() {
      return store.getters.comments
    },
		getReply() {
      return store.getters.reply
    }
  },
  components: {
    comment: CommentVue,
    commentForm: commentForm,
    post: Post,
    Loader
},
  mounted() {
    axios.get(`http://localhost:8000/comments.json`, { params: { id: this.id, type: this.model } }).then((response) => {
      //this.comments = response.data.comments
      store.dispatch('addComments', response.data.comments)
    }).then(() => {
      this.loading = false
    })
  }
}

</script>


<template>

  <post></post>
  <Loader v-if="loading"></Loader>
  <comment :comment="comment" v-for="comment in getComments"></comment>
  <commentForm :id="id" :model="model" v-if="getReply === 0"></commentForm>
</template>

<style>
.loader {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  background: #FFFFFF91;
  text-align: center;
}
.custom_spinner {
  position: absolute;
  top: 60%;
}
</style>
