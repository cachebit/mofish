<template>
  <div :id="'reply-'+id" class="panel panel-default">
    <div class="panel-heading">
      <ul class="list-inline">
        <li>
          <a :href="'/profiles/'+data.owner.name" v-text="data.owner.name">
          </a> said <span v-text="ago"></span>...
        </li>

        <li class="pull-right" v-if="signedIn">
          <favorite :reply="data"></favorite>
        </li>
      </ul>
    </div>
    <div class="panel-body">
      <div v-if="editing">
        <div class="form-group">
          <textarea class="form-control" v-model="body"></textarea>
        </div>

        <button class="btn btn-xs btn-primary" @click="update">Update</button>
        <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
      </div>

      <div v-else v-text="body"></div>
    </div>

    <div class="panel-footer level" v-if="canUpdate">
      <button class="btn btn-xs mr-1" @click="editing = true">Edit</button>
      <button class="btn btn-danger btn-xs mr-1" @click="destory">Delete</button>
    </div>
  </div>
</template>

<script>
  import Favorite from './Favorite.vue';
  import moment from 'moment';

  export default{
    props:["data"],

    components: { Favorite },

    data() {
      return {
        editing: false,
        id: this.data.id,
        body: this.data.body,
      };
    },

    computed:{
      ago() {
        return moment(this.data.created_at).fromNow();
      },

      signedIn(){
        return window.App.signedIn;
      },

      canUpdate(){
        return this.authorize(user => this.data.user_id == user.id);
      }
    },

    methods:{
      update(){
        axios.patch('/replies/' + this.data.id, {
          body:this.body
        });

        this.editing = false;

        flash('Updated!');
      },

      destory(){
        axios.delete('/replies/' + this.data.id);

        this.$emit('deleted', this.data.id);
      }
    }
  }
</script>
