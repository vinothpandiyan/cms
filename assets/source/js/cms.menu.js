$(document).ready(function() {
    var updateOutput = function(e){
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } 
        else {
            output.val('JSON browser support required for this demo.');
        }
    };

    
    $('#nestable').nestable({
        group: 1,
        //maxDepth:3,
        expandBtnHTML   : '<button class="dd-action" data-action="expand" type="button"><i class="icon-chevron-right"></i></button>',
        collapseBtnHTML : '<button class="dd-action" data-action="collapse" type="button"><i class="icon-chevron-down"></i></button>',
        customActions   : {
            'remove'    : function(item,button) {
                console.log('test');
                if( item.hasClass('dd-deleted') ) {
                    item.data('isDeleted',false).removeClass('dd-deleted');
                    button.html('<i class="icon-remove"></i>');
                }
                else {
                    item.data('isDeleted',true).addClass('dd-deleted').remove();
                    button.html('undo');
                     updateOutput($('#nestable').data('output', $('#nestable-output')));
                }
            }
        }
    })
    .on('change', updateOutput);
    
    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));


    $('#nestable-menu').on('click', function(e){
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });


    // ajax update menu items
    $('.update-menu').on('click', function () {
        var form = $('#menu-update');
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (data) {
                var message = '';
                if(data.status == 'success'){
                    message += '<br><div class="alert alert-success alert-dismissible" role="alert">';
                } else {
                    message += '<br><div class="alert alert-danger alert-dismissible" role="alert">';
                }                
                message += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                message += data.message;
                message += '</div>';

                // Auto close message after 3 second
                $('.ajax-messages').html('').append(message);
                $(".ajax-messages").fadeTo(3000, 500).slideUp(500, function(){
                    $(this).alert('close');
                }); 
            }
        });
    });


    // Add Menu To Menu Area
    $('.addmenu').on('click', function(){
        var page_id, page_name;
        $('.checkbox :checkbox:checked').each(function () {
            page_id = $(this).attr('data-id');
            page_name = $(this).attr('data-name');
            //$('ol.initmenu').append('<li class="dd-item dd-nonest" data-id="' + page_id + '" data-pageid="' + page_id + '"><button class="dd-action pull-right" type="button" data-action="remove" title="Remove"><i class="icon-remove"></i></button><div class="dd-handle">'+ page_name+'</div></li>');
            $('ol.initmenu').append('<li class="dd-item " data-id="' + page_id + '" data-pageid="' + page_id + '"><button class="dd-action pull-right" type="button" data-action="remove" title="Remove"><i class="icon-remove"></i> </button> <div class="dd-handle">'+page_name+'</div></li>');
            updateOutput($('#nestable').data('output', $('#nestable-output')));
        });
    });

});


