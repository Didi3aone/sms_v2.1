<script type="text/javascript">
	// var source = 
	var lists = function () {
	    var table_id = "#dataTable";
	    var ajax_source = "<?= site_url('sms/list_all_data_outbox'); ?>";
	    var url = "<?= site_url('sms/'); ?>";
	    var columns = [
	        {"data": "ID" },
	        {"data": "DestinationNumber" },
	        {"data": "TextDecoded" },
	        {"data": "Status" },
	        {
	            "title": "Action",
	            "class": "text-center",
	            "data": null,
	            "sortable": false,
	            "render": function(data, type, full) {
	                var edit =  '<td>';
	                    // edit +=  ' <a href="' + url + full.template_id + '" class="btn btn-info btn-circle" rel="tooltip" title="View Group" data-placement="top" ><i class="fa fa-eye"></i></a>';
	                           
	                    edit +=  ' <a href="'+ url + "edit/" +full.ID + '" class="btn btn-primary btn-circle" rel="tooltip" title="Edit Template" data-placement="top" ><i class="fa fa-pencil"></i></a>' +
	                             ' <a href="'+ url +'delete" data-id ="' + full.ID + '" data-name ="' + full.DestinationNumber + '" class="btn btn-danger btn-circle delete-confirm" rel="tooltip" title="Delete Group" data-placement="top" ><i class="fa fa-trash-o"></i></a>';
	                    edit +=  '</td>';

	                return edit;
	            }
	        },
	    ];
	    setup_daterangepicker(".date-range-picker");
	    init_datatables (table_id, ajax_source, columns);

	    $(document).on("click", ".delete-confirm", function(e) {
	        e.stopPropagation();
	        e.preventDefault();
	        var url = $(this).attr("href");
	        var data_id = $(this).data("id");
	        var data_name = $(this).data("name");

	        title = 'Delete Confirmation';
	        content = 'Do you really want to delete template ' + data_name + ' ?';

	        popup_confirm (url, data_id, title, content);

	    });

	    // $(document).on("click", ".reactivate-confirm", function(e) {
	    //     e.stopPropagation();
	    //     e.preventDefault();
	    //     var url = $(this).attr("href");
	    //     var data_id = $(this).data("id");
	    //     var data_name = $(this).data("name");

	    //     title = 'Re-activate Confirmation';
	    //     content = 'Do you really want to re-activate ' + data_name + ' ?';

	    //     popup_confirm (url, data_id, title, content);

	    // });

	    $(document).on("popup-confirm:success", function (e, url, data_id){
	        $("#dataTable").dataTable().fnClearTable();
	    });
	};

	$(document).ready(function() {
	    lists();
	});

</script>