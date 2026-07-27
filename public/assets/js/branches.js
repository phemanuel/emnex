$(document).on('click','.view-branch',function(){

    let id = $(this).data('id');


    $.get(
        `/branches/${id}/details`,
        function(response){


            let branch = response.branch;


            // Store selected branch for KPI previews
            window.currentBranchId = branch.id;



            $('#inspectorBranchName')
                .text(branch.name);


            $('#inspectorBranchCode')
                .text(branch.branch_code);



            $('#inspectorPhone')
                .text(branch.phone ?? 'Not available');


            $('#inspectorEmail')
                .text(branch.email ?? 'Not available');


            $('#inspectorAddress')
                .text(branch.address ?? 'Not available');



            $('#inspectorUsers')
                .text(branch.users_count ?? 0);



            $('#inspectorTerminals')
                .text(branch.terminals_count ?? 0);



            $('#inspectorOrders')
                .text(branch.orders_count ?? 0);
            
            $('#inspectorCustomers')
            .text(response.customer_count ?? 0);



            $('#inspectorBranchStatus')
                .text(
                    branch.status 
                    ? 'Active'
                    : 'Inactive'
                );



            $('#branchInspector')
                .addClass('open');


            $('#branchInspectorOverlay')
                .addClass('show');


        }
    );


});



$('#closeBranchInspector, #branchInspectorOverlay')
.on('click',function(){


    $('#branchInspector')
        .removeClass('open');


    $('#branchInspectorOverlay')
        .removeClass('show');


    // optional clear
    window.currentBranchId = null;


});

$(document).on('click','.branch-preview-btn',function(){


    let type = $(this).data('type');

    let branchId = window.currentBranchId;


    if(!branchId){

        return;

    }



    $.get(
        `/branches/${branchId}/${type}`,
        function(response){


            let title =
                type.charAt(0).toUpperCase()
                + type.slice(1);



            $('#previewTitle')
                .text(title);



            let html = '';



            if(response.data.length === 0){


                html = `

                <div class="text-center py-5 text-muted">

                    <i class="bi bi-info-circle fs-2"></i>

                    <p class="mt-2">
                        No ${type} found
                    </p>

                </div>

                `;


            }
            else {



                if(type === 'users'){


                    html = `

                    <table class="preview-table">

                    `;


                    response.data.forEach(user=>{


                        html += `

                        <tr>

                            <td>

                                <div class="preview-title">

                                    ${user.first_name} ${user.last_name}

                                </div>


                                <div class="preview-subtitle">

                                    ${user.email ?? ''}

                                </div>

                            </td>


                            <td class="text-end">

                                <i class="bi bi-person"></i>

                            </td>


                        </tr>

                        `;


                    });


                    html += `</table>`;


                }





                if(type === 'terminals'){


                    html = `

                    <table class="preview-table">

                    `;


                    response.data.forEach(terminal=>{


                        html += `

                        <tr>

                            <td>

                                <div class="preview-title">

                                    ${terminal.terminal_name}

                                </div>


                                <div class="preview-subtitle">

                                    Code:
                                    ${terminal.terminal_code}

                                </div>


                            </td>


                            <td class="text-end">

                                ${
                                    terminal.status 
                                    ? 'Active'
                                    : 'Inactive'
                                }

                            </td>


                        </tr>

                        `;


                    });


                    html += `</table>`;

                }


                if(type === 'customers'){


                    html = `

                    <table class="preview-table">

                    `;


                    response.data.forEach(customer=>{


                        html += `

                        <tr>

                            <td>

                                <div class="preview-title">

                                    ${customer.name}

                                </div>


                                <div class="preview-subtitle">

                                    ${customer.email ?? customer.phone ?? ''}

                                </div>


                            </td>

                        </tr>

                        `;


                    });


                    html += `</table>`;


                }



                if(type === 'orders'){


                    html = `

                    <table class="preview-table">

                    `;


                    response.data.forEach(order=>{


                        html += `

                        <tr>


                            <td>


                                <div class="preview-title">

                                    ${order.order_no}

                                </div>


                                <div class="preview-subtitle">

                                    ${order.created_at}

                                </div>


                            </td>



                            <td class="text-end">

                                ₦${Number(order.total)
                                .toLocaleString()}

                            </td>


                        </tr>

                        `;


                    });


                    html += `</table>`;

                }



            }



            $('#previewContent')
                .html(html);



            $('#branchPreviewModal')
                .modal('show');


        }
    );


});
