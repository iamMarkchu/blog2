<template>
	<div class="modal fade" id="addTag" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">添加标签</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning alert-dismissible fade in" role="alert" v-for="errorItem in errors">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    {{ errorItem }}
                </div>
                <form action="" id="addTagForm">
                    <div class="form-group">
                        <label for="">名字</label>
                        <input type="text" class="form-control" name="tag_name">
                    </div>
                    <div class="form-group">
                        <label for="">排序</label>
                        <input type="text" class="form-control" name="display_order" value="99">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-default" @click="do_insert()">提交</a>
            </div>
        </div>
      </div>
    </div>
</template>
<script>
	export default {
		mounted() {
			console.log('addTag mounted');
		},
        props: [
            'tag_list'
        ],
        data(){
            return {
                errors: null
            }
        },
        methods: {
            do_insert: function(){
                var that = this;
                that.errors = null;
                var form = document.getElementById('addTagForm');
                var formData = new FormData(form);
                window.axios.post('/tag', formData)
                .then(function (response) {
                    that.$emit('tag_inserted', response.data);
                }).catch(function (error){
                    that.errors = error.response.data;
                    console.log(error.response.data);
                });
                
            }
        }
	}
</script>