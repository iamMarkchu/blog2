<template>
    <div id="edit">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">编辑文章</h3>
            </div>
            <form action="" id="editArticleForm" class="form-horizontal" >
                <div class="panel-body">
                    <input type="hidden" name="id" :value="article.id">
                    <div class="form-group">
                        <label for="" class="control-label col-sm-2">标题</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="title" v-model="article.title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-sm-2">来源</label>
                        <div class="col-md-4">
                            <select name="source" class="form-control" v-model="article.source">
                                <option value="origin">原创</option>
                                <option value="reprint">转载</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-sm-2">内容</label>
                        <div class="col-md-10">
                            <textarea name="content" id="editContent" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-sm-2">排序</label>
                        <div class="col-md-2">
                            <input type="text" name="display_order" class="form-control" v-model="article.display_order" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-sm-2">类别</label>
                        <div class="col-md-2">
                            <select name="category_id" class="form-control" v-model="article.category_id">
                                <option v-for="item in category_list" :value="item.id">{{ item.category_name }}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:;" class="btn btn-primary" @click="show_add_category()">添加类别</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-sm-2">标签</label>
                        <div class="col-md-2">
                            <label class="checkbox-inline" v-for="item in tag_list">
                                <input type="checkbox" :value="item.id" v-model="selected_tags" name="tag_ids[]"> {{ item.tag_name }}
                            </label>
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:;" class="btn btn-info" @click="show_add_tag()">添加标签</a>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="javascript:;" class="btn btn-success col-md-offset-2 btn-update" @click="do_update()">提交</a>
                    <router-link class="btn btn-default" to="/article">返回</router-link>
                </div>
            </form>
        </div>
        <div id="modal-block">
            <category-add-modal :category_list="category_list" v-on:category_inserted="after_insert_category"></category-add-modal>
            <tag-add-modal v-on:tag_inserted="after_insert_tag"></tag-add-modal>
            <error-modal :errors="modal_errors"></error-modal>
        </div>
    </div>
</template>
<style>
    
</style>
<script>
    import "simplemde/dist/simplemde.min.css";
    import SimpleMDE from 'simplemde';

    export default {
        data(){
            return {
                category_id: 0,
                category_list: [
                    {id: 0, category_name: '无'}
                ],
                tag_list: null,
                article: {
                    id: null,
                    source: '',
                    title: '',
                    content: '',
                    display_order: 99,
                    category_id: 0,
                    tags: null,
                },
                selected_tags: [],
                selected_category: null,
                modal_errors: null,
                simplemde: null
            }
        },
        created(){
            this.article_id = this.$route.params.id;
            this.get_category();
            this.get_tag();
            this.get_article(this.article_id);
        },
        mounted(){
            this.simplemde = new SimpleMDE({ 
                element: document.getElementById("editContent"),
                forceSync: true
            });
        },
        methods: {
            get_category: function(){
                var that = this;
                window.axios.get('/category')
                .then(function (response){
                    for (var i = 0; i < response.data.length; i++) {
                        that.category_list.push(response.data[i]);
                    }
                }).catch(function (error){

                });
            },
            get_tag: function(){
                var that = this;
                window.axios.get('/tag')
                .then(function (response){
                    that.tag_list = response.data;
                }).catch(function (error){

                });  
            },
            get_article: function(id){
                var that = this;
                window.axios.get('/article/'+id)
                .then(function (response){
                    that.article = response.data;
                    if(that.article.tags.length >0)
                    {
                        for (var i = 0; i < that.article.tags.length; i++) {
                            that.selected_tags.push(that.article.tags[i]['id']); 
                        }
                    }
                    that.simplemde.value(that.article.content);
                }).catch(function (error){

                });    
            },
            show_add_category: function(){
                $('#addCategory').modal('show');
            },
            show_add_tag: function(){
                $('#addTag').modal('show');
            },
            after_insert_category: function(category){
                this.article.category_id = category.id;
                this.category_list.push(category);
                $('#addCategory').modal('hide');
            },
            after_insert_tag: function(tag){
                this.tag_list.push(tag);
                this.selected_tags.push(tag.id);
                $('#addTag').modal('hide');
            },
            do_update: function(){
                var that = this;
                /*var form = document.getElementById('editArticleForm');
                var formData = new FormData(form);
                var articleInterceptor = window.axios.interceptors.request.use(function(config){
                    config.headers['Content-Type'] = 'application/x-www-form-urlencoded';
                    $('.btn-update').html('处理中...');
                    return config;
                });
                window.axios.put('/article/'+that.article.id, formData)
                .then(function (response){
                    $('.btn-update').html('成功!');
                }).catch(function (error){
                    that.modal_errors = error.response.data;
                    $('#errorModal').modal('show');
                    $('.btn-update').html('重新提交');
                });
                window.axios.interceptors.request.eject(articleInterceptor);*/

                var formData = $('#editArticleForm').serialize();
                $.ajax({
                    url: '/admin/article/'+that.article.id,
                    data: formData,
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function(xhr){
                        $('.btn-update').html('处理中...');
                    },
                    success: function(data){
                        $('.btn-update').html('成功!');
                    },
                    error: function(error){
                        that.modal_errors = error.response.data;
                        $('#errorModal').modal('show');
                        $('.btn-update').html('重新提交');
                    }
                });
            }
        },
        components: {
            CategoryAddModal: require('../Category/AddModal.vue'),
            TagAddModal: require('../Tag/AddModal.vue'),
            ErrorModal: require('../Public/ErrorModal.vue')
        }
    }
</script>