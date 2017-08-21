<template>
    <nav aria-label="Page navigation">
      <p class="page_total">共 {{ total }} 条</p>
      <ul class="pagination pagination-sm">
        <li>
          <a href="javascript:;" aria-label="Previous" @click="current_change(--page)">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <li v-for="item in pageList" @click="current_change(item)" :class="{'active': item == page}">
          <a href="javascript:;">{{ item }}</a>
        </li>
        <li>
          <a href="javascript:;" aria-label="Next" @click="current_change(++page)">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
</template>
<style scoped>
  nav {
    float: right;
  }
  .page_total {
    display: inline-block;
    margin-right: 10px;
    position: relative;
    bottom: 8px;
  }
  .pagination>li {
    display: inline-block;
  }
</style>
<script>
    export default {
      props: ['total', 'size', 'current_page'],
      data: function(){
        return {
          page: this.current_page
        }
      },
      computed: {
        pageList: function(){
          return Math.ceil(this.total / this.size)          
        }
      },
      methods: {
        current_change(item) {
          this.page = item
          this.$emit('update:current_page', item)
          this.$emit('current_change')
        }
      }
    }
</script>
