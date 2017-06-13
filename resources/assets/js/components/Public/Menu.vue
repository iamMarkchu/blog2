<template>
    <div class="col-md-2">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">菜单</h3>
          </div>
          <div class="list-group">
            <router-link to="/" class="list-group-item" active-class="active" exact>首页</router-link>
            <router-link to="/article" class="list-group-item" active-class="active">文章管理</router-link>
            <router-link to="/tag" class="list-group-item" active-class="active">标签管理</router-link>
            <router-link to="/category" class="list-group-item" active-class="active">类别管理</router-link>
            <router-link to="/user" class="list-group-item" active-class="active">用户管理</router-link>
        </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
