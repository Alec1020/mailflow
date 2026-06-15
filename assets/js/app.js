$(document).ready(function() {

    function loadInbox() {
        $.get('ajax/get_inbox.php', function(data) {
            $('#mailList').empty();
            data.forEach(mail => {
                const readClass = mail.is_read ? "" : "fw-bold";
                const item = $(`
                    <div class="mail-item p-2 border-bottom ${readClass}" data-id="${mail.id}">
                        <strong>${mail.subject}</strong><br>
                        <small>From: ${mail.sender_name}</small>
                    </div>
                `);
                item.click(function() {
                    loadMail(mail.id);
                });
                $('#mailList').append(item);
            });
        }, 'json');
    }

    function loadMail(mailId) {

    $.get('ajax/get_mail.php', {id: mailId}, function(mail) {

        $('#mailContent').html(`

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h4>${mail.subject}</h4>

                <button
                    class="btn btn-warning btn-sm"
                    id="summaryBtn">
                    🤖 AI Summary
                </button>

            </div>

            <p>
                <b>From:</b>
                ${mail.sender_name}
                &lt;${mail.sender_email || ''}&gt;
            </p>

            <hr>

            <div class="mb-3">

                <div
                    id="summaryBox"
                    class="alert alert-info d-none">
                </div>

            </div>

            <div class="mail-body mb-3">
                ${mail.body}
            </div>

            <button
                class="btn btn-primary btn-sm"
                id="replyBtn">
                Reply
            </button>

        `);

        $.post(
            'ajax/mark_read.php',
            {id: mailId}
        );

        $('#replyBtn').click(function() {

            $('#composeModal').modal('show');

            $('#newMailForm input[name="to"]')
                .val(mail.sender_email);

            $('#newMailForm input[name="subject"]')
                .val("Re: " + mail.subject);

        });

        /*
        ====================================
        AI SUMMARY
        ====================================
        */

$('#summaryBtn').click(function() {

    $.ajax({

        url:'ajax/ai_summary.php',

        type:'POST',

        data:{
            body:mail.body
        },

        dataType:'json',

        success:function(res){

            $('#summaryBox').html(
                res.summary
            );

        }

    });

});


        $('#summaryBtn').click(function() {

            const btn = $(this);

            btn.prop('disabled', true);

            btn.html(`
                <span
                    class="spinner-border spinner-border-sm">
                </span>
                Generating...
            `);

            $('#summaryBox')
                .removeClass('d-none')
                .html('Generating summary...');

            $.ajax({

                url: 'ajax/ai_summary.php',

                type: 'POST',

                dataType: 'json',

                data: {
                    body: mail.body
                },

                success: function(res) {

                    if(res.status === 'success') {

                        $('#summaryBox').html(`

                            <div class="d-flex justify-content-between">

                                <strong>
                                    AI Summary
                                </strong>

                                <button
                                    class="btn btn-success btn-sm"
                                    id="copySummary">
                                    Copy
                                </button>

                            </div>

                            <hr>

                            <pre
                                style="
                                white-space:pre-wrap;
                                margin:0;">
${res.summary}
                            </pre>

                        `);

                    } else {

                        $('#summaryBox').html(
                            res.message
                        );

                    }

                },

                error: function() {

                    $('#summaryBox').html(
                        'AI service unavailable.'
                    );

                },

                complete: function() {

                    btn.prop('disabled', false);

                    btn.html(
                        '🤖 AI Summary'
                    );

                }

            });

        });

        $(document).on(
            'click',
            '#copySummary',
            function() {

                let text =
                    $('#summaryBox pre').text();

                navigator.clipboard.writeText(text);

                $(this).text('Copied!');

            }
        );

    }, 'json');
}

    // Send new mail
    // $('#newMailForm').submit(function(e) {
    //     e.preventDefault();
    //     $.post('ajax/send_mail.php', $(this).serialize(), function(res) {

    //         console.log(res);

    //         if(res.status === 'success') {
    //             alert("Mail sent successfully");
    //             $('#composeModal').modal('hide');
    //             $('#newMailForm')[0].reset();
    //             loadInbox();
    //         } else {
    //             alert('Failed to send mail: ' + res.message);
    //         }
    //     }, 'json');
    // });
    $('#newMailForm').submit(function(e) {
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: "ajax/send_mail.php",
        data: $(this).serialize(),  // important!
        dataType: "json",
        success: function(res) {
            console.log(res);  // check response in browser console
            if (res.status === 'success') {
                alert("Mail sent successfully!");
                $('#composeModal').modal('hide');
                $('#newMailForm')[0].reset();
                loadInbox();
            } else {
                alert(res.message);
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

    $('#mailSearch').on('input', function(){
        const query = $(this).val().toLowerCase();
        $('#mailList .mail-item').each(function(){
            const subject = $(this).find('strong').text().toLowerCase();
            $(this).toggle(subject.indexOf(query) !== -1);
        });
    });
    
    loadInbox();
});
