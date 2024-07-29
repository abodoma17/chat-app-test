let pusherManager = {
    loggedInUserId: 0,
    chatUserId: 0,
    pusher: null,
    subscribedChannels: [],

    init: function () {
        Pusher.logToConsole = true;

        pusherManager.pusher = new Pusher('c1ed8df259aae5e19782', {
            cluster: 'eu'
        });

        $('.chat').click(function () {
            let chatUserId = $(this).attr('chatUserId');
            $('#chat-container').remove();
            pusherManager.appendChatForm($(this).closest('.user-div'));
            pusherManager.connectToChannel(chatUserId);
        });
    },

    connectToChannel: function (chatUserId) {
        if(pusherManager.subscribedChannels.length)
        {
            pusherManager.subscribedChannels.forEach(function (channelName) {
                pusherManager.pusher.unsubscribe(channelName);
            });
        }

        let channelName = pusherManager.generateChannelName(pusherManager.loggedInUserId, chatUserId);
        let channel = pusherManager.pusher.subscribe(channelName);
        pusherManager.subscribedChannels.push(channelName);
        channel.bind('chat-event', function(data) {
            pusherManager.appendMessage(data);
        });

        $('input[name="receiverUserId"]').val(chatUserId);
    },

    generateChannelName: function (userId1, userId2) {
        userId1 = parseInt(userId1);
        userId2 = parseInt(userId2);

        let users = [userId1, userId2];

        return `${Math.min(...users)}-CHAT-${Math.max(...users)}`;
    },

    appendChatForm: function ($wrap) {
        let _html = "";
        _html += '<div class="row my-2" id="chat-container">';
        _html += '    <div class="col-12">';
        _html += '        <div class="card">';
        _html += '            <div class="card-header">';
        _html += '                Chat';
        _html += '            </div>';
        _html += '            <div class="card-body">';
        _html += '                <div class="chat-messages mb-3" style="height: 300px; overflow-y: scroll; border: 1px solid #ddd; padding: 10px;">';
        _html += '                </div>';
        _html += '                <form id="messageForm" action="/send-message" method="POST">';
        _html += '                    <div class="input-group">';
        _html += '                        <input type="text" class="form-control" placeholder="Type a message" aria-label="Type a message" aria-describedby="button-send" name="message">';
        _html += '                        <input type="text" name="senderUserId" hidden="" value="' + pusherManager.loggedInUserId + '">';
        _html += '                        <input type="text" name="receiverUserId" hidden="">';
        _html += '                        <div class="input-group-append">';
        _html += '                            <button class="btn btn-primary" type="submit" id="button-send">Send</button>';
        _html += '                        </div>';
        _html += '                    </div>';
        _html += '                </form>';
        _html += '            </div>';
        _html += '        </div>';
        _html += '    </div>';
        _html += '</div>';

        $wrap.append(_html);
        pusherManager.addChatFormListener();
    },

    addChatFormListener: function () {
        $('#messageForm').submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: "/send-message",
                data: {
                    "_token": csrf,
                    "senderUserId": $('input[name="senderUserId"]').val(),
                    "receiverUserId": $('input[name="receiverUserId"]').val(),
                    "message": $('input[name="message"]').val(),
                },
                cache: false,
                type: "POST"
            });

            $('input[name="message"]').val('');
        });
    },

    appendMessage: function (data) {
        _html = "";
        _html += '<div class="row mb-2">';

        if(data.senderUserId == pusherManager.loggedInUserId)
        {
            _html += '  <div class="col-12 d-flex justify-content-end">';
            _html += '      <div class="message py-2 bg-success rounded text-white px-3">';
        }
        else {
            _html += '  <div class="col-12 d-flex justify-content-start">';
            _html += '      <div class="message py-2 bg-primary rounded text-white px-3">';
        }

        _html += data.message + '</div></div></div>';

        $('.chat-messages').append(_html);
    }
}
