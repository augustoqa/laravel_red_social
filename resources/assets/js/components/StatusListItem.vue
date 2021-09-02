<template>
  <div class="card mb-3 border-0 shadow-sm">
    <div class="card-body d-flex flex-column">
      <div class="d-flex align-items-center mb-3">
        <img src="avatar.png" alt="Avatar" class="rounded mr-3 shadow-sm" width="40">
        <div>
          <h5 class="mb-1" v-text="status.user_name"></h5>
          <div class="small text-muted" v-text="status.ago"></div>
        </div>
      </div>
      <p v-text="status.body" class="card-text text-secondary"></p>
    </div>
    <div class="card-footer p-2 d-flex justify-content-between align-items-center">
      <like-btn 
        dusk="like-btn" 
        :url="`/statuses/${status.id}/likes`"
        :model="status"
      ></like-btn>
      <div class="text-secondary mr-2">
        <i class="far fa-thumbs-up"></i>
        <span dusk="likes-count">{{ status.likes_count }}</span>
      </div>
    </div>
    <div class="card-footer">
      <div v-for="comment in status.comments" class="mb-3">
        <img width="34px" :src="comment.user_avatar" :alt="comment.user_name" class="rounded shadow-sm float-left mr-2">
        <div class="card border-0 shadow-sm">
          <div class="card-body p-2 text-secondary">
            <a href="#"><strong>{{ comment.user_name }}</strong></a>
            {{ comment.body }}
          </div>
        </div>
        <span dusk="comment-likes-count">{{ comment.likes_count }}</span>
        <like-btn 
          dusk="comment-like-btn" 
          :url="`/comments/${comment.id}/likes`"
          :model="comment"
        ></like-btn>
      </div>

      <form @submit.prevent="addComment" v-if="isAuthenticated">
        <div class="d-flex align-items-center">
          <img width="34px" src="avatar.png" :alt="currentUser.name" class="rounded shadow-sm float-left mr-2">
          <div class="input-group">
            <textarea
              v-model="newComment"
              name="comment"
              class="form-control border-0 shadow-sm"
              placeholder="Escribe un comentario..."
              rows="1"
              required
            ></textarea>
            <div class="input-group-append">
              <button dusk="comment-btn" class="btn btn-primary">Enviar</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import LikeBtn from './LikeBtn'

export default {
  props: {
    status: {
      type: Object,
      required: true,
    }
  },
  data() {
    return {
      newComment: '',
      comments: this.status.comments,
    }
  },
  methods: {
    addComment() {
      axios.post(`/statuses/${this.status.id}/comments`, { body: this.newComment })
        .then(res => {
          this.newComment = ''
          this.comments.push(res.data.data)
        })
        .catch((res) => {
          console.log(err.response.data);
        });
    },
  },
  components: {
    LikeBtn,
  }
}
</script>
