<template>
  <div @click="redirectIfGuest">
    <div class="card mb-3 border-0 shadow-sm" v-for="status in statuses">
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
      <div class="card-footer p-2">
        <button 
          v-if="status.is_liked" 
          @click="unlike(status)"
          class="btn btn-link btn-sm" 
          dusk="unlike-btn" 
        >
          <i class="fas fa-thumbs-up text-primary mr-1"></i>
          <strong>TE GUSTA</strong>
        </button>
        <button 
          v-else 
          @click="like(status)"
          class="btn btn-link btn-sm" 
          dusk="like-btn" 
        >
           <i class="far fa-thumbs-up text-primary mr-1"></i>
          ME GUSTA
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      statuses: []
    }
  },
  mounted() {
    axios.get('/statuses')
      .then(res => {
        this.statuses = res.data.data
      })
      .catch(err => {
        console.log(err.response.data)
      })

    EventBus.$on('status-created', status => {
      this.statuses.unshift(status)
    })
  },
  methods: {
    like(status) {
      axios.post(`/statuses/${status.id}/likes`)
        .then(res => {
          status.is_liked = true
        })
    },
    unlike(status) {
      axios.delete(`/statuses/${status.id}/likes`)
        .then(res => {
          status.is_liked = false
        })
    }
  }
}
</script>

<style scoped>

</style>
