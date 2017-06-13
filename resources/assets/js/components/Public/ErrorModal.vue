<template>
	<div class="modal fade" id="errorModal" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">错误提醒</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning alert-dismissible fade in" role="alert" v-for="errorItem in errors">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    {{ errorItem }}
                </div>
            </div>
        </div>
      </div>
    </div>
</template>
<script>
	export default {
		mounted() {
			console.log('errorModal mounted');
		},
        props: [
            'errors'
        ]
	}
</script>