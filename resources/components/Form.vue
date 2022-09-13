<script>
import { def } from '@vue/shared';
import axios from 'axios';
import store from '../js/store/store';
import Loader from './Loader.vue';

export default {
  props: {
    id: Number,
    model: String,
    reply: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      username: "",
      email: "",
      content: "",
      errors: {},
      loading: false
    };
  },
  methods: {
    addComment() {
      this.loading = true
      let csrfToken = document.querySelector("meta[name=\"csrfToken\"]").getAttribute("content");
      let commentData = {
        commentable_id: this.id,
        commentable_type: this.model,
        username: this.username,
        email: this.email,
        content: this.email,
        reply: this.reply
      };
      axios.post("http://localhost:8000/comments.json", commentData, { headers: { "X-CSRF-Token": csrfToken } }).then((response) => {
        store.dispatch("addComment", response.data.comment);
        this.viderForm();
      }).catch((response) => {
        this.loading = false
        this.errors = response.response.data.errors;
      });
    },
    viderForm() {
      this.username = "";
      this.email = "";
      this.content = "";
      this.loading = false
    },
    replyComment () {
			store.dispatch("replyTo", 0 );
		}
  },
  components: { Loader }
}
</script>

<template>
  <div>
    <h3>{{ reply == 0 ? 'Commenter': 'Repondre'}}</h3>
    <form class="row" @submit.prevent="addComment" style="position: relative;">
      <Loader v-if="loading"></Loader>
      <div class="form-group col-md-6">
        <label>Username</label>
        <input type="text" v-model="username" :class="errors.username ? 'form-control is-invalid': 'form-control'">
        <div class="invalid-feedback" v-if="errors.username">
          {{ errors.username.username }}
        </div>
      </div>
      <div class="form-group col-md-6">
        <label>Email</label>
        <input type="text" v-model="email" :class="errors.email ? 'form-control is-invalid': 'form-control'">
        <div class="invalid-feedback" v-if="errors.email">
          {{ errors.email.email }}
        </div>
      </div>
      <div class="form-group col-md-12">
        <label>Message</label>
        <textarea type="text" v-model="content"
          :class="errors.content ? 'form-control is-invalid': 'form-control'"></textarea>
      </div>
      <div class="form-group col-md-12">
        <button class="btn btn-primary btn-comment"><i class="fa fa-pencil"></i>{{ reply == 0 ? 'Commenter': 'Repondre'}}</button>
        <button class="btn btn-danger" @click.prevent="replyComment(0)" v-if="reply > 0">Annuler</button>
      </div>
    </form>
  </div>
</template>

<style>
.form-group {
  padding-bottom: 20px;
}

.btn-comment:hover {
  background-color: #0c73b4;
}
</style>