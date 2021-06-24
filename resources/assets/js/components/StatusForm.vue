<template>
  <div>
    <form @submit.prevent="submit" v-if="isAuthenticated">
      <div class="card-body">
        <textarea
          v-model="body"
          name="body"
          class="form-control border-0 bg-light"
          :placeholder="`¿Qué estás pensando ${currentUser.name}?`"
        ></textarea>
      </div>
      <div class="card-footer">
        <button id="create-status" class="btn btn-primary">
          <i class="fas fa-paper-plane mr-1"></i>
          Publicar
        </button>
      </div>
    </form>
    <div v-else class="card-body">
      <a href="/login">Debes hacer login</a>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      body: "",
    };
  },
  methods: {
    submit() {
      axios
        .post("/statuses", { body: this.body })
        .then((res) => {
          EventBus.$emit('status-created', res.data.data)
          this.body = ''
        })
        .catch((res) => {
          console.log(err.response.data);
        });
    },
  },
};
</script>
