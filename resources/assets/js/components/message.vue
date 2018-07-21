<template>
  <div>
    <li class="list-group-item mt-1 mx-1" :class="className">
      <h5>{{message.msg}}
        <span class="badge badge-light ml-3">{{message.usr}} @ {{message.tm}}</span>
      </h5>
    </li>
  </div>
</template>

<script>
export default {
  props: ['message'],
  computed: {
    className() {
      return 'list-group-item-' + this.message.clr;
    },
  },
};
</script>
