<script>
import axios from 'axios';
import { comment } from 'postcss';
import store from '../js/store/store';
import commentForm from './Form.vue'

export default {
	props: {
		comment: Object
	},
	components: {
		comment: this,
		commentForm: commentForm
	},
	computed: {
		getReply() {
      return store.getters.reply
    },
		formVisible () {
			return this.getReply === this.comment.id
		}
	},
	methods: {
		replyComment () {
			store.dispatch("replyTo", this.comment.id );
		}
	}
}
</script>

<template>
	<div class="row comment">
		<div class="col-md-1">
			<div class="avatar"><img src="https://www.gravatar.com/avatar/{{comment.username.id}}" /></div>

		</div>
		<div class="col-md-11">
			<div class="content">
				<span class="author">{{comment.username}}</span>
				<span class="date">{{ comment.created }}</span>
				<div class="metadata">
					<div class="text">
						{{comment.content}}
					</div>
					<div class="action">
						<a href="#" @click.prevent="replyComment(comment.reply == 0  ? comment.id : comment.reply)">Repondre</a>
					</div>
				</div>
				
				<div class="comments">
					<comment :comment="comment" v-for="comment in comment.replies" ></comment>
					<commentForm :id="comment.commentable_id" :model="comment.commentable_type" :reply="comment.id" v-if="formVisible"></commentForm>
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


</style>