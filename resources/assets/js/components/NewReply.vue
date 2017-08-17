<template>
  <div v-if="signedIn">
    <div class="form-group">
      <textarea class="form-control" name="body"
                                     rows="8"
                                     cols="80"
                                     placeholder="Post a reply!"
                                     required
                                     v-model="body"></textarea>
    </div>

    <button class="btn btn-primary" @click="addReply">Post</button>
  </div>

  <p class="text-center" v-else>To participate the moyu! Please <a href="/login">Login</a>!</p>
</template>

<script>
  export default {
    props:['endpoint'],

    data() {
      return {
        body:'',
      }
    },

    computed:{
      signedIn(){
        return window.App.signedIn;
      }
    },

    methods:{
      addReply() {
        axios.post(this.endpoint, {body:this.body})
          .then(({data}) => {
            this.body = '';

            flash('Your reply has been posted!');

            this.$emit('created', data);
          });
      }
    }
  }
</script>
