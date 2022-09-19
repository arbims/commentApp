<script>
import axios from 'axios';
import { comment } from 'postcss';
import store from '../js/store/store';
import commentForm from './Form.vue'
import LoaderVue from './Loader.vue';

export default {
	data () {
		return {
			loading: false
		}
	},
	props: {
		comment: Object
	},
	components: {
		comment: this,
		commentForm: commentForm,
		LoaderVue: LoaderVue
	},
	computed: {
		getReply() {
			return store.getters.reply
		},
		formVisible() {
			return this.getReply === this.comment.id
		}
	},
	methods: {
		replyComment() {
			store.dispatch("replyTo", this.comment.id);
		},
		deleteComment(comment) {
			if (confirm('Voulez vous supprimer votre commentaire')) {
				this.loading = true
				let csrfToken = document.querySelector("meta[name=\"csrfToken\"]").getAttribute("content");
				axios.delete('http://localhost:8000/comments/'+comment.id+'.json',  { headers: { "X-CSRF-Token": csrfToken } }).then((response) => {
					store.dispatch("deleteComment", this.comment).then(() => {
						this.loading = false
					})
				})
			}
		}
	}
}
</script>

<template>
	<LoaderVue v-if="loading"></LoaderVue>
	<div class="row comment">
		<div class="col-md-1">
			<div class="avatar"><img src="https://www.gravatar.com/avatar/{{comment.username.id}}" /></div>

		</div>
		<div class="col-md-11">
			<div class="content">
				<span class="author">{{comment.username}}</span>
				<span class="date">{{ comment.created }}</span>
				<a class="delete" href="#" @click.prevent="deleteComment(comment)"> Supprimer </a>
				<div class="metadata">
					<div class="text">
						{{comment.content}}
					</div>
					<div class="action">
						<a href="#" @click.prevent="replyComment(comment.reply = comment.id)">Repondre</a>
					</div>
				</div>

				<div class="comments">
					<comment :comment="comment" v-for="comment in comment.replies"></comment>
					<commentForm :id="comment.commentable_id" :model="comment.commentable_type" :reply="comment.reply"
						v-if="formVisible"></commentForm>
				</div>
			</div>
		</div>
	</div>
</template>

<style>
.author {
	font-size: 14px;
	font-weight: bold;
}

.date {
	font-size: 12px;
	color: gray;
	margin-left: 20px;
}

.text {
	margin: 10px 0px;
	font-size: 14px;
}

.metadata {
	margin-bottom: 20px;
}

.avatar img {
	width: 40px;
	margin-top: 5px;
}

.btn-comment {
	background-color: #0c73b4;
	border-color: #0c73b4;
	font-size: 14px;
}

.btn-danger {
	font-size: 14px;
	margin-left: 10px;
}

.action a {
	font-size: 14px;
	color: gray;
	text-decoration: none;
	transition: font-weight .4s ease-in-out;
}

.action a:hover {
	font-weight: bold;
}

.delete {
	color: #f03636;
	font-size: 14px;
	padding-left: 10px;
	cursor: pointer;
	text-decoration: none;
}
.delete:hover {
	color: #FF0000;
}
</style>