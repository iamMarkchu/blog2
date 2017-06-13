<template>
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">确认删除?</h4>
            </div>
            <div class="modal-body">
                {{ something.title }}
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-danger btn-delete" @click="do_delete(something.id)">提交</a>
            </div>
        </div>
      </div>
    </div>
</template>
<script>
	export default {
		mounted() {
			console.log('deleteModal mounted');
		},
        props: [
            'something'
        ],
        methods: {
            do_delete: function(id){
                var that = this;
                window.axios.delete('article/'+id)
                .then(function (response){
                    $('.btn-delete').html('删除成功!');
                    setTimeout("$('#deleteModal').modal('hide')", 1000);
                    that.$emit('do_delete');
                })
            }
        }
	}
</script>