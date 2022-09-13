import { createStore } from 'vuex'

// Create a new store instance.
const store = createStore({
  state () {
    return {
      comments: [],
      reply: 0
    }
  },
  getters: {
    comments (state) { return state.comments },
    reply (state) { return state.reply }
  },
  actions: {
    addComments (context, comments) {
      context.commit('ADD_COMMENTS', comments)
    },
    addComment (context, comment) {
      context.commit('ADD_COMMENT', comment)
    },
    replyTo (context, id) {
      context.commit('REPLY_TO', id)  
    }
  },
  mutations: {
    ADD_COMMENTS (state, comments) {
      state.comments.push(...comments)
    },
    ADD_COMMENT (state, comment) {
      if (comment.reply) {
        let c = state.comments.find((c) => c.id === comment.reply)
        if (c.repiles === undefined) {
          c.repiles = []
        }
        c.repiles.push(comment)
      }else {
        state.comments.push(comment)
      }
    },
    DELETE_COMMENT (state, comment) {
      if (comment.reply) {
        let parent = state.comments.find((c) => c.id === comment.reply)
        let index = parent.replies.comments.findIndex((c) => c.id === comment.id)
        parent.replies.splice(index, 1)
      }else {
        let index = state.comments.findIndex((c) => c.id === comment.id)
        state.comments.splice(index, 1)
      }
    },
    REPLY_TO (state, id) {
      state.reply = id
    }
  }
})

export default store