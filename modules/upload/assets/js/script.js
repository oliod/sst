var collect = new Array(); 
$(function(){

    var ul = $('#upload ul');
	var tpl = '';
    $('#drop a').click(function(){
        // Simulate a click on the file input button
        // to show the file browser dialog
        $(this).parent().find('input').click();
    });

    // Initialize the jQuery File Upload plugin
    $('#upload').fileupload({

        // This element will accept file drag/drop uploading
        dropZone: $('#drop'),

        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
		
        add: function (e, data) {
		
		/*
			tpl = $('');
		*/	
			
            tpl = $('<li class="working"> <input type="text" value="0" data-width="32"  data-height="32"'+
                ' data-fgColor="#639971" data-readOnly="1" data-bgColor="#ccc" /><p></p><span></span></li>');
			
			
            // Append the file name and file size
			var nm = ((data.files[0].name.length > 50) ? data.files[0].name.substring(0 , 50) + "... " : data.files[0].name ); 
            tpl.find('p').html(' <i style="color:#999999; ">'+ nm +'</i>')
                         .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

            // Add the HTML to the UL element
            data.context = tpl.appendTo(ul);

            // Initialize the knob plugin
            tpl.find('input').knob();

            // Listen for clicks on the cancel icon
			/*
            tpl.find('span').click(function() {

                if(tpl.hasClass('working')) {
                    jqXHR.abort();
                }

                tpl.fadeOut(function() {
                    tpl.remove();
                });

            });
			*/
			
			
			var jqXHR = data.submit();
        },
		
		success : function (response) {
			// convert in json 
			var response = JSON.parse(response);
			// If there were errors 
			var bool = 'true';
			for(var i in response) {
				
				if(response[i] == 'error') {
					 
					switch(response.key) {
						case 319:
							collect.push("ERROR size file: " + response.name);
							bool += 'false';
						break;
						case 320:
							collect.push("ERROR  direction doesn't exist: " + response.name);
							bool += 'false';
						break;
						case 322:
							collect.push("ERROR  uri not complete: " + response.name);
							bool += 'false';
						break;
						case 323:
							collect.push("ERROR  uri not complete: " + response.name);
							bool += 'false';
						break;
						case 324:
							collect.push("ERROR check uri: " + response.name);
							bool += 'false';
						break;
						case 325:
							collect.push("ERROR extension: " + response.name);
							bool += 'false';
						break;
						case 326:
							collect.push("ERROR impossible to move file: " + response.name);
							bool += 'false';
						break;
						case 300:
							collect.push("ERROR  direction doesn't exist: " + response.name);
							bool += 'false';
						break;
						case 230:
							collect.push("ERROR please contact to administrator , direction is long: " + response.name);
							bool += 'false';
						break;
					}
					
				}
			} 
			var mark = window.location.href.toString().split(window.location.host)[1].split("?");	

			if(bool.indexOf('false') !== -1) {
			
				showFixedError(collect);
				
				closeDialog();
				openDialog();
				
				setProcessingForwarding(3000, '?'+mark[1]);   
				var icon = classDialog.dialogIconObject.ICON_ERROR;  
					showDialogObject.dialogSimple(null, 
									showText("DIALOG", "dialog", null, null), 
									showText("DIALOG", "downloaded_pdf_only", null, null), icon );	
				listener();
				return ;
			  
			} else {
			
				closeDialog();
				openDialog();
				
				classDialog.whence = '';
				var icon = classDialog.dialogIconObject.ICON_PROG;
					showDialogObject.dialogProgress(null, 
													showText("DIALOG", "dialog", null, null),
													'Please wite... ', icon);
													
					classDialog.PROGRESS = window.setInterval("progress();", 50);  
					window.setTimeout("intervalTimeProgress();", 5000); // 10000
					listener(); 
				return;
					
				
			}		
        },
		
        progress: function(e, data) {
			 
            // Calculate the completion percentage of the upload
            var progress = parseInt(data.loaded / data.total * 100, 10);

            // Update the hidden input field and trigger a change
            // so that the jQuery knob plugin knows to update the dial
            data.context.find('input').val(progress).change();

            if(progress == 100) {
                data.context.removeClass('working');
				
            }
        },

        fail:function(e, data) {
            // Something has gone wrong!
            data.context.addClass('error');
        },
    });

    // Prevent the default action when a file is dropped on the window
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });

    // Helper function that formats the file sizes
    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return "";
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + " GB";
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + " MB";
        }

        return (bytes / 1000).toFixed(2) + " KB";
    }

});

function showFixedError(collect) {
	var d = document.createElement("div");
		d.innerHTML = collect.join(',').replace(',', '<br>') ;
		d.setAttribute("id","fling");
		d.setAttribute('style','z-index:1000000000; margin:10px; padding:10px; color:red; top:10px; left:10px; position:fixed;background-color: #E5F0F4;border: 1px solid #98A0A3; box-shadow: 1px 2px 4px #888888;');
		document.body.appendChild(d); 
		setTimeout("deleteFixedError()", 3000);
}

function deleteFixedError() {
	 collect = new Array(); 
	var del = document.getElementById("fling");
		del.parentNode.removeChild(del);
}	
		
		
		
