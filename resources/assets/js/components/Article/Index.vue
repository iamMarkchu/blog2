<template>
    <div id="index">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">文章</h3>
            </div>
            <div class="panel-body query-form">
                <router-link class="btn btn-success" to="/article/add">添加文章</router-link>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>TITLE</th>
                            <th>STATUS</th>
                            <th>ORDER</th>
                            <th>SOURCE</th>
                            <th>CATEGORY</th>
                            <th>TAGS</th>
                            <th>CLICK_COUNT/VOTE_COUNT</th>
                            <th>CREATED_AT/UPDATED_AT</th>
                            <th>OPERATION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, key) in articles">
                            <td>{{ item.id }}</td>
                            <td>{{ item.title }}</td>
                            <!-- status start -->
                            <td v-if="item.status == 'active'">
                                <span class="label label-success">{{ item.status }}</span> 
                            </td>
                            <td v-else-if="item.status == 'republish'">
                                <span class="label label-info">{{ item.status }}</span> 
                            </td>
                            <td v-else-if="item.status == 'deleted'">
                                <span class="label label-danger">{{ item.status }}</span> 
                            </td>
                            <!-- status end -->
                            <td>{{ item.display_order }}</td>
                            <td>{{ item.source }}</td>
                            <!-- category name start-->
                            <td v-if="item.category"><span>{{ item.category.category_name }}</span></td>
                            <td v-else><span class="label label-danger">无类别</span></td>
                            <!-- category name end-->
                            <!-- tags start -->
                            <td v-if="item.tags[0]">
                                <span v-for="tagItem in item.tags">
                                    {{ tagItem.tag_name }}&nbsp;
                                </span>
                            </td>
                            <td v-else><span class="label label-danger">无标签</span></td>
                            <!-- tags end -->
                            <td>{{ item.click_count }}/{{ item.vote_count }}</td>
                            <td>{{ item.created_at }}/{{ item.updated_at }}</td>
                            <td>
                                <router-link :to="{name: 'article-edit', params: {id: item.id}}">编辑</router-link>
                                <a href="javascript:;" @click="change_status(item, 'active')" v-if="item.status == 'republish'">发布</a>

                                <a href="javascript:;" @click="show_delete(item, key)" v-if="item.status != 'deleted'">删除</a>
                                <a href="javascript:;" @click="change_status(item, 'active')" v-else>恢复</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div id="modal-block">
            <delete-modal :something="current_artcle" v-on:do_delete="after_do_delete"></delete-modal>
            <error-modal :errors="errors"></error-modal>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.get_article();
        },
        data() {
            var that = this;
            return {
                current_artcle: {
                    'title': ''
                },
                current_key: 0,
                articles: [],
                errors: {

                }
            }
        },
        methods: {
            get_article: function(){
                var that = this;
                window.axios.get('/article')
                .then(function (response){
                    that.articles = response.data;
                }).catch(function (error){

                });
            },
            show_delete: function(article, key){
                this.current_artcle = article;
                $('#deleteModal').modal('show');
            },
            after_do_delete: function(){
                this.current_artcle.status = 'deleted';
            },
            change_status: function(article, changeStatus){
                var that = this;
                $.ajax({
                    url: '/admin/article/'+article.id+ '/status',
                    data: {status: changeStatus},
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data){
                        article.status = changeStatus;
                    },
                    error: function(error){
                        that.errors = error;
                        $('#errorModal').modal('show');
                    }
                });
            }
        },
        components: {
            DeleteModal: require('../Public/DeleteModal.vue'),
            ErrorModal: require('../Public/ErrorModal.vue'),
        }
    }
</script>