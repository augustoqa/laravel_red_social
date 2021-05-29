<template>
  <div>
    <form @submit.prevent="submit">
      <div class="card-body">
        <textarea
          v-model="body"
          name="body"
          class="form-control border-0 bg-light"
          placeholder="¿Qué estás pensando Jorge?"
        ></textarea>
      </div>
      <div class="card-footer">
        <button id="create-status" class="btn btn-primary">Publicar</button>
      </div>
    </form>
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
          EventBus.$emit('status-created', res.data)
          this.body = ''
        })
        .catch((res) => {
          console.log(err.response.data);
        });
    },
  },
};
</script>
