<!-- Edit MODAL SECTION -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Tweet Form</h4>
        </div>
        <div class="modal-body">
        <form id="editTweetForm" name="editTweetForm" class="form-horizontal" novalidate="">
            <div class="form-group error">
            <label for="inputName" class="col-sm-3 control-label">Title</label>
            <div class="col-sm-9">
                <input type="text" class="form-control has-error" id="title" name="title" placeholder="Tweet Title" value="">
            </div>
            </div>
            <div class="form-group">
            <label for="inputDetail" class="col-sm-3 control-label">Description</label>
            <div class="col-sm-9">
                <input type="text" class="form-control has-error" id="description" name="description" placeholder="Tweet Description" value="">
            </div>
            </div>
        </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save" value="Edit">Edit</button>
        <input type="hidden" id="tweet_id" name="tweet_id" value="0">
        </div>
    </div>
    </div>
</div>