<template>
  <div>
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
  }
}
</script>

<style scoped>

</style>
