<script>
    function appendModal() {
        let html = `
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are you sure to delete this data?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Deleting data is irreversible, please be careful!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button id="deleteButton"  type="button" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        `
        $('body').append(html)
    }

    let clickedDeleteId = null;

    function ajaxDeleteData(id) {
        let deleteUrl = "{{ $deleteRoute }}";
        deleteUrl = deleteUrl.replace(':id', id);
        $.ajax({
            url: deleteUrl,
            type: 'DELETE',
            contentType: 'application/json',
            dataType: 'JSON',
            success: function(result) {
                refreshDatatable()
            }
        });
    }

    function deleteData(id) {
        clickedDeleteId = id;
        $('#deleteModal').modal('show');
    }
    $(document).ready(function() {
        appendModal();

        $('#deleteButton').click(function() {
            ajaxDeleteData(clickedDeleteId);
            $('#deleteModal').modal('hide');
        });
    })
</script>
