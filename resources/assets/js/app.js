require('./bootstrap');

import Vue from 'vue';

import Toaster from 'v-toaster';
Vue.use(Toaster, {timeout: 4000});

import VueChatScroll from 'vue-chat-scroll';
Vue.use(VueChatScroll);

Vue.component('message', require('./components/message.vue'));

const app = new Vue({
  el: '#app',
  data: {
    message: '',
    chat: {
      messages: []
    },
    typing: '',
    users: []
  },
  methods: {
    send() {
      if(this.message.length > 0) {
        let d = new Date();
        // Show browser time
        let tm = d.toLocaleString();
        this.chat.messages.push({msg:this.message, usr:'Me', clr:'primary', tm:tm});
        // Find timezone offset from UTC in milliseconds
        let offset = d.getTimezoneOffset()*60000;
        // Create ISO-formatted date
        let isoTm = new Date(d - offset).toISOString().slice(0,19).replace('T',' ');
        axios.post('/send', {message: this.message, tm:isoTm})
             .then(response => this.message = '')
             .catch(error => console.log(error));
      }
    },
  },
  beforeMount() {
    axios.post('/messages')
         .then(response => {
           response.data.forEach(
             m => {
               let t = m.created_at.split(/[- :]/);
               let d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
               this.chat.messages.unshift(
                 {msg:m.message, usr:m.name, clr:'light', tm:d.toLocaleString()}
               );
             }
           )
         })
         .catch(error => console.log(error));
  },
  mounted() {
    Echo.private('chat')
        .listen('ChatEvent', e => {
          let tm = new Date(e.tm);
          this.chat.messages.push({msg:e.message, usr:e.user.name, clr:'danger', tm:tm.toLocaleString()});
        })
        .listenForWhisper('typing', e => {
          if(e.txt) this.typing = 'someone is typing...';
          else this.typing = '';
        });
    Echo.join('chat')
        .here(users => this.users = users)
        .joining(user => {
          this.$toaster.success(`${user.name} joined the chat room`);
          this.users.push(user);
        })
        .leaving(user => {
          this.$toaster.error(`${user.name} left the chat room`);
          this.users = this.users.filter(u => u.name !== user.name);
        });
  },
  watch: {
    message(val) {
      Echo.private('chat')
          .whisper('typing', {txt: val});
    }
  }
});
